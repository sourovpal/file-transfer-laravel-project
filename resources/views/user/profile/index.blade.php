@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('My Profile') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('User') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('My Profile') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')
	<!-- USER PROFILE PAGE -->
	<div class="row">

		<div class="col-xl-3 col-lg-3 col-md-12">
			<div class="card border-0" id="dashboard-background">
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="@if(auth()->user()->profile_photo_path){{ asset(auth()->user()->profile_photo_path) }} @else {{ URL::asset('img/users/avatar.jpg') }} @endif"></div>
				<div class="card-body text-center">
					<div>
						<h4 class="mb-1 mt-1 font-weight-bold fs-16">{{ auth()->user()->name }}</h4>
						<h6 class="text-muted fs-12">{{ auth()->user()->job_role }}</h6>
					</div>
				</div>
				<div class="card-footer p-0">
					<div class="row">
						<div class="col-sm-12">
							<div class="text-center p-4">
								<h5 class="mb-1 font-weight-bold text-highlight number-font fs-14">{{ $storage['available'] }}</h5>
								<span class="text-muted fs-12">{{ __('Total Allocated Storage Space') }}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer p-0">
					<div class="row" id="profile-pages">
						<div class="col-sm-12">
							<div class="text-center pt-4">
								<a href="{{ route('user.profile.edit') }}" class="fs-13 text-muted"><i class="fa fa-calendar-lines-pen mr-1"></i> {{ __('Update Profile') }}</a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center p-3 ">
								<a href="{{ route('user.security') }}" class="fs-13 text-muted"><i class="fa fa-lock-hashtag mr-1"></i> {{ __('Change Password') }}</a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center pb-4">
								<a href="{{ route('user.security.2fa') }}" class="fs-13 text-muted"><i class="fa fa-shield-check mr-1"></i> {{ __('2FA Authentication') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card border-0">
				<div class="card-body">
					<h4 class="card-title mb-4 mt-1">{{ __('Personal Details') }}</h4>
					<div class="table-responsive">
						<table class="table mb-0">
							<tbody>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Full Name') }} </span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->name }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Job Role') }}</span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->job_role }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Company') }}</span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->company }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Website') }} </span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->website }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('City') }} </span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->city }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Country') }} </span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->country }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Email') }} </span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->email }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Phone') }} </span>
									</td>
									<td class="py-2 px-0">{{ auth()->user()->phone_number }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-9 col-lg-9 col-md-12">

			<div class="row">
				<div class="col-lg-6 col-md-12 col-xm-12">
					<div class="card overflow-hidden border-0">
						<div class="card-body d-flex">
							<div class="usage-info w-100">
								<p class=" mb-0 fs-12 font-weight-bold">{{ __('Total Shares via Link') }}</p>
								<h2 class="mb-1 mt-2 number-font-light font-weight-800">{{ number_format($storage['links']) }}</h2>
							</div>
							<div class="usage-icon text-right">
								<i class="fa-solid fa-link"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-xm-12">
					<div class="card overflow-hidden border-0">
						<div class="card-body d-flex">
							<div class="usage-info w-100">
								<p class=" mb-0 fs-12 font-weight-bold">{{ __('Total Shares via Email') }}</p>
								<h2 class="mb-1 mt-2 number-font-light font-weight-800">{{ number_format($storage['emails']) }}</h2>
							</div>
							<div class="usage-icon text-right">
								<i class="fa-solid fa-envelope-circle-check"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="card border-0">
						<div class="card-header d-inline border-0">
							<div>
								<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-hard-drive mr-4 text-info"></i>{{ __('Storage Usage') }}</h3>
							</div>
							<div>
								<h3 class="card-title fs-24 font-weight-800">{{ $storage_used }}</h3>
							</div>
							<div class="mb-3">
								@if (auth()->user()->storage_total == 0)
									<span class="fs-12 text-muted">{{ __('Unlimited Storage Space') }}</span>
								@else
									<span class="fs-12 text-muted">{{ __('Total allocated storage space is ') }}{{ $user_storage_size }}</span>
								@endif								
							</div>
						</div>
						<div class="card-body">
							<div class="progress mb-4">
								<div class="progress-bar progress-bar-striped progress-bar-animated zip-bar" role="progressbar" style="width: {{ $progress['zip'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning documents-bar" role="progressbar" style="width: {{ $progress['document'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-success images-bar" role="progressbar" style="width: {{ $progress['image'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger media-bar" role="progressbar" style="width: {{ $progress['media'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<div class="progress-info d-flex overflow-x-auto">
								<div class="label mr-5">
									<span class="label-dot zip"></span>
									<b class="label-title">{{ __('Zip Files') }}</b>
								</div>
								<div class="label mr-5">
									<span class="label-dot documents"></span>
									<b class="label-title">{{ __('Documents') }}</b>
								</div>
								<div class="label mr-5">
									<span class="label-dot images"></span>
									<b class="label-title">{{ __('Images') }}</b>
								</div>
								<div class="label mr-5">
									<span class="label-dot media"></span>
									<b class="label-title">{{ __('Audio & Video') }}</b>
								</div>
								<div class="label mr-5">
									<span class="label-dot other"></span>
									<b class="label-title">{{ __('Other') }}</b>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="card border-0">
						<div class="card-header d-inline border-0">
							<div>
								<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-shuffle mr-4 text-info"></i>{{ __('File Transfers') }}</h3>
							</div>
							<div>
								<h3 class="card-title fs-24 font-weight-800">{{ $storage_used_current_year }}</h3>
							</div>
							<div class="mb-3">
								<span class="fs-12 text-muted">{{ __('Total Active Transfers Sizes During Current Year') }}</span>
							</div>
						</div>
						<div class="card-body">
							<div class="chartjs-wrapper-demo">
								<canvas id="chart-user-usage" class="h-330"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- END USER PROFILE PAGE -->
@endsection

@section('js')
	<!-- Chart JS -->
	<script src="{{URL::asset('plugins/chart/chart.min.js')}}"></script>
	<script>
		$(function() {
	
			'use strict';

			let usageData = JSON.parse(`<?php echo $chart_data['storage_usage']; ?>`);
			let usageDataset = Object.values(usageData);
			let delayed;

			let ctx = document.getElementById('chart-user-usage');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					datasets: [{
						label: 'Transfered (MB)',
						data: usageDataset,
						backgroundColor: '#007bff',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
						labels: {
							display: false
						}
					},
					responsive: true,
					animation: {
						onComplete: () => {
							delayed = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed) {
								delay = context.dataIndex * 50 + context.datasetIndex * 5;
							}
							return delay;
						},
					},
					scales: {
						y: {
							stacked: true,
							ticks: {
								beginAtZero: true,
								font: {
									size: 10
								},
								stepSize: 2000,
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
						x: {
							stacked: true,
							ticks: {
								font: {
									size: 10
								}
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
					},
					plugins: {
						tooltip: {
							cornerRadius: 10,
							padding: 15,
							backgroundColor: '#000000',
							titleColor: '#FF9D00',
							yAlign: 'bottom',
							xAlign: 'center',
						},
						legend: {
							position: 'bottom',
							labels: {
								boxWidth: 10,
								font: {
									size: 10
								}
							}
						}
					}
					
				}
			});
		});
	</script>
@endsection
