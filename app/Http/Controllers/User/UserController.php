<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Services\Statistics\StorageUsageService;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use DB;


class UserController extends Controller
{
    use Notifiable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                         
        $year = $request->input('year', date('Y'));

        $storage_usage = new StorageUsageService();

        $storage = [
            'available' => $this->formatSize(auth()->user()->storage_total * 1000000),
            'total' => $storage_usage->getTotalAchives(),
            'links' => $storage_usage->getTotalLinkShared(),
            'emails' => $storage_usage->getTotalEmailShared(),
        ];
        
        $chart_data['storage_usage'] = json_encode($storage_usage->getStorageUsageChart()); 
        
        $storage_used = $this->formatSize($storage_usage->getTotalUsage());
        $storage_used_current_year = $this->formatSize($storage_usage->getTotalUsageCurrentYear());
        $user_storage_size = $this->formatSize(auth()->user()->storage_total * 1000000);
        
        $user_storage = ($storage_usage->getTotalUsage() > 0) ? $storage_usage->getTotalUsage() : 1;

        $progress = [
            'zip' => ($storage_usage->getZipSize() / $user_storage) * 100,
            'document' => ($storage_usage->getDocumentSize() / $user_storage) * 100,
            'image' => ($storage_usage->getImageSize() / $user_storage) * 100,
            'media' => ($storage_usage->getMediaSize() / $user_storage) * 100,
            'other' => ($storage_usage->getOtherSize() / $user_storage) * 100,
        ];

        return view('user.profile.index', compact('chart_data', 'storage', 'user_storage_size', 'storage_used', 'storage_used_current_year', 'progress'));           
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {   
        $storage['available'] = $this->formatSize(auth()->user()->storage_total * 1000000);

        return view('user.profile.edit', compact('storage'));
    }

    
    /**
     * Update the specified resource in storage.
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
            'country' => 'nullable|string|max:255',
        ]));
        
        if (request()->has('profile_photo')) {
        
            try {
                request()->validate([
                    'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048'
                ]);
                
            } catch (\Exception $e) {
                toastr()->error(__('PHP FileInfo function is not enabled in your hosting, make sure to enable it first'));
                return redirect()->back();
            }
            
            $image = request()->file('profile_photo');

            $name = Str::random(20);
         
            $folder = '/uploads/img/users/';
          
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            
            $this->uploadImage($image, $folder, 'public', $name);

            $user->profile_photo_path = $filePath;

            $user->save();
        }

        toastr()->success(__('Profile Successfully Updated'));
        return redirect()->route('user.profile.edit', compact('user'));

    }


    /**
     * Upload user profile image
     */
    public function uploadImage(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $image = $file->storeAs($folder, $name .'.'. $file->getClientOriginalExtension(), $disk);

        return $image;
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
