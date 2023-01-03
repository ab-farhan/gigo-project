

<aside class="sidebar-widget-area">
    <div class="widget widget-search mb-30">
        <h4 class="title">Search Posts</h4>
        <form class="search-form">
            <input type="search" class="search-input" placeholder="Search Here">
            <button class="btn-search" type="submit">
                <i class="far fa-search"></i>
            </button>
        </form>
    </div>
    <div class="widget widget-post mb-30">
        <h4 class="title"><?php echo e(__('Recent Posts')); ?></h4>
        <?php $__currentLoopData = $allBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="article-item mb-30">
                <div class="image">
                    <a href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>"
                        class="lazy-container aspect-ratio-1-1 d-block">
                        <img class="lazyload lazy-image"
                            src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>"
                            data-src="<?php echo e(asset('assets/front/img/blogs/' . $blog->main_image)); ?>" alt="Blog Image">
                    </a>
                </div>
                <div class="content">
                    <h6>
                        <a href="<?php echo e(route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug])); ?>">
                            <?php echo e(strlen($blog->title) > 60 ? mb_substr($blog->title, 0, 60, 'utf-8') . '...' : $blog->title); ?>

                        </a>
                    </h6>
                    <div class="time">
                        <?php echo e($blog->created_at->diffForHumans()); ?>

                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="widget widget-social-link mb-30">
        <h4 class="title">Follow Us</h4>
        <div class="social-link">
            <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($social->url); ?>" target="_blank" title="Social Link"><i
                        class="<?php echo e($social->icon); ?>"></i></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
    <div class="widget widget-categories mb-30">
        <h4 class="title"><?php echo e(__('Categories')); ?></h4>
        <ul class="list-unstyled m-0">
            <?php $__currentLoopData = $bcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="d-flex align-items-center justify-content-between">
                    <a href="<?php echo e(route('front.blogs', ['category' => $bcat->id])); ?>"> <i class="fal fa-folder"></i>
                        <?php echo e($bcat->name); ?> </a>
                    <span class="tqy">( <?php echo e($bcat->blogs->count()); ?> )</span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </ul>
    </div>
    <div class="widget widget-tag mb-30">
        <h4 class="title">Tags</h4>
        <ul class="list-unstyled mb-0">
            <li><a href="javaScript:void(0)">Technology</a></li>
            <li><a href="javaScript:void(0)">Business</a></li>
            <li><a href="javaScript:void(0)">Marketing</a></li>
            <li><a href="javaScript:void(0)">App</a></li>
            <li><a href="javaScript:void(0)">Social</a></li>
            <li><a href="javaScript:void(0)">Politics</a></li>
        </ul>
    </div>
</aside>
<?php /**PATH D:\laragon\www\gigo\resources\views/front/partials/blog-sidebar.blade.php ENDPATH**/ ?>