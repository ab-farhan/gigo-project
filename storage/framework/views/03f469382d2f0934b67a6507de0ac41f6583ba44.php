<?php $__env->startSection('pagename'); ?>
- <?php echo e($page->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($page) ? $page->meta_keywords : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($page) ? $page->meta_description : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<?php echo e($page->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e($page->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!--====== Start faqs-section ======-->

    <section class="terms-condition-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 m-auto">

                    <div class="item-single mb-30" data-aos="fade-up">
                        <?php echo replaceBaseUrl($page->body); ?>

                    </div>

                </div>
            </div>
        </div>
    </section>


   <!--====== End faqs-section ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/front/dynamic.blade.php ENDPATH**/ ?>