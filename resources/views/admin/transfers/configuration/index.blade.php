@extends('layouts.app')

@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/tippy/scale-extreme.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/tippy/material.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('Transfer Settings') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-shuffle mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.transfer.dashboard') }}"> {{ __('Transfer Management') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('Transfer Settings') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection
@section('content')					
	<div class="row">
		<div class="col-lg-8 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title"><i class="fa-sharp fa-solid fa-sliders mr-2 text-primary"></i>{{ __('Setup Transfer Settings') }}</h3>
				</div>
				<div class="card-body">
				
					<form action="{{ route('admin.transfer.configs.store') }}" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="row">							

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Default File Storage') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="selected-storage" name="selected-storage" data-placeholder="{{ __('Choose Default File Storage') }}:">			
										<option value="local" @if ( config('settings.default_storage')  == 'local') selected @endif>{{ __('Local Server') }}</option>
										<option value="aws" @if ( config('settings.default_storage')  == 'aws') selected @endif>{{ __('Amazon Web Services') }}</option>
										<option value="wasabi" @if ( config('settings.default_storage')  == 'wasabi') selected @endif>{{ __('Wasabi') }}</option>
										<option value="gcp" @if ( config('settings.default_storage')  == 'gcp') selected @endif>{{ __('Google Cloud Platform') }}</option>
										<option value="storj" @if ( config('settings.default_storage')  == 'storj') selected @endif>{{ __('Storj') }}</option>
										<option value="dropbox" @if ( config('settings.default_storage')  == 'dropbox') selected @endif>{{ __('Dropbox') }}</option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Default File Share Method') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="selected-share-method" name="selected-share-method" data-placeholder="{{ __('Choose Default File Share Method') }}:">			
										<option value="link" @if ( config('settings.default_share_method')  == 'link') selected @endif>{{ __('Link') }}</option>
										<option value="email" @if ( config('settings.default_share_method')  == 'email') selected @endif>{{ __('Email') }}</option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6>{{ __('Default Allocated Initial Storage Capacity') }} <span class="text-muted">(MB) ({{ __('For Newly Registered Users') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="number" class="form-control @error('default-storage-size') is-danger @enderror" id="default-storage-size" name="default-storage-size" placeholder="Ex: 1000" value="{{ config('settings.default_storage_size') }}" required>
										@error('default-storage-size')
											<p class="text-danger">{{ $errors->first('default-storage-size') }}</p>
									@enderror
									</div> 
								</div> 						
							</div>	

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Server Side Encryption') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Applicable only to AWS | Wasabi cloud vendors.') }}"></i></h6>
									  	<select id="server-encryption" name="server-encryption" data-placeholder="{{ __('Enable/Disable S3 Server Side Encryption') }}:">			
										<option value="enable" @if ( config('settings.server_encryption')  == 'enable') selected @endif>{{ __('Enable') }}</option>
										<option value="disable" @if ( config('settings.server_encryption')  == 'disable') selected @endif>{{ __('Disable') }}</option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Password Protection for Download') }} <span class="text-muted">({{ __('Default State') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="password-protection" name="password-protection-default-state" data-placeholder="{{ __('Enable/Disable Password Protection for Download Link') }}:">			
										<option value="enable" @if ( config('settings.password_protection_default_state')  == 'enable') selected @endif>{{ __('Enable') }}</option>
										<option value="disable" @if ( config('settings.password_protection_default_state')  == 'disable') selected @endif>{{ __('Disable') }}</option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Link Expiration') }} <span class="text-muted">({{ __('Default State') }})</span><span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="link-expiration" name="link-expiration-default-state" data-placeholder="{{ __('Enable/Disable Link Expiration Feature') }}:">			
										<option value="enable" @if ( config('settings.link_expiration_default_state')  == 'enable') selected @endif>{{ __('Enable') }}</option>
										<option value="disable" @if ( config('settings.link_expiration_default_state')  == 'disable') selected @endif>{{ __('Disable') }}</option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6>{{ __('Maximum Transfer File Size') }} (MB) <span class="text-muted">({{ __('For Admin Group') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> </span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Maximum upload size limit for a single file for admin group. Provide size in MB.') }}"></i></h6>
									<div class="form-group">							    
										<input type="number" class="form-control @error('maximum-upload-limit-admin') is-danger @enderror" id="maximum-upload-limit-admin" name="maximum-upload-limit-admin" placeholder="Ex: 1000" value="{{ config('settings.upload_limit_admin') }}" required>
										@error('maximum-upload-limit-admin')
											<p class="text-danger">{{ $errors->first('maximum-upload-limit-admin') }}</p>
										@enderror
									</div> 
								</div>							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6>{{ __('Maximum Transfer File Quantity') }} <span class="text-muted">({{ __('For Admin Group') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Maximum parallel upload file quantity limit for admin group.') }}"></i></h6>
									<div class="form-group">							    
										<input type="number" class="form-control @error('maximum-upload-quantity-admin') is-danger @enderror" id="maximum-upload-quantity-admin" name="maximum-upload-quantity-admin" placeholder="Ex: 1" value="{{ config('settings.upload_quantity_admin') }}" required>
										@error('maximum-upload-quantity-admin')
											<p class="text-danger">{{ $errors->first('maximum-upload-quantity-admin') }}</p>
										@enderror
									</div> 
								</div>							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6>{{ __('Maximum Transfer Expiration Days Limit') }} <span class="text-muted">({{ __('For Admin Group') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="number" class="form-control @error('expiration-days-admin') is-danger @enderror" id="expiration-days-admin" name="expiration-days-admin" placeholder="Ex: 1" value="{{ config('settings.expiration_days_limit_admin') }}" required>
										@error('expiration-days-admin')
											<p class="text-danger">{{ $errors->first('expiration-days-admin') }}</p>
										@enderror
									</div> 
								</div>							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6>{{ __('Transfer Download Limit per Month') }} <span class="text-muted">({{ __('For Admin Group') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('All user transfered data cannot exceed download limit set during current month.') }}"></i></h6>
									<div class="form-group">							    
										<input type="number" class="form-control @error('download-limit') is-danger @enderror" id="download-limit" name="download-limit" placeholder="Ex: 1" value="{{ config('settings.download_limit_admin') }}" required>
										@error('download-limit')
											<p class="text-danger">{{ $errors->first('download-limit') }}</p>
										@enderror
									</div> 
								</div>							
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">

								<h6 class="fs-12 font-weight-bold mb-4"><i class="fa fa-gift text-info fs-14 mr-2"></i>{{ __('Free Tier Options') }} <span class="text-muted">({{ __('User Group Only') }})</span></h6>

								<div class="row">							
									
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6>{{ __('Maximum Transfer File Size') }} (MB) <span class="text-muted">({{ __('For User Group') }})<span class="text-required"><i class="fa-solid fa-asterisk"></i></span> </span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Maximum upload size limit for a single file for free tier user group. Provide size in MB.') }}"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control @error('maximum-upload-limit-user') is-danger @enderror" id="maximum-upload-limit-user" name="maximum-upload-limit-user" placeholder="Ex: 1000" value="{{ config('settings.upload_limit_user') }}" required>
												@error('maximum-upload-limit-user')
													<p class="text-danger">{{ $errors->first('maximum-upload-limit-user') }}</p>
												@enderror
											</div> 
										</div>							
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6>{{ __('Maximum Transfer File Quantity') }} <span class="text-muted">({{ __('For User Group') }}) <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> </span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Maximum parallel upload file quantity limit for free tier user group.') }}"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control @error('maximum-upload-quantity-user') is-danger @enderror" id="maximum-upload-quantity-user" name="maximum-upload-quantity-user" placeholder="Ex: 1" value="{{ config('settings.upload_quantity_user') }}" required>
												@error('maximum-upload-quantity-user')
													<p class="text-danger">{{ $errors->first('maximum-upload-quantity-user') }}</p>
												@enderror
											</div> 
										</div>							
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6>{{ __('Allow Password Protection Feature') }} <span class="text-muted">({{ __('For User Group') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="password-protection-user" name="password-protection-user" data-placeholder="{{ __('Enable/Disable Password Protection for Download Link') }}:">			
												<option value="enable" @if ( config('settings.password_protection_feature_user')  == 'enable') selected @endif>{{ __('Enable') }}</option>
												<option value="disable" @if ( config('settings.password_protection_feature_user')  == 'disable') selected @endif>{{ __('Disable') }}</option>
											</select>
										</div>								
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6>{{ __('Allow Link Expiration Feature') }} <span class="text-muted">({{ __('For User Group') }})</span><span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="link-expiration-user" name="link-expiration-user" data-placeholder="{{ __('Enable/Disable Link Expiration Feature') }}:">			
												<option value="enable" @if ( config('settings.link_expiration_feature_user')  == 'enable') selected @endif>{{ __('Enable') }}</option>
												<option value="disable" @if ( config('settings.link_expiration_feature_user')  == 'disable') selected @endif>{{ __('Disable') }}</option>
											</select>
										</div>								
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6>{{ __('Maximum Transfer Expiration Days Limit') }} <span class="text-muted">({{ __('For User Group') }})</span><span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Free tier user will not be able to exceed this limit when setting expiration days for their links.') }}"></i></h6>
											<input type="number" class="form-control @error('expiration-days') is-danger @enderror" id="expiration-days" name="expiration-days" placeholder="Ex: 10" value="{{ config('settings.expiration_days_limit_user') }}" required>
											@error('expiration-days')
												<p class="text-danger">{{ $errors->first('expiration-days') }}</p>
											@enderror
										</div>								
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6>{{ __('Transfer Download Limit per Month') }} <span class="text-muted">({{ __('For User Group') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('All user transfered data cannot exceed download limit set during current month.') }}"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control @error('download-limit-user') is-danger @enderror" id="download-limit-user" name="download-limit-user" placeholder="Ex: 1" value="{{ config('settings.download_limit_user') }}" required>
												@error('download-limit-user')
													<p class="text-danger">{{ $errors->first('download-limit-user') }}</p>
												@enderror
											</div> 
										</div>							
									</div>
								</div>	
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">

								<h6 class="fs-12 font-weight-bold mb-4"><i class="fa-solid fa-browser text-yellow fs-14 mr-2"></i>{{ __('Frontend Demo Options') }}</h6>

								<div class="row">							
									
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6>{{ __('Maximum Transfer File Size') }} (MB) <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Maximum upload size limit for a single file. Provide size in MB.') }}"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control @error('maximum-upload-limit-frontend') is-danger @enderror" id="maximum-upload-limit-frontend" name="maximum-upload-limit-frontend" placeholder="Ex: 1000" value="{{ config('settings.upload_limit_frontend') }}" required>
												@error('maximum-upload-limit-frontend')
													<p class="text-danger">{{ $errors->first('maximum-upload-limit-frontend') }}</p>
												@enderror
											</div> 
										</div>							
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6>{{ __('Maximum Transfer File Quantity') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Maximum parallel upload file quantity limit for free tier user group.') }}"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control @error('maximum-upload-quantity-frontend') is-danger @enderror" id="maximum-upload-quantity-frontend" name="maximum-upload-quantity-frontend" placeholder="Ex: 1" value="{{ config('settings.upload_quantity_frontend') }}" required>
												@error('maximum-upload-quantity-frontend')
													<p class="text-danger">{{ $errors->first('maximum-upload-quantity-frontend') }}</p>
												@enderror
											</div> 
										</div>							
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6>{{ __('Allow Password Protection Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="password-protection-frontend" name="password-protection-frontend" data-placeholder="{{ __('Enable/Disable Password Protection for Download Link') }}:">			
												<option value="enable" @if ( config('settings.password_protection_feature_frontend')  == 'enable') selected @endif>{{ __('Enable') }}</option>
												<option value="disable" @if ( config('settings.password_protection_feature_frontend')  == 'disable') selected @endif>{{ __('Disable') }}</option>
											</select>
										</div>								
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6>{{ __('Allow Link Expiration Feature') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="link-expiration-frontend" name="link-expiration-frontend" data-placeholder="{{ __('Enable/Disable Link Expiration Feature') }}:">			
												<option value="enable" @if ( config('settings.link_expiration_feature_frontend')  == 'enable') selected @endif>{{ __('Enable') }}</option>
												<option value="disable" @if ( config('settings.link_expiration_feature_frontend')  == 'disable') selected @endif>{{ __('Disable') }}</option>
											</select>
										</div>								
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6>{{ __('Maximum Transfer Expiration Days Limit') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('Expiration date not be able to exceed this limit when setting expiration days for their links.') }}"></i></h6>
											<input type="number" class="form-control @error('expiration-days-frontend') is-danger @enderror" id="expiration-days-frontend" name="expiration-days-frontend" placeholder="Ex: 10" value="{{ config('settings.expiration_days_limit_frontend') }}" required>
											@error('expiration-days-frontend')
												<p class="text-danger">{{ $errors->first('expiration-days-frontend') }}</p>
											@enderror
										</div>								
									</div>
								</div>	
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="{{URL::asset('img/csp/aws-sm.png')}}" class="fw-2 mr-2" alt="">{{ __('Amazon Web Services') }}</h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('AWS Access Key') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-aws-access-key') is-danger @enderror" id="aws-access-key" name="set-aws-access-key" value="{{ config('services.aws.key') }}" autocomplete="off">
												@error('set-aws-access-key')
													<p class="text-danger">{{ $errors->first('set-aws-access-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('AWS Secret Access Key') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-aws-secret-access-key') is-danger @enderror" id="aws-secret-access-key" name="set-aws-secret-access-key" value="{{ config('services.aws.secret') }}" autocomplete="off">
												@error('set-aws-secret-access-key')
													<p class="text-danger">{{ $errors->first('set-aws-secret-access-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Amazon S3 Bucket Name') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-aws-bucket') is-danger @enderror" id="aws-bucket" name="set-aws-bucket" value="{{ config('services.aws.bucket') }}" autocomplete="off">
												@error('set-aws-bucket')
													<p class="text-danger">{{ $errors->first('set-aws-bucket') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- AWS REGION -->
										<div class="input-box">	
											<h6>{{ __('Set AWS Region') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="set-aws-region" name="set-aws-region" data-placeholder="Select Default AWS Region:">			
												<option value="us-east-1" @if ( config('services.aws.region')  == 'us-east-1') selected @endif>{{ __('US East (N. Virginia) us-east-1') }}</option>
												<option value="us-east-2" @if ( config('services.aws.region')  == 'us-east-2') selected @endif>{{ __('US East (Ohio) us-east-2') }}</option>
												<option value="us-west-1" @if ( config('services.aws.region')  == 'us-west-1') selected @endif>{{ __('US West (N. California) us-west-1') }}</option>
												<option value="us-west-2" @if ( config('services.aws.region')  == 'us-west-2') selected @endif>{{ __('US West (Oregon) us-west-2') }}</option>
												<option value="ap-east-1" @if ( config('services.aws.region')  == 'ap-east-1') selected @endif>{{ __('Asia Pacific (Hong Kong) ap-east-1') }}</option>
												<option value="ap-south-1" @if ( config('services.aws.region')  == 'ap-south-1') selected @endif>{{ __('Asia Pacific (Mumbai) ap-south-1') }}</option>
												<option value="ap-northeast-3" @if ( config('services.aws.region')  == 'ap-northeast-3') selected @endif>{{ __('Asia Pacific (Osaka) ap-northeast-3') }}</option>
												<option value="ap-northeast-2" @if ( config('services.aws.region')  == 'ap-northeast-2') selected @endif>{{ __('Asia Pacific (Seoul) ap-northeast-2') }}</option>
												<option value="ap-southeast-1" @if ( config('services.aws.region')  == 'ap-southeast-1') selected @endif>{{ __('Asia Pacific (Singapore) ap-southeast-1') }}</option>
												<option value="ap-southeast-2" @if ( config('services.aws.region')  == 'ap-southeast-2') selected @endif>{{ __('Asia Pacific (Sydney) ap-southeast-2') }}</option>
												<option value="ap-northeast-1" @if ( config('services.aws.region')  == 'ap-northeast-1') selected @endif>{{ __('Asia Pacific (Tokyo) ap-northeast-1') }}</option>
												<option value="ap-northeast-1" @if ( config('services.aws.region')  == 'ap-northeast-1') selected @endif>{{ __('Asia Pacific (Hyderabad) ap-south-2') }}</option>
												<option value="ap-northeast-1" @if ( config('services.aws.region')  == 'ap-northeast-1') selected @endif>{{ __('Asia Pacific (Jakarta) ap-southeast-3') }}</option>
												<option value="eu-central-1" @if ( config('services.aws.region')  == 'eu-central-1') selected @endif>{{ __('Europe (Frankfurt) eu-central-1') }}</option>
												<option value="eu-central-1" @if ( config('services.aws.region')  == 'eu-central-1') selected @endif>{{ __('Europe (Zurich) eu-central-2') }}</option>
												<option value="eu-west-1" @if ( config('services.aws.region')  == 'eu-west-1') selected @endif>{{ __('Europe (Ireland) eu-west-1') }}</option>
												<option value="eu-west-2" @if ( config('services.aws.region')  == 'eu-west-2') selected @endif>{{ __('Europe (London) eu-west-2') }}</option>
												<option value="eu-south-1" @if ( config('services.aws.region')  == 'eu-south-1') selected @endif>{{ __('Europe (Milan) eu-south-1') }}</option>
												<option value="eu-south-1" @if ( config('services.aws.region')  == 'eu-south-1') selected @endif>{{ __('Europe (Spain) eu-south-2') }}</option>
												<option value="eu-west-3" @if ( config('services.aws.region')  == 'eu-west-3') selected @endif>{{ __('Europe (Paris) eu-west-3') }}</option>
												<option value="eu-north-1" @if ( config('services.aws.region')  == 'eu-north-1') selected @endif>{{ __('Europe (Stockholm) eu-north-1') }}</option>
												<option value="me-south-1" @if ( config('services.aws.region')  == 'me-south-1') selected @endif>{{ __('Middle East (Bahrain) me-south-1') }}</option>
												<option value="me-south-1" @if ( config('services.aws.region')  == 'me-south-1') selected @endif>{{ __('Middle East (UAE) me-central-1') }}</option>
												<option value="sa-east-1" @if ( config('services.aws.region')  == 'sa-east-1') selected @endif>{{ __('South America (São Paulo) sa-east-1') }}</option>
												<option value="ca-central-1" @if ( config('services.aws.region')  == 'ca-central-1') selected @endif>{{ __('Canada (Central) ca-central-1') }}</option>
												<option value="af-south-1" @if ( config('services.aws.region')  == 'af-south-1') selected @endif>{{ __('Africa (Cape Town) af-south-1') }}</option>
											</select>
										</div> <!-- END AWS REGION -->									
									</div>									
		
								</div>
	
							</div>
						</div>	


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="{{URL::asset('img/csp/wasabi-sm.png')}}" class="fw-2 mr-2" alt="">{{ __('Wasabi Cloud Storage') }}</h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>Wasabi Access Key <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-wasabi-access-key') is-danger @enderror" id="wasabi-access-key" name="set-wasabi-access-key" value="{{ config('services.wasabi.key') }}" autocomplete="off">
												@error('set-wasabi-access-key')
													<p class="text-danger">{{ $errors->first('set-wasabi-access-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6>Wasabi Secret Access Key <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-wasabi-secret-access-key') is-danger @enderror" id="wasabi-secret-access-key" name="set-wasabi-secret-access-key" value="{{ config('services.wasabi.secret') }}" autocomplete="off">
												@error('set-wasabi-secret-access-key')
													<p class="text-danger">{{ $errors->first('set-wasabi-secret-access-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>Wasabi Bucket Name <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-wasabi-bucket') is-danger @enderror" id="wasabi-bucket" name="set-wasabi-bucket" value="{{ config('services.wasabi.bucket') }}" autocomplete="off">
												@error('set-wasabi-bucket')
													<p class="text-danger">{{ $errors->first('set-wasabi-bucket') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- AWS REGION -->
										<div class="input-box">	
											<h6>{{ __('Set Wasabi Region') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											  <select id="set-wasabi-region" name="set-wasabi-region" data-placeholder="Select Default Wasabi Region:">			
												<option value="us-west-1" @if ( config('services.wasabi.region')  == 'us-west-1') selected @endif>{{ __('US Oregon us-west-1') }}</option>
												<option value="us-central-1" @if ( config('services.wasabi.region')  == 'us-central-1') selected @endif>{{ __('US Texas us-central-1') }}</option>
												<option value="us-east-1" @if ( config('services.wasabi.region')  == 'us-east-1') selected @endif>{{ __('US N.Virginia us-east-1') }}</option>
												<option value="us-east-2" @if ( config('services.wasabi.region')  == 'us-east-2') selected @endif>{{ __('US N.Virginia us-east-2') }}</option>
												<option value="ap-northeast-1" @if ( config('services.wasabi.region')  == 'ap-northeast-1') selected @endif>{{ __('Asia Pacific Tokyo ap-northeast-1') }}</option>
												<option value="ap-northeast-2" @if ( config('services.wasabi.region')  == 'ap-northeast-2') selected @endif>{{ __('Asia Pacific Osaka ap-northeast-2') }}</option>
												<option value="ap-sotheast-1" @if ( config('services.wasabi.region')  == 'ap-sotheast-1') selected @endif>{{ __('Asia Pacific Singapore ap-sotheast-1') }}</option>
												<option value="ap-southeast-2" @if ( config('services.wasabi.region')  == 'ap-southeast-2') selected @endif>{{ __('Asia Pacific Sydney ap-southeast-2') }}</option>
												<option value="ca-central-1" @if ( config('services.wasabi.region')  == 'ca-central-1') selected @endif>{{ __('Canada Toronto ca-central-1') }}</option>
												<option value="eu-central-1" @if ( config('services.wasabi.region')  == 'eu-central-1') selected @endif>{{ __('Europe Amsterdam eu-central-1') }}</option>
												<option value="eu-central-2" @if ( config('services.wasabi.region')  == 'eu-central-2') selected @endif>{{ __('Europe Frankfurt eu-central-2') }}</option>
												<option value="eu-west-1" @if ( config('services.wasabi.region')  == 'eu-west-1') selected @endif>{{ __('Europe London eu-west-1') }}</option>
												<option value="eu-west-2" @if ( config('services.wasabi.region')  == 'eu-west-2') selected @endif>{{ __('Europe Paris eu-west-2') }}</option>
											</select>
										</div> <!-- END AWS REGION -->									
									</div>								
		
								</div>
	
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">

								<h6 class="fs-12 font-weight-bold mb-4"><img src="{{URL::asset('img/csp/gcp-sm.png')}}" class="fw-2 mr-2" alt="">{{ __('Google Cloud Platform') }}</h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('GCP Configuration File Path') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('gcp-configuration-path') is-danger @enderror" id="gcp-configuration-path" name="gcp-configuration-path" value="{{ config('services.gcp.key_path') }}" autocomplete="off">
												@error('gcp-configuration-path')
													<p class="text-danger">{{ $errors->first('gcp-configuration-path') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>	
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<div class="input-box">								
											<h6>GCP Storage Bucket Name <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('gcp-bucket') is-danger @enderror" id="gcp-bucket" name="gcp-bucket" value="{{ config('services.gcp.bucket') }}" autocomplete="off">
												@error('gcp-bucket')
													<p class="text-danger">{{ $errors->first('gcp-bucket') }}</p>
												@enderror
											</div> 
										</div> 
									</div>							
								</div>
	
							</div>
						</div>

						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="{{URL::asset('img/csp/storj-ssm.png')}}" class="fw-2 mr-2" alt="">{{ __('Storj Cloud') }}</h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Storj Access Key') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-storj-access-key') is-danger @enderror" id="storj-access-key" name="set-storj-access-key" value="{{ config('services.storj.key') }}" autocomplete="off">
												@error('set-storj-access-key')
													<p class="text-danger">{{ $errors->first('set-storj-access-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Storj Secret Access Key') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-storj-secret-access-key') is-danger @enderror" id="storj-secret-access-key" name="set-storj-secret-access-key" value="{{ config('services.storj.secret') }}" autocomplete="off">
												@error('set-storj-secret-access-key')
													<p class="text-danger">{{ $errors->first('set-storj-secret-access-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Storj Bucket Name') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-storj-bucket') is-danger @enderror" id="storj-bucket" name="set-storj-bucket" value="{{ config('services.storj.bucket') }}" autocomplete="off">
												@error('set-storj-bucket')
													<p class="text-danger">{{ $errors->first('set-storj-bucket') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>									
		
								</div>
	
							</div>
						</div>

						<div class="card border-0 special-shadow">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="{{URL::asset('img/csp/dropbox-ssm.png')}}" class="fw-2 mr-2" alt="">{{ __('Dropbox') }}</h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Dropbox App Key') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-dropbox-app-key') is-danger @enderror" id="dropbox-app-key" name="set-dropbox-app-key" value="{{ config('services.dropbox.key') }}" autocomplete="off">
												@error('set-dropbox-app-key')
													<p class="text-danger">{{ $errors->first('set-dropbox-app-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Dropbox Secret Key') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-dropbox-secret-key') is-danger @enderror" id="dropbox-secret-key" name="set-dropbox-secret-key" value="{{ config('services.dropbox.secret') }}" autocomplete="off">
												@error('set-dropbox-secret-key')
													<p class="text-danger">{{ $errors->first('set-dropbox-secret-key') }}</p>
												@enderror
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>{{ __('Dropbox Access Token') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control @error('set-dropbox-access-token') is-danger @enderror" id="dropbox-access-token" name="set-dropbox-access-token" value="{{ config('services.dropbox.token') }}" autocomplete="off">
												@error('set-dropbox-access-token')
													<p class="text-danger">{{ $errors->first('set-dropbox-access-token') }}</p>
												@enderror
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>									
		
								</div>
	
							</div>
						</div>				

						<!-- SAVE CHANGES ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-1">
							<a href="{{ route('admin.transfer.dashboard') }}" class="btn btn-cancel mr-2">{{ __('Cancel') }}</a>
							<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>							
						</div>				

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<!-- Awselect JS -->
	<script src="{{URL::asset('plugins/awselect/awselect-custom.js')}}"></script>
	<script src="{{URL::asset('js/awselect.js')}}"></script>
	<script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
	<script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
	<script>
		 $(function () {
			tippy('[data-tippy-content]', {
				animation: 'scale-extreme',
				theme: 'material',
			});
		 });
	</script>
@endsection