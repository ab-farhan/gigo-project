<?php $__env->startSection('meta-description', !empty($seo) ? $seo->login_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->login_meta_keywords : ''); ?>

<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!--====== Start user-form-section ======-->

    
    <div class="authentication-area bg-light">
        <div class="container">
            <div class="row min-vh-100 align-items-center">
                <div class="col-12">
                    <div class="wrapper">
                        <div class="row align-items-center">

                            <div class="col-lg-6 bg-primary-light">
                                <div class="content">
                                    <div class="logo mb-3">
                                        <a href="<?php echo e(route('front.index')); ?>"><img
                                                src="<?php echo e(asset('assets/front/img/' . $bs->logo)); ?>" alt="Logo"></a>
                                    </div>
                                    <div class="svg-image">
                                        <svg class="mw-100" data-src="<?php echo e(asset('')); ?>/assets/front/images/login.svg"
                                            data-unique-ids="disabled" data-cache="disabled"></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="main-form">
                                    <a href="<?php echo e(route('front.index')); ?>" class="icon-link" title="Go back to home"><i
                                            class="fal fa-home"></i></a>
                                    <div class="title">
                                        <h3 class="mb-4"><?php echo e(__('Login to Gigo')); ?></h3>
                                    </div>
                                    <form id="#authForm" action="<?php echo e(route('user.login')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group mb-3">
                                            <label for="email" class="mb-1"> <?php echo e(__('Email Address')); ?></label>
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Enter your email" required>
                                            <?php if(Session::has('err')): ?>
                                                <p class="text-danger mb-2 mt-2"><?php echo e(Session::get('err')); ?></p>
                                            <?php endif; ?>
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
                                        <div class="form-group mb-3">
                                            <label for="password" class="mb-1"><?php echo e(__('Password')); ?></label>
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="Enter password" required>
                                            <?php $__errorArgs = ['password'];
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
                                        <div class="form_group mb-3">
                                            <?php if($bs->is_recaptcha == 1): ?>
                                                <div class="d-block mb-4">
                                                    <?php echo NoCaptcha::renderJs(); ?>

                                                    <?php echo NoCaptcha::display(); ?>

                                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                                        <?php
                                                            $errmsg = $errors->first('g-recaptcha-response');
                                                        ?>
                                                        <p class="text-danger mb-0 mt-2"><?php echo e(__("$errmsg")); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-sm-4 col-xs-12">
                                                <div class="link">
                                                    <a href="<?php echo e(route('user.forgot.password.form')); ?>"><?php echo e(__('Forgot password?')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-xs-12">
                                                <div class="link go-signup">
                                                    <?php echo e(__('Not a member?')); ?> <a
                                                        href="<?php echo e(route('front.pricing')); ?>"><?php echo e(__('Sign up now')); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100">
                                                <?php echo e(__('Login')); ?> </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== End user-form-section ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/front/auth/login.blade.php ENDPATH**/ ?>