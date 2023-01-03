

<!-- Footer Area -->
<footer class="footer-area bg-primary-light bg-img" data-bg-image="<?php echo e(asset('/')); ?>assets/front/images/footer-bg.png">
    <?php if($bs->top_footer_section == 1): ?>
        <div class="footer-top pt-120 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="100">
                            <div class="navbar-brand">
                                <a href="index.html">
                                    <img src="<?php echo e(asset('assets/front/img/' . $bs->footer_logo)); ?>" alt="Logo">
                                </a>
                            </div>
                            <p><?php echo e($bs->footer_text); ?></p>
                            <div class="btn-groups">
                                <a href="error.html" class="btn btn-img radius-sm size-sm" title="App Store"
                                    target="_blank">
                                    <img class="blur-up ls-is-cached lazyloaded"
                                        src="<?php echo e(asset('/')); ?>assets/front/images/app-store.png"
                                        data-src="<?php echo e(asset('/')); ?>assets/front/images/app-store.png" alt="App Store">
                                </a>
                                <a href="error.html" class="btn btn-img radius-sm size-sm" title="Play Store"
                                    target="_blank">
                                    <img class="blur-up ls-is-cached lazyloaded"
                                        src="<?php echo e(asset('/')); ?>assets/front/images/play-store.png"
                                        data-src="<?php echo e(asset('/')); ?>assets/front/images/play-store.png"
                                        alt="App Store">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-6">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                            <?php
                                $ulinks = App\Models\Ulink::where('language_id', $currentLang->id)
                                    ->orderby('id', 'desc')
                                    ->get();
                            ?>
                            <h5><?php echo e($bs->useful_links_title); ?></h5>

                            <ul class="footer-links">
                                <?php $__currentLoopData = $ulinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ulink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($ulink->url); ?>"><?php echo e($ulink->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-6">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                            <h5>Features</h5>
                            <ul class="footer-links">
                                <li>
                                    <a href="javaScript:void(0)">Wp Themes</a>
                                </li>
                                <li>
                                    <a href="javaScript:void(0)">Html Template</a>
                                </li>
                                <li>
                                    <a href="javaScript:void(0)">UI Template</a>
                                </li>
                                <li>
                                    <a href="javaScript:void(0)">CMS Template</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-6">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                            <h5>Categories</h5>
                            <ul class="footer-links">
                                <li>
                                    <a href="javaScript:void(0)">Wp Themes</a>
                                </li>
                                <li>
                                    <a href="javaScript:void(0)">Html Template</a>
                                </li>
                                <li>
                                    <a href="javaScript:void(0)">UI Template</a>
                                </li>
                                <li>
                                    <a href="javaScript:void(0)">CMS Template</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="footer-widget" data-aos="fade-up" data-aos-delay="500">
                            <h5><?php echo e($bs->newsletter_title); ?></h5>
                            <p class="lh-1 mb-20"><?php echo e($bs->newsletter_subtitle); ?></p>
                            <div class="newsletter-form">
                                <form id="newsletterForm" action="<?php echo e(route('front.subscribe')); ?>" method="POST"
                                    class="subscribeForm">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <input class="form-control radius-sm" name="email"
                                            placeholder="<?php echo e(__('Enter email here...')); ?>" type="text" name="EMAIL"
                                            required="" autocomplete="off">
                                        <button class="btn btn-md btn-primary radius-sm no-animation" type="submit"><i
                                                class="fal fa-paper-plane"></i></button>
                                    </div>
                                    <p id="erremail" class="text-danger mb-0 err-email"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($bs->copyright_section == 1): ?>
        <div class="copy-right-area border-top">
            <div class="container">
                <div class="copy-right-content">
                    <div class="social-link justify-content-center mb-2">

                        <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($social->url); ?>" target="_blank" title="instagram"><i
                                    class="<?php echo e($social->icon); ?>"></i></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>

                    <span>
                        <?php echo replaceBaseUrl($bs->copyright_text); ?>

                    </span>

                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>
<!-- Footer Area -->

<?php /**PATH D:\laragon\www\gigo\resources\views/front/partials/footer.blade.php ENDPATH**/ ?>