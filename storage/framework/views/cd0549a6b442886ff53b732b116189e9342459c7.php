

<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/awselect/awselect.min.css')); ?>" rel="stylesheet" />
	<link href="<?php echo e(URL::asset('plugins/tippy/scale-extreme.css')); ?>" rel="stylesheet" />
	<link href="<?php echo e(URL::asset('plugins/tippy/material.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Transfer Settings')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-shuffle mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.transfer.dashboard')); ?>"> <?php echo e(__('Transfer Management')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> <?php echo e(__('Transfer Settings')); ?></a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>					
	<div class="row">
		<div class="col-lg-8 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title"><i class="fa-sharp fa-solid fa-sliders mr-2 text-primary"></i><?php echo e(__('Setup Transfer Settings')); ?></h3>
				</div>
				<div class="card-body">
				
					<form action="<?php echo e(route('admin.transfer.configs.store')); ?>" method="POST" enctype="multipart/form-data">
						<?php echo csrf_field(); ?>

						<div class="row">							

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6><?php echo e(__('Default File Storage')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="selected-storage" name="selected-storage" data-placeholder="<?php echo e(__('Choose Default File Storage')); ?>:">			
										<option value="local" <?php if( config('settings.default_storage')  == 'local'): ?> selected <?php endif; ?>><?php echo e(__('Local Server')); ?></option>
										<option value="aws" <?php if( config('settings.default_storage')  == 'aws'): ?> selected <?php endif; ?>><?php echo e(__('Amazon Web Services')); ?></option>
										<option value="wasabi" <?php if( config('settings.default_storage')  == 'wasabi'): ?> selected <?php endif; ?>><?php echo e(__('Wasabi')); ?></option>
										<option value="gcp" <?php if( config('settings.default_storage')  == 'gcp'): ?> selected <?php endif; ?>><?php echo e(__('Google Cloud Platform')); ?></option>
										<option value="storj" <?php if( config('settings.default_storage')  == 'storj'): ?> selected <?php endif; ?>><?php echo e(__('Storj')); ?></option>
										<option value="dropbox" <?php if( config('settings.default_storage')  == 'dropbox'): ?> selected <?php endif; ?>><?php echo e(__('Dropbox')); ?></option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6><?php echo e(__('Default File Share Method')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="selected-share-method" name="selected-share-method" data-placeholder="<?php echo e(__('Choose Default File Share Method')); ?>:">			
										<option value="link" <?php if( config('settings.default_share_method')  == 'link'): ?> selected <?php endif; ?>><?php echo e(__('Link')); ?></option>
										<option value="email" <?php if( config('settings.default_share_method')  == 'email'): ?> selected <?php endif; ?>><?php echo e(__('Email')); ?></option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6><?php echo e(__('Default Allocated Initial Storage Capacity')); ?> <span class="text-muted">(MB) (<?php echo e(__('For Newly Registered Users')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="number" class="form-control <?php $__errorArgs = ['default-storage-size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="default-storage-size" name="default-storage-size" placeholder="Ex: 1000" value="<?php echo e(config('settings.default_storage_size')); ?>" required>
										<?php $__errorArgs = ['default-storage-size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('default-storage-size')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div> 
								</div> 						
							</div>	

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6><?php echo e(__('Server Side Encryption')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Applicable only to AWS | Wasabi cloud vendors.')); ?>"></i></h6>
									  	<select id="server-encryption" name="server-encryption" data-placeholder="<?php echo e(__('Enable/Disable S3 Server Side Encryption')); ?>:">			
										<option value="enable" <?php if( config('settings.server_encryption')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
										<option value="disable" <?php if( config('settings.server_encryption')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6><?php echo e(__('Password Protection for Download')); ?> <span class="text-muted">(<?php echo e(__('Default State')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="password-protection" name="password-protection-default-state" data-placeholder="<?php echo e(__('Enable/Disable Password Protection for Download Link')); ?>:">			
										<option value="enable" <?php if( config('settings.password_protection_default_state')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
										<option value="disable" <?php if( config('settings.password_protection_default_state')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6><?php echo e(__('Link Expiration')); ?> <span class="text-muted">(<?php echo e(__('Default State')); ?>)</span><span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									  	<select id="link-expiration" name="link-expiration-default-state" data-placeholder="<?php echo e(__('Enable/Disable Link Expiration Feature')); ?>:">			
										<option value="enable" <?php if( config('settings.link_expiration_default_state')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
										<option value="disable" <?php if( config('settings.link_expiration_default_state')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6><?php echo e(__('Maximum Transfer File Size')); ?> (MB) <span class="text-muted">(<?php echo e(__('For Admin Group')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> </span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Maximum upload size limit for a single file for admin group. Provide size in MB.')); ?>"></i></h6>
									<div class="form-group">							    
										<input type="number" class="form-control <?php $__errorArgs = ['maximum-upload-limit-admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="maximum-upload-limit-admin" name="maximum-upload-limit-admin" placeholder="Ex: 1000" value="<?php echo e(config('settings.upload_limit_admin')); ?>" required>
										<?php $__errorArgs = ['maximum-upload-limit-admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('maximum-upload-limit-admin')); ?></p>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div> 
								</div>							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6><?php echo e(__('Maximum Transfer File Quantity')); ?> <span class="text-muted">(<?php echo e(__('For Admin Group')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Maximum parallel upload file quantity limit for admin group.')); ?>"></i></h6>
									<div class="form-group">							    
										<input type="number" class="form-control <?php $__errorArgs = ['maximum-upload-quantity-admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="maximum-upload-quantity-admin" name="maximum-upload-quantity-admin" placeholder="Ex: 1" value="<?php echo e(config('settings.upload_quantity_admin')); ?>" required>
										<?php $__errorArgs = ['maximum-upload-quantity-admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('maximum-upload-quantity-admin')); ?></p>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div> 
								</div>							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6><?php echo e(__('Maximum Transfer Expiration Days Limit')); ?> <span class="text-muted">(<?php echo e(__('For Admin Group')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="number" class="form-control <?php $__errorArgs = ['expiration-days-admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="expiration-days-admin" name="expiration-days-admin" placeholder="Ex: 1" value="<?php echo e(config('settings.expiration_days_limit_admin')); ?>" required>
										<?php $__errorArgs = ['expiration-days-admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('expiration-days-admin')); ?></p>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div> 
								</div>							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">								
									<h6><?php echo e(__('Transfer Download Limit per Month')); ?> <span class="text-muted">(<?php echo e(__('For Admin Group')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('All user transfered data cannot exceed download limit set during current month.')); ?>"></i></h6>
									<div class="form-group">							    
										<input type="number" class="form-control <?php $__errorArgs = ['download-limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="download-limit" name="download-limit" placeholder="Ex: 1" value="<?php echo e(config('settings.download_limit_admin')); ?>" required>
										<?php $__errorArgs = ['download-limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('download-limit')); ?></p>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div> 
								</div>							
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">

								<h6 class="fs-12 font-weight-bold mb-4"><i class="fa fa-gift text-info fs-14 mr-2"></i><?php echo e(__('Free Tier Options')); ?> <span class="text-muted">(<?php echo e(__('User Group Only')); ?>)</span></h6>

								<div class="row">							
									
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6><?php echo e(__('Maximum Transfer File Size')); ?> (MB) <span class="text-muted">(<?php echo e(__('For User Group')); ?>)<span class="text-required"><i class="fa-solid fa-asterisk"></i></span> </span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Maximum upload size limit for a single file for free tier user group. Provide size in MB.')); ?>"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control <?php $__errorArgs = ['maximum-upload-limit-user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="maximum-upload-limit-user" name="maximum-upload-limit-user" placeholder="Ex: 1000" value="<?php echo e(config('settings.upload_limit_user')); ?>" required>
												<?php $__errorArgs = ['maximum-upload-limit-user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('maximum-upload-limit-user')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div>							
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6><?php echo e(__('Maximum Transfer File Quantity')); ?> <span class="text-muted">(<?php echo e(__('For User Group')); ?>) <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> </span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Maximum parallel upload file quantity limit for free tier user group.')); ?>"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control <?php $__errorArgs = ['maximum-upload-quantity-user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="maximum-upload-quantity-user" name="maximum-upload-quantity-user" placeholder="Ex: 1" value="<?php echo e(config('settings.upload_quantity_user')); ?>" required>
												<?php $__errorArgs = ['maximum-upload-quantity-user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('maximum-upload-quantity-user')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div>							
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6><?php echo e(__('Allow Password Protection Feature')); ?> <span class="text-muted">(<?php echo e(__('For User Group')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="password-protection-user" name="password-protection-user" data-placeholder="<?php echo e(__('Enable/Disable Password Protection for Download Link')); ?>:">			
												<option value="enable" <?php if( config('settings.password_protection_feature_user')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
												<option value="disable" <?php if( config('settings.password_protection_feature_user')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
											</select>
										</div>								
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6><?php echo e(__('Allow Link Expiration Feature')); ?> <span class="text-muted">(<?php echo e(__('For User Group')); ?>)</span><span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="link-expiration-user" name="link-expiration-user" data-placeholder="<?php echo e(__('Enable/Disable Link Expiration Feature')); ?>:">			
												<option value="enable" <?php if( config('settings.link_expiration_feature_user')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
												<option value="disable" <?php if( config('settings.link_expiration_feature_user')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
											</select>
										</div>								
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6><?php echo e(__('Maximum Transfer Expiration Days Limit')); ?> <span class="text-muted">(<?php echo e(__('For User Group')); ?>)</span><span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Free tier user will not be able to exceed this limit when setting expiration days for their links.')); ?>"></i></h6>
											<input type="number" class="form-control <?php $__errorArgs = ['expiration-days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="expiration-days" name="expiration-days" placeholder="Ex: 10" value="<?php echo e(config('settings.expiration_days_limit_user')); ?>" required>
											<?php $__errorArgs = ['expiration-days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
												<p class="text-danger"><?php echo e($errors->first('expiration-days')); ?></p>
											<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
										</div>								
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6><?php echo e(__('Transfer Download Limit per Month')); ?> <span class="text-muted">(<?php echo e(__('For User Group')); ?>)</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('All user transfered data cannot exceed download limit set during current month.')); ?>"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control <?php $__errorArgs = ['download-limit-user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="download-limit-user" name="download-limit-user" placeholder="Ex: 1" value="<?php echo e(config('settings.download_limit_user')); ?>" required>
												<?php $__errorArgs = ['download-limit-user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('download-limit-user')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div>							
									</div>
								</div>	
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">

								<h6 class="fs-12 font-weight-bold mb-4"><i class="fa-solid fa-browser text-yellow fs-14 mr-2"></i><?php echo e(__('Frontend Demo Options')); ?></h6>

								<div class="row">							
									
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6><?php echo e(__('Maximum Transfer File Size')); ?> (MB) <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Maximum upload size limit for a single file. Provide size in MB.')); ?>"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control <?php $__errorArgs = ['maximum-upload-limit-frontend'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="maximum-upload-limit-frontend" name="maximum-upload-limit-frontend" placeholder="Ex: 1000" value="<?php echo e(config('settings.upload_limit_frontend')); ?>" required>
												<?php $__errorArgs = ['maximum-upload-limit-frontend'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('maximum-upload-limit-frontend')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div>							
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">								
											<h6><?php echo e(__('Maximum Transfer File Quantity')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Maximum parallel upload file quantity limit for free tier user group.')); ?>"></i></h6>
											<div class="form-group">							    
												<input type="number" class="form-control <?php $__errorArgs = ['maximum-upload-quantity-frontend'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="maximum-upload-quantity-frontend" name="maximum-upload-quantity-frontend" placeholder="Ex: 1" value="<?php echo e(config('settings.upload_quantity_frontend')); ?>" required>
												<?php $__errorArgs = ['maximum-upload-quantity-frontend'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('maximum-upload-quantity-frontend')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div>							
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6><?php echo e(__('Allow Password Protection Feature')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="password-protection-frontend" name="password-protection-frontend" data-placeholder="<?php echo e(__('Enable/Disable Password Protection for Download Link')); ?>:">			
												<option value="enable" <?php if( config('settings.password_protection_feature_frontend')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
												<option value="disable" <?php if( config('settings.password_protection_feature_frontend')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
											</select>
										</div>								
									</div>
		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6><?php echo e(__('Allow Link Expiration Feature')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												  <select id="link-expiration-frontend" name="link-expiration-frontend" data-placeholder="<?php echo e(__('Enable/Disable Link Expiration Feature')); ?>:">			
												<option value="enable" <?php if( config('settings.link_expiration_feature_frontend')  == 'enable'): ?> selected <?php endif; ?>><?php echo e(__('Enable')); ?></option>
												<option value="disable" <?php if( config('settings.link_expiration_feature_frontend')  == 'disable'): ?> selected <?php endif; ?>><?php echo e(__('Disable')); ?></option>
											</select>
										</div>								
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">	
											<h6><?php echo e(__('Maximum Transfer Expiration Days Limit')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span><i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Expiration date not be able to exceed this limit when setting expiration days for their links.')); ?>"></i></h6>
											<input type="number" class="form-control <?php $__errorArgs = ['expiration-days-frontend'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="expiration-days-frontend" name="expiration-days-frontend" placeholder="Ex: 10" value="<?php echo e(config('settings.expiration_days_limit_frontend')); ?>" required>
											<?php $__errorArgs = ['expiration-days-frontend'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
												<p class="text-danger"><?php echo e($errors->first('expiration-days-frontend')); ?></p>
											<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
										</div>								
									</div>
								</div>	
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="<?php echo e(URL::asset('img/csp/aws-sm.png')); ?>" class="fw-2 mr-2" alt=""><?php echo e(__('Amazon Web Services')); ?></h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('AWS Access Key')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-aws-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="aws-access-key" name="set-aws-access-key" value="<?php echo e(config('services.aws.key')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-aws-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-aws-access-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('AWS Secret Access Key')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-aws-secret-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="aws-secret-access-key" name="set-aws-secret-access-key" value="<?php echo e(config('services.aws.secret')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-aws-secret-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-aws-secret-access-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Amazon S3 Bucket Name')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-aws-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="aws-bucket" name="set-aws-bucket" value="<?php echo e(config('services.aws.bucket')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-aws-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-aws-bucket')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- AWS REGION -->
										<div class="input-box">	
											<h6><?php echo e(__('Set AWS Region')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<select id="set-aws-region" name="set-aws-region" data-placeholder="Select Default AWS Region:">			
												<option value="us-east-1" <?php if( config('services.aws.region')  == 'us-east-1'): ?> selected <?php endif; ?>><?php echo e(__('US East (N. Virginia) us-east-1')); ?></option>
												<option value="us-east-2" <?php if( config('services.aws.region')  == 'us-east-2'): ?> selected <?php endif; ?>><?php echo e(__('US East (Ohio) us-east-2')); ?></option>
												<option value="us-west-1" <?php if( config('services.aws.region')  == 'us-west-1'): ?> selected <?php endif; ?>><?php echo e(__('US West (N. California) us-west-1')); ?></option>
												<option value="us-west-2" <?php if( config('services.aws.region')  == 'us-west-2'): ?> selected <?php endif; ?>><?php echo e(__('US West (Oregon) us-west-2')); ?></option>
												<option value="ap-east-1" <?php if( config('services.aws.region')  == 'ap-east-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Hong Kong) ap-east-1')); ?></option>
												<option value="ap-south-1" <?php if( config('services.aws.region')  == 'ap-south-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Mumbai) ap-south-1')); ?></option>
												<option value="ap-northeast-3" <?php if( config('services.aws.region')  == 'ap-northeast-3'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Osaka) ap-northeast-3')); ?></option>
												<option value="ap-northeast-2" <?php if( config('services.aws.region')  == 'ap-northeast-2'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Seoul) ap-northeast-2')); ?></option>
												<option value="ap-southeast-1" <?php if( config('services.aws.region')  == 'ap-southeast-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Singapore) ap-southeast-1')); ?></option>
												<option value="ap-southeast-2" <?php if( config('services.aws.region')  == 'ap-southeast-2'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Sydney) ap-southeast-2')); ?></option>
												<option value="ap-northeast-1" <?php if( config('services.aws.region')  == 'ap-northeast-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Tokyo) ap-northeast-1')); ?></option>
												<option value="ap-northeast-1" <?php if( config('services.aws.region')  == 'ap-northeast-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Hyderabad) ap-south-2')); ?></option>
												<option value="ap-northeast-1" <?php if( config('services.aws.region')  == 'ap-northeast-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific (Jakarta) ap-southeast-3')); ?></option>
												<option value="eu-central-1" <?php if( config('services.aws.region')  == 'eu-central-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Frankfurt) eu-central-1')); ?></option>
												<option value="eu-central-1" <?php if( config('services.aws.region')  == 'eu-central-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Zurich) eu-central-2')); ?></option>
												<option value="eu-west-1" <?php if( config('services.aws.region')  == 'eu-west-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Ireland) eu-west-1')); ?></option>
												<option value="eu-west-2" <?php if( config('services.aws.region')  == 'eu-west-2'): ?> selected <?php endif; ?>><?php echo e(__('Europe (London) eu-west-2')); ?></option>
												<option value="eu-south-1" <?php if( config('services.aws.region')  == 'eu-south-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Milan) eu-south-1')); ?></option>
												<option value="eu-south-1" <?php if( config('services.aws.region')  == 'eu-south-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Spain) eu-south-2')); ?></option>
												<option value="eu-west-3" <?php if( config('services.aws.region')  == 'eu-west-3'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Paris) eu-west-3')); ?></option>
												<option value="eu-north-1" <?php if( config('services.aws.region')  == 'eu-north-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe (Stockholm) eu-north-1')); ?></option>
												<option value="me-south-1" <?php if( config('services.aws.region')  == 'me-south-1'): ?> selected <?php endif; ?>><?php echo e(__('Middle East (Bahrain) me-south-1')); ?></option>
												<option value="me-south-1" <?php if( config('services.aws.region')  == 'me-south-1'): ?> selected <?php endif; ?>><?php echo e(__('Middle East (UAE) me-central-1')); ?></option>
												<option value="sa-east-1" <?php if( config('services.aws.region')  == 'sa-east-1'): ?> selected <?php endif; ?>><?php echo e(__('South America (São Paulo) sa-east-1')); ?></option>
												<option value="ca-central-1" <?php if( config('services.aws.region')  == 'ca-central-1'): ?> selected <?php endif; ?>><?php echo e(__('Canada (Central) ca-central-1')); ?></option>
												<option value="af-south-1" <?php if( config('services.aws.region')  == 'af-south-1'): ?> selected <?php endif; ?>><?php echo e(__('Africa (Cape Town) af-south-1')); ?></option>
											</select>
										</div> <!-- END AWS REGION -->									
									</div>									
		
								</div>
	
							</div>
						</div>	


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="<?php echo e(URL::asset('img/csp/wasabi-sm.png')); ?>" class="fw-2 mr-2" alt=""><?php echo e(__('Wasabi Cloud Storage')); ?></h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>Wasabi Access Key <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-wasabi-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="wasabi-access-key" name="set-wasabi-access-key" value="<?php echo e(config('services.wasabi.key')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-wasabi-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-wasabi-access-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6>Wasabi Secret Access Key <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-wasabi-secret-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="wasabi-secret-access-key" name="set-wasabi-secret-access-key" value="<?php echo e(config('services.wasabi.secret')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-wasabi-secret-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-wasabi-secret-access-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6>Wasabi Bucket Name <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-wasabi-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="wasabi-bucket" name="set-wasabi-bucket" value="<?php echo e(config('services.wasabi.bucket')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-wasabi-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-wasabi-bucket')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- AWS REGION -->
										<div class="input-box">	
											<h6><?php echo e(__('Set Wasabi Region')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											  <select id="set-wasabi-region" name="set-wasabi-region" data-placeholder="Select Default Wasabi Region:">			
												<option value="us-west-1" <?php if( config('services.wasabi.region')  == 'us-west-1'): ?> selected <?php endif; ?>><?php echo e(__('US Oregon us-west-1')); ?></option>
												<option value="us-central-1" <?php if( config('services.wasabi.region')  == 'us-central-1'): ?> selected <?php endif; ?>><?php echo e(__('US Texas us-central-1')); ?></option>
												<option value="us-east-1" <?php if( config('services.wasabi.region')  == 'us-east-1'): ?> selected <?php endif; ?>><?php echo e(__('US N.Virginia us-east-1')); ?></option>
												<option value="us-east-2" <?php if( config('services.wasabi.region')  == 'us-east-2'): ?> selected <?php endif; ?>><?php echo e(__('US N.Virginia us-east-2')); ?></option>
												<option value="ap-northeast-1" <?php if( config('services.wasabi.region')  == 'ap-northeast-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific Tokyo ap-northeast-1')); ?></option>
												<option value="ap-northeast-2" <?php if( config('services.wasabi.region')  == 'ap-northeast-2'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific Osaka ap-northeast-2')); ?></option>
												<option value="ap-sotheast-1" <?php if( config('services.wasabi.region')  == 'ap-sotheast-1'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific Singapore ap-sotheast-1')); ?></option>
												<option value="ap-southeast-2" <?php if( config('services.wasabi.region')  == 'ap-southeast-2'): ?> selected <?php endif; ?>><?php echo e(__('Asia Pacific Sydney ap-southeast-2')); ?></option>
												<option value="ca-central-1" <?php if( config('services.wasabi.region')  == 'ca-central-1'): ?> selected <?php endif; ?>><?php echo e(__('Canada Toronto ca-central-1')); ?></option>
												<option value="eu-central-1" <?php if( config('services.wasabi.region')  == 'eu-central-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe Amsterdam eu-central-1')); ?></option>
												<option value="eu-central-2" <?php if( config('services.wasabi.region')  == 'eu-central-2'): ?> selected <?php endif; ?>><?php echo e(__('Europe Frankfurt eu-central-2')); ?></option>
												<option value="eu-west-1" <?php if( config('services.wasabi.region')  == 'eu-west-1'): ?> selected <?php endif; ?>><?php echo e(__('Europe London eu-west-1')); ?></option>
												<option value="eu-west-2" <?php if( config('services.wasabi.region')  == 'eu-west-2'): ?> selected <?php endif; ?>><?php echo e(__('Europe Paris eu-west-2')); ?></option>
											</select>
										</div> <!-- END AWS REGION -->									
									</div>								
		
								</div>
	
							</div>
						</div>


						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">

								<h6 class="fs-12 font-weight-bold mb-4"><img src="<?php echo e(URL::asset('img/csp/gcp-sm.png')); ?>" class="fw-2 mr-2" alt=""><?php echo e(__('Google Cloud Platform')); ?></h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('GCP Configuration File Path')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['gcp-configuration-path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gcp-configuration-path" name="gcp-configuration-path" value="<?php echo e(config('services.gcp.key_path')); ?>" autocomplete="off">
												<?php $__errorArgs = ['gcp-configuration-path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('gcp-configuration-path')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>	
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<div class="input-box">								
											<h6>GCP Storage Bucket Name <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['gcp-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gcp-bucket" name="gcp-bucket" value="<?php echo e(config('services.gcp.bucket')); ?>" autocomplete="off">
												<?php $__errorArgs = ['gcp-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('gcp-bucket')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> 
									</div>							
								</div>
	
							</div>
						</div>

						<div class="card border-0 special-shadow mb-7">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="<?php echo e(URL::asset('img/csp/storj-ssm.png')); ?>" class="fw-2 mr-2" alt=""><?php echo e(__('Storj Cloud')); ?></h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Storj Access Key')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-storj-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="storj-access-key" name="set-storj-access-key" value="<?php echo e(config('services.storj.key')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-storj-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-storj-access-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Storj Secret Access Key')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-storj-secret-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="storj-secret-access-key" name="set-storj-secret-access-key" value="<?php echo e(config('services.storj.secret')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-storj-secret-access-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-storj-secret-access-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Storj Bucket Name')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-storj-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="storj-bucket" name="set-storj-bucket" value="<?php echo e(config('services.storj.bucket')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-storj-bucket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-storj-bucket')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>									
		
								</div>
	
							</div>
						</div>

						<div class="card border-0 special-shadow">							
							<div class="card-body">
								<h6 class="fs-12 font-weight-bold mb-4"><img src="<?php echo e(URL::asset('img/csp/dropbox-ssm.png')); ?>" class="fw-2 mr-2" alt=""><?php echo e(__('Dropbox')); ?></h6>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Dropbox App Key')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-dropbox-app-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="dropbox-app-key" name="set-dropbox-app-key" value="<?php echo e(config('services.dropbox.key')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-dropbox-app-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-dropbox-app-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<!-- SECRET ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Dropbox Secret Key')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-dropbox-secret-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="dropbox-secret-key" name="set-dropbox-secret-key" value="<?php echo e(config('services.dropbox.secret')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-dropbox-secret-key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-dropbox-secret-key')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END SECRET ACCESS KEY -->
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">								
										<!-- ACCESS KEY -->
										<div class="input-box">								
											<h6><?php echo e(__('Dropbox Access Token')); ?>  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
											<div class="form-group">							    
												<input type="text" class="form-control <?php $__errorArgs = ['set-dropbox-access-token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="dropbox-access-token" name="set-dropbox-access-token" value="<?php echo e(config('services.dropbox.token')); ?>" autocomplete="off">
												<?php $__errorArgs = ['set-dropbox-access-token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
													<p class="text-danger"><?php echo e($errors->first('set-dropbox-access-token')); ?></p>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
											</div> 
										</div> <!-- END ACCESS KEY -->
									</div>									
		
								</div>
	
							</div>
						</div>				

						<!-- SAVE CHANGES ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-1">
							<a href="<?php echo e(route('admin.transfer.dashboard')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Cancel')); ?></a>
							<button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>							
						</div>				

					</form>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Awselect JS -->
	<script src="<?php echo e(URL::asset('plugins/awselect/awselect-custom.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('js/awselect.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('plugins/tippy/popper.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('plugins/tippy/tippy-bundle.umd.min.js')); ?>"></script>
	<script>
		 $(function () {
			tippy('[data-tippy-content]', {
				animation: 'scale-extreme',
				theme: 'material',
			});
		 });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hgdtksec/activec8fbc3cde6ecab5955cdad00.com/resources/views/admin/transfers/configuration/index.blade.php ENDPATH**/ ?>