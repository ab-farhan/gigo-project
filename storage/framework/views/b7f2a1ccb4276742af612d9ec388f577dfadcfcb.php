<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h4 class="page-title"><?php echo e(__('Package Features')); ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?php echo e(__('Packages Management')); ?></a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?php echo e(__('Package Features')); ?></a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block"><?php echo e(__('Package Features')); ?></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form id="permissionsForm" class="" action="<?php echo e(route('admin.package.features')); ?>"
                                method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="alert alert-warning">
                                    <?php echo e(__('Only these selected features will be visible in frontend Pricing Section')); ?>

                                </div>
                                <div class="form-group">

                                    <label class="form-label"><?php echo e(__('Package Features')); ?></label>
                                    <div class="selectgroup selectgroup-pills">


                                        

                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Domain"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Custom Domain', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Custom Domain')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Subdomain"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Subdomain', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Subdomain')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service Form Builder"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Service Form Builder', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Service Form Builder')); ?></span>
                                        </label>
                                        
                                        <label class="selectgroup-item">
                                            <input type="checkbox" id="shopManagement" name="features[]"
                                                value="Shop Management" class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Shop Management', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Shop Management')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Page"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Custom Page', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Custom Page')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Contact Form"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Contact Form', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Contact Form')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Support Tickets"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Support Tickets', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Support Tickets')); ?></span>
                                        </label>

                                        <label class="selectgroup-item" id="vCard">
                                            <input type="checkbox" name="features[]" value="vCard"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('vCard', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('vCard')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="QR Builder"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('QR Builder', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('QR Builder')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom CSS"
                                                class="selectgroup-input" <?php if(is_array($features) && in_array('Custom CSS', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Custom CSS')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Analytics"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Google Analytics', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Google Analytics')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Facebook Pixel"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Facebook Pixel', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Facebook Pixel')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Disqus"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Disqus', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Disqus')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Recaptcha"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Google Recaptcha', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Google Recaptcha')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Whatsapp"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Whatsapp', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Whatsapp')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Login"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Google Login', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Google Login')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Facebook Login"
                                                class="selectgroup-input"
                                                <?php if(is_array($features) && in_array('Facebook Login', $features)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Facebook Login')); ?></span>
                                        </label>


                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="permissionBtn"
                                    class="btn btn-success"><?php echo e(__('Update')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/packages/features.blade.php ENDPATH**/ ?>