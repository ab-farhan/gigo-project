<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Profile')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->profiles_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->profiles_meta_keywords : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e(__('Profile')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__('Profile')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!--====== Start saas-featured-users section ======-->

    

    <!--====== End saas-featured-users section ======-->
    <!-- User Profile Start -->
    <section class="user-profile-area ptb-120">
        <div class="container">
            <div class="row">
                <?php if(count($users) == 0): ?>
                    <div class="bg-light text-center py-5 d-block w-100">
                        <h3>NO PROFILE FOUND</h3>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                            <div class="card mb-30">
                                <div class="icon">

                                    <?php if($user->photo): ?>
                                        <img class="lazy" src="<?php echo e(asset('assets/front/img/user/' . $user->photo)); ?>"
                                            alt="user">
                                    <?php else: ?>
                                        <img class="lazy" src="<?php echo e(asset('assets/admin/img/propics/blank_user.jpg')); ?>"
                                            alt="user">
                                    <?php endif; ?>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo e($user->first_name . ' ' . $user->last_name); ?></h4>
                                    <div class="social-link">
                                        <?php $__currentLoopData = $user->social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e($social->url); ?>" target="_blank"><i
                                                    class="<?php echo e($social->icon); ?>"></i></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                    <div class="btn-groups">
                                        <?php
                                            if (!empty($user)) {
                                                $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($user->id);
                                                $preferences = App\Models\User\UserPermission::where([['user_id', $user->id], ['package_id', $currentPackage->package_id]])->first();
                                                $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                            }
                                        ?>
                                        <a href="<?php echo e(detailsUrl($user)); ?>" class="btn btn-sm btn-outline"
                                            title="View Profile" target="_self"><?php echo e(__('View Profile')); ?></a>
                                        <?php if(auth()->guard()->guest()): ?>
                                            <?php if(!empty($permissions) && in_array('Follow/Unfollow', $permissions)): ?>
                                                <a href="<?php echo e(route('user.follow', ['id' => $user->id])); ?>"
                                                    class="btn btn-sm btn-primary " title="Follow Us" target="_self">
                                                    <?php echo e(__('Follow Us')); ?>

                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(Auth::guard('web')->check() && Auth::guard('web')->user()->id != $user->id): ?>
                                            <?php if(!empty($permissions) && in_array('Follow/Unfollow', $permissions)): ?>
                                                <?php if(App\Models\User\Follower::where('follower_id', Auth::guard('web')->user()->id)->where('following_id', $user->id)->count() > 0): ?>
                                                    <a href="<?php echo e(route('user.unfollow', $user->id)); ?>"
                                                        class="btn btn-sm btn-primary"> <?php echo e(__('Unfollow')); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('user.follow', ['id' => $user->id])); ?>"
                                                        class="btn btn-sm btn-primary"> <?php echo e(__('Follow Us')); ?>

                                                <?php endif; ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>


            </div>
            <nav class="pagination-nav" data-aos="fade-up">
                <ul class="pagination justify-content-center mb-0">
                    <?php echo e($users->appends(['search' => request()->input('search'), 'designation' => request()->input('designation'), 'location' => request()->input('location')])->links()); ?>

                    
                </ul>
            </nav>
        </div>
    </section>
    <!-- User Profile End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/front/users.blade.php ENDPATH**/ ?>