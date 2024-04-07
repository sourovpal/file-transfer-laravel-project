<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;


class TransferConfigController extends Controller
{
    /**
     * Display TTS configuration settings
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.transfers.configuration.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'selected-storage' => 'required',
            'default-storage-size' => 'required|integer|min:0',
            'maximum-upload-limit-admin' => 'required|integer|min:1',
            'maximum-upload-limit-user' => 'required|integer|min:1',
            'maximum-upload-quantity-admin' => 'required|integer|min:1',
            'maximum-upload-quantity-user' => 'required|integer|min:1',
            'expiration-days-admin' => 'required|integer|min:1',
            'expiration-days' => 'required|integer|min:1',
            'download-limit-user' => 'required|integer|min:1',
            'download-limit' => 'required|integer|min:1',
            'server-encryption' => 'required',
            'link-expiration-default-state' => 'required',
            'link-expiration-user' => 'required',
            'password-protection-default-state' => 'required',
            'password-protection-user' => 'required',
        ]);    

        $this->storeConfiguration('TRANSFER_SETTINGS_DEFAULT_STORAGE', request('selected-storage'));
        $this->storeConfiguration('TRANSFER_SETTINGS_DEFAULT_STORAGE_SIZE', request('default-storage-size'));
        $this->storeConfiguration('TRANSFER_SETTINGS_UPLOAD_LIMIT_ADMIN', request('maximum-upload-limit-admin'));
        $this->storeConfiguration('TRANSFER_SETTINGS_UPLOAD_LIMIT_USER', request('maximum-upload-limit-user'));
        $this->storeConfiguration('TRANSFER_SETTINGS_UPLOAD_LIMIT_FRONTEND', request('maximum-upload-limit-frontend'));
        $this->storeConfiguration('TRANSFER_SETTINGS_UPLOAD_QUANTITY_ADMIN', request('maximum-upload-quantity-admin'));
        $this->storeConfiguration('TRANSFER_SETTINGS_UPLOAD_QUANTITY_USER', request('maximum-upload-quantity-user'));
        $this->storeConfiguration('TRANSFER_SETTINGS_UPLOAD_QUANTITY_FRONTEND', request('maximum-upload-quantity-frontend'));
        $this->storeConfiguration('TRANSFER_SETTINGS_SERVER_ENCRYPTION_FEATURE', request('server-encryption'));
        $this->storeConfiguration('TRANSFER_SETTINGS_DEFAULT_SHARE_METHOD', request('selected-share-method'));
        $this->storeConfiguration('TRANSFER_SETTINGS_LINK_EXPIRATION_DEFAULT_STATE', request('link-expiration-default-state'));
        $this->storeConfiguration('TRANSFER_SETTINGS_LINK_EXPIRATION_FEATURE_USER', request('link-expiration-user'));
        $this->storeConfiguration('TRANSFER_SETTINGS_LINK_EXPIRATION_FEATURE_FRONTEND', request('link-expiration-frontend'));
        $this->storeConfiguration('TRANSFER_SETTINGS_EXPIRATION_DAYS_LIMIT_USER', request('expiration-days'));
        $this->storeConfiguration('TRANSFER_SETTINGS_EXPIRATION_DAYS_LIMIT_ADMIN', request('expiration-days-admin'));
        $this->storeConfiguration('TRANSFER_SETTINGS_EXPIRATION_DAYS_LIMIT_FRONTEND', request('expiration-days-frontend'));
        $this->storeConfiguration('TRANSFER_SETTINGS_PASSWORD_PROTECTION_DEFAULT_STATE', request('password-protection-default-state'));
        $this->storeConfiguration('TRANSFER_SETTINGS_PASSWORD_PROTECTION_FEATURE_USER', request('password-protection-user'));
        $this->storeConfiguration('TRANSFER_SETTINGS_PASSWORD_PROTECTION_FEATURE_FRONTEND', request('password-protection-frontend'));
        $this->storeConfiguration('TRANSFER_SETTINGS_DOWNLOAD_LIMIT_ADMIN', request('download-limit'));
        $this->storeConfiguration('TRANSFER_SETTINGS_DOWNLOAD_LIMIT_USER', request('download-limit-user'));

        $this->storeConfiguration('AWS_ACCESS_KEY_ID', request('set-aws-access-key'));
        $this->storeConfiguration('AWS_SECRET_ACCESS_KEY', request('set-aws-secret-access-key'));
        $this->storeConfiguration('AWS_DEFAULT_REGION', request('set-aws-region'));
        $this->storeConfiguration('AWS_BUCKET', request('set-aws-bucket'));

        $this->storeConfiguration('WASABI_ACCESS_KEY_ID', request('set-wasabi-access-key'));
        $this->storeConfiguration('WASABI_SECRET_ACCESS_KEY', request('set-wasabi-secret-access-key'));
        $this->storeConfiguration('WASABI_DEFAULT_REGION', request('set-wasabi-region'));
        $this->storeConfiguration('WASABI_BUCKET', request('set-wasabi-bucket'));

        $this->storeConfiguration('GOOGLE_APPLICATION_CREDENTIALS', request('gcp-configuration-path'));
        $this->storeConfiguration('GOOGLE_STORAGE_BUCKET', request('gcp-bucket'));

        $this->storeConfiguration('STORJ_ACCESS_KEY_ID', request('set-storj-access-key'));
        $this->storeConfiguration('STORJ_SECRET_ACCESS_KEY', request('set-storj-secret-access-key'));
        $this->storeConfiguration('STORJ_BUCKET', request('set-storj-bucket')); 

        $this->storeConfiguration('DROPBOX_APP_KEY', request('set-dropbox-app-key'));
        $this->storeConfiguration('DROPBOX_APP_SECRET', request('set-dropbox-secret-key'));
        $this->storeConfiguration('DROPBOX_ACCESS_TOKEN', request('set-dropbox-access-token'));

        toastr()->success(__('Settings were successfully updated'));
        return redirect()->back();       
    }


    /**
     * Record in .env file
     */
    private function storeConfiguration($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));

        }
    }
}
