<?php

namespace App\Services\Statistics;

use Illuminate\Support\Facades\Auth;
use App\Models\Transfer;
use App\Models\User;
use DB;

class StorageUsageService 
{
    private $month;
    private $year;

    public function __construct(int $month = null, int $year = null)
    {
        $this->month = $month;
        $this->year = $year;
    }


    /**
     * Total usage per user id
     */
    public function getTotalUsage($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->get();  
        
        return $total_size[0]['data'];
    }


    /**
     * Total storage space used by all users
     */
    public function getTotalStorageUsed()
    {
        $total_size = Transfer::select(DB::raw("sum(size) as data"))
                ->get();  
        
        return $total_size[0]['data'];
    }


     /**
     * Total allocated storage space for all users
     */
    public function getTotalStorageAllocated()
    {
        $total_size = User::select(DB::raw("sum(storage_total) as data"))
                ->get();  
        
        return $total_size[0]['data'];
    }


    /**
     * Current year total usage per user id
     */
    public function getTotalUsageCurrentYear($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->whereYear('created_at', date('Y'))
                ->get();  
        
        return $total_size[0]['data'];
    }


    /**
     * Current month total usage per user id
     */
    public function getTotalUsageCurrentMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y'))
                ->get();  
        
        return $total_size[0]['data'];
    }


    /**
     * Current year total used by all users
     */
    public function getTotalStorageUsedCurrentYear()
    {
        $total_size = Transfer::select(DB::raw("sum(size) as data"))
                ->whereYear('created_at', date('Y'))
                ->get();  
        
        return $total_size[0]['data'];
    }


    /**
     * Chart data - total usage during current year split by month by user id
     */
    public function getStorageUsageChart($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $transfers = Transfer::select(DB::raw("sum(size/1000000) as data"), DB::raw("MONTH(created_at) month"))
                ->whereYear('created_at', date('Y'))
                ->where('user_id', $user_id)
                ->groupBy('month')
                ->orderBy('month')
                ->get()->toArray();  
        
        $data = [];

        for($i = 1; $i <= 12; $i++) {
            $data[$i] = 0;
        }

        foreach ($transfers as $row) {				            
            $month = $row['month'];
            $data[$month] = intval($row['data']);
        }
        
        return $data;
    }


    public function getLinksChartDaily($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $users = Transfer::select(DB::raw("count(id) as data"), DB::raw("DAY(created_at) day"))
                ->whereMonth('created_at', $this->month)
                ->where('share_type', 'link')
                ->groupBy('day')
                ->orderBy('day')
                ->get()->toArray();  
        
        $data = [];

        for($i = 1; $i <= 31; $i++) {
            $data[$i] = 0;
        }

        foreach ($users as $row) {				            
            $month = $row['day'];
            $data[$month] = intval($row['data']);
        }
        
        return $data;
    }


    public function getEmailsChartDaily($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $users = Transfer::select(DB::raw("count(id) as data"), DB::raw("DAY(created_at) day"))
                ->whereMonth('created_at', $this->month)
                ->where('share_type', 'email')
                ->groupBy('day')
                ->orderBy('day')
                ->get()->toArray();  
        
        $data = [];

        for($i = 1; $i <= 31; $i++) {
            $data[$i] = 0;
        }

        foreach ($users as $row) {				            
            $month = $row['day'];
            $data[$month] = intval($row['data']);
        }
        
        return $data;
    }


    /**
     * Chart data - total usage during current year split by month for all users
     */
    public function getTotalStorageUsageChart()
    {
        $standard_chars = Transfer::select(DB::raw("sum(size/1000000) as data"), DB::raw("MONTH(created_at) month"))
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get()->toArray();  
        
        $data = [];

        for($i = 1; $i <= 12; $i++) {
            $data[$i] = 0;
        }

        foreach ($standard_chars as $row) {				            
            $month = $row['month'];
            $data[$month] = intval($row['data']);
        }
        
        return $data;
    }


    public function getTotalStorageUsageDailyChart()
    {
        $users = Transfer::select(DB::raw("count(id) as data"), DB::raw("DAY(created_at) day"))
                ->whereMonth('created_at', $this->month)
                ->groupBy('day')
                ->orderBy('day')
                ->get()->toArray();  
        
        $data = [];

        for($i = 1; $i <= 31; $i++) {
            $data[$i] = 0;
        }

        foreach ($users as $row) {				            
            $month = $row['day'];
            $data[$month] = intval($row['data']);
        }
        
        return $data;
    }


    /**
     * Total transfered files per user id
     */
    public function getTotalAchives($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files per user id
     */
    public function getTotalAchivesCurrentMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total downloaded files per user id
     */
    public function getTotalDownloads($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("sum(downloads) as data"))
                ->where('user_id', $user_id)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total downloaded files per user id
     */
    public function getTotalDownloadsCurrentMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("sum(downloads) as data"))
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files per user id
     */
    public function getTotalAchivesAll()
    {
        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files per user id
     */
    public function getTotalAchivesAllCurrentMonth()
    {
        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->whereMonth('created_at', $this->month)
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total downloaded files per user id
     */
    public function getTotalDownloadsAll()
    {
        $total_transfers = Transfer::select(DB::raw("sum(downloads) as data"))
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files per user id
     */
    public function getFileUploadsCurrentMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files per user id
     */
    public function getFileUploadsPastMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $date = \Carbon\Carbon::now();
        $pastMonth =  $date->subMonth()->format('m');

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $pastMonth)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files via link
     */
    public function getTotalLinkShared($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->where('share_type', 'link')
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files via link
     */
    public function getLinkSharedCurrentMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->where('share_type', 'link')
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files via link
     */
    public function getLinkSharedPastMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $date = \Carbon\Carbon::now();
        $pastMonth =  $date->subMonth()->format('m');

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->where('share_type', 'link')
                ->whereMonth('created_at', $pastMonth)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files via email
     */
    public function getTotalEmailShared($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->where('share_type', 'email')
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total transfered files via email
     */
    public function getEmailSharedCurrentMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->where('share_type', 'email')
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


     /**
     * Total transfered files via email
     */
    public function getEmailSharedPastMonth($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $date = \Carbon\Carbon::now();
        $pastMonth =  $date->subMonth()->format('m');

        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('user_id', $user_id)
                ->where('share_type', 'email')
                ->whereMonth('created_at', $pastMonth)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    /**
     * Total zip file type size per user id
     */
    public function getZipSize($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $zip_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->where('file_type', 'zip')
                ->get();  
        
        return $zip_size[0]['data'];
    }


    /**
     * Total document file type size per user id
     */
    public function getDocumentSize($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $document_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->where('file_type', 'document')
                ->get();  
        
        return $document_size[0]['data'];
    }


    /**
     * Total image file type size per user id
     */
    public function getImageSize($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $media_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->where('file_type', 'image')
                ->get();  
        
        return $media_size[0]['data'];
    }


    /**
     * Total media file type size per user id
     */
    public function getMediaSize($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $media_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->where('file_type', 'media')
                ->get();  
        
        return $media_size[0]['data'];
    }


    /**
     * Total other file type size per user id
     */
    public function getOtherSize($user = null)
    {
        $user_id = (is_null($user)) ? Auth::user()->id : $user;

        $other_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('user_id', $user_id)
                ->where('file_type', 'other')
                ->get();  
        
        return $other_size[0]['data'];
    }


    /**
     * Total zip file type size
     */
    public function getTotalZipSize()
    {
        $zip_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('file_type', 'zip')
                ->get();  
        
        return $zip_size[0]['data'];
    }


    /**
     * Total document file type size 
     */
    public function getTotalDocumentSize()
    {
        $document_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('file_type', 'document')
                ->get();  
        
        return $document_size[0]['data'];
    }


    /**
     * Total media file type size 
     */
    public function getTotalMediaSize()
    {
        $media_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('file_type', 'media')
                ->get();  
        
        return $media_size[0]['data'];
    }


    /**
     * Total media file type size 
     */
    public function getTotalImageSize()
    {
        $media_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('file_type', 'image')
                ->get();  
        
        return $media_size[0]['data'];
    }


    /**
     * Total other file type size 
     */
    public function getTotalOtherSize()
    {
        $other_size = Transfer::select(DB::raw("sum(size) as data"))
                ->where('file_type', 'other')
                ->get();  
        
        return $other_size[0]['data'];
    }


    /**
     * Current Month Free Storage Usage 
     */
    public function getCurrentMonthFreeStorageUsage()
    {
        $other_size = Transfer::select(DB::raw("sum(size) as data"))
                ->whereMonth('created_at', date('m'))        
                ->get();  
        
        return $other_size[0]['data'];
    }


    /**
     * Current Year Storage Usage 
     */
    public function getCurrentYearStorageUsage()
    {
        $other_size = Transfer::select(DB::raw("sum(size) as data"))
                ->whereYear('created_at', date('Y'))    
                ->get();  
        
        return $other_size[0]['data'];
    }


    /**
     * Current Year Free Storage Usage 
     */
    public function getCurrentYearFreeTransferUsage()
    {
        $other_size = Transfer::select(DB::raw("count(id) as data"))
                ->where('plan_type', 'free')    
                ->whereYear('created_at', date('Y'))    
                ->get();  
        
        return $other_size[0]['data'];
    }

    public function getCurrentMonthFreeTransferUsage()
    {
        $other_size = Transfer::select(DB::raw("count(id) as data"))
                ->where('plan_type', 'free')    
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y'))   
                ->get();  
        
        return $other_size[0]['data'];
    }


    /**
     * Current Year Paid Storage Usage 
     */
    public function getCurrentYearPaidTransferUsage()
    {
        $other_size = Transfer::select(DB::raw("count(id) as data"))
                ->where('plan_type', 'paid')    
                ->whereYear('created_at', date('Y'))    
                ->get();  
        
        return $other_size[0]['data'];
    }

    public function getCurrentMonthPaidTransferUsage()
    {
        $other_size = Transfer::select(DB::raw("count(id) as data"))
                ->where('plan_type', 'paid')    
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y'))   
                ->get();  
        
        return $other_size[0]['data'];
    }


     /**
     * Transfer Dashboard Data 
     */
    public function getTotalEmailTransfersCurrentYear()
    {
        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('share_type', 'email')
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    public function getTotalEmailTransfersCurrentMonth()
    {
        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('share_type', 'email')
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }

    public function getTotalLinkTransfersCurrentYear()
    {
        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('share_type', 'link')
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }


    public function getTotalLinkTransfersCurrentMonth()
    {
        $total_transfers = Transfer::select(DB::raw("count(id) as data"))
                ->where('share_type', 'link')
                ->whereMonth('created_at', $this->month)
                ->whereYear('created_at', date('Y')) 
                ->get();  
        
        return $total_transfers[0]['data'];
    }

}