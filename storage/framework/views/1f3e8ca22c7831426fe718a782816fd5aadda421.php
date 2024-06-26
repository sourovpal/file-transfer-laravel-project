

<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/awselect/awselect.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(config('frontend.maintenance') == 'on'): ?>			
        <div class="container h-100vh">
            <div class="row text-center h-100vh align-items-center">
                <div class="col-md-12">
                    <img src="<?php echo e(URL::asset('img/files/maintenance.png')); ?>" alt="Maintenance Image">
                    <h2 class="mt-4 font-weight-bold"><?php echo e(__('We are just tuning up a few things')); ?>.</h2>
                    <h5><?php echo e(__('We apologize for the inconvenience but')); ?> <span class="font-weight-bold text-info"><?php echo e(config('app.name')); ?></span> <?php echo e(__('is currenlty undergoing planned maintenance')); ?>.</h5>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if(config('settings.registration') == 'enabled'): ?>
            <div class="container-fluid justify-content-center">
                <div class="row h-100vh align-items-center background-white">
                    <div class="col-md-7 col-sm-12 text-center background-special h-100 align-middle p-0" id="login-background">
                        <div class="login-bg"></div>
                    </div>
                    
                    <div class="col-md-5 col-sm-12 h-100" id="login-responsive">                
                        <div class="card-body pr-10 pl-10 pt-10">
                            <form method="POST" action="<?php echo e(route('register')); ?>">
                                <?php echo csrf_field(); ?>
                                
                                <h3 class="text-center font-weight-bold mb-8"><?php echo e(__('Sign Up to')); ?> <span class="text-info"><a href="<?php echo e(url('/')); ?>"><?php echo e(config('app.name')); ?></a></span></h3>

                                <div class="input-box mb-4">                             
                                    <label for="name" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Full Name')); ?></label>
                                    <input id="name" type="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" autocomplete="off" autofocus placeholder="First and Last Names">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                </div>

                                <div class="input-box mb-4">                             
                                    <label for="email" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Email Address')); ?></label>
                                    <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" autocomplete="off"  placeholder="Email Address" required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                </div>

                                <div class="input-box mb-4">                             
                                    <label for="country" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Country')); ?></label>
                                    <select id="user-country" name="country" data-placeholder="Select Your Country" required>	
                                        <?php $__currentLoopData = config('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($value); ?>" <?php if(config('settings.default_country') == $value): ?> selected <?php endif; ?>><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>										
                                    </select>
                                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                </div>

                                <div class="input-box">                            
                                    <label for="password-input" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Password')); ?></label>
                                    <input id="password-input" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="off" placeholder="Password">
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                </div>

                                <div class="input-box">
                                    <label for="password-confirm" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Confirm Password')); ?></label>                       
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" placeholder="Confirm Password">                        
                                </div>

                                <div class="form-group mb-3">  
                                    <div class="d-flex">                        
                                        <label class="custom-switch">
                                            <input type="checkbox" class="custom-switch-input" name="agreement" id="agreement" <?php echo e(old('remember') ? 'checked' : ''); ?> required>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description fs-10 text-muted"><?php echo e(__('By continuing, I agree with your')); ?> <a href="<?php echo e(route('terms')); ?>" class="text-info"><?php echo e(__('Terms and Conditions')); ?></a> <?php echo e(__('and')); ?> <a href="<?php echo e(route('privacy')); ?>" class="text-info"><?php echo e(__('Privacy Policies')); ?></a></span>
                                        </label>   
                                    </div>
                                </div>

                                <input type="hidden" name="recaptcha" id="recaptcha">

                                <div class="form-group mb-0">                        
                                    <button type="submit" class="btn btn-primary mr-2"><?php echo e(__('Sign Up')); ?></button> 
                                    <p class="fs-10 text-muted mt-2">or <a class="text-info" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a></p>                               
                                </div>
                            </form>
                        </div>  

                        <footer class="footer" id="login-footer">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-12 col-sm-12 fs-10 text-muted text-center">
                                        <?php echo e(__('Copyright')); ?> © <?php echo e(date("Y")); ?> <a href="<?php echo e(config('app.url')); ?>"><?php echo e(config('app.name')); ?></a>. <?php echo e(__('All rights reserved')); ?>

                                    </div>
                                </div>
                            </div>
                        </footer>       
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h5 class="text-center pt-9"><?php echo e(__('New user registration is disabled currently')); ?></h5>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Awselect JS -->
	<script src="<?php echo e(URL::asset('plugins/awselect/awselect.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('js/awselect.js')); ?>"></script>

    <?php if(config('services.google.recaptcha.enable') == 'on'): ?>
         <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo e(config('services.google.recaptcha.site_key')); ?>"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo e(config('services.google.recaptcha.site_key')); ?>', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    <?php endif; ?>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\file-transfer-laravel-project\resources\views/auth/register.blade.php ENDPATH**/ ?>