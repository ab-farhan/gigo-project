<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Home')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->home_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : ''); ?>

<?php $__env->startSection('content'); ?>


    <!-- Home Start-->
    <?php if($bs->home_section == 1): ?>
    <section id="home" class="home-banner pb-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content mb-30" data-aos="fade-down">
                        <span class="subtitle"><?php echo e($be->hero_section_title); ?><img loading="lazy" src="<?php echo e(asset('assets/front/img/icon-trophy.png')); ?>"
                                                                               alt="Icon"></span>
                        <h1 class="title"><?php echo e($be->hero_section_text); ?> 
                        </h1>
                        <p class="text"><?php echo e($be->hero_section_desc); ?></p>
                        <div class="content-botom d-flex align-items-center">
                            <?php if($be->hero_section_button_url): ?>
                            <a href="<?php echo e($be->hero_section_button_url); ?>" class="btn primary-btn"><?php echo e($be->hero_section_button_text); ?></a>
                            <?php endif; ?>
                            <?php if($be->hero_section_video_url): ?>
                            <a href="<?php echo e($be->hero_section_video_url); ?>" class="btn video-btn youtube-popup"><i
                                    class="fas fa-play"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner-img image-right mb-30" data-aos="fade-right">
                        <img src="<?php echo e(asset('assets/front/img/'.$be->hero_img)); ?>" alt="Banner Image">
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-1.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-2.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-3.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-5.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-6.png')); ?>" alt="Shape">
            <img class="shape-7" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-8" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
            <img class="shape-9" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Home End -->

    <!-- partner Start  -->
    <?php if($bs->partners_section == 1): ?>
    <section class="sponsor pt-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <span class="subtitle"><?php echo e($bs->partner_title); ?> </span>
                        <h2 class="title"><?php echo e($bs->partner_subtitle); ?> </span></h2>
                        <!-- Shape -->
                        <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/arrow-1.png')); ?>" alt="Shape">
                        <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/arrow-2.png')); ?>" alt="Shape">
                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper sponsor-slider">
                        <div class="swiper-wrapper">

                            <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <div class="item-single d-flex" data-aos="fade-up" data-aos-delay="100">
                                        <div class="sponsor-img">
                                            <a class="d-block" href="<?php echo e($partner->url); ?>" target="_blank">
                                                <img src="<?php echo e(asset('assets/front/img/partners/'.$partner->image)); ?>" alt="Sponsor">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="swiper-pagination" data-aos="fade-up"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- partner End -->

    <!-- Work Process Start -->
    <?php if($bs->process_section == 1): ?>
    <section class="store-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title align-items-center justify-content-between mw-100"
                         data-aos="fade-up" data-aos-delay="100">
                        <span class="subtitle"><?php echo e($bs->work_process_subtitle); ?></span>
                        <h2 class="title"><?php echo e($bs->work_process_title); ?></span></h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">
                        <?php $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $process): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-6 col-lg-6 col-xl-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="card primary mb-30">
                                <div class="card-icon green">
                                    <i class=" <?php echo e($process->icon); ?>"></i>
                                </div>
                                <div class="card-content">
                                    <a>
                                        <h3 class="card-title"> <?php echo e($process->title); ?></h3>
                                    </a>
                                    <p class="card-text"><?php echo e($process->text); ?></p>

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
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-2.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-9.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-11.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Work Process End -->

    <!-- Template Start -->
    <?php if($bs->template_section == 1): ?>
    <section class="template-area pt-120 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <span class="subtitle"><?php echo e($bs->preview_templates_title); ?></span>
                        <h2 class="title"> <?php echo e($bs->preview_templates_subtitle); ?></h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">

                        <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="50">
                                <div class="card text-center mb-50">
                                    <div class="card-image">
                                        <a href="<?php echo e(detailsUrl($template)); ?>" class="lazy-container">
                                            <img class="lazyload lazy-image" data-src="<?php echo e(asset('assets/front/img/template-previews/' . $template->template_img)); ?>"
                                                 alt="Demo Image" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-1.png')); ?>" alt="Bg">
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-2.png')); ?>" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-9.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-7" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
            <img class="shape-8" src="<?php echo e(asset('assets/front/img/shape/shape-9.png')); ?>" alt="Shape">
            <img class="shape-9" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-10" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Template End -->

    <!-- Intro Start -->
    <?php if($bs->intro_section == 1): ?>
    <section class="choose-area pt-120 pb-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="choose-content mb-30" data-aos="fade-right">
                        <span class="subtitle"><?php echo e($bs->intro_title); ?></span>
                        <h2 class="title"><?php echo e($bs->intro_subtitle); ?></h2>
                        <p class="text"><?php echo nl2br($bs->intro_text); ?> </p>
                        <div class="d-flex align-items-center">

                            <?php if($bs->intro_section_button_url): ?>
                                <a href="<?php echo e($bs->intro_section_button_url); ?>" class="btn primary-btn"><?php echo e($bs->intro_section_button_text); ?></a>
                            <?php endif; ?>
                            <?php if($bs->intro_section_video_url): ?>
                                    <a href="<?php echo e($bs->intro_section_video_url); ?>" class="btn video-btn youtube-popup"><i
                                            class="fas fa-play"></i></a>
                            <?php endif; ?>



                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row justify-content-center">
                        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="card mt-30 mb-sm-30">
                                    <div class="card-icon green">
                                        <img src="<?php echo e(asset('assets/front/img/feature/'.$feature->icon)); ?>" alt="Barcode">
                                    </div>
                                    <div class="card-content">
                                        <a href="#">
                                            <h3 class="card-title"><?php echo e($feature->title); ?></h3>
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

            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-12.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-13.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-14.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-6.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Intro End -->

    <!-- Pricing Start -->
    <?php if($bs->pricing_section == 1): ?>
    <section class="pricing-area pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <span class="subtitle"><?php echo e($bs->pricing_title); ?></span>
                        <h2 class="title"><?php echo e($bs->pricing_subtitle); ?></h2>

                    </div>
                </div>
                <div class="col-12">
                    <?php if(count($terms) > 1): ?>
                        <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                            <ul class="nav nav-tabs">
                                <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <li class="nav-item">
                                        <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" data-bs-toggle="tab" data-bs-target="#<?php echo e(__("$term")); ?>"
                                                type="button"><?php echo e(__("$term")); ?></button>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="tab-content">
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?> " id="<?php echo e(__("$term")); ?>">
                                <div class="row">
                                    <?php
                                        $packages = \App\Models\Package::where('status', '1')->where('featured', '1')->where('term', strtolower($term))->get();
                                    ?>
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $pFeatures = json_decode($package->features);
                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card mb-30 <?php echo e($package->recommended == '1' ? 'active' : ''); ?>" data-aos="fade-up" data-aos-delay="100">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon blue"><i class="<?php echo e($package->icon); ?>"></i></div>
                                                    <div class="label">
                                                        <h3><?php echo e($package->title); ?></h3>

                                                        <?php if($package->recommended == '1'): ?>
                                                            <span><?php echo e(__('Recommended')); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <p class="text"></p>
                                                <div class="d-flex align-items-center">

                                                    <span class="price"><?php echo e($package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''); ?><?php echo e($package->price == 0 ? "Free" : $package->price); ?><?php echo e($package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''); ?></span>
                                                    <span class="period">/ <?php echo e(__("$package->term")); ?></span>


                                                </div>
                                                <h5><?php echo e(__('Whats Included')); ?></h5>
                                                <ul class="item-list list-unstyled p-0">
    
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        <?php echo e($package->course_categories_limit === 999999 ? __('Unlimited') : $package->course_categories_limit.' '); ?><?php echo e($package->course_categories_limit ===1 ? __('Course Category'):__('Course Categories')); ?>

                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        <?php echo e($package->course_limit === 999999 ? __('Unlimited') : $package->course_limit.' '); ?><?php echo e($package->course_limit=== 1 ? __('Course'):__('Courses')); ?>

                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        <?php echo e($package->module_limit === 999999 ? __('Unlimited') : $package->module_limit.' '); ?><?php echo e($package->module_limit===1 ? __('Module'): __('Modules')); ?>

                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        <?php echo e($package->lesson_limit === 999999 ? __('Unlimited') : $package->lesson_limit.' '); ?><?php echo e($package->lesson_limit ===1 ? __('Lesson'):__('Lessons')); ?>

                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        <?php echo e($package->featured_course_limit === 999999 ? __('Unlimited') : $package->featured_course_limit.' '); ?><?php echo e($package->featured_course_limit === 1 ? __('Featured Course'):__('Featured Courses')); ?>

                                                    </li>
        
                                                    <?php $__currentLoopData = $allPfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li  class="<?php echo e(is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled'); ?>">
                                                            <i class="<?php echo e(is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times'); ?>"></i>
                                                            <?php if($feature == 'Storage Limit'): ?>
                                                                <?php if($package->storage_limit == 0 || $package->storage_limit == 999999): ?>
                                                                    <?php echo e(__("$feature")); ?>

                                                                <?php elseif($package->storage_limit < 1024): ?>
                                                                    <?php echo e(__("$feature"). ' ( '.$package->storage_limit .'MB )'); ?>

                                                                <?php else: ?>
                                                                    <?php echo e(__("$feature"). ' ( '. ceil($package->storage_limit/1024) .'GB )'); ?>

                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <?php echo e(__("$feature")); ?>

                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>
                                                <div class="d-flex align-items-center">
                                                    <?php if($package->is_trial === "1" && $package->price != 0): ?>
                                                        <a href="<?php echo e(route('front.register.view',['status' => 'trial','id'=> $package->id])); ?>"
                                                           class="btn secondary-btn"><?php echo e(__('Trial')); ?></a>
                                                    <?php endif; ?>
                                                    <?php if($package->price == 0): ?>
                                                        <a href="<?php echo e(route('front.register.view',['status' => 'regular','id'=> $package->id])); ?>"
                                                           class="btn primary-btn"><?php echo e(__('Signup')); ?></a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('front.register.view',['status' => 'regular','id'=> $package->id])); ?>"
                                                           class="btn primary-btn"><?php echo e(__('Purchase')); ?></a>
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
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-2.png')); ?>" alt="Bg">
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-1.png')); ?>" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-6.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-3.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-5.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-11.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Pricing End -->

    <!-- Featured Profile Start -->
    <?php if($bs->featured_users_section == 1): ?>
    <section class="user-profile-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <?php if(!empty($bs->featured_users_title)): ?>
                            <span class="subtitle"><?php echo e($bs->featured_users_title); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($bs->featured_users_subtitle)): ?>
                            <h2 class="title"><?php echo e($bs->featured_users_subtitle); ?></h2>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper user-slider">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $featured_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="swiper-slide">
                                    <div class="card" data-aos="fade-up" data-aos-delay="100">
                                        <div class="icon">
                                            <?php if($featured_user->photo): ?>
                                            <img class="lazy" src="<?php echo e(asset('assets/front/img/user/'.$featured_user->photo)); ?>"
                                                  alt="user">
                                            <?php else: ?>
                                                <img class="lazy" src="<?php echo e(asset('assets/admin/img/propics/blank_user.jpg')); ?>"
                                                          alt="user">
                                            <?php endif; ?>

                                        </div>
                                        <div class="card-content blue">
                                            <h3 class="card-title"><?php echo e($featured_user->first_name." ".$featured_user->last_name); ?></h3>


                                            <div class="social-link">


                                                <div class="social-link">
                                                    <?php $__currentLoopData = $featured_user->social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e($social->url); ?>" target="_blank"><i
                                                                class="<?php echo e($social->icon); ?>"></i></a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>

                                            </div>

                                            <div class="cta-btns">
                                                <?php
                                                    if (!empty($featured_user)) {
                                                        $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($featured_user->id);
                                                        $preferences = App\Models\User\UserPermission::where([
                                                            ['user_id',$featured_user->id],
                                                            ['package_id',$currentPackage->package_id]
                                                        ])->first();
                                                        $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                                    }
                                                ?>
                                                <a href="<?php echo e(detailsUrl($featured_user)); ?>" class="btn btn-sm secondary-btn"><?php echo e(__("View Profile")); ?></a>
                                                <?php if(auth()->guard()->guest()): ?>
                                                    <?php if(!empty($permissions) && in_array('Follow/Unfollow', $permissions)): ?>

                                                        <a href="<?php echo e(route('user.follow',['id' => $featured_user->id])); ?>" class="btn btn-sm primary-btn"><i class="fal fa-user-plus"></i><?php echo e(__('Follow')); ?>

                                                        </a>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if(Auth::check() && Auth::id() != $featured_user->id): ?>
                                                    <?php if(!empty($permissions) && in_array('Follow/Unfollow', $permissions)): ?>

                                                        <?php if(App\Models\User\Follower::where('follower_id', Auth::id())->where('following_id', $featured_user->id)->count() > 0): ?>
                                                            <a href="<?php echo e(route('user.unfollow', $featured_user->id)); ?>" class="btn btn-sm primary-btn"><i class="fal fa-user-minus"></i><?php echo e(__('Unfollow')); ?>

                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(route('user.follow',['id' => $featured_user->id])); ?>" class="btn btn-sm primary-btn"><i class="fal fa-user-plus"></i><?php echo e(__('Follow')); ?>

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
                        <div class="swiper-pagination" data-aos="fade-up"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-2.png')); ?>" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-6.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-3.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Featured Profile End -->

    <!-- Testimonial Start -->
    <?php if($bs->testimonial_section == 1): ?>
    <section class="testimonial-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title ms-0" data-aos="fade-right">
                        <span class="subtitle"><?php echo e($bs->testimonial_subtitle); ?></span>
                    <?php if(!empty($bs->testimonial_title)): ?>
                            <h2 class="title"><?php echo e($bs->testimonial_title); ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center gx-xl-5">
                        <div class="col-lg-6">
                            <div class="image image-left" data-aos="fade-right">
                                <img src="<?php echo e(asset('assets/front/img/testimonials/'.$be->testimonial_img)); ?>" alt="Banner Image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="swiper testimonial-slider" data-aos="fade-left">
                                <div class="swiper-wrapper">

                                    <?php for($i = 0; $i <= count($testimonials); $i=$i+2): ?>
                                        <?php if($i < (count($testimonials) - 1)): ?>
                                            <div class="swiper-slide">

                                                <div class="slider-item">
                                                    <div class="quote">
                                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                                        <p class="text">
                                                            <?php echo e($testimonials[$i]->comment); ?>

                                                        </p>
                                                    </div>
                                                    <div class="client">
                                                        <div class="image">
                                                            <div class="lazy-container aspect-ratio-1-1">
                                                                <img class="lazyload lazy-image"
                                                                     data-src="<?php echo e($testimonials[$i]->image ? asset('assets/front/img/testimonials/'. $testimonials[$i]->image) : asset('assets/front/img/thumb-1.jpg')); ?>"
                                                                     alt="Person Image">
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name"><?php echo e($testimonials[$i]->name); ?></h6>
                                                            <span class="designation"><?php echo e($testimonials[$i]->rank); ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="slider-item">
                                                    <div class="quote">
                                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                                        <p class="text">
                                                            <?php echo e($testimonials[$i+1]->comment); ?>

                                                        </p>
                                                    </div>
                                                    <div class="client">
                                                        <div class="image">
                                                            <div class="lazy-container aspect-ratio-1-1">
                                                                <img class="lazyload lazy-image"
                                                                     data-src="<?php echo e($testimonials[$i+1]->image ? asset('assets/front/img/testimonials/'. $testimonials[$i+1]->image) : asset('assets/front/img/thumb-1.jpg')); ?>"
                                                                     alt="Person Image">
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name"><?php echo e($testimonials[$i+1]->name); ?></h6>
                                                            <span class="designation"><?php echo e($testimonials[$i+1]->rank); ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-1.png')); ?>" alt="Bg">
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-2.png')); ?>" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-3.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-6.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Testimonial End -->

    <!-- Blog Start -->
    <?php if($bs->news_section == 1): ?>
    <section class="blog-area ptb-90">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <span class="subtitle"><?php echo e($bs->blog_subtitle); ?></span>

                <?php if(!empty($bs->blog_title)): ?>
                    <h2 class="title"><?php echo e($bs->blog_title); ?></h2>
                <?php endif; ?>
            </div>
            <div class="row justify-content-center">

                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-image">
                                <a href="<?php echo e(route('front.blogdetails',['id' => $blog->id,'slug' => $blog->slug])); ?>" class="lazy-container aspect-ratio-16-9">
                                    <img class="lazyload lazy-image" data-src="<?php echo e(asset('assets/front/img/blogs/'.$blog->main_image)); ?>" alt="Banner Image">
                                </a>
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i><?php echo e(__("Admin")); ?></li>
                                    <li><i class="fal fa-calendar"></i><?php echo e(\Carbon\Carbon::parse($blog->created_at)->format("F j, Y")); ?></li>
                                    <li><i class="fal fa-tag"></i><?php echo e($blog->bcategory->name); ?></li>
                                </ul>
                            </div>
                            <div class="content">
                                <h3 class="card-title">
                                    <a href="<?php echo e(route('front.blogdetails',['id' => $blog->id,'slug' => $blog->slug])); ?>">
                                        <?php echo e(strlen($blog->title) > 55 ? mb_substr($blog->title, 0, 55, 'utf-8') . '...' : $blog->title); ?>

                                    </a>
                                </h3>
                                <p class="card-text">
                                    <?php echo substr(strip_tags($blog->content), 0, 150); ?>


                                </p>
                                <a href="#" class="card-btn"><?php echo e(__("Read More")); ?></a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-2.png')); ?>" alt="Bg">
        <img class="bg-overlay" src="<?php echo e(asset('assets/front/img/shadow-bg-1.png')); ?>" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="<?php echo e(asset('assets/front/img/shape/shape-10.png')); ?>" alt="Shape">
            <img class="shape-2" src="<?php echo e(asset('assets/front/img/shape/shape-6.png')); ?>" alt="Shape">
            <img class="shape-3" src="<?php echo e(asset('assets/front/img/shape/shape-7.png')); ?>" alt="Shape">
            <img class="shape-4" src="<?php echo e(asset('assets/front/img/shape/shape-4.png')); ?>" alt="Shape">
            <img class="shape-5" src="<?php echo e(asset('assets/front/img/shape/shape-3.png')); ?>" alt="Shape">
            <img class="shape-6" src="<?php echo e(asset('assets/front/img/shape/shape-8.png')); ?>" alt="Shape">
        </div>
    </section>
    <?php endif; ?>
    <!-- Blog End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samiulalimpratik/Sites/coursemat/coursemat/resources/views/front/index.blade.php ENDPATH**/ ?>