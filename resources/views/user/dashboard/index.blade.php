@extends('layouts.app')

@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
	<!-- Sweet Alert CSS -->
	<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/tippy/scale-extreme.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/tippy/material.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('My Dashboard') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fa-solid fa-chart-tree-map mr-2 fs-12"></i>{{ __('User') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{url('#')}}"> {{ __('My Dashboard') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')
	<!-- USER PROFILE PAGE -->
	<div class="row">

		<div class="col-xl-4 col-lg-4 col-md-12">
			<div class="card border-0 pt-2" id="dashboard-background">
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="@if(auth()->user()->profile_photo_path){{ asset(auth()->user()->profile_photo_path) }} @else {{ URL::asset('img/users/avatar.jpg') }} @endif"></div>
				<div class="card-body text-center">
					<div>
						<h4 class="mb-1 mt-1 font-weight-800 fs-16">{{ auth()->user()->name }}</h4>
						<h6 class="text-muted fs-12">{{ auth()->user()->job_role }}</h6>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-8 col-lg-8 col-md-12">
			<div class="card border-0">				
				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">				
							<div class="d-inline border-0">
								<div>
									<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-hard-drive mr-4 text-info"></i>{{ __('Storage Space Usage') }}</h3>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div>
											<h3 class="card-title fs-24 font-weight-800">{{ $storage_used }}</h3>
										</div>
										<div>
											@if (auth()->user()->storage_total == 0)
												<span class="fs-12 text-muted">{{ __('Unlimited Storage Space') }}</span>
											@else
												<span class="fs-12 text-muted">{{ __('Total of ') }}{{ $user_storage_size }}{{ __(' Used') }}</span>
											@endif
											
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div>
											<h3 class="card-title fs-24 font-weight-800">@if(auth()->user()->download_limit == 0) <i class="fa-solid fa-infinity"></i> @else {{ auth()->user()->download_limit }} @endif</h3>
										</div>
										<div>
											<span class="fs-12 text-muted">{{ __('Monthly Download Limit') }}</span>
										</div>
									</div>
								</div>								
							</div>
							<div>
								<div class="progress mb-4 mt-4">
									<div class="progress-bar progress-bar-striped progress-bar-animated zip-bar" role="progressbar" style="width: {{ $progress['zip'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning documents-bar" role="progressbar" style="width: {{ $progress['document'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-success images-bar" role="progressbar" style="width: {{ $progress['image'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger media-bar" role="progressbar" style="width: {{ $progress['media'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
									<div class="progress-bar progress-bar-striped progress-bar-animated zip-bar2" role="progressbar" style="width: {{ $progress['other'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="progress-info d-flex overflow-x-auto">
									<div class="label mr-5">
										<span class="label-dot zip"></span>
										<b class="label-title">{{ __('Archives') }}</b>
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
										<span class="label-dot zip"></span>
										<b class="label-title">{{ __('Other') }}</b>
									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-12 col-lg-12 col-md-12 mt-2">
			<div class="card border-0">				
				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="d-inline border-0">
								<div>
									<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-shuffle mr-4 text-info"></i>{{ __('Transfers') }} <span class="text-muted">({{ ('Current Month') }})</span></h3>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div>
											<h3 class="card-title fs-24 font-weight-800">{{ $storage_used_current_month }}</h3>
										</div>
										<div class="mb-3">
											<span class="fs-12 text-muted">{{ __('Total Transfers Sizes Shared') }}</span>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div>
											<h3 class="card-title fs-24 font-weight-800">{{ number_format($files_shared_current_month) }}</h3>
										</div>
										<div class="mb-3">
											<span class="fs-12 text-muted">{{ __('Total Files Transfered') }}</span>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div>
											<h3 class="card-title fs-24 font-weight-800">{{ number_format($files_downloads_current_month) }}</h3>
										</div>
										<div class="mb-3">
											<span class="fs-12 text-muted">{{ __('Total Files Downloads') }}</span>
										</div>
									</div>
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
	</div>
	<!-- END USER PROFILE PAGE -->
@endsection

@section('js')
	<!-- Chart JS -->
	<script src="{{URL::asset('plugins/chart/chart.min.js')}}"></script>
	<script src="{{URL::asset('plugins/datatable/datatables.min.js')}}"></script>
	<script src="{{URL::asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
	<script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
	<script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
	<script>
		$(function() {
	
			'use strict';


			let usageData = JSON.parse(`<?php echo $chart_data['links']; ?>`);
			let usageDataset = Object.values(usageData);
			let usageData2 = JSON.parse(`<?php echo $chart_data['emails']; ?>`);
			let usageDataset2 = Object.values(usageData2);
			let delayed;

			let ctx = document.getElementById('chart-user-usage');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
					datasets: [{
						label: '{{ __('Shared via Links') }}',
						data: usageDataset,
						backgroundColor: '#1e1e2d',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					},{
						label: '{{ __('Shared via Emails') }}',
						data: usageDataset2,
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
