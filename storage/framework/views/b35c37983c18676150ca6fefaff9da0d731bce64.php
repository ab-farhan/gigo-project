<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4 class="page-title"><?php echo e(__('Section Customization')); ?></h4>
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
          <a href="#"><?php echo e(__('Website Pages')); ?></a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"><?php echo e(__('Settings')); ?></a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"><?php echo e(__('Section Customization')); ?></a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form class="" action="<?php echo e(route('admin.sections.update')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title"><?php echo e(__('Customize Sections')); ?></div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label><?php echo e(__('Hero Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="home_section" value="1" class="selectgroup-input" <?php echo e($abs->home_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="home_section" value="0" class="selectgroup-input" <?php echo e($abs->home_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Work Process Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="process_section" value="1" class="selectgroup-input" <?php echo e($abs->process_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="process_section" value="0" class="selectgroup-input" <?php echo e($abs->process_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Users Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="featured_users_section" value="1" class="selectgroup-input" <?php echo e($abs->featured_users_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="featured_users_section" value="0" class="selectgroup-input" <?php echo e($abs->featured_users_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Features Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="intro_section" value="1" class="selectgroup-input" <?php echo e($abs->intro_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="intro_section" value="0" class="selectgroup-input" <?php echo e($abs->intro_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Template Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="template_section" value="1" class="selectgroup-input" <?php echo e($abs->template_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="template_section" value="0" class="selectgroup-input" <?php echo e($abs->template_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Pricing Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="pricing_section" value="1" class="selectgroup-input" <?php echo e($abs->pricing_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="pricing_section" value="0" class="selectgroup-input" <?php echo e($abs->pricing_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Partners Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="partners_section" value="1" class="selectgroup-input" <?php echo e($abs->partners_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="partners_section" value="0" class="selectgroup-input" <?php echo e($abs->partners_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Testimonial Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="testimonial_section" value="1" class="selectgroup-input" <?php echo e($abs->testimonial_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="testimonial_section" value="0" class="selectgroup-input" <?php echo e($abs->testimonial_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Blogs Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="news_section" value="1" class="selectgroup-input" <?php echo e($abs->news_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="news_section" value="0" class="selectgroup-input" <?php echo e($abs->news_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Top Footer Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="top_footer_section" value="1" class="selectgroup-input" <?php echo e($abs->top_footer_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="top_footer_section" value="0" class="selectgroup-input" <?php echo e($abs->top_footer_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Copyright Section')); ?> **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="copyright_section" value="1" class="selectgroup-input" <?php echo e($abs->copyright_section == 1 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="copyright_section" value="0" class="selectgroup-input" <?php echo e($abs->copyright_section == 0 ? 'checked' : ''); ?>>
                                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="displayNotif" class="btn btn-success"><?php echo e(__('Update')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/sections.blade.php ENDPATH**/ ?>