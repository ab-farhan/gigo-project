<?php $__env->startSection('pagename'); ?>
    - <?php echo e(__('Blog')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-description', !empty($seo) ? $seo->blogs_meta_description : ''); ?>
<?php $__env->startSection('meta-keywords', !empty($seo) ? $seo->blogs_meta_keywords : ''); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <?php echo e(__('Blog')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-link'); ?>
    <?php echo e(__('Blog')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!--====== Start saas-blog section ======-->


    
    <section class="blog-area ptb-120">
        <div class="container">
            <div class="row justify-content-center">
                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-image">
                                <a href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>"
                                    class="lazy-container ratio-16-9">
                                    <img class="lazyload lazy-image" 
                                        data-src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>"
                                        alt="Blog Image">
                                </a>
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i><?php echo e(__('Admin')); ?></li>
                                    <li><i class="fal fa-calendar"></i>
                                        <?php echo e(\Carbon\Carbon::parse($blog->created_at)->format('d M, Y')); ?>

                                    </li>
                                    <li><i class="fal fa-tag"></i><?php echo e($blog->bcategory->name); ?></li>
                                </ul>
                            </div>
                            <div class="content">
                                <h5 class="card-title lc-2">
                                    <a href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>">
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

            <nav class="pagination-nav" data-aos="fade-up">

                <ul class="pagination justify-content-center mb-0">
                    <?php echo e($blogs->appends(['category' => request()->input('category')])->links()); ?>

                    
                </ul>
            </nav>
        </div>
    </section>
    <!--====== End saas-blog section ======-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/front/blogs.blade.php ENDPATH**/ ?>