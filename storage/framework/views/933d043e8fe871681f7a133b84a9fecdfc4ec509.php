<?php $__env->startComponent('mail::message'); ?>
# **<?php echo e($data['email_from']); ?>** has transfered some files to you.

<?php echo e($data['message']); ?>


<?php $__currentLoopData = $data['links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
- **File Name: <?php echo e($key); ?>**
- <?php echo e(config("app.url")); ?>/download/<?php echo e($node); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/hgdtksec/activec8fbc3cde6ecab5955cdad00.com/resources/views/emails/transfer.blade.php ENDPATH**/ ?>