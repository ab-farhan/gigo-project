<?php $__env->startSection('pagename'); ?>
- <?php echo e(__('FAQs')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->faqs_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->faqs_meta_keywords : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<?php echo e(__('FAQs')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__('FAQs')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!--====== Start faqs-section ======-->
    <div id="faq" class="faq-area pt-120 pb-90">
        <div class="container">
            <div class="accordion" id="faqAccordion">
                <div class="row justify-content-center">
                    <div class="col-lg-8 has-time-line" data-aos="fade-right">
                        <div class="row">
                            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key == 0): ?>
                                    <div class="col-12">
                                        <div class="accordion-item">
                                            <h6 class="accordion-header" id="heading<?php echo e($key); ?>">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse<?php echo e($key); ?>" aria-expanded="true"
                                                        aria-controls="collapse<?php echo e($key); ?>">
                                                    <?php echo e($faq->question); ?>

                                                </button>
                                            </h6>
                                            <div id="collapse<?php echo e($key); ?>" class="accordion-collapse collapse show"
                                                 aria-labelledby="heading<?php echo e($key); ?>" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    <p><?php echo e($faq->answer); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="accordion-item">
                                            <h6 class="accordion-header" id="heading<?php echo e($key); ?>">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse<?php echo e($key); ?>" aria-expanded="false"
                                                        aria-controls="collapse<?php echo e($key); ?>">
                                                    <?php echo e($faq->question); ?>

                                                </button>
                                            </h6>
                                            <div id="collapse<?php echo e($key); ?>" class="accordion-collapse collapse "
                                                 aria-labelledby="heading<?php echo e($key); ?>" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    <p><?php echo e($faq->answer); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <!--====== End faqs-section ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/front/faq.blade.php ENDPATH**/ ?>