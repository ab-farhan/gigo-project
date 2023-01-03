<!-- CSS Files -->
<link href="<?php echo e(asset('assets/front/css/all.min.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/fontawesome-iconpicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/dropzone.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/bootstrap-tagsinput.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/bootstrap-datepicker.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/jquery-ui.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/jquery.timepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/summernote-bs4.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/atlantis.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/custom.css')); ?>">
<?php if(request()->cookie('admin-theme') == 'dark'): ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/dark.css')); ?>">
<?php endif; ?>

<?php echo $__env->yieldContent('styles'); ?>
<?php /**PATH /Users/samiulalimpratik/Sites/coursemat/coursemat/resources/views/admin/partials/styles.blade.php ENDPATH**/ ?>