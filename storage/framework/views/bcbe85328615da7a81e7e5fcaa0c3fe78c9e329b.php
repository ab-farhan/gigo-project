<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Blog Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($blog) ? $blog->meta_keywords : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($blog) ? $blog->meta_description : ''); ?>

<?php $__env->startSection('og-meta'); ?>
    <meta property="og:image" content="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e(strlen($blog->title) > 30 ? mb_substr($blog->title, 0, 30) . '...' : $blog->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__('Blog Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!--====== BLOG DETAILS PART START ======-->

    <!-- Blog Details Start -->
    <div class="blog-details-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center gx-xl-5">
                <div class="col-lg-8">
                    
                    <div class="blog-description mb-50">
                        <article class="item-single">
                            <div class="image">
                                <div class="lazy-container ratio-16-9">
                                    <img class="lazyload lazy-image"
                                        src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>"
                                        data-src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>"
                                        alt="Blog Image">
                                </div>
                                <a href="//twitter.com/intent/tweet?text=my share text&amp;url=<?php echo e(urlencode(url()->current())); ?>"
                                    class="btn btn-lg btn-primary"><i class="fas fa-share-alt"></i>Share</a>
                            </div>
                            <div class="content">
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>Admin</li>
                                    <li> <i class="fal fa-calendar"></i>
                                        <?php echo e(\Carbon\Carbon::parse($blog->created_at)->format('d m, Y')); ?>

                                    </li>
                                    <li><i class="fal fa-tag"></i>
                                        <?php echo e(route('front.blogs', ['category' => $blog->bcategory->id])); ?>"><?php echo e($blog->bcategory->name); ?>

                                    </li>
                                </ul>
                                <h4 class="title">
                                    <?php echo e($blog->title); ?>

                                </h4>
                                <?php echo replaceBaseUrl($blog->content); ?>

                            </div>
                        </article>
                    </div>
                    <div class="comments mb-30">
                        <div class="comment-box mb-50">
                            <span class="h3 d-block mb-20">Comments</span>
                            <ol class="comment-list">
                                <li class="comment">
                                    <div class="comment-body">
                                        <div class="comment-author">
                                            <div class="lazy-container ratio-1-1">
                                                <img class="lazyload lazy-image"
                                                    src="<?php echo e(asset('')); ?>/assets/front/images/placeholder.png"
                                                    data-src="<?php echo e(asset('')); ?>/assets/front/images/client/client-1.jpg"
                                                    alt="image" />
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            <h5 class="name">Adam Haul</h5>
                                            <p>
                                                Quality control of your data including read length distribution and
                                                uniformity assessment in a few clicks and choose your favorite. name
                                                this.
                                            </p>
                                            <a href="javaScript:void(0)" class="btn-reply"><i
                                                    class="fas fa-reply-all"></i>Reply</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="comment">
                                    <div class="comment-body">
                                        <div class="comment-author">
                                            <div class="lazy-container ratio-1-1">
                                                <img class="lazyload lazy-image"
                                                    src="<?php echo e(asset('')); ?>/assets/front/images/placeholder.png"
                                                    data-src="<?php echo e(asset('')); ?>/assets/front/images/client/client-2.jpg"
                                                    alt="image" />
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            <h5 class="name">David Murphy</h5>
                                            <p>
                                                Quality control of your data including read length distribution and
                                                uniformity assessment in a few clicks and choose your favorite. name
                                                this.
                                            </p>
                                            <a href="javaScript:void(0)" class="btn-reply"><i
                                                    class="fas fa-reply-all"></i>Reply</a>
                                        </div>
                                    </div>
                                    <ol class="children">
                                        <li class="comment">
                                            <div class="comment-body">
                                                <div class="comment-author">
                                                    <div class="lazy-container ratio-1-1">
                                                        <img class="lazyload lazy-image"
                                                            src="<?php echo e(asset('')); ?>/assets/front/images/placeholder.png"
                                                            data-src="<?php echo e(asset('')); ?>/assets/front/images/client/client-3.jpg"
                                                            alt="image" />
                                                    </div>
                                                </div>
                                                <div class="comment-content">
                                                    <h5 class="name">Harry jain</h5>
                                                    <p>
                                                        Quality control of your data including read length distribution
                                                        and uniformity assessment in a few clicks and choose your
                                                        favorite. name this.
                                                    </p>
                                                    <a href="javaScript:void(0)" class="btn-reply"><i
                                                            class="fas fa-reply-all"></i>Reply</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                        <div class="comment-reply mb-30">
                            <span class="h3 d-block">Post Comment</span>
                            <p class="comment-notes">
                                <span id="email-notes">Your email address will not be published.</span>
                                Required fields are marked
                                <span class="required">*</span>
                            </p>
                            <form id="commentForm" class="comment-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-20">
                                            <input type="text" class="form-control" name="name" placeholder=" Name*"
                                                required="required" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-20">
                                            <input type="email" class="form-control" name="email" placeholder=" Email*"
                                                required="required" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-30">
                                            <textarea name="message" class="form-control" placeholder="Comment" required="required" rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary">
                                    Post Comment
                                </button>
                            </form>
                        </div>
                    </div>
                    

                </div>
                <div class="col-lg-4">
                    <?php if ($__env->exists('front.partials.blog-sidebar')) echo $__env->make('front.partials.blog-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Details End -->



    <!--====== BLOG DETAILS PART ENDS ======-->


<?php $__env->stopSection(); ?>

<?php if($bs->is_disqus == 1): ?>
    <?php $__env->startSection('scripts'); ?>
        <script>
            "use strict";
            (function() {
                var d = document,
                    s = d.createElement('script');
                s.src = '//<?php echo e($bs->disqus_shortname); ?>.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d. || d.body).appendChild(s);
            })();
        </script>
    <?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/front/blog-details.blade.php ENDPATH**/ ?>