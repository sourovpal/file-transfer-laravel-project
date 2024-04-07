<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Services\Statistics\StorageUsageService;


class UserDashboardController extends Controller
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
        $month = $request->input('month', date('m'));

        $storage_usage = new StorageUsageService($month, $year);

        $storage = [
            'available' => $this->formatSize(auth()->user()->storage_total * 1000000),
            'total' => $storage_usage->getTotalAchives(),
        ];
        
        $chart_data['links'] = json_encode($storage_usage->getLinksChartDaily()); 
        $chart_data['emails'] = json_encode($storage_usage->getEmailsChartDaily()); 
        
        $storage_used = $this->formatSize($storage_usage->getTotalUsage());
        $storage_used_current_month = $this->formatSize($storage_usage->getTotalUsageCurrentMonth());
        $files_shared_current_month = $storage_usage->getTotalAchivesCurrentMonth();
        $files_downloads_current_month = $storage_usage->getTotalDownloadsCurrentMonth();

        $user_storage_size = $this->formatSize(auth()->user()->storage_total * 1000000);
        
        $user_storage = (auth()->user()->storage_total > 0) ? auth()->user()->storage_total * 1000000 : 1;

        $progress = [
            'zip' => ($storage_usage->getZipSize() / $user_storage) * 100,
            'document' => ($storage_usage->getDocumentSize() / $user_storage) * 100,
            'image' => ($storage_usage->getImageSize() / $user_storage) * 100,
            'media' => ($storage_usage->getMediaSize() / $user_storage) * 100,
            'other' => ($storage_usage->getOtherSize() / $user_storage) * 100,
        ];

        return view('user.dashboard.index', compact('chart_data', 'storage', 'user_storage_size', 'storage_used', 'storage_used_current_month', 'progress', 'files_shared_current_month', 'files_downloads_current_month'));           
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
