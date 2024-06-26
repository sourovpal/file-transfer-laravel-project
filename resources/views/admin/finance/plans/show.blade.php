@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('View Plan') }}</h4>
			<ol class="breadcrumb mb-2">
				<ol class="breadcrumb mb-2">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-sack-dollar mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
					<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.dashboard') }}"> {{ __('Finance Management') }}</a></li>
					<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.plans') }}"> {{ __('Subscription Plans') }}</a></li>
					<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Plan') }}</a></li>
				</ol>
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
					<h3 class="card-title">{{ __('Subscription Plan Name') }}: <span class="text-info">{{ $id->plan_name }}</span> </h3>
				</div>
				<div class="card-body p-0">
					<table class="table" id="database-backup">
						<tbody>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Plan Name') }}</span><span>{{ ucfirst($id->plan_name) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5"><span class="font-weight-bold">{{ __('Plan Status') }}</span><span class="cell-box plan-{{ $id->status }}">{{ ucfirst($id->status) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Payment Frequency') }}</span><span class="cell-box payment-{{ $id->payment_frequency }}">{{ ucfirst($id->payment_frequency) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Price') }}</span><span>{{ $id->price }} {{ $id->currency }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Paypal Plan ID') }}</span><span>{{ $id->paypal_gateway_plan_id }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Stripe Plan ID') }}</span><span>{{ $id->stripe_gateway_plan_id }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Razorpay Plan ID') }}</span><span>{{ $id->razorpay_gateway_plan_id }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Paystack Plan ID') }}</span><span>{{ $id->paystack_gateway_plan_id }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Allocated Storage') }}</span><span>@if ($id->storage_total == 0) {{ __('Unlimited') }} @else {{ $id->storage_total }} MB @endif</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Free Plan') }}</span>@if($id->free)<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>@else <i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i> @endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Featured Plan') }}</span>@if($id->featured)<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>@else <i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i> @endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Password Protection') }}</span>@if($id->password_protection)<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>@else <i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i> @endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Custom Expiration Time') }}</span>@if($id->custom_expiration)<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>@else <i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i> @endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Total File Download Limit per Month') }}</span><span>@if ($id->download_limit == 0) {{ __('Unlimited') }} @else {{ $id->download_limit }} {{ __('Files') }} @endif</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('File Available Days') }}</span><span>@if ($id->available_days == 0) {{ __('Unlimited') }} @else {{ $id->available_days }} {{ __('Days') }}@endif</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Parallel File Transfers') }}</span><span>@if ($id->parallel_transfers == 0) {{ __('Unlimited') }} @else {{ $id->parallel_transfers }} {{ __('Files') }}@endif</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('File Transfer Size') }}</span><span>@if ($id->transfer_size == 0) {{ __('Unlimited') }} @else {{ $id->transfer_size }} {{ __('MB') }}@endif</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Primary Heading') }}</span><span>{{ ucfirst($id->primary_heading) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Plan Features') }}</span><span>{{ ucfirst($id->plan_features) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Created On') }}</span><span>{{ date_format($id->created_at, 'M d, Y H:i A') }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Last Updated On') }}</span><span>{{ date_format($id->updated_at, 'M d, Y H:i A') }}</span></td></tr>
						</tbody>
					</table>		

					<!-- SAVE CHANGES ACTION BUTTON -->
					<div class="border-0 text-right mb-4 mr-4">
						<a href="{{ route('admin.finance.plans') }}" class="btn btn-cancel mr-2">{{ __('Return') }}</a>
						<a href="{{ route('admin.finance.plan.edit', $id) }}" class="btn btn-primary">{{ __('Edit Plan') }}</a>						
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
