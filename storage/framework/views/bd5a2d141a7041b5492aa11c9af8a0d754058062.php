<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Pricing')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->pricing_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e(__('Pricing')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__('Pricing')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    

    <!-- Pricing Start -->
    <section class="pricing-area pt-120 pb-90">
        <div class="container">
            <?php if(count($terms) > 1): ?>
                <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                    <ul class="nav nav-tabs">
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" data-bs-toggle="tab"
                                    data-bs-target="#<?php echo e(__("$term")); ?>" type="button"><?php echo e(__("$term")); ?></button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </ul>
                </div>
            <?php endif; ?>
            <div class="tab-content">
                <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="<?php echo e(__("$term")); ?>">
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
                                        <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                            industry.</p>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="price"><?php echo e($package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''); ?><?php echo e($package->price == 0 ? 'Free' : $package->price); ?><?php echo e($package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''); ?></span>
                                            <span class="period">/ <?php echo e(__("$package->term")); ?></span>
                                        </div>
                                        <h5><?php echo e(__('Whats Included')); ?></h5>
                                        <ul class="pricing-list list-unstyled p-0">
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->service_limit === 999999 ? __('Unlimited') : $package->service_limit . ' '); ?>

                                                <?php echo e($package->service_limit === 1 ? __('Service') : __('Service')); ?>

                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->service_categories_limit === 999999 ? __('Unlimited') : $package->service_categories_limit . ' '); ?><?php echo e($package->service_categories_limit === 1 ? __('Service categories') : __('Service Categories')); ?>

                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->service_subcategories_limit === 999999 ? __('Unlimited') : $package->service_subcategories_limit . ' '); ?><?php echo e($package->service_subcategories_limit === 1 ? __('Service Subcategories') : __('Service Subcategories')); ?>

                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->service_orders_limit === 999999 ? __('Unlimited') : $package->service_orders_limit . ' '); ?><?php echo e($package->service_orders_limit === 1 ? __('Service Orders') : __('Service Orders')); ?>

                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->invoice_limit === 999999 ? __('Unlimited') : $package->invoice_limit . ' '); ?><?php echo e($package->invoice_limit === 1 ? __('Invoice') : __('Invoice')); ?>

                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->user_limit === 999999 ? __('Unlimited') : $package->user_limit . ' '); ?><?php echo e($package->user_limit === 1 ? __('User') : __('User')); ?>

                                            </li>
                                            
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->post_limit === 999999 ? __('Unlimited') : $package->post_limit . ' '); ?><?php echo e($package->post_limit === 1 ? __('Post') : __('Post')); ?>

                                            </li>
                                            
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <?php echo e($package->language_limit === 999999 ? __('Unlimited') : $package->language_limit . ' '); ?><?php echo e($package->language_limit === 1 ? __('Language') : __('Language')); ?>

                                            </li>

                                            <?php $__currentLoopData = $allPfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li
                                                    class="<?php echo e(is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled'); ?>">
                                                    <i
                                                        class="<?php echo e(is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times'); ?>"></i>
                                                    <?php if($feature == 'vCard'): ?>
                                                        <?php echo e($package->vCard_limit === 999999 ? __('Unlimited') : $package->vCard_limit . ' '); ?>

                                                        <?php echo e($package->vCard_limit === 1 ? __('vCard') : __('vCard')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(__("$feature")); ?>

                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </ul>
                                        <div class="btn-groups">
                                            

                                            <?php if($package->is_trial === '1' && $package->price != 0): ?>
                                                <a href="<?php echo e(route('front.register.view', ['status' => 'trial', 'id' => $package->id])); ?>"
                                                    itle="Trial" target="_self"
                                                    class="btn btn-lg btn-primary no-animation"><?php echo e(__('Trial')); ?></a>
                                            <?php endif; ?>
                                            <?php if($package->price == 0): ?>
                                                <a href="<?php echo e(route('front.register.view', ['status' => 'regular', 'id' => $package->id])); ?>"
                                                    class="btn btn-lg btn-primary no-animation"><?php echo e(__('Signup')); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('front.register.view', ['status' => 'regular', 'id' => $package->id])); ?>"
                                                    title="Purchase" target="_self"
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
    </section>
    <!-- Pricing End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/front/pricing.blade.php ENDPATH**/ ?>