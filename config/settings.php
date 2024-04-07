<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Settings
    |--------------------------------------------------------------------------
    */

    'registration' => env('GENERAL_SETTINGS_REGISTRATION'),

    'email_verification' => env('GENERAL_SETTINGS_EMAIL_VERIFICATION'),

    'oauth_login' => env('GENERAL_SETTINGS_OAUTH_LOGIN'),

    'default_user' => env('GENERAL_SETTINGS_DEFAULT_USER_GROUP'),

    'default_country' => env('GENERAL_SETTINGS_DEFAULT_COUNTRY'),

    'support_email' => env('GENERAL_SETTINGS_SUPPORT_EMAIL'),

    'user_notification' => env('GENERAL_SETTINGS_USER_NOTIFICATION'),

    'user_support' => env('GENERAL_SETTINGS_USER_SUPPORT'),

    /*
    |--------------------------------------------------------------------------
    | Transfer Settings
    |--------------------------------------------------------------------------
    */

    'default_storage_size' => env('TRANSFER_SETTINGS_DEFAULT_STORAGE_SIZE'),

    'upload_limit_admin' => env('TRANSFER_SETTINGS_UPLOAD_LIMIT_ADMIN'),
    'upload_limit_user' => env('TRANSFER_SETTINGS_UPLOAD_LIMIT_USER'),
    'upload_limit_frontend' => env('TRANSFER_SETTINGS_UPLOAD_LIMIT_FRONTEND'),

    'upload_quantity_admin' => env('TRANSFER_SETTINGS_UPLOAD_QUANTITY_ADMIN'),
    'upload_quantity_user' => env('TRANSFER_SETTINGS_UPLOAD_QUANTITY_USER'),
    'upload_quantity_frontend' => env('TRANSFER_SETTINGS_UPLOAD_QUANTITY_FRONTEND'),

    'server_encryption' => env('TRANSFER_SETTINGS_SERVER_ENCRYPTION_FEATURE'),

    'link_expiration_default_state' => env('TRANSFER_SETTINGS_LINK_EXPIRATION_DEFAULT_STATE'),
    'link_expiration_feature_user' => env('TRANSFER_SETTINGS_LINK_EXPIRATION_FEATURE_USER'),
    'link_expiration_feature_frontend' => env('TRANSFER_SETTINGS_LINK_EXPIRATION_FEATURE_FRONTEND'),

    'expiration_days_limit_user' => env('TRANSFER_SETTINGS_EXPIRATION_DAYS_LIMIT_USER'),
    'expiration_days_limit_admin' => env('TRANSFER_SETTINGS_EXPIRATION_DAYS_LIMIT_ADMIN'),
    'expiration_days_limit_frontend' => env('TRANSFER_SETTINGS_EXPIRATION_DAYS_LIMIT_FRONTEND'),

    'password_protection_default_state' => env('TRANSFER_SETTINGS_PASSWORD_PROTECTION_DEFAULT_STATE'),
    'password_protection_feature_user' => env('TRANSFER_SETTINGS_PASSWORD_PROTECTION_FEATURE_USER'),
    'password_protection_feature_frontend' => env('TRANSFER_SETTINGS_PASSWORD_PROTECTION_FEATURE_FRONTEND'),

    'default_share_method' => env('TRANSFER_SETTINGS_DEFAULT_SHARE_METHOD'),

    'default_storage' => env('TRANSFER_SETTINGS_DEFAULT_STORAGE'),

    'download_limit_admin' => env('TRANSFER_SETTINGS_DOWNLOAD_LIMIT_ADMIN'),
    'download_limit_user' => env('TRANSFER_SETTINGS_DOWNLOAD_LIMIT_USER'),


];
