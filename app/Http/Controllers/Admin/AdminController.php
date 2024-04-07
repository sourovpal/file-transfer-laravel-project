<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Statistics\PaymentsService;
use App\Services\Statistics\RegistrationService;
use App\Services\Statistics\UserRegistrationMonthlyService;
use App\Services\Statistics\StorageUsageService;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $payment = new PaymentsService($year, $month);
        $registration = new RegistrationService($year, $month);
        $user_registration = new UserRegistrationMonthlyService($month);
        $storage_usage = new StorageUsageService($month);
       
        $total_data_monthly = [
            'new_users_current_month' => $registration->getNewUsersCurrentMonth(),
            'new_users_past_month' => $registration->getNewUsersPastMonth(),
            'new_subscribers_current_month' => $registration->getNewSubscribersCurrentMonth(),
            'new_subscribers_past_month' => $registration->getNewSubscribersPastMonth(),
            'income_current_month' => $payment->getTotalPaymentsCurrentMonth(),
            'income_past_month' => $payment->getTotalPaymentsPastMonth(),
            'file_uploads_current_month' => $storage_usage->getFileUploadsCurrentMonth(),
            'file_uploads_past_month' => $storage_usage->getFileUploadsPastMonth(),
            'links_current_month' => $storage_usage->getLinkSharedCurrentMonth(),
            'links_past_month' => $storage_usage->getLinkSharedPastMonth(),
            'emails_current_month' => $storage_usage->getEmailSharedCurrentMonth(),
            'emails_past_month' => $storage_usage->getEmailSharedPastMonth(),
        ];

        $total_data_yearly = [
            'total_new_users' => $registration->getNewUsersCurrentYear(),
            'total_new_subscribers' => $registration->getNewSubscribersCurrentYear(),
            'total_income' => $payment->getTotalPaymentsCurrentYear(),
            'total_file_uploads' => $storage_usage->getTotalAchives(),
            'total_links' => $storage_usage->getTotalLinkShared(),
            'total_emails' => $storage_usage->getTotalEmailShared(),
        ];
        
        $chart_data['total_new_users'] = json_encode($registration->getAllUsers());
        $chart_data['monthly_new_users'] = json_encode($user_registration->getRegisteredUsers());
        $chart_data['total_income'] = json_encode($payment->getPayments());

        $percentage['users_current'] = json_encode($registration->getNewUsersCurrentMonth());
        $percentage['users_past'] = json_encode($registration->getNewUsersPastMonth());
        $percentage['subscribers_current'] = json_encode($registration->getNewSubscribersCurrentMonth());
        $percentage['subscribers_past'] = json_encode($registration->getNewSubscribersPastMonth());
        $percentage['income_current'] = json_encode($payment->getTotalPaymentsCurrentMonth());
        $percentage['income_past'] = json_encode($payment->getTotalPaymentsPastMonth());
        $percentage['transfers_current'] = json_encode($storage_usage->getFileUploadsCurrentMonth());
        $percentage['transfers_past'] = json_encode($storage_usage->getFileUploadsPastMonth());
        $percentage['links_current'] = json_encode($storage_usage->getLinkSharedCurrentMonth());
        $percentage['links_past'] = json_encode($storage_usage->getLinkSharedPastMonth());
        $percentage['emails_current'] = json_encode($storage_usage->getEmailSharedCurrentMonth());
        $percentage['emails_past'] = json_encode($storage_usage->getEmailSharedPastMonth());

        $chart_data['storage_usage'] = json_encode($storage_usage->getTotalStorageUsageChart());

        $new_users = User::latest()->take(5)->get();
        $new_uploads = Transfer::latest()->take(5)->get();

        $result = User::latest()->take(5)->get();
        $transaction = User::select('users.id', 'users.email', 'users.name', 'users.profile_photo_path', 'payments.*')->join('payments', 'payments.user_id', '=', 'users.id')->orderBy('payments.created_at', 'DESC')->take(5)->get();       
 
        return view('admin.dashboard.index', compact('total_data_monthly', 'total_data_yearly', 'chart_data', 'percentage', 'new_users', 'new_uploads', 'result', 'transaction'));
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
