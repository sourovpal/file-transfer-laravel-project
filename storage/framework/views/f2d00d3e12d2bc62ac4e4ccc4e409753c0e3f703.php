

<?php $__env->startSection('page-header'); ?>
	<!--PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Transfer Dashboard')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-shuffle mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.transfer.dashboard')); ?>"> <?php echo e(__('Transfer Management')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> <?php echo e(__('Transfer Dashboard')); ?></a></li>
			</ol>
		</div>
	</div>
	<!--END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>	
	<div class="row">
		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-body">
					<div class="d-flex align-items-end justify-content-between">
						<div class="w-100">
							<p class=" mb-3 fs-12 font-weight-bold"><?php echo e(__('Free Tier Transfers')); ?> <span class="text-muted">(<?php echo e(__('Current Month')); ?>)</span></p>
							<h2 class="mb-0"><span class="number-font-chars"><?php echo e($usage_data['free_current_month']); ?></span></h2>									
						</div>
						<div class="text-right">
							<i class="fs-35 fa-solid fa-dolly" style="vertical-align: bottom;"></i>
						</div>
					</div>
					<div class="d-flex mt-2">
						<div>
							<span class="text-muted fs-12 mr-1"><?php echo e(__('Total Free Transfers')); ?> (<?php echo e(__('Current Year')); ?>):</span>
							<span class="number-font fs-12"><i class="fa fa-bookmark mr-1 text-info"></i><?php echo e($usage_data['free_current_year']); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-body">
					<div class="d-flex align-items-end justify-content-between">
						<div class="w-100">
							<p class=" mb-3 fs-12 font-weight-bold"><?php echo e(__('Subscriber Transfers')); ?> <span class="text-muted">(<?php echo e(__('Current Month')); ?>)</span></p>
							<h2 class="mb-0"><span class="number-font-chars"><?php echo e($usage_data['paid_current_month']); ?></span></h2>									
						</div>
						<div class="text-right">
							<i class="fs-35 text-info fa-solid fa-cart-flatbed" style="vertical-align: bottom;"></i>
						</div>
					</div>
					<div class="d-flex mt-2">
						<div>
							<span class="text-muted fs-12 mr-1"><?php echo e(__('Total Paid Transfers')); ?> (<?php echo e(__('Current Year')); ?>):</span>
							<span class="number-font fs-12"><i class="fa fa-bookmark mr-1 text-info"></i><?php echo e($usage_data['paid_current_year']); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-body">
					<div class="d-flex align-items-end justify-content-between">
						<div class="w-100">
							<p class=" mb-3 fs-12 font-weight-bold"><?php echo e(__('Transfers via Links')); ?> <span class="text-muted">(<?php echo e(__('Current Month')); ?>)</span></p>
							<h2 class="mb-0"><span class="number-font-chars"><?php echo e($usage_data['links_current_month']); ?></span></h2>									
						</div>
						<div class="text-right">
							<i class="fs-35 text-warning fa-solid fa-link" style="vertical-align: bottom;"></i>
						</div>
					</div>
					<div class="d-flex mt-2">
						<div>
							<span class="text-muted fs-12 mr-1"><?php echo e(__('Total Link Transfers')); ?> (<?php echo e(__('Current Year')); ?>):</span>
							<span class="number-font fs-12"><i class="fa fa-bookmark mr-1 text-info"></i><?php echo e($usage_data['links_current_year']); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-body">
					<div class="d-flex align-items-end justify-content-between">
						<div class="w-100">
							<p class=" mb-3 fs-12 font-weight-bold"><?php echo e(__('Transfers via Emails')); ?> <span class="text-muted">(<?php echo e(__('Current Month')); ?>)</span></p>
							<h2 class="mb-0"><span class="number-font-chars"><?php echo e($usage_data['emails_current_month']); ?></span></h2>									
						</div>
						<div class="text-right">
							<i class="fs-35 text-success fa-solid fa-envelope-circle-check" style="vertical-align: bottom;"></i>
						</div>
					</div>
					<div class="d-flex mt-2">
						<div>
							<span class="text-muted fs-12 mr-1"><?php echo e(__('Total Email Transfers')); ?> (<?php echo e(__('Current Year')); ?>):</span>
							<span class="number-font fs-12"><i class="fa fa-bookmark mr-1 text-info"></i><?php echo e($usage_data['emails_current_year']); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card mb-4 border-0">
				<div class="card-header d-inline border-0">
					<div>
						<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-hard-drive mr-4 text-info"></i><?php echo e(__('Storage Usage')); ?></h3>
					</div>
					<div>
						<h3 class="card-title fs-24 font-weight-800"><?php echo e($total_used); ?></h3>
					</div>
					<div class="mb-3">
						<span class="fs-12 text-muted"><?php echo e(__('Total Storage Used Space')); ?></span>
					</div>
				</div>
				<div class="card-body">
					<div class="progress mb-4">
						<div class="progress-bar progress-bar-striped progress-bar-animated zip-bar" role="progressbar" style="width: <?php echo e($progress['zip']); ?>%" aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning documents-bar" role="progressbar" style="width: <?php echo e($progress['document']); ?>%" aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-success images-bar" role="progressbar" style="width: <?php echo e($progress['image']); ?>%" aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger media-bar" role="progressbar" style="width: <?php echo e($progress['media']); ?>%" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<div class="progress-info d-flex overflow-x-auto">
						<div class="label mr-5">
							<span class="label-dot zip"></span>
							<b class="label-title"><?php echo e(__('Archives')); ?></b>
						</div>
						<div class="label mr-5">
							<span class="label-dot documents"></span>
							<b class="label-title"><?php echo e(__('Documents')); ?></b>
						</div>
						<div class="label mr-5">
							<span class="label-dot images"></span>
							<b class="label-title"><?php echo e(__('Images')); ?></b>
						</div>
						<div class="label mr-5">
							<span class="label-dot media"></span>
							<b class="label-title"><?php echo e(__('Audio & Video')); ?></b>
						</div>
						<div class="label mr-5">
							<span class="label-dot other"></span>
							<b class="label-title"><?php echo e(__('Other')); ?></b>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- CURRENT YEAR USAGE ANALYTICS -->
	<div class="row mt-4">
		<div class="col-lg-12 col-md-12">
			<div class="card mb-4 overflow-hidden border-0">
				<div class="card-header d-inline border-0">
					<div>
						<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-cloud-arrow-up mr-4 text-info"></i><?php echo e(__('Transfered Files')); ?> <span class="text-muted">(<?php echo e(__('Current Month')); ?>)</span></h3>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div>
								<h3 class="card-title fs-24 font-weight-800"><?php echo e(number_format($total_transfers_current_month)); ?></h3>
							</div>
							<div class="mb-3">
								<span class="fs-12 text-muted"><?php echo e(__('Total Active Transfers During Current Month')); ?></span>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div>
								<h3 class="card-title fs-24 font-weight-800"><?php echo e(number_format($total_transfers_current_year)); ?></h3>
							</div>
							<div class="mb-3">
								<span class="fs-12 text-muted"><?php echo e(__('Total Active Transfers During Current Year')); ?></span>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div>
								<h3 class="card-title fs-24 font-weight-800"><?php echo e(number_format($total_downloads_current_year)); ?></h3>
							</div>
							<div class="mb-3">
								<span class="fs-12 text-muted"><?php echo e(__('Total Downloads of Active Transfers During Current Year')); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="">
								<canvas id="chart-storage-dashboard-monthly" class="h-400"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-lg-12 col-md-12">
			<div class="card mb-4 overflow-hidden border-0">
				<div class="card-header d-inline border-0">
					<div>
						<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-cloud-arrow-up mr-4 text-info"></i><?php echo e(__('Transfers Size')); ?> <span class="text-muted">(<?php echo e(__('Current Year')); ?>)</span></h3>
					</div>
					<div>
						<h3 class="card-title fs-24 font-weight-800"><?php echo e($total_used_current_year); ?></h3>
					</div>
					<div class="mb-3">
						<span class="fs-12 text-muted"><?php echo e(__('Total Active Transfers Size Shared During Current Year')); ?></span>
					</div>

				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="">
								<canvas id="chart-storage-dashboard" class="h-400"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- CURRENT YEAR USAGE ANALYTICS -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Chart JS -->
	<script src="<?php echo e(URL::asset('plugins/chart/chart.min.js')); ?>"></script>
	<script type="text/javascript">
		$(function() {
	
			'use strict';
			
			let usageData = JSON.parse(`<?php echo $chart_data['storage_usage']; ?>`);
			let usageDataset = Object.values(usageData);
			let delayed;

			let ctx = document.getElementById('chart-storage-dashboard');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					datasets: [{
						label: 'Shared (MB)',
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
								stepSize: 500,
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


			let usageData2 = JSON.parse(`<?php echo $chart_data['storage_usage_quantity']; ?>`);
			let usageDataset2 = Object.values(usageData2);
			let delayed2;

			let ctx2 = document.getElementById('chart-storage-dashboard-monthly');
			new Chart(ctx2, {
				type: 'bar',
				data: {
					labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
					datasets: [{
						label: '<?php echo e(__('Transfered Files')); ?>',
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
							delayed2 = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed2) {
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
								stepSize: 5000,
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hgdtksec/activec8fbc3cde6ecab5955cdad00.com/resources/views/admin/transfers/dashboard/index.blade.php ENDPATH**/ ?>