<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Services\Statistics\StorageUsageService;
use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
use App\Models\Transfer;
use App\Models\User;
use DataTables;
use Carbon\Carbon;

class AdminTransferController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new S3Client([
            'credentials' => [													
               'key'    => config('services.aws.key'),						
               'secret' => config('services.aws.secret'),			
           ],
           'version' => 'latest',	
           'signature_version' => 'v4',	
           'region'  => config('services.aws.region')
       ]);
    }


    /**
     * Display Transfer Dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $storage_usage = new StorageUsageService($month, $year);

        $usage_data = [
            'free_current_month' => $storage_usage->getCurrentMonthFreeTransferUsage(),
            'paid_current_month' => $storage_usage->getCurrentMonthPaidTransferUsage(),
            'links_current_month' => $storage_usage->getTotalLinkTransfersCurrentMonth(),
            'emails_current_month' => $storage_usage->getTotalEmailTransfersCurrentMonth(),
            'free_current_year' => $storage_usage->getCurrentYearFreeTransferUsage(),
            'paid_current_year' => $storage_usage->getCurrentYearPaidTransferUsage(),
            'links_current_year' => $storage_usage->getTotalLinkTransfersCurrentYear(),
            'emails_current_year' => $storage_usage->getTotalEmailTransfersCurrentYear(),
        ];
        
        $chart_data['storage_usage'] = json_encode($storage_usage->getTotalStorageUsageChart());
        $chart_data['storage_usage_quantity'] = json_encode($storage_usage->getTotalStorageUsageDailyChart());

        $total_used = $this->formatSize($storage_usage->getTotalStorageUsed());
        $total_used_current_year = $this->formatSize($storage_usage->getTotalStorageUsedCurrentYear());
        $total_transfers_current_month = $storage_usage->getTotalAchivesAllCurrentMonth();
        $total_transfers_current_year = $storage_usage->getTotalAchivesAll();
        $total_downloads_current_year = $storage_usage->getTotalDownloadsAll();

        $total_storage = ($storage_usage->getTotalStorageUsed() > 0) ? $storage_usage->getTotalStorageUsed() : 1;

        $progress = [
            'zip' => ($storage_usage->getTotalZipSize() / $total_storage) * 100,
            'document' => ($storage_usage->getTotalDocumentSize() / $total_storage) * 100,
            'image' => ($storage_usage->getTotalImageSize() / $total_storage) * 100,
            'media' => ($storage_usage->getTotalMediaSize() / $total_storage) * 100,
            'other' => ($storage_usage->getTotalOtherSize() / $total_storage) * 100,
        ];

        return view('admin.transfers.dashboard.index', compact('chart_data', 'progress', 'total_used', 'total_used_current_year', 'total_transfers_current_year', 'usage_data', 'total_downloads_current_year', 'total_transfers_current_month'));
    }


    /**
     * Display Transfer Results
     *
     * @return \Illuminate\Http\Response
     */
    public function listTransfers(Request $request)
    {
        if ($request->ajax()) {
            $data = Transfer::select('transfers.*', 'users.name', 'users.email', 'users.profile_photo_path')->join('users', 'users.id', '=', 'transfers.user_id')->where('users.group', '<>', 'guest')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>
                                    <a href="'. route("admin.transfer.show", $row["id"] ). '"><i class="fa-solid fa-cabinet-filing  table-action-buttons view-action-button" title="View Transfer"></i></a>
                                    <a class="deleteTransferButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark  table-action-buttons delete-action-button" title="Delete Transfer"></i></a>
                                </div>';
                        
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span class="font-weight-bold">'.date_format($row["created_at"], 'd M Y').'</span><br><span>'.date_format($row["created_at"], 'H:i A').'</span>';
                        return $created_on;
                    })
                    ->addColumn('expires-on', function($row){
                        $expires_on = ($row["expires_at"]) ? '<span class="font-weight-bold">'.Carbon::parse($row["expires_at"])->format('d M Y').'</span><br><span>'.Carbon::parse($row["expires_at"])->format('H:i A').'</span>' : '';
                        return $expires_on;
                    })
                    ->addColumn('user', function($row){
                        if ($row['profile_photo_path']) {
                            $path = asset($row['profile_photo_path']);
                        } else {
                            $path = URL::asset('img/users/avatar.png');
                        }

                        $user = '<div class="d-flex">
                                    <div class="widget-user-image-sm overflow-hidden mr-4"><img alt="Avatar" src="' . $path . '"></div>
                                    <div class="widget-user-name"><span class="font-weight-bold">'. $row['name'] .'</span><br><span class="text-muted">'.$row["email"].'</span></div>
                                </div>';
                        return $user;
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
                    ->addColumn('custom-storage', function($row){
                        switch ($row['storage']) {
                            case 'local':
                                $custom_type = '<div class="overflow-hidden"><i class="fa-solid fa-server fs-17"></i></div>';
                                break;
                            case 's3':
                                $custom_type = '<div class="overflow-hidden"><img alt="AWS" src="' . URL::asset('img/csp/aws-ssm.png') . '"></div>';
                                break;
                            case 'wasabi':
                                $custom_type = '<div class="overflow-hidden"><img alt="Wasabi" src="' . URL::asset('img/csp/wasabi-ssm.png') . '"></div>';
                                break;
                            case 'gcp':
                                $custom_type = '<div class="overflow-hidden"><img alt="GCP" src="' . URL::asset('img/csp/gcp-ssm.png') . '"></div>';
                                break;
                            case 'storj':
                                $custom_type = '<div class="overflow-hidden"><img alt="Storj" src="' . URL::asset('img/csp/storj-ssm.png') . '"></div>';
                                break;
                            case 'dropbox':
                                $custom_type = '<div class="overflow-hidden"><img alt="Dropbox" src="' . URL::asset('img/csp/dropbox-ssm.png') . '"></div>';
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
                        $custom_name = $icon . '<a class="file-name font-weight-bold" href="#" id="'.$row["id"].'">'. substr($row["file_name"],0,30).'</a>';
                        return $custom_name;
                    })  
                    ->addColumn('custom-size', function($row){
                        $size = '<span class="font-weight-bold">'.$this->formatSize($row["size"]).'</span>';
                        return $size;
                    })
                    ->addColumn('custom-plan', function($row){
                        $size = '<span class="cell-box plan-'. $row["plan_type"] .'">' . ucfirst($row["plan_type"]) .'</span>';
                        return $size;
                    })
                    ->addColumn('custom-protected', function($row){
                        $protected = ($row['protected']) ? '<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>' : '<i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i>';
                        return $protected;
                    })
                    ->rawColumns(['actions', 'created-on', 'expires-on', 'user', 'custom-name', 'custom-size', 'custom-type', 'custom-plan', 'custom-protected', 'custom-storage'])
                    ->make(true);
                    
        }

        return view('admin.transfers.results.index');
    }


    /**
     * Display Transfer Results
     *
     * @return \Illuminate\Http\Response
     */
    public function listGuestTransfers(Request $request)
    {
        if ($request->ajax()) {
            $data = Transfer::select('transfers.*')->join('users', 'users.id', '=', 'transfers.user_id')->where('users.group', 'guest')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>
                                    <a href="'. route("admin.transfer.show", $row["id"] ). '"><i class="fa-solid fa-cabinet-filing  table-action-buttons view-action-button" title="View Transfer"></i></a>
                                    <a class="deleteTransferButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark  table-action-buttons delete-action-button" title="Delete Transfer"></i></a>
                                </div>';
                        
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span class="font-weight-bold">'.date_format($row["created_at"], 'd M Y').'</span><br><span>'.date_format($row["created_at"], 'H:i A').'</span>';
                        return $created_on;
                    })
                    ->addColumn('expires-on', function($row){
                        $expires_on = ($row["expires_at"]) ? '<span class="font-weight-bold">'.Carbon::parse($row["expires_at"])->format('d M Y').'</span><br><span>'.Carbon::parse($row["expires_at"])->format('H:i A').'</span>' : '';
                        return $expires_on;
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
                    ->addColumn('custom-storage', function($row){
                        switch ($row['storage']) {
                            case 'local':
                                $custom_type = '<div class="overflow-hidden"><i class="fa-solid fa-server fs-17"></i></div>';
                                break;
                            case 's3':
                                $custom_type = '<div class="overflow-hidden"><img alt="AWS" src="' . URL::asset('img/csp/aws-ssm.png') . '"></div>';
                                break;
                            case 'wasabi':
                                $custom_type = '<div class="overflow-hidden"><img alt="Wasabi" src="' . URL::asset('img/csp/wasabi-ssm.png') . '"></div>';
                                break;
                            case 'gcp':
                                $custom_type = '<div class="overflow-hidden"><img alt="GCP" src="' . URL::asset('img/csp/gcp-ssm.png') . '"></div>';
                                break;
                            case 'storj':
                                $custom_type = '<div class="overflow-hidden"><img alt="Storj" src="' . URL::asset('img/csp/storj-ssm.png') . '"></div>';
                                break;
                            case 'dropbox':
                                $custom_type = '<div class="overflow-hidden"><img alt="Dropbox" src="' . URL::asset('img/csp/dropbox-ssm.png') . '"></div>';
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
                        $custom_name = $icon . '<a class="file-name font-weight-bold" href="#" id="'.$row["id"].'">'. substr($row["file_name"],0,30).'</a>';
                        return $custom_name;
                    })  
                    ->addColumn('custom-size', function($row){
                        $size = '<span class="font-weight-bold">'.$this->formatSize($row["size"]).'</span>';
                        return $size;
                    })
                    ->addColumn('custom-plan', function($row){
                        $size = '<span class="cell-box plan-'. $row["plan_type"] .'">' . ucfirst($row["plan_type"]) .'</span>';
                        return $size;
                    })
                    ->addColumn('custom-protected', function($row){
                        $protected = ($row['protected']) ? '<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>' : '<i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i>';
                        return $protected;
                    })
                    ->rawColumns(['actions', 'created-on', 'expires-on', 'custom-name', 'custom-size', 'custom-type', 'custom-plan', 'custom-protected', 'custom-storage'])
                    ->make(true);
                    
        }

        return view('admin.transfers.results.guests.index');
    }


    /**
     * Display selected result details
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $id)
    {   
        $user = User::find($id->user_id);

        return view('admin.transfers.results.show', compact('id', 'user'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {

            $transfer = Transfer::where('id', request('id'))->firstOrFail(); 
            
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
            
        }     
    }


    /**
     * Format storage space to readable format
     */
    private function formatSize($size, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $size = max($size, 0); 
        $pow = floor(($size ? log($size) : 0) / log(1000)); 
        $pow = min($pow, count($units) - 1); 
        
        $size /= pow(1000, $pow);

        return round($size, $precision) . $units[$pow]; 
    }

}
