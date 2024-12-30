

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <h1><?php echo e($title); ?></h1>
    <p>This is your home page.</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KaslFW\src\View/home.blade.php ENDPATH**/ ?>