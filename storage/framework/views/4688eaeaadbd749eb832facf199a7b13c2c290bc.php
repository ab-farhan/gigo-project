

<!-- Footer Area -->
<footer class="footer-area">
    <?php if($bs->top_footer_section == 1): ?>
        <div class="footer-top pt-120 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="100">
                    <div class="navbar-brand">
                        <a href="index.html">
                            <img src="<?php echo e(asset('assets/front/img/' . $bs->footer_logo)); ?>" alt="Logo">
                        </a>
                    </div>
                    <p><?php echo e($bs->footer_text); ?></p>
                    <div class="social-link">


                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                    <?php
                        $ulinks = App\Models\Ulink::where('language_id',$currentLang->id)->orderby('id','desc')->get();
                    ?>
                    <h3><?php echo e($bs->useful_links_title); ?></h3>
                    <ul class="footer-links">
                        <?php $__currentLoopData = $ulinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ulink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e($ulink->url); ?>"><?php echo e($ulink->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="400">
                    <h3> <?php echo e($bs->contact_info_title); ?></h3>

                    <ul class="info-list">
                        <li>
                            <i class="fal fa-map-marker-alt"></i>
                            <span><?php echo e($be->contact_addresses); ?></span>
                        </li>
                        <li>
                            <?php
                                $phones = explode(',', $be->contact_numbers);
                            ?>
                            <i class="fal fa-phone"></i>
                            <?php $__currentLoopData = $phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="tel:<?php echo e($phone); ?>"><?php echo e($phone); ?></a>
                                <?php if(!$loop->last): ?>
                                   , 
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </li>
                        <li>
                            <?php
                                $mails = explode(',', $be->contact_mails);
                            ?>
                            <i class="fal fa-envelope"></i>
                            <?php $__currentLoopData = $mails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="mailto:<?php echo e($mail); ?>"><?php echo e($mail); ?></a>
                                <?php if(!$loop->last): ?>
                                   , 
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="500">
                    <h3><?php echo e($bs->newsletter_title); ?></h3>
                    <p><?php echo e($bs->newsletter_subtitle); ?></p>
                    <form id="footerSubscriber" action="<?php echo e(route('front.subscribe')); ?>" method="POST" class="subscribeForm">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input name="email" class="form-control" placeholder="<?php echo e(__("Enter Your Email")); ?>" type="text" required="" autocomplete="off">
                            <button class="btn btn-sm primary-btn" type="submit"><?php echo e(__("Subscribe")); ?></button>
                        </div>
                        <p id="erremail" class="text-danger mb-0 err-email"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php endif; ?>
    <?php if($bs->copyright_section == 1): ?>
        <div class="copy-right-area">
            <div class="container">
                <div class="copy-right-content">
                    <?php if($bs->copyright_section ==1): ?>
                        <span>
                        <?php echo replaceBaseUrl($bs->copyright_text); ?>

                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>
<!-- Footer Area -->
<?php /**PATH /Users/samiulalimpratik/Sites/coursemat/coursemat/resources/views/front/partials/footer.blade.php ENDPATH**/ ?>