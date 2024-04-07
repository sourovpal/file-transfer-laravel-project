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
			<h4 class="page-title mb-0">{{ __('Edit Plan') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-sack-dollar mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.dashboard') }}"> {{ __('Finance Management') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.plans') }}"> {{ __('Subscription Plans') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Edit Plan') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')						
	<div class="row">
		<div class="col-lg-6 col-md-6 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Edit Subscription Plan') }}</h3>
				</div>
				<div class="card-body pt-5">									
					<form action="{{ route('admin.finance.plan.update', $id) }}" method="POST" enctype="multipart/form-data">
						@method('PUT')
						@csrf

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">						
								<div class="input-box">	
									<h6>{{ __('Plan Status') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="plan-status" name="plan-status" data-placeholder="{{ __('Select Plan Status') }}:">			
										<option value="active" @if ($id->status == 'active') selected @endif>{{ __('Active') }}</option>
										<option value="closed" @if ($id->status == 'closed') selected @endif>{{ __('Closed') }}</option>
									</select>
									@error('plan-status')
										<p class="text-danger">{{ $errors->first('plan-status') }}</p>
									@enderror	
								</div>						
							</div>							
							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Plan Name') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="plan-name" name="plan-name" value="{{ $id->plan_name }}" required>
									</div> 
									@error('plan-name')
										<p class="text-danger">{{ $errors->first('plan-name') }}</p>
									@enderror
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Price') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="cost" name="cost" value="{{ $id->price }}" required>
									</div> 
									@error('cost')
										<p class="text-danger">{{ $errors->first('cost') }}</p>
									@enderror
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Currency') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="currency" name="currency" data-placeholder="{{ __('Select Currency') }}:">			
										@foreach(config('currencies.all') as $key => $value)
											<option value="{{ $key }}" @if( $id->currency == $key) selected @endif>{{ $value['name'] }} - {{ $key }} ({{ $value['symbol'] }})</option>
										@endforeach
									</select>
									@error('currency')
										<p class="text-danger">{{ $errors->first('currency') }}</p>
									@enderror
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Payment Frequence') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="duration" name="duration" data-placeholder="{{ __('Select Payment Frequency') }}:" data-callback="duration_select">		
										<option value="monthly" @if ($id->payment_frequency == 'monthly') selected @endif>{{ __('Monthly') }}</option>
										<option value="yearly" @if ($id->payment_frequency == 'yearly') selected @endif>{{ __('Yearly') }}</option>
										<option value="lifetime" @if ($id->payment_frequency == 'lifetime') selected @endif>{{ __('Lifetime') }}</option>
									</select>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Featured Plan') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="featured" name="featured" data-placeholder="{{ __('Select if Plan is Featured') }}:">		
										<option value=1 @if ($id->featured == true) selected @endif>{{ __('Yes') }}</option>
										<option value=0 @if ($id->featured == false) selected @endif>{{ __('No') }}</option>
									</select>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">								
									<h6>{{ __('Free Plan') }}</h6>
									<div class="form-group">							    
										<select id="free-plan" name="free-plan" data-placeholder="{{ __('Make this plan a Free Plan?') }}:">			
											<option value=1 @if ($id->free == true) selected @endif>{{ ('Yes') }}</option>
											<option value=0 @if ($id->free == false) selected @endif>{{ ('No') }}</option>
										</select>
									</div> 
									@error('free-plan')
										<p class="text-danger">{{ $errors->first('free-plan') }}</p>
									@enderror
								</div> 						
							</div>
						</div>

						<div class="card special-shadow border-0" id="payment-gateways">
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-5"><i class="fa fa-bank text-info fs-14 mr-1 fw-2"></i>{{ __('Payment Gateways Plan IDs') }}</h6>

								<div class="row">								
									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('PayPal Plan ID') }} <span class="text-danger">({{ __('Required for Paypal') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Paypal Plan ID in your Paypal account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="paypal_gateway_plan_id" name="paypal_gateway_plan_id" value="{{ $id->paypal_gateway_plan_id }}">
											</div> 
											@error('paypal_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('paypal_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Stripe Product ID') }} <span class="text-danger">({{ __('Required for Stripe') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Stripe Product ID in your Stripe account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="stripe_gateway_plan_id" name="stripe_gateway_plan_id" value="{{ $id->stripe_gateway_plan_id }}">
											</div> 
											@error('stripe_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('stripe_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Paystack Plan Code') }} <span class="text-danger">({{ __('Required for Paystack') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Paystack Plan ID in your Paystack account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="paystack_gateway_plan_id" name="paystack_gateway_plan_id" value="{{ $id->paystack_gateway_plan_id }}">
											</div> 
											@error('paystack_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('paystack_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Razorpay Plan ID') }} <span class="text-danger">({{ __('Required for Razorpay') }}) <i class="ml-2 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="{{ __('You have to get Razorpay Plan ID in your Razorpay account. Refer to the documentation if you need help with creating one') }}."></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control" id="razorpay_gateway_plan_id" name="razorpay_gateway_plan_id" value="{{ $id->razorpay_gateway_plan_id }}">
											</div> 
											@error('razorpay_gateway_plan_id')
												<p class="text-danger">{{ $errors->first('razorpay_gateway_plan_id') }}</p>
											@enderror
										</div> 						
									</div>
								</div>
							</div>						
						</div>

						<div class="card mt-6 mb-7 special-shadow border-0">
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-5"><i class="fa-solid fa-hard-drive text-info fs-14 mr-1 fw-2"></i>{{ __('Storage Capacity and Features') }}</h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Total Storage Size') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="storage" name="storage" value="{{ $id->storage_total }}" required>
												<span class="text-muted fs-10">{{ __('Provide size in MB. Ex: value 1000 for 1GB. Use 0 for unlimited space.') }}</span>
											</div> 
											@error('storage')
												<p class="text-danger">{{ $errors->first('storage') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Parallel File Transfers') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="quantity" name="quantity" value="{{ $id->parallel_transfers }}" required>
												<span class="text-muted fs-10">{{ __('Specify how many files user can transfer in parallel. Use 0 for unlimited files.') }}</span>
											</div> 
											@error('quantity')
												<p class="text-danger">{{ $errors->first('quantity') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('File Transfer Size') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="size" name="size" value="{{ $id->transfer_size }}" required>
												<span class="text-muted fs-10">{{ __('Specify file size for transfer. Provide size in MB. Use 0 for unlimited size.') }}</span>
											</div> 
											@error('size')
												<p class="text-danger">{{ $errors->first('size') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('File Download Limit') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="download-limit" name="download-limit" value="{{ $id->download_limit }}" required>
												<span class="text-muted fs-10">{{ __('Specify how many times user transfers can be downloaded per month. Use 0 for unlimited downloads.') }}</span>
											</div> 
											@error('download-limit')
												<p class="text-danger">{{ $errors->first('download-limit') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('File Availability Days') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="number" class="form-control" id="store-limit" name="store-limit" value="{{ $id->available_days }}" required>
												<span class="text-muted fs-10">{{ __('Specify maximum days transfered file could be available for. Use 0 for unlimited days.') }}</span>
											</div> 
											@error('store-limit')
												<p class="text-danger">{{ $errors->first('store-limit') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Allow Password Protection') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<select id="password" name="password" data-placeholder="{{ __('Specify if user can password protect transfered files') }}:">			
													<option value=1 @if ($id->password_protection == true) selected @endif>{{ ('Allow') }}</option>
													<option value=0 @if ($id->password_protection == false) selected @endif>{{ ('Deny') }}</option>
												</select>
											</div> 
											@error('password')
												<p class="text-danger">{{ $errors->first('password') }}</p>
											@enderror
										</div> 						
									</div>

									<div class="col-sm-12">							
										<div class="input-box">								
											<h6>{{ __('Custom File Expiration Date') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<select id="custom-expiration" name="custom-expiration" data-placeholder="{{ __('Specify if user can set custom expiration date') }}:">			
													<option value='1' @if ($id->custom_expiration == true) selected @endif>{{ ('Allow') }}</option>
													<option value='0' @if ($id->custom_expiration == false) selected @endif>{{ ('Deny') }}</option>
												</select>
											</div> 
											@error('custom-expiration')
												<p class="text-danger">{{ $errors->first('custom-expiration') }}</p>
											@enderror
										</div> 						
									</div>
								</div>
							</div>
						</div>

						<div class="row mt-6">
							<div class="col-12">
								<div class="input-box">	
									<h6>{{ __('Primary Heading') }} <span class="text-muted">({{ __('Optional') }})</span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="primary-heading" name="primary-heading" value="{{ $id->primary_heading }}">
									</div>
								</div>
							</div>
						</div>

						<div class="row mt-6">
							<div class="col-lg-12 col-md-12 col-sm-12">	
								<div class="input-box">	
									<h6>{{ __('Plan Features') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <span class="text-danger ml-3">({{ __('Comma Seperated') }})</span></h6>							
									<textarea class="form-control" name="features" rows="10">{{ $id->plan_features }}</textarea>
									@error('features')
										<p class="text-danger">{{ $errors->first('features') }}</p>
									@enderror	
								</div>											
							</div>
						</div>
						

						<!-- ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-1">
							<a href="{{ route('admin.finance.plans') }}" class="btn btn-cancel mr-2">{{ __('Cancel') }}</a>
							<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>							
						</div>				

					</form>					
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<!-- Awselect JS -->
	<script src="{{URL::asset('plugins/awselect/awselect.min.js')}}"></script>
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

		 function duration_select(value) {
			if (value == 'lifetime') {
				$('#payment-gateways').css('display', 'none');
			} else {
				$('#payment-gateways').css('display', 'block');
			}
		 }
	</script>
@endsection
