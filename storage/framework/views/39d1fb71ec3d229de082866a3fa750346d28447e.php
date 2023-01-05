<?php $__env->startSection('pagename'); ?>
    - <?php echo e($package->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($package) ? $package->meta_keywords : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($package) ? $package->meta_description : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e($package->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e($package->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Authentication Start -->
    

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
                                        <svg class="mw-100" data-src="assets/images/login.svg" data-unique-ids="disabled"
                                            data-cache="disabled"></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="main-form">
                                    <a href="index.html" class="icon-link" title="Go back to home"><i
                                            class="fal fa-home"></i></a>
                                    <div class="title">
                                        <h3 class="mb-4"><?php echo e(__('Signup to Gigo')); ?></h3>
                                    </div>
                                    <form id="#authForm" action="<?php echo e(route('front.checkout.view')); ?>" method="post"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group mb-3">
                                            <label for="name" class="mb-1"><?php echo e(__('Username')); ?></label>
                                            <input type="text" id="name" class="form-control" name="username"
                                                value="<?php echo e(old('username')); ?>" placeholder="<?php echo e(__('username')); ?>" required>
                                            <?php if($hasSubdomain): ?>
                                                <p class="mb-0">
                                                    <?php echo e(__('Your subdomain based website URL will be')); ?>:
                                                    <strong class="text-primary"><span
                                                            id="username">{username}</span>.<?php echo e(env('WEBSITE_HOST')); ?></strong>
                                                </p>
                                            <?php endif; ?>
                                            <p class="text-danger mb-0" id="usernameAvailable"></p>
                                            <?php $__errorArgs = ['username'];
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
                                            <label for="email" class="mb-1"> <?php echo e(__('Email Address')); ?></label>
                                            <input type="email" id="email" class="form-control" name="email"
                                                value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Enter your email')); ?>"
                                                required>
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
                                                value="<?php echo e(old('password')); ?>" placeholder="<?php echo e(__('Password')); ?>"
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
                                        <div class="form-group mb-30">
                                            <label for="password-confirm"><?php echo e(__('Confirm Password')); ?></label>
                                            <input class="form-control" id="password-confirm" type="password"
                                                class="form_control" placeholder="<?php echo e(__('Confirm Password')); ?>"
                                                name="password_confirmation" required autocomplete="new-password">
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
                                        <div>
                                            <input type="hidden" name="status" value="<?php echo e($status); ?>">
                                            <input type="hidden" name="id" value="<?php echo e($id); ?>">
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="checkbox mb-3">
                                                <input type="checkbox" id="checkboxInput">
                                                <label for="checkboxInput" id="checkbox">
                                                    <svg viewBox="0 0 100 100">
                                                        <path class="box"
                                                            d="M82,89H18c-3.87,0-7-3.13-7-7V18c0-3.87,3.13-7,7-7h64c3.87,0,7,3.13,7,7v64C89,85.87,85.87,89,82,89z" />
                                                        <polyline class="check" points="25.5,53.5 39.5,67.5 72.5,34.5 " />
                                                    </svg>
                                                    <span>I agreed to Gigo's <a
                                                            href="<?php echo e(url('p/terms-&-conditions')); ?>">Terms of
                                                            Services</a></span>
                                                </label>
                                            </div>
                                            <div class="link go-signup">
                                                Already a member? <a href="<?php echo e(route('user.login')); ?>">Login now</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100"> Signup </button>
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
    <!-- Authentication End -->
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    <?php if($hasSubdomain): ?>
        <script>
            "use strict";
            $(document).ready(function() {
                $("input[name='username']").on('input', function() {
                    let username = $(this).val();
                    if (username.length > 0) {
                        $("#username").text(username);
                    } else {
                        $("#username").text("{username}");
                    }
                });
            });
        </script>
    <?php endif; ?>
    <script>
        "use strict";
        $(document).ready(function() {
            $("input[name='username']").on('change', function() {
                let username = $(this).val();
                if (username.length > 0) {
                    $.get("<?php echo e(url('/')); ?>/check/" + username + '/username', function(data) {
                        if (data == true) {
                            $("#usernameAvailable").text('This username is already taken.');
                        } else {
                            $("#usernameAvailable").text('');
                        }
                    });
                } else {
                    $("#usernameAvailable").text('');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/front/step.blade.php ENDPATH**/ ?>