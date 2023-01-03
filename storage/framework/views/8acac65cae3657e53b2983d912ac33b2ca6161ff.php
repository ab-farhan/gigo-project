

<!-- Header Start -->
<header class="header-area" data-aos="fade-down">
    <!-- Start mobile menu -->
    <div class="mobile-menu">
        <div class="container">
            <div class="mobile-menu-wrapper"></div>
        </div>
    </div>
    <!-- End mobile menu -->

    <div class="main-responsive-nav">
        <div class="container">
            <!-- Mobile Logo -->
            <div class="logo">
                <a href="<?php echo e(route('front.index')); ?>">
                    <img src="<?php echo e(asset('assets/front/img/' . $bs->logo)); ?>" alt="logo">
                </a>
            </div>
            <!-- Menu toggle button -->
            <button class="menu-toggler" type="button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <div class="main-navbar">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <!-- Logo -->
                <a class="navbar-brand" href="<?php echo e(route('front.index')); ?>">
                    <img src="<?php echo e(asset('assets/front/img/' . $bs->logo)); ?>" alt="logo">
                </a>
                <!-- Navigation items -->
                <div class="collapse navbar-collapse">
                    <ul id="mainMenu" class="navbar-nav mobile-item">
                        <?php
                            $links = json_decode($menus, true);
                        ?>
                        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $href = getHref($link);
                                
                            ?>


                            <?php if(!array_key_exists('children', $link)): ?>
                                <li class="nav-item">
                                    <a class="nav-link " target="<?php echo e($link['target']); ?>"
                                        href="<?php echo e($href); ?>"><?php echo e($link['text']); ?></a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link toggle" target="<?php echo e($link['target']); ?>"
                                        href="<?php echo e($href); ?>"><?php echo e($link['text']); ?><i class="fal fa-plus"></i></a>
                                    <ul class="menu-dropdown">
                                        <?php $__currentLoopData = $link['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $l2Href = getHref($level2);
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo e($l2Href); ?>"
                                                    target="<?php echo e($level2['target']); ?>"><?php echo e($level2['text']); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </ul>
                </div>
                <div class="more-option mobile-item">
                    <div class="item">
                        <div class="language">

                            <?php if(!empty($currentLang)): ?>
                                <select onchange="handleSelect(this)" class="select">
                                    <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lang->code); ?>"
                                            <?php echo e($currentLang->code === $lang->code ? 'selected' : ''); ?>>
                                            <?php echo e($lang->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if(auth()->guard()->guest()): ?>
                        <div class="item">
                            <a href="<?php echo e(route('user.login')); ?>" class="btn btn-md btn-primary" title="Login"
                                target="_self">
                                <span><?php echo e(__('Login')); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if(auth()->guard()->check()): ?>
                        <div class="item">
                            <a href="<?php echo e(route('user-dashboard')); ?>" class="btn btn-md btn-primary" title="Dashboard"
                                target="_self">
                                <span><?php echo e(__('Dashboard')); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </div>
</header>
<!-- Header End -->
<?php /**PATH D:\laragon\www\gigo\resources\views/front/partials/header.blade.php ENDPATH**/ ?>