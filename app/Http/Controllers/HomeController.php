<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Mail\ContactFormEmail;
use App\Models\Setting;
use App\Models\Transfer;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Page;
use App\Models\Faq;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show home page
     */
    public function index()
    {

        $review_exists = Review::count();   
        $reviews = Review::all();

        $information = $this->metadataInformation();

        $faq_exists = Faq::count();        
        $faqs = Faq::where('status', 'visible')->get();

        $blog_exists = Blog::count();
        $blogs = Blog::where('status', 'published')->get();

        if (Session::has('folder')) {
            Session::remove('folder');
            Session::remove('filename');
        }

        return view('home', compact('information', 'blog_exists', 'blogs', 'faq_exists', 'faqs', 'review_exists', 'reviews'));
    }


    /**
     * Display terms & conditions page
     * 
     */
    public function termsAndConditions() 
    {
        $information = $this->metadataInformation();

        $pages_rows = ['terms'];
        $pages = [];
        $page = Page::all();

        foreach ($page as $row) {
            if (in_array($row['name'], $pages_rows)) {
                $pages[$row['name']] = $row['value'];
            }
        }

        return view('service-terms', compact('information', 'pages'));
    }


    /**
     * Display privacy policy page
     * 
     */
    public function privacyPolicy() 
    {
        $information = $this->metadataInformation();

        $pages_rows = ['privacy'];
        $pages = [];
        $page = Page::all();

        foreach ($page as $row) {
            if (in_array($row['name'], $pages_rows)) {
                $pages[$row['name']] = $row['value'];
            }
        }

        return view('privacy-policy', compact('information', 'pages'));
    }


    /**
     * Frontend show blog
     * 
     */
    public function blogShow($slug)
    {
        $blog = Blog::where('url', $slug)->firstOrFail();

        $information_rows = ['js', 'css'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        $information['author'] = $blog->created_by;
        $information['title'] = $blog->title;
        $information['keywords'] = $blog->keywords;
        $information['description'] = $blog->title;

        return view('blog-show', compact('information', 'blog'));
    }


    /**
     * Frontend contact us form record
     * 
     */
    public function contact(Request $request)
    {
        request()->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        if (config('services.google.recaptcha.enable') == 'on') {

            $recaptchaResult = $this->reCaptchaCheck(request('recaptcha'));

            if ($recaptchaResult->success != true) {
                return redirect()->back()->with('error', 'Google reCaptcha Validation has Failed');
            }

            if ($recaptchaResult->score >= 0.5) {

                try {

                    Mail::to(config('mail.from.address'))->send(new ContactFormEmail($request));
 
                    if (Mail::flushMacros()) {
                        return redirect()->back()->with('error', 'Sending email failed, please try again.');
                    }
                    
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'SMTP settings were not set yet, please contact support team. ' . $e->getMessage());
                }

                return redirect()->back()->with('success', 'Email was successfully sent');

            } else {
                return redirect()->back()->with('error', 'Google reCaptcha Validation has Failed');
            }
        
        } else {

            try {

                Mail::to(config('mail.from.address'))->send(new ContactFormEmail($request));
 
                if (Mail::flushMacros()) {
                    return redirect()->back()->with('error', 'Sending email failed, please try again.');
                }

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'SMTP settings were not set yet, please contact support team. ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Email was successfully sent');
        }  
    }


    /**
     * Verify reCaptch for frontend contact us page (if enabled)
     * 
     */
    private function reCaptchaCheck($recaptcha)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $data = [
                'secret' => config('services.google.recaptcha.secret_key'),
                'response' => $recaptcha,
                'remoteip' => $remoteip
        ];

        $options = [
                'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
                ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        return $resultJson;
    }


    public function metadataInformation()
    {
        $information_rows = ['title', 'author', 'keywords', 'description', 'js', 'css'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        return $information;
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

            $data['max_file_size'] = config('settings.upload_limit_user');
            $data['max_file_quantity'] = config('settings.upload_quantity_user');

            return $data;
        }
    }


    /**
     * Download File
     * 
     */
    public function download($transfer_id)
    {

        $information_rows = ['title', 'author', 'keywords', 'description', 'js', 'css', 'disclaimer'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        $file = Transfer::where('transfer_id', $transfer_id)->firstOrFail();

        $name = $file->file_name;
        $size = $this->formatSize($file->size);
        $extension = $file->file_ext;
        $date = date_format($file->created_at, 'd M Y H:i A');
        $password = $file->protected;
        $views = $file->views + 1;
        $downloads = $file->downloads;
        $file->update(['views' => $views]);

        if ($file->signed_link) {
            
            $result = Carbon::createFromFormat('Y-m-d H:i:s', $file->expires_at)->isPast();

            $available = ($result) ? false : true;

        } else {
            $available = true;
        }

        $blog_exists = Blog::count();
        $blogs = Blog::where('status', 'published')->get();

        return view('download', compact('information', 'blogs', 'blog_exists', 'name', 'size', 'extension', 'date', 'available', 'password', 'transfer_id', 'views', 'downloads'));
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
