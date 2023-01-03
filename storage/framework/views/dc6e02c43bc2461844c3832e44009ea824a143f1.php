<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<title><?php echo e($bs->website_title); ?> - <?php echo e(__('Admin')); ?></title>
	<link rel="icon" href="<?php echo e(asset('assets/front/img/'.$bs->favicon)); ?>">
	<?php if ($__env->exists('admin.partials.styles')) echo $__env->make('admin.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php
        $selLang = App\Models\Language::where('code', request()->input('language'))->first();
    ?>
    <?php if(!empty($selLang) && $selLang->rtl == 1): ?>
    <style>
    #editModal form input,
    #editModal form textarea,
    #editModal form select {
        direction: rtl;
    }
    #editModal form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
    </style>
    <?php endif; ?>

    <?php echo $__env->yieldContent('styles'); ?>

</head>
<body <?php if(request()->cookie('admin-theme') == 'dark'): ?> data-background-color="dark" <?php endif; ?>>
	<div class="wrapper">

    
    <?php if ($__env->exists('admin.partials.top-navbar')) echo $__env->make('admin.partials.top-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    


    
    <?php if ($__env->exists('admin.partials.side-navbar')) echo $__env->make('admin.partials.side-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    


		<div class="main-panel">
        <div class="content">
            <div class="page-inner">
            <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
            <?php if ($__env->exists('admin.partials.footer')) echo $__env->make('admin.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>

	</div>

	<?php if ($__env->exists('admin.partials.scripts')) echo $__env->make('admin.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <div class="request-loader">
        <img src="<?php echo e(asset('assets/admin/img/loader.gif')); ?>" alt="">
    </div>
    
</body>
</html>
<?php /**PATH D:\laragon\www\coursemat\resources\views/admin/layout.blade.php ENDPATH**/ ?>