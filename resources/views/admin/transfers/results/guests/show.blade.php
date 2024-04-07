@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('Transfer Details') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-shuffle mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.transfer.dashboard') }}"> {{ __('Transfer Management') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('Transfer Details') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')						
	<div class="row">
		<div class="col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Transfer ID') }}: <span class="text-primary">{{ $id->transfer_id }}</span></h3>
				</div>
				<div class="card-body p-0">
					<table class="table" id="database-backup">
						<tbody>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('User') }}</span><span>{{ $user->name }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5"><span class="font-weight-bold">{{ __('User Group') }}</span><span class="cell-box user-group-{{ $user->group }}">{{ ucfirst($user->group) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('User Email') }}</span><span>{{ $user->email }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5"><span class="font-weight-bold">{{ __('Plan Type') }}</span>@if($id->plan_type == 'free') <span class="cell-box plan-{{ $id->plan_type }}">{{ ucfirst($id->plan_type) }}</span> @else <span class="cell-box plan-{{ $id->plan_type }}">{{ ucfirst($id->plan_type) }}</span>@endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('File Name') }}</span><span>{{ $id->file_name }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('File Share URL') }}</span><span>{{ config('app.url') }}/download/{{ $id->transfer_id }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Format') }}</span><span>{{ strtoupper($id->file_ext) }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Password Protected') }}</span>@if($id->protected)<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>@else <i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i> @endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Total Views') }}</span>{{ $id->views }}</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Total Downloads') }}</span>{{ $id->downloads }}</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Storage Server') }}</span>{{ strtoupper($id->storage) }}</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Transfer Method') }}</span>@if($id->share_type == 'link')<span class="font-weight-bold glacier cell-box">{{ __('Link') }}</span>@else<span class="font-weight-bold glacier-ir cell-box">{{ __('Email') }}</span>@endif</td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Email From') }}</span><span>{{ $user->email }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Emails To') }}</span><span>{{ $user->email }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Transfered On') }}</span><span>{{ $id->created_at }}</span></td></tr>
							<tr><td class="justify-content-between d-flex align-items-center pl-5 pr-5 pt-4 pb-4"><span class="font-weight-bold">{{ __('Expires On') }}</span><span>{{ $id->expires_at }}</span></td></tr>
						</tbody>
					</table>
			 

					<!-- SAVE CHANGES ACTION BUTTON -->
					<div class="border-0 text-right mb-4 mr-4">
						<a href="{{ route('admin.transfer.list') }}" class="btn btn-primary">{{ __('Return') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

