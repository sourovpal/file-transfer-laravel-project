<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Services\Statistics\UserRegistrationYearlyService;
use App\Services\Statistics\UserRegistrationMonthlyService;
use App\Services\Statistics\StorageUsageService;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Cache;


class AdminUserController extends Controller
{
    private $storage_usage;

    public function __construct()
    {
        $this->storage_usage = new StorageUsageService();
    }

    /**
     * Display user management dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $registration_yearly = new UserRegistrationYearlyService($year);
        $registration_monthly = new UserRegistrationMonthlyService($month);

        $user_data_year = [
            'total_free_tier' => $registration_yearly->getTotalFreeRegistrations(),
            'total_users' => $registration_yearly->getTotalUsers(),
            'top_countries' => $this->getTopCountries(),
        ];
        
        $chart_data['free_registration_yearly'] = json_encode($registration_yearly->getFreeRegistrations());
        $chart_data['current_registered_users'] = json_encode($registration_monthly->getRegisteredUsers());
        $chart_data['user_countries'] = json_encode($this->getAllCountries());


        $cachedUsers = json_decode(Cache::get('isOnline', []), true);
        $users_online = count($cachedUsers);

        $users_today = User::whereNotNull('last_seen')->whereDate('last_seen', Carbon::today())->count();

        return view('admin.users.dashboard.index', compact('chart_data', 'user_data_year', 'users_online', 'users_today'));
    }


    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
    public function listUsers(Request $request)
    {  
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn ='<div>
                                        <a href="'. route("admin.user.show", $row["id"] ). '"><i class="fa-solid fa-clipboard-user table-action-buttons view-action-button" title="View User"></i></a>
                                        <a href="'. route("admin.user.edit", $row["id"] ). '"><i class="fa-solid fa-user-pen table-action-buttons edit-action-button" title="Edit User Group"></i></a>
                                        <a class="deleteUserButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-user-slash table-action-buttons delete-action-button" title="Delete User"></i></a>
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('user', function($row){
                        if ($row['profile_photo_path']) {
                            $path = asset($row['profile_photo_path']);
                            $user = '<div class="d-flex">
                                    <div class="widget-user-image-sm overflow-hidden mr-4"><img alt="Avatar" src="' . $path . '"></div>
                                    <div class="widget-user-name"><span class="font-weight-bold">'. $row['name'] .'</span><br><span class="text-muted">'.$row["email"].'</span></div>
                                </div>';
                        } else {
                            $path = URL::asset('img/users/avatar.png');
                            $user = '<div class="d-flex">
                                    <div class="widget-user-image-sm overflow-hidden mr-4"><img alt="Avatar" class="rounded-circle" src="' . $path . '"></div>
                                    <div class="widget-user-name"><span class="font-weight-bold">'. $row['name'] .'</span><br><span class="text-muted">'.$row["email"].'</span></div>
                                </div>';
                        }
                        
                        return $user;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span class="font-weight-bold">'.date_format($row["created_at"], 'd M Y').'</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-status', function($row){
                        $custom_status = '<span class="cell-box user-'.$row["status"].'">'.ucfirst($row["status"]).'</span>';
                        return $custom_status;
                    })
                    ->addColumn('custom-group', function($row){
                        $custom_group = '<span class="cell-box user-group-'.$row["group"].'">'.ucfirst($row["group"]).'</span>';
                        return $custom_group;
                    })
                    ->addColumn('custom-country', function($row){
                        $custom_country = '<span class="font-weight-bold">'.$row["country"].'</span>';
                        return $custom_country;
                    })
                    ->addColumn('storage-used', function($row){
                        $storage_used = '<span class="font-weight-bold">'.$this->formatSize($this->storage_usage->getTotalUsage($row["id"])).'</span>';
                        return $storage_used;
                    })
                    ->addColumn('max-storage', function($row){
                        if ($row['storage_total'] == 0) {
                            $storage = 'Unlimited';
                        } else {
                            $storage = $this->formatSize($row["storage_total"] * 1000000);
                        }
                        $custom_storage = '<span class="font-weight-bold">'.$storage.'</span>';
                        return $custom_storage;
                    })
                    ->addColumn('max-downloads', function($row){
                        if ($row['download_limit'] == 0) {
                            $storage = 'Unlimited';
                        } else {
                            $storage = number_format($row["download_limit"]);
                        }
                        $custom_storage = '<span class="font-weight-bold">'.$storage.'</span>';
                        return $custom_storage;
                    })
                    ->rawColumns(['actions', 'custom-status', 'custom-group', 'created-on', 'user', 'custom-country', 'max-storage', 'storage-used', 'max-downloads'])
                    ->make(true);                    
        }

        return view('admin.users.list.index');
    }


    /**
     * Display user activity
     *
     * @return \Illuminate\Http\Response
     */
    public function activity(Request $request)
    {
        $result = DB::table('sessions')
                ->join('users', 'sessions.user_id', '=', 'users.id')
                ->whereNotNull('sessions.user_id')
                ->select('sessions.ip_address', 'sessions.user_agent', 'sessions.last_activity', 'users.email', 'users.group')
                ->orderBy('sessions.last_activity', 'desc')
                ->get()->toArray();

        return view('admin.users.activity.index', compact('result'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.list.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'job_role' => $request->job_role,
            'phone_number' => $request->phone_number,
            'company' => $request->company,
            'website' => $request->website,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);       
        
        $user->syncRoles($request->role);
        $user->status = 'active';
        $user->group = $request->role;
        $user->storage_total = config('settings.default_storage_size');
		$user->download_limit = config('settings.download_limit_user');
        $user->save();        

        toastr()->success(__('Congratulation! New user has been created'));
        return redirect()->back();
    }


    /**
     * Display the details of selected user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {   
        $year = $request->input('year', date('Y'));

        $storage_usage = new StorageUsageService();

        $storage = [
            'available' => $this->formatSize($user->storage_total * 1000000),
            'total' => $storage_usage->getTotalAchives($user->id),
            'links' => $storage_usage->getTotalLinkShared($user->id),
            'emails' => $storage_usage->getTotalEmailShared($user->id),
        ];
        
        $chart_data['storage_usage'] = json_encode($storage_usage->getStorageUsageChart($user->id));
      
        $storage_used = $this->formatSize($storage_usage->getTotalUsage($user->id));
        $storage_used_current_year = $this->formatSize($storage_usage->getTotalUsageCurrentYear($user->id));
        $user_storage_size = $this->formatSize($user->storage_total * 1000000);
        
        $user_storage = ($user->storage_total > 0) ? $user->storage_total * 1000000 : 1;

        $progress = [
            'zip' => ($storage_usage->getZipSize($user->id) / $user_storage) * 100,
            'document' => ($storage_usage->getDocumentSize($user->id) / $user_storage) * 100,
            'media' => ($storage_usage->getMediaSize($user->id) / $user_storage) * 100,
            'image' => ($storage_usage->getImageSize($user->id) / $user_storage) * 100,
            'other' => ($storage_usage->getOtherSize($user->id) / $user_storage) * 100,
        ];

        return view('admin.users.list.show', compact('user', 'chart_data', 'storage', 'storage_used', 'storage_used_current_year', 'user_storage_size', 'progress'));
    }


    /**
     * Show the form for editing the specified user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.list.edit', compact('user'));
    }


    /**
     * Show users storage capacity
     */
    public function storage(User $user)
    {
        return view('admin.users.list.increase', compact('user'));
    }


    /**
     * Change user storage capacity
     */
    public function increase(Request $request, User $user)
    {
        $request->validate([
            'storage' => 'required|integer',
        ]);

        $user->storage_total = request('storage');
        $user->save();

        toastr()->success(__('Storage capacity has been changed successfully'));
        return redirect()->back();
    }


    /**
     * Update selected user data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $user->update(request()->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user)],
            'job_role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'phone_number' => 'nullable|max:20',
            'address' => 'nullable|string|max:255',            
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'string|max:255',
        ]));

        toastr()->success(__('User profile was successfully updated'));
        return redirect()->back();
    }

    /**
     * Change user group/status/password
     */
    public function change(Request $request, User $user)
    {        
        $request->validate([
            'password' => ['nullable', 'confirmed', Rules\Password::min(8)],
            'status' => 'required',
            'group' => 'required'
        ]);
        
		$user->removeRole($user->group);
        $user->assignRole($request->group);
        $user->status = $request->status;
        $user->group = $request->group;
        $user->google2fa_enabled = $request->twoFactor_status;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();   

        toastr()->success(__('User data was successfully updated'));
        return redirect()->back();
    }


    /**
     * Delete selected user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {

            $user = User::find(request('id'));

            if($user) {

                $user->delete();

                return response()->json('success');

            } else{
                return response()->json('error');
            } 
        }     
    }


    /**
     * Show list of all countries
     */
    public function getAllCountries()
    {        
        $countries = User::select(DB::raw("count(id) as data, country"))
                ->groupBy('country')
                ->orderBy('data')
                ->pluck('data', 'country');    
        
        return $countries;        
    }


    /**
     * Show top 30 countries
     */
    public function getTopCountries()
    {        
        $countries = User::select(DB::raw("count(id) as data, country"))
                ->groupBy('country')
                ->orderByDesc('data')
                ->pluck('data', 'country')
                ->take(30)
                ->toArray();    

        return $countries;        
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
