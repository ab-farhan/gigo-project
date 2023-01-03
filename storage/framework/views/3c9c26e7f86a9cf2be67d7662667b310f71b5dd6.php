<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Home')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->home_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : ''); ?>

<?php $__env->startSection('content'); ?>


    

    <?php if($bs->home_section == 1): ?>
        <!-- Home Start-->
        <section id="home" class="home-banner bg-primary-light pb-120">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="fluid-left">
                            <div class="content mb-30">
                                <span class="subtitle bg-primary-light color-primary" data-aos="fade-up">
                                    <?php echo e($be->hero_section_title); ?> </span>
                                <h1 class="title" data-aos="fade-up" data-aos-delay="100">
                                    <?php echo e($be->hero_section_text); ?>

                                </h1>
                                <p data-aos="fade-up" data-aos-delay="150">
                                    We are elite author at envato, We help you to build
                                    your own booking website easy way
                                </p>
                                <div class="btn-groups" data-aos="fade-up" data-aos-delay="200">
                                    

                                    <?php if($be->hero_section_button_url): ?>
                                        <a href="<?php echo e($be->hero_section_button_url); ?>"
                                            title="<?php echo e($be->hero_section_button_text); ?>"
                                            class="btn btn-lg btn-primary"><?php echo e($be->hero_section_button_text); ?></a>
                                    <?php endif; ?>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline" title="View Demo"
                                        target="_self">View Demo</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="fluid-auto">
                            <div class="banner-img mb-30" data-aos="fade-left">
                                <img src="<?php echo e(asset('assets/front/img/' . $be->hero_img)); ?>" alt="Banner Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-1.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-2.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-10" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-11" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-5.png" alt="Shape">
            </div>
        </section>
        <!-- Home End -->
    <?php endif; ?>

    <?php if($bs->partners_section == 1): ?>
        <!-- Sponsor Start  -->
        <section class="sponsor pt-120">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <span class="subtitle"><?php echo e($bs->partner_title); ?> </span>
                            <h2 class="title"><?php echo e($bs->partner_subtitle); ?> </h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper sponsor-slider">
                            <div class="swiper-wrapper">
                                <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <div class="item-single d-flex justify-content-center">
                                            <div class="sponsor-img">
                                                <img class="lazyload blur-up"
                                                    src="<?php echo e(asset('assets/front/img/partners/' . $partner->image)); ?>"
                                                    alt="Sponsor">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                

                            </div>
                            <div class="swiper-pagination position-static mt-30" data-aos="fade-up"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sponsor End -->
    <?php endif; ?>

    <?php if($bs->process_section == 1): ?>
        <!-- Store Start -->
        <section class="store-area pt-120 pb-90">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title title-inline mb-50" data-aos="fade-up">
                            <h2 class="title"><?php echo e($bs->work_process_title); ?></h2>

                            <a href="<?php echo e(route('front.pricing')); ?>" class="btn btn-lg btn-primary" title="Purchase Now"
                                target="_self">Purchase Now</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <?php $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $process): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-6 col-lg-4 col-xl-3 mb-30 item" data-aos="fade-up">
                                    <div class="card">
                                        <div class="card-icon">
                                            <i class=" <?php echo e($process->icon); ?> "></i>
                                        </div>
                                        <div class="card-content">
                                            <a href="javaScript:void(0)">
                                                <h4 class="card-title lc-1"><?php echo e($process->title); ?></h4>
                                            </a>
                                            <p class="card-text lc-2"><?php echo e($process->text); ?></p>
                                            <a href="<?php echo e(route('front.pricing')); ?>" class="btn-text color-primary"
                                                title="Title" target="_self">Purchase Now</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
            </div>
        </section>
        <!-- Store End -->
    <?php endif; ?>

    <?php if($bs->template_section == 1): ?>
        <!-- Template Start -->
        <section class="template-area bg-primary-light ptb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <span class="subtitle"><?php echo e($bs->preview_templates_title); ?></span>
                            <h2 class="title mt-0"><?php echo e($bs->preview_templates_subtitle); ?></h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                                    <div class="card text-center mb-50">
                                        <div class="card-image">
                                            <a href="javaScript:void(0)" class="lazy-container" title="Image"
                                                target="_self">
                                                <img class="lazyload lazy-image"
                                                    data-src="<?php echo e(asset('assets/front/img/template-previews/' . $template->template_img)); ?>"
                                                    alt="Demo Image" />
                                            </a>
                                        </div>
                                        <h4 class="card-title">
                                            <a href="javaScript:void(0)" title="Link" target="_self">
                                                01 - Home Demo
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="col-12 text-center">
                                <a href="javaScript:void(0)" class="btn btn-lg btn-primary" title="More Template"
                                    target="_self">More Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-9.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-7" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-8" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-9.png" alt="Shape">
                <img class="shape-9" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-10" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
            </div>
        </section>
        <!-- Template End -->
    <?php endif; ?>

    <?php if($bs->intro_section == 1): ?>
        <!-- Choose Start -->
        <section class="choose-area pt-120 pb-90">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="choose-content mb-30 pe-lg-5" data-aos="fade-right">
                            <span class="subtitle"><?php echo e($bs->intro_title); ?></span>
                            <h2 class="title"><?php echo e($bs->intro_subtitle); ?></h2>
                            <p class="text"><?php echo nl2br($bs->intro_text); ?></p>
                            
                            <?php if($bs->intro_section_button_url): ?>
                                <a href="<?php echo e($bs->intro_section_button_url); ?>"
                                    class="btn btn-lg btn-primary"><?php echo e($bs->intro_section_button_text); ?></a>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-6 item" data-aos="fade-up">
                                    <div class="card mb-30">
                                        <div class="card-icon">
                                            <img src="<?php echo e(asset('assets/front/img/feature/' . $feature->icon)); ?>"
                                                alt="Icon">
                                        </div>
                                        <div class="card-content">
                                            <a href="#">
                                                <h4 class="card-title lc-1"><?php echo e($feature->title); ?></h4>
                                            </a>
                                            <p class="card-text"><?php echo e($feature->text); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-11.png" alt="Shape">
            </div>
        </section>
        <!-- Choose End -->
    <?php endif; ?>

    <?php if($bs->pricing_section == 1): ?>
        <!-- Pricing Start -->
        <section class="pricing-area pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <span class="subtitle"><?php echo e($bs->pricing_title); ?></span>
                            <h2 class="title mb-2 mt-0"> <?php echo e($bs->pricing_subtitle); ?> </h2>
                            <p class="text">Curabitur non nulla sit amet nisl tempus lectus Nulla porttitor accumsan
                                tincidunt.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <?php if(count($terms) > 1): ?>
                            <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                                <ul class="nav nav-tabs">
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>"
                                                data-bs-toggle="tab" data-bs-target="#<?php echo e(__("$term")); ?>"
                                                type="button"><?php echo e(__("$term")); ?></button>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="tab-content">
                            <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>"
                                    id="<?php echo e(__("$term")); ?>">
                                    <div class="row justify-content-center">
                                        <?php
                                            $packages = \App\Models\Package::where('status', '1')
                                                ->where('featured', '1')
                                                ->where('term', strtolower($term))
                                                ->get();
                                        ?>
                                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $pFeatures = json_decode($package->features);
                                            ?>
                                            <div class="col-md-6 col-lg-4 item">
                                                <div class="card mb-30 <?php echo e($package->recommended == '1' ? 'active' : ''); ?>"
                                                    data-aos="fade-up" data-aos-delay="100">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon"><i class="<?php echo e($package->icon); ?>"></i></div>
                                                        <div class="label">
                                                            <h4><?php echo e($package->title); ?></h4>
                                                            <?php if($package->recommended == '1'): ?>
                                                                <span><?php echo e(__('Recommended')); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <p class="text">

                                                    </p>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="price"><?php echo e($package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''); ?><?php echo e($package->price == 0 ? 'Free' : $package->price); ?><?php echo e($package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''); ?></span>
                                                        <span class="period">/ <?php echo e(__("$package->term")); ?></span>
                                                    </div>
                                                    <h5>What's Included</h5>
                                                    <ul class="pricing-list list-unstyled p-0">
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            <?php echo e($package->course_categories_limit === 999999 ? __('Unlimited') : $package->course_categories_limit . ' '); ?><?php echo e($package->course_categories_limit === 1 ? __('Course Category') : __('Course Categories')); ?>

                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            <?php echo e($package->course_limit === 999999 ? __('Unlimited') : $package->course_limit . ' '); ?><?php echo e($package->course_limit === 1 ? __('Course') : __('Courses')); ?>

                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            <?php echo e($package->module_limit === 999999 ? __('Unlimited') : $package->module_limit . ' '); ?><?php echo e($package->module_limit === 1 ? __('Module') : __('Modules')); ?>

                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            <?php echo e($package->lesson_limit === 999999 ? __('Unlimited') : $package->lesson_limit . ' '); ?><?php echo e($package->lesson_limit === 1 ? __('Lesson') : __('Lessons')); ?>

                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            <?php echo e($package->featured_course_limit === 999999 ? __('Unlimited') : $package->featured_course_limit . ' '); ?><?php echo e($package->featured_course_limit === 1 ? __('Featured Course') : __('Featured Courses')); ?>

                                                        </li>

                                                        <?php $__currentLoopData = $allPfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li
                                                                class="<?php echo e(is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled'); ?>">
                                                                <i
                                                                    class="<?php echo e(is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times'); ?>"></i>
                                                                <?php if($feature == 'Storage Limit'): ?>
                                                                    <?php if($package->storage_limit == 0 || $package->storage_limit == 999999): ?>
                                                                        <?php echo e(__("$feature")); ?>

                                                                    <?php elseif($package->storage_limit < 1024): ?>
                                                                        <?php echo e(__("$feature") . ' ( ' . $package->storage_limit . 'MB )'); ?>

                                                                    <?php else: ?>
                                                                        <?php echo e(__("$feature") . ' ( ' . ceil($package->storage_limit / 1024) . 'GB )'); ?>

                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php echo e(__("$feature")); ?>

                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    <div class="btn-groups">


                                                        <?php if($package->is_trial === '1' && $package->price != 0): ?>
                                                            <a href="<?php echo e(route('front.register.view', ['status' => 'trial', 'id' => $package->id])); ?>"
                                                                class="btn btn-lg btn-primary no-animation"><?php echo e(__('Trial')); ?></a>
                                                        <?php endif; ?>
                                                        <?php if($package->price == 0): ?>
                                                            <a href="<?php echo e(route('front.register.view', ['status' => 'regular', 'id' => $package->id])); ?>"
                                                                class="btn btn-lg btn-primary no-animation"><?php echo e(__('Signup')); ?></a>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(route('front.register.view', ['status' => 'regular', 'id' => $package->id])); ?>"
                                                                class="btn btn-lg btn-outline no-animation"><?php echo e(__('Purchase')); ?></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-11.png" alt="Shape">
            </div>
        </section>
        <!-- Pricing End -->
    <?php endif; ?>
    <?php if($bs->featured_users_section == 1): ?>
        <!-- User Profile Start -->
        <section class="user-profile-area pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <?php if(!empty($bs->featured_users_title)): ?>
                                <span class="subtitle"><?php echo e($bs->featured_users_title); ?></span>
                            <?php endif; ?>
                            <?php if(!empty($bs->featured_users_subtitle)): ?>
                                <h2 class="title"><?php echo e($bs->featured_users_subtitle); ?></h2>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper user-slider" data-aos="fade-up">
                            <div class="swiper-wrapper">
                                <?php $__currentLoopData = $featured_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <div class="card">
                                            <div class="icon">
                                                <?php if($featured_user->photo): ?>
                                                    <img class="lazy"
                                                        src="<?php echo e(asset('assets/front/img/user/' . $featured_user->photo)); ?>"
                                                        alt="user">
                                                <?php else: ?>
                                                    <img class="lazy"
                                                        src="<?php echo e(asset('assets/admin/img/propics/blank_user.jpg')); ?>"
                                                        alt="user">
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-content">
                                                <h4 class="card-title">
                                                    <?php echo e($featured_user->first_name . ' ' . $featured_user->last_name); ?>

                                                </h4>
                                                <div class="social-link">
                                                    <a href="https://www.instagram.com/" target="_blank"><i
                                                            class="fab fa-instagram"></i></a>
                                                    <a href="https://www.dribbble.com/" target="_blank"><i
                                                            class="fab fa-dribbble"></i></a>
                                                    <a href="https://www.twitter.com/" target="_blank"><i
                                                            class="fab fa-twitter"></i></a>
                                                    <a href="https://www.youtube.com/" target="_blank"><i
                                                            class="fab fa-youtube"></i></a>
                                                </div>
                                                <div class="btn-groups">
                                                    
                                                    <?php
                                                        if (!empty($featured_user)) {
                                                            $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($featured_user->id);
                                                            $preferences = App\Models\User\UserPermission::where([['user_id', $featured_user->id], ['package_id', $currentPackage->package_id]])->first();
                                                            $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                                        }
                                                    ?>
                                                    <a href="<?php echo e(detailsUrl($featured_user)); ?>"
                                                        class="btn btn-sm btn-outline"><?php echo e(__('View Profile')); ?></a>
                                                    <?php if(auth()->guard()->guest()): ?>
                                                        <?php if(!empty($permissions) && in_array('Follow/Unfollow', $permissions)): ?>
                                                            <a href="<?php echo e(route('user.follow', ['id' => $featured_user->id])); ?>"
                                                                class="btn btn-sm btn-primary"> <?php echo e(__('Follow')); ?>

                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if(Auth::check() && Auth::id() != $featured_user->id): ?>
                                                        <?php if(!empty($permissions) && in_array('Follow/Unfollow', $permissions)): ?>
                                                            <?php if(App\Models\User\Follower::where('follower_id', Auth::id())->where('following_id', $featured_user->id)->count() > 0): ?>
                                                                <a href="<?php echo e(route('user.unfollow', $featured_user->id)); ?>"
                                                                    class="btn btn-sm btn-primary"> <?php echo e(__('Unfollow')); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?php echo e(route('user.follow', ['id' => $featured_user->id])); ?>"
                                                                    class="btn btn-sm btn-primary"> <?php echo e(__('Follow')); ?>

                                                            <?php endif; ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                            <div class="swiper-pagination position-static mt-30"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-8.png" alt="Shape">
            </div>
        </section>
        <!-- User Profile End -->
    <?php endif; ?>
    <?php if($bs->testimonial_section == 1): ?>
        <!-- Testimonial Start -->
        <section class="testimonial-area">
            <div class="container">
                <div class="row align-items-center gx-xl-5">
                    <div class="col-lg-6">
                        <div class="content mb-30" data-aos="fade-up">
                            <h2 class="title"><?php echo e($bs->testimonial_title); ?></h2>

                        </div>
                        <div class="swiper testimonial-slider mb-30" data-aos="fade-up">
                            <div class="swiper-wrapper">

                                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <div class="slider-item bg-primary-light">
                                            <div class="ratings justify-content-between size-md">
                                                <div class="rate">
                                                    <div class="rating-icon"></div>
                                                </div>
                                                <span class="ratings-total">5 star of 20 review</span>
                                            </div>
                                            <div class="quote">
                                                <p class="text mb-0">
                                                    <?php echo e($testimonial->comment); ?>

                                                </p>
                                            </div>
                                            <div class="client flex-wrap">
                                                <div class="client-info d-flex align-items-center">
                                                    <div class="client-img">
                                                        <div class="lazy-container ratio ratio-1-1">
                                                            <img class="lazyload"
                                                                data-src="<?php echo e($testimonial->image ? asset('assets/front/img/testimonials/' . $testimonial->image) : asset('assets/front/img/thumb-1.jpg')); ?>"
                                                                alt="Person Image">
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h6 class="name"><?php echo e($testimonial->name); ?></h6>
                                                        <span class="designation"><?php echo e($testimonial->rank); ?></span>
                                                    </div>
                                                </div>
                                                <span class="icon"><i class="fas fa-quote-right"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                            <div class="swiper-pagination" id="testimonial-slider-pagination" data-min data-max></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="image mb-30 img-right" data-aos="fade-left">
                            <img src="<?php echo e(asset('assets/front/img/testimonials/' . $be->testimonial_img)); ?>"
                                alt="Image">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-8.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
            </div>
        </section>
        <!-- Testimonial End -->
    <?php endif; ?>

    <?php if($bs->news_section == 1): ?>
        <!-- Blog Start -->
        <section class="blog-area ptb-90">
            <div class="container">
                <div class="section-title title-inline mb-50" data-aos="fade-up">
                    <h2 class="title"><?php echo e($bs->blog_title); ?></h2>
                    
                </div>
                <div class="row justify-content-center">
                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                <div class="card-image">
                                    <a href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>"
                                        class="lazy-container ratio-16-9">
                                        <img class="lazyload lazy-image"
                                            src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>"
                                            data-src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>"
                                            alt="Blog Image">
                                    </a>
                                    <ul class="info-list">
                                        <li><i class="fal fa-user"></i><?php echo e(__('Admin')); ?></li>
                                        <li><i
                                                class="fal fa-calendar"></i><?php echo e(\Carbon\Carbon::parse($blog->created_at)->format('d m, Y')); ?>

                                        </li>
                                        <li><i class="fal fa-tag"></i><?php echo e($blog->bcategory->name); ?></li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <h5 class="card-title lc-2">
                                        <a
                                            href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>">
                                            <?php echo e(strlen($blog->title) > 55 ? mb_substr($blog->title, 0, 55, 'utf-8') . '...' : $blog->title); ?>

                                        </a>
                                    </h5>
                                    <p class="card-text lc-2">
                                        <?php echo substr(strip_tags($blog->content), 0, 150); ?>

                                    </p>
                                    <a href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>"
                                        class="card-btn">Read More</a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('/')); ?>assets/front/images/shape/shape-8.png" alt="Shape">
            </div>
        </section>
    <?php endif; ?>
    <!-- Blog End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/front/index.blade.php ENDPATH**/ ?>