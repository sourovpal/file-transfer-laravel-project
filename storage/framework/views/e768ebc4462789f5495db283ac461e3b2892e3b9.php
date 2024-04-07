

<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
	<!-- Sweet Alert CSS -->
	<link href="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('All Registered Users')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-user-shield mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.user.dashboard')); ?>"> <?php echo e(__('User Management')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(route('admin.user.list')); ?>"> <?php echo e(__('User List')); ?></a></li>
			</ol>
		</div>
		<div class="page-rightheader">
			<a href="<?php echo e(route('admin.user.create')); ?>" class="btn btn-primary mt-1"><?php echo e(__('Create New User')); ?></a>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<!-- USERS LIST DATA TABEL -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('User Management')); ?></h3>
				</div>
				<div class="card-body pt-2">
					<!-- BOX CONTENT -->
					<div class="box-content">
						
						<!-- DATATABLE -->
						<table id='listUsersTable' class='table listUsersTable' width='100%'>
								<thead>
									<tr>	
										<th width="20%"><?php echo e(__('User')); ?></th> 		
										<th width="7%"><?php echo e(__('Group')); ?></th>								
										<th width="7%"><?php echo e(__('Storage Used')); ?></th>         	
										<th width="7%"><?php echo e(__('Max Storage')); ?></th>         	       	    						           	     	       	    						           	
										<th width="7%"><?php echo e(__('Max Downloads')); ?></th>         	       	    						           	     	       	    						           	
										<th width="7%"><?php echo e(__('Country')); ?></th>    
										<th width="5%"><?php echo e(__('Status')); ?></th> 						           	
										<th width="7%"><?php echo e(__('Created On')); ?></th> 							    						           	
										<th width="7%"><?php echo e(__('Actions')); ?></th>        	      	
									</tr>
								</thead>
						</table>
						<!-- END DATATABLE -->
						
					</div> <!-- END BOX CONTENT -->
				</div>
			</div>
		</div>
	</div>
	<!-- END USERS LIST DATA TABEL -->
<?php $__env->stopSection(); ?>
  
<?php $__env->startSection('js'); ?>
	<!-- Data Tables JS -->
	<script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";
			
			var table = $('#listUsersTable').DataTable({
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: true,
				colReorder: true,
				"order": [[ 0, "desc" ]],
				language: {
					search: "<i class='fa fa-search search-icon'></i>",
					lengthMenu: '_MENU_ ',
					paginate : {
						first    : '<i class="fa fa-angle-double-left"></i>',
						last     : '<i class="fa fa-angle-double-right"></i>',
						previous : '<i class="fa fa-angle-left"></i>',
						next     : '<i class="fa fa-angle-right"></i>'
					}
				},
				pagingType : 'full_numbers',
				processing: true,
				serverSide: true,
				ajax: "<?php echo e(route('admin.user.list')); ?>",
				columns: [
					{
						data: 'user',
						name: 'user',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-group',
						name: 'custom-group',
						orderable: true,
						searchable: true
					},
					{
						data: 'storage-used',
						name: 'storage-used',
						orderable: true,
						searchable: true
					},
					{
						data: 'max-storage',
						name: 'max-storage',
						orderable: true,
						searchable: true
					},
					{
						data: 'max-downloads',
						name: 'max-downloads',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-country',
						name: 'custom-country',
						orderable: true,
						searchable: true
					},									
					{
						data: 'custom-status',
						name: 'custom-status',
						orderable: true,
						searchable: true
					},
					{
						data: 'created-on',
						name: 'created-on',
						orderable: true,
						searchable: true
					},
					{
						data: 'actions',
						name: 'actions',
						orderable: false,
						searchable: false
					},
				]
			});

			// DELETE CONFIRMATION 
			$(document).on('click', '.deleteUserButton', function(e) {

				e.preventDefault();

				Swal.fire({
					title: '<?php echo e(__('Confirm User Deletion')); ?>',
					text: '<?php echo e(__('Warning! This action will delete user permanently')); ?>',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: '<?php echo e(__('Delete')); ?>',
					reverseButtons: true,
				}).then((result) => {
					if (result.isConfirmed) {
						var formData = new FormData();
						formData.append("id", $(this).attr('id'));
						$.ajax({
							headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
							method: 'post',
							url: 'delete',
							data: formData,
							processData: false,
							contentType: false,
							success: function (data) {
								if (data == 'success') {
									Swal.fire('<?php echo e(__('User Deleted')); ?>', '<?php echo e(__('User has been successfully deleted')); ?>', 'success');	
									$("#listUsersTable").DataTable().ajax.reload();								
								} else {
									Swal.fire('<?php echo e(__('Delete Failed')); ?>', '<?php echo e(__('There was an error while deleting this user')); ?>', 'error');
								}      
							},
							error: function(data) {
								Swal.fire({ type: 'error', title: 'Oops...', text: '<?php echo e(__("Something went wrong")); ?>!' })
							}
						})
					} 
				})
			});
	
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hgdtksec/activec8fbc3cde6ecab5955cdad00.com/resources/views/admin/users/list/index.blade.php ENDPATH**/ ?>