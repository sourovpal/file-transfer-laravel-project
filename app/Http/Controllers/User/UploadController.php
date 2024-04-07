<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\LicenseController;
use App\Services\Statistics\StorageUsageService;
use App\Services\Statistics\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\TransferEmail;
use App\Models\TemporaryFile;
use App\Models\Transfer;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Mail;

class UploadController extends Controller
{
    private $api;
    private $user;

    public function __construct()
    {
        $this->api = new LicenseController();
        $this->user = new UserService();

    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        if ($request->ajax()) {
            $data = Transfer::where('user_id', Auth::user()->id)->whereDate('created_at', Carbon::today())->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>                                            
                                        <a href="'. route("user.transfer.show", $row["id"] ). '"><i class="fa-solid fa-cabinet-filing table-action-buttons view-action-button" title="View Transfer Details"></i></a>
                                        <a class="deleteTransferButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Transfer"></i></a>
                                    </div>';
                        
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span class="font-weight-bold">'.date_format($row["created_at"], 'd M Y').'</span><br><span>'.date_format($row["created_at"], 'H:i A').'</span>';
                        return $created_on;
                    })   
                    ->addColumn('expires-on', function($row){
                        $created_on = '<span class="font-weight-bold">'.date_format(Carbon::parse($row["expires_at"]), 'd M Y').'</span><br><span>'.date_format(Carbon::parse($row["created_at"]), 'H:i A').'</span>';
                        return $created_on;
                    }) 
                    ->addColumn('custom-format', function($row){
                        $custom_format = '<span class="font-weight-bold">'.strtoupper($row["file_ext"]).'</span>';
                        return $custom_format;
                    })    
                    ->addColumn('custom-type', function($row){
                        switch ($row['share_type']) {
                            case 'link':
                                $custom_type = '<span class="font-weight-bold glacier cell-box">Link</span>';
                                break;
                            case 'email':
                                $custom_type = '<span class="font-weight-bold glacier-ir cell-box">Email</span>';
                                break;
                            default:
                                $custom_type = '<span class="font-weight-bold glacier cell-box">Link</span>';
                                break;
                        }
                        return $custom_type;
                    })   
                    ->addColumn('custom-name', function($row){
                        $icon = '<div class="file-placeholder-container">
                                    <span class="file-placeholder-text text-center">'.$row['file_ext'].'</span>
                                    <svg width="30px" height="35px" fill="currentColor" viewBox="0 0 38 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="file-placeholder"><path d="M22.1666667,13.546875 L22.1666667,0 L2.375,0 C1.05885417,0 0,1.06582031 0,2.390625 L0,48.609375 C0,49.9341797 1.05885417,51 2.375,51 L35.625,51 C36.9411458,51 38,49.9341797 38,48.609375 L38,15.9375 L24.5416667,15.9375 C23.2354167,15.9375 22.1666667,14.8617187 22.1666667,13.546875 Z M38,12.1423828 L38,12.75 L25.3333333,12.75 L25.3333333,0 L25.9369792,0 C26.5703125,0 27.1739583,0.249023438 27.6192708,0.697265625 L37.3072917,10.4589844 C37.7526042,10.9072266 38,11.5148437 38,12.1423828 Z"></path></svg>';
                                '</div>';
                        $custom_name = $icon . '<a class="file-name font-weight-bold" href="#" id="'.$row["id"].'">'.substr($row["file_name"],0,30).'</a>';
                        return $custom_name;
                    })  
                    ->addColumn('custom-size', function($row){
                        $size = '<span class="font-weight-bold">'.$this->formatSize($row["size"]).'</span>';
                        return $size;
                    })
                    ->addColumn('custom-protected', function($row){
                        $protected = ($row['protected']) ? '<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>' : '<i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i>';
                        return $protected;
                    })
                    ->rawColumns(['actions', 'created-on', 'custom-size', 'custom-format', 'custom-type', 'custom-name', 'custom-protected', 'expires-on'])
                    ->make(true);
                    
        }

        if (Session::has('folder')) {
            Session::remove('folder');
            Session::remove('filename');
        }
        

        return view('user.upload.index');
    }


    /**
	*
	* Store form results
	* @param - form data
	* @return - completion status code
	*
	*/
    public function store(Request $request) {

        if ($request->ajax()) {

            $verify = $this->user->verify_license();

            if($verify['status']!=true){
                return false;
            }

            $storage_usage = new StorageUsageService();

            $folder_names = Session::get('folder');
            $file_names = Session::get('filename');

            $links = [];

            $plan_type = (is_null(auth()->user()->plan_id)) ? 'free' : 'paid';

            # Check if user has a subscription plan
            if ($plan_type == 'paid') {
                $plan = Plan::where('id', auth()->user()->plan_id)->first();
                $subscriber = true;
            } else {
                $subscriber = false;
            }


            # Loop through each uploaded file for transfering
            foreach ($folder_names as $key => $value) { 
                
                $tmp_file = TemporaryFile::where('folder', $value)->where('file', $file_names[$key])->first();

                # Check allowed file size before transfering
                if ($subscriber) {
                    if ($plan->transfer_size !== 0) {
                        if (($tmp_file->size / 1000000) > $plan->transfer_size) {
                            Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
                            $tmp_file->delete();
                            continue;
                        }
                    }
                } elseif (auth()->user()->group == 'user') {
                    if (($tmp_file->size / 1000000) > config('settings.upload_limit_user')) {
                        Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
                        $tmp_file->delete();
                        continue;
                    }
                } else {
                    if (($request->size / 1000000) > config('settings.upload_limit_admin')) {
                        Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
                        $tmp_file->delete();
                        continue;
                    }
                }

                # Check if user have enough storage available before transfering
                if (auth()->user()->storage_total !== 0) {
                    if (($storage_usage->getTotalUsage() + $tmp_file->size) / 1000000 > auth()->user()->storage_total ) {
                        $output['status'] = 'error';
                        $output['message'] = __('Not enough available storage space, delete old files or request more storage space');
                        return $output;
                    }
                }

                if ($tmp_file) {

                    $verify = $this->user->verify_license();
                    if($verify['status']!=true){return false;}

                    # Store in the local or cloud storage
                    if (config('settings.default_storage') == 'local') {
                        Storage::copy('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, 'transfers/' . $tmp_file->folder . '/' . $tmp_file->file, 'public');
                        $transfer_url = 'transfers/' . $tmp_file->folder . '/' . $tmp_file->file;
                        $storage = 'local';
                    } elseif (config('settings.default_storage') == 's3') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('s3')->put($tmp_file->folder . '/' . $tmp_file->file, $content, 'public');
                        $transfer_url = Storage::disk('s3')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 's3';
                    } elseif (config('settings.default_storage') == 'wasabi') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('wasabi')->put($tmp_file->folder . '/' . $tmp_file->file, $content, 'public');
                        $transfer_url = Storage::disk('wasabi')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 'wasabi';
                    } elseif (config('settings.default_storage') == 'gcp') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('gcs')->put($tmp_file->folder . '/' . $tmp_file->file, $content);
                        Storage::disk('gcs')->setVisibility($tmp_file->folder . '/' . $tmp_file->file, 'public');
                        $transfer_url = Storage::disk('gcs')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 'gcp';
                    } elseif (config('settings.default_storage') == 'storj') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('storj')->put($tmp_file->folder . '/' . $tmp_file->file, $content, 'public');
                        Storage::disk('storj')->setVisibility($tmp_file->folder . '/' . $tmp_file->file, 'public');
                        $transfer_url = Storage::disk('storj')->temporaryUrl($tmp_file->folder . '/' . $tmp_file->file, now()->addHours(10));
                        $storage = 'storj';                        
                    } elseif (config('settings.default_storage') == 'dropbox') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('dropbox')->put($tmp_file->folder . '/' . $tmp_file->file, $content);
                        $transfer_url = Storage::disk('dropbox')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 'dropbox';
                    }
                    
                    $transfer_id = strtoupper(Str::random(10));
                    $file = explode('.', $tmp_file->file);
                    $extension = end($file);
                    $links[$tmp_file->file] = $transfer_id;

                    # Assign file group
                    switch ($extension) {
                        case 'zip':
                        case 'rar':
                        case '7z':
                        case 'iso':
                        case 'tar':
                        case 'bz2':
                        case 'tar.gz':
                            $file_type = 'zip';
                            break;
                        case 'docx':
                        case 'xlsx':
                        case 'pdf':
                        case 'txt':
                        case 'ppt':
                            $file_type = 'document';
                            break;
                        case 'mp3':
                        case 'wav':
                        case 'mp4':
                        case 'avi':
                        case 'mpg':
                            $file_type = 'media';
                            break;
                        case 'jpg':
                        case 'png':
                        case 'jpeg':
                        case 'ico':
                        case 'gif':
                            $file_type = 'image';
                            break;
                        default:
                            $file_type = 'other';
                            break;
                    }

                    # Check how long file can be stored for before deletion
                    if (request('link-expiration')) {

                        $user_date = Carbon::parse(request('link-duration'));
                        $current_date = Carbon::now();
                        
                        if ($user_date->lt($current_date)) {
                            $output['status'] = 'error';
                            $output['message'] = __('Expiration date cannot be in the past');
                            return $output;
                        } else {
                            if ($subscriber) {
                                if ($plan->available_days == 0) {
                                    $expiration = $user_date;
                                } else {
                                    $available_date = Carbon::now()->addDays($plan->available_days);
                                    if ($available_date->lt($user_date)) {
                                        $output['status'] = 'error';
                                        $output['message'] = __('Maximum allowed expiration date is up to ' . $plan->available_days . ' days');
                                        return $output;
                                    } else {
                                        $expiration = $user_date;
                                    }
                                }
                            } elseif (auth()->user()->group == 'user') {
                                    $available_date = Carbon::now()->addDays(config('settings.expiration_days_limit_user'));
                                    if ($available_date->lt($user_date)) {
                                        $output['status'] = 'error';
                                        $output['message'] = __('Maximum allowed expiration date is up to ' . config('settings.expiration_days_limit_user') . ' days');
                                        return $output;
                                    } else {
                                        $expiration = $user_date;
                                    }
                            } else {
                                    $available_date = Carbon::now()->addDays(config('settings.expiration_days_limit_admin'));
                                    if ($available_date->lt($user_date)) {
                                        $output['status'] = 'error';
                                        $output['message'] = __('Maximum allowed expiration date is up to ' . config('settings.expiration_days_limit_admin') . ' days');
                                        return $output;
                                    } else {
                                        $expiration = $user_date;
                                    }
                            }
                        }   
                      
                    } else {

                        if ($subscriber) {
                            $expiration = Carbon::now()->addDays($plan->available_days);
                        } elseif (auth()->user()->group == 'user') {
                            $expiration = Carbon::now()->addDays(config('settings.expiration_days_limit_user'));
                        } else {
                            $expiration = Carbon::now()->addDays(config('settings.expiration_days_limit_admin'));
                        }
                    }

                    # Record transfer details 
                    $transfer = new Transfer([
                        'user_id' => auth()->user()->id,
                        'file_name' => $tmp_file->file,
                        'transfer_id' => $transfer_id,
                        'object_key' => $tmp_file->folder . '/' . $tmp_file->file,
                        'transfer_url' => $transfer_url,
                        'file_ext' => $extension,
                        'size' => $tmp_file->size,
                        'share_type' => request('type'),
                        'file_type' => $file_type,
                        'protected' => request('password-protection'),
                        'password' => request('password'),
                        'expires_at' => $expiration,
                        'sent_to' => request('email_to'),
                        'sent_from' => request('email_from'),
                        'message' => request('message'),
                        'plan_type' => $plan_type,
                        'storage' => $storage,
                    ]);
    
                    $transfer->save();
        
                    Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
                    $tmp_file->delete();
                }
            
            } 

            Session::remove('folder');
            Session::remove('filename');

            if (request('type') == 'email') {
                $data = [
                    'email_from' => request('email_from'),
                    'message' => request('message'),
                    'links' => $links
                ];
    
                Mail::to(request('email_to'))
                    ->cc(request('email_from'))
                    ->send(new TransferEmail($data));

                $output['status'] = 'success';
                $output['type'] = 'email';
                $output['links'] = $links;
                return $output;

            } else {
                $output['status'] = 'success';
                $output['type'] = 'link';
                $output['links'] = $links;
                return $output;
            }
        
        }

    }


    /**
	*
	* Store form results
	* @param - form data
	* @return - completion status code
	*
	*/
    public function storeFrontend(Request $request) {

        if ($request->ajax()) {

            $verify = $this->api->verify_license();

            if($verify['status']!=true){
                return false;
            }

            $folder_names = Session::get('folder');
            $file_names = Session::get('filename');

            $links = [];

            # Loop through each uploaded file for transfering
            foreach ($folder_names as $key => $value) { 
                
                $tmp_file = TemporaryFile::where('folder', $value)->where('file', $file_names[$key])->first();

                # Check allowed file size before transfering
                if (($tmp_file->size / 1000000) > config('settings.upload_limit_frontend')) {
                    Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
                    $tmp_file->delete();
                    continue;
                }

                if ($tmp_file) {
                    $verify = $this->user->verify_license();
                    if($verify['status']!=true){return false;}

                    # Store in the local or cloud storage
                    if (config('settings.default_storage') == 'local') {
                        Storage::copy('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, 'transfers/' . $tmp_file->folder . '/' . $tmp_file->file, 'public');
                        $transfer_url = 'transfers/' . $tmp_file->folder . '/' . $tmp_file->file;
                        $storage = 'local';
                    } elseif (config('settings.default_storage') == 's3') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('s3')->put($tmp_file->folder . '/' . $tmp_file->file, $content, 'public');
                        $transfer_url = Storage::disk('s3')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 's3';
                    } elseif (config('settings.default_storage') == 'wasabi') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('wasabi')->put($tmp_file->folder . '/' . $tmp_file->file, $content, 'public');
                        $transfer_url = Storage::disk('wasabi')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 'wasabi';
                    } elseif (config('settings.default_storage') == 'gcp') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('gcs')->put($tmp_file->folder . '/' . $tmp_file->file, $content);
                        Storage::disk('gcs')->setVisibility($tmp_file->folder . '/' . $tmp_file->file, 'public');
                        $transfer_url = Storage::disk('gcs')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 'gcp';
                    } elseif (config('settings.default_storage') == 'storj') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('storj')->put($tmp_file->folder . '/' . $tmp_file->file, $content, 'public');
                        Storage::disk('storj')->setVisibility($tmp_file->folder . '/' . $tmp_file->file, 'public');
                        $transfer_url = Storage::disk('storj')->temporaryUrl($tmp_file->folder . '/' . $tmp_file->file, now()->addHours(10));
                        $storage = 'storj';                        
                    } elseif (config('settings.default_storage') == 'dropbox') {
                        $content = Storage::get('transfers/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
                        Storage::disk('dropbox')->put($tmp_file->folder . '/' . $tmp_file->file, $content);
                        $transfer_url = Storage::disk('dropbox')->url($tmp_file->folder . '/' . $tmp_file->file);
                        $storage = 'dropbox';                        
                    }
                    
                    $transfer_id = strtoupper(Str::random(10));
                    $file = explode('.', $tmp_file->file);
                    $extension = end($file);
                    $links[$tmp_file->file] = $transfer_id;

                    # Assign file group
                    switch ($extension) {
                        case 'zip':
                        case 'rar':
                        case '7z':
                        case 'iso':
                        case 'tar':
                        case 'bz2':
                        case 'tar.gz':
                            $file_type = 'zip';
                            break;
                        case 'docx':
                        case 'xlsx':
                        case 'pdf':
                        case 'txt':
                        case 'ppt':
                            $file_type = 'document';
                            break;
                        case 'mp3':
                        case 'wav':
                        case 'mp4':
                        case 'avi':
                        case 'mpg':
                            $file_type = 'media';
                            break;
                        case 'jpg':
                        case 'png':
                        case 'jpeg':
                        case 'ico':
                        case 'gif':
                            $file_type = 'image';
                            break;
                        default:
                            $file_type = 'other';
                            break;
                    }

                    # Check how long file can be stored for before deletion
                    if (request('link-expiration')) {

                        $user_date = Carbon::parse(request('link-duration'));
                        $current_date = Carbon::now();
                        
                        if ($user_date->lt($current_date)) {
                            $output['status'] = 'error';
                            $output['message'] = __('Expiration date cannot be in the past');
                            return $output;
                        } else {
                            $available_date = Carbon::now()->addDays(config('settings.expiration_days_limit_frontend'));
                            if ($available_date->lt($user_date)) {
                                $output['status'] = 'error';
                                $output['message'] = __('Maximum allowed expiration date is up to ' . config('settings.expiration_days_limit_frontend') . ' days');
                                return $output;
                            } else {
                                $expiration = $user_date;
                            }
                        }   
                      
                    } else {
                        $expiration = Carbon::now()->addDays(config('settings.expiration_days_limit_frontend'));
                    }

                    $user = User::where('group', 'guest')->firstOrFail();

                    # Record transfer details 
                    $transfer = new Transfer([
                        'user_id' => $user->id,
                        'file_name' => $tmp_file->file,
                        'transfer_id' => $transfer_id,
                        'object_key' => $tmp_file->folder . '/' . $tmp_file->file,
                        'transfer_url' => $transfer_url,
                        'file_ext' => $extension,
                        'size' => $tmp_file->size,
                        'share_type' => request('type'),
                        'file_type' => $file_type,
                        'protected' => request('password-protection'),
                        'password' => request('password'),
                        'expires_at' => $expiration,
                        'sent_to' => request('email_to'),
                        'sent_from' => request('email_from'),
                        'message' => request('message'),
                        'plan_type' => 'free',
                        'storage' => $storage,
                    ]);
    
                    $transfer->save();
        
                    Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
                    $tmp_file->delete();
                } 
            
            } 

            Session::remove('folder');
            Session::remove('filename');

            if (request('type') == 'email') {
                $data = [
                    'email_from' => request('email_from'),
                    'message' => request('message'),
                    'links' => $links
                ];
    
                Mail::to(request('email_to'))
                    ->cc(request('email_from'))
                    ->send(new TransferEmail($data));

                $output['status'] = 'success';
                $output['type'] = 'email';
                $output['links'] = $links;
                return $output;

            } else {
                $output['status'] = 'success';
                $output['type'] = 'link';
                $output['links'] = $links;
                return $output;
            }
        
        }

    }


    /**
	*
	* Store form results
	* @param - form data
	* @return - completion status code
	*
	*/
    public function tmpUpload(Request $request) {

        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $size = $file->getSize();
            $file_name = $file->getClientOriginalName();
            $folder = uniqid();
            $file->storeAs('transfers/tmp/' . $folder, $file_name);

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
                'size' => $size
            ]);

            Session::push('folder', $folder);
            Session::push('filename', $file_name);

            return $folder;
        }

        return '';
        
    }


     /**
	*
	* Store form results
	* @param - form data
	* @return - completion status code
	*
	*/
    public function tmpDelete(Request $request) {

        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();

        if ($tmp_file) {
            Storage::deleteDirectory('transfers/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            $folder_names = Session::get('folder');

            if (!is_null($folder_names)) {
                for ($i=0; $i < count($folder_names); $i++) { 
                    if (request()->getContent() == $folder_names[$i]) {
                        Session::forget('folder.' . $i);
                        Session::forget('filename.' . $i);
                    }
                }
            }

            return response('');
        }

    }


    /**
	*
	* Get File Download Link
	* @param - file id in DB
	* @return - file link
	*
	*/
	public function getFileLink(Request $request) {
    
        if ($request->ajax()) {

            $verify = $this->user->verify_license();
            if($verify['status']!=true){return false;}

            $transfer = Transfer::where('transfer_id', $request->id)->first();

            if ($transfer) {

                $user = User::where('id', $transfer->user_id)->first();

                if ($user) {
                    if ($user->download_limit == 0 || ($user->download_limit > $user->downloaded)) {
                    
                        $downloaded = $user->downloaded + 1;
                        $user->update(['downloaded' => $downloaded]);
    
                        $downloads = $transfer->downloads + 1;
                        $transfer->update(['downloads' => $downloads]);

                        switch ($transfer->storage) {
                            case 'local':
                                $url = URL::asset($transfer->transfer_url);
                                break;
                            case 'storj':
                                $url = Storage::disk('storj')->temporaryUrl($transfer->object_key, now()->addHours(10));
                                break;
                            default:
                                $url = $transfer->transfer_url;
                                break;
                        }
    
                        $data = [];
                        $data['status'] = 200;
                        $data['url'] = $url;
    
                        return $data;
    
                    } elseif ($user->download_limit <= $user->downloaded) {
                        $data['status'] = 405;
                        return $data;
                    }

                } else {
                    $data['status'] = 404;
                    return $data;
                }                

            } else {
                $data['status'] = 404;
                return $data;
            }
           
        }

	}


    /**
	*
	* Check file password
	* @param - file id in DB
	* @return - file link
	*
	*/
	public function checkPassword(Request $request) {
    
        if ($request->ajax()) {

            $verify = $this->user->verify_license();
            if($verify['status']!=true){return false;}

            $transfer = Transfer::where('transfer_id', $request->id)->first();

            if ($transfer) {
                if ($transfer->password == $request->pass) {

                    $user = User::where('id', $transfer->user_id)->first();

                    if ($user) {
                        if ($user->download_limit == 0 || ($user->download_limit >= $user->downloaded)) {

                            $downloaded = $user->downloaded + 1;
                            $user->update(['downloaded' => $downloaded]);
    
                            $downloads = $transfer->downloads + 1;
                            $transfer->update(['downloads' => $downloads]);

                            switch ($transfer->storage) {
                                case 'local':
                                    $url = URL::asset($transfer->transfer_url);
                                    break;
                                case 'storj':
                                    $url = Storage::disk('storj')->temporaryUrl($transfer->object_key, now()->addHours(10));
                                    break;
                                default:
                                    $url = $transfer->transfer_url;
                                    break;
                            }
    
                            $data = [];
                            $data['status'] = 200;
                            $data['url'] = $url;
    
                            return $data;
    
                        } elseif ($user->download_limit <= $user->downloaded) {
                            $data['status'] = 405;
                            return $data;
                        }

                    } else {
                        $data['status'] = 404;
                        return $data;
                    }                    
                    
                } else {
                    $data['status'] = 404;
                    return $data;
                }
            }
           
        }

	}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $id)
    {
        if ($id->user_id == Auth::user()->id){

            return view('user.upload.show', compact('id'));     

        } else{
            return redirect()->route('user.transfer.upload');
        }
      
    }


    /**
	*
	* Delete File
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function delete(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->user->verify_license();
            if($verify['status']!=true){return false;}

            $transfer = Transfer::where('id', request('id'))->first(); 

            if ($transfer->user_id == Auth::user()->id){

                switch ($transfer->storage) {
                    case 'local':
                        if (Storage::exists($transfer->transfer_url)) {
                            Storage::delete($transfer->transfer_url);
                        }
                        break;
                    case 's3':
                        if (Storage::disk('s3')->exists($transfer->object_key)) {
                            Storage::disk('s3')->delete($transfer->object_key);
                        }
                        break;
                    case 'wasabi':
                        if (Storage::disk('wasabi')->exists($transfer->object_key)) {
                            Storage::disk('wasabi')->delete($transfer->object_key);
                        }
                        break;
                    case 'storj':
                        if (Storage::disk('storj')->exists($transfer->object_key)) {
                            Storage::disk('storj')->delete($transfer->object_key);
                        }
                        break;
                    case 'gcp':
                        if (Storage::disk('gcp')->exists($transfer->object_key)) {
                            Storage::disk('gcp')->delete($transfer->object_key);
                        }
                        break;
                    case 'dropbox':
                        if (Storage::disk('dropbox')->exists($transfer->object_key)) {
                            Storage::disk('dropbox')->delete($transfer->object_key);
                        }
                        break;
                    default:
                        # code...
                        break;
                }

                $transfer->delete();

                $data['status'] = 'success';
                return $data;  
    
            } else{

                $data['status'] = 'error';
                $data['message'] = __('There was an error while deleting this file');
                return $data;
            }  
        }
	}


    /**
	*
	* Process media file
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function process(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->user->verify_license();
            if($verify['status']!=true){return false;}

            $transfer = Transfer::where('id', request('id'))->first(); 

            if ($transfer->user_id == Auth::user()->id){

                switch ($transfer->storage) {
                    case 'local':
                        $url = URL::asset($transfer->transfer_url);
                        break;
                    case 'storj':
                        $url = Storage::disk('storj')->temporaryUrl($transfer->object_key, now()->addHours(10));
                        break;
                    default:
                        $url = $transfer->transfer_url;
                        break;
                }

                $data['status'] = 'success';
                $data['url'] = $url;
                $data['format'] = strtolower($transfer->file_ext);
                return $data;  
    
            } else{

                $data['status'] = 'error';
                $data['message'] = __('There was an error while retrieving this file');
                return $data;
            }  
        }
	}



    /**
     * Initial settings for file uploader
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request)
    {
        if ($request->ajax()) {

            if (!is_null(auth()->user()->plan_id)) {
                $plan = Plan::where('id', auth()->user()->plan_id)->first();
                $data['max_file_size'] = ($plan->transfer_size == 0) ? 100000000 : $plan->transfer_size;
                $data['max_file_quantity'] = ($plan->parallel_transfers == 0) ? 100000 : $plan->parallel_transfers;
    
            } elseif (auth()->user()->group == 'admin') {
                $data['max_file_size'] = config('settings.upload_limit_admin');
                $data['max_file_quantity'] = config('settings.upload_quantity_admin');
    
            } else {
                $data['max_file_size'] = config('settings.upload_limit_user');
                $data['max_file_quantity'] = config('settings.upload_quantity_user');
            }

            return $data;
        }
    }


    /**
     * Format storage space to readable format
     */
    private function formatSize($size, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $size = max($size, 0); 
        $pow = floor(($size ? log($size) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        
        $size /= pow(1024, $pow);

        return round($size, $precision) . $units[$pow]; 
    }
}
