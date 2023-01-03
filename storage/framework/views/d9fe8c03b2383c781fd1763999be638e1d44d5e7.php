<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/forgot-password.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__("Reset Password")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->forget_password_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->forget_password_meta_keywords : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e(__("Reset Password")); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__("Reset Password")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!--====== End Breadcrumbs section ======-->
    <div class="authentication-area pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="user-form">
                        <div class="title">
                        </div>
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>
                        <form class="login-form" action="<?php echo e(route('user.forgot.password.submit')); ?>" method="post"
                              enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                                <div class="form_group">
                                    <span><?php echo e(__('Email Address')); ?>*</span>
                                    <input type="email" name="<?php echo e(__('email')); ?>" class="form-control" value="<?php echo e(Request::old('email')); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-danger mb-2 mt-2"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <div class="form_group">
                                <button class="btn primary-btn w-100"><?php echo e(__('Send Password Reset Link')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/front/auth/passwords/email.blade.php ENDPATH**/ ?>