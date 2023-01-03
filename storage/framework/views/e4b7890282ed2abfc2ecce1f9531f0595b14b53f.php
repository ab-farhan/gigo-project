<?php
    $default = \App\Models\Language::where('is_default', 1)->first();
    $admin = Auth::guard('admin')->user();
    if (!empty($admin->role)) {
      $permissions = $admin->role->permissions;
      $permissions = json_decode($permissions, true);
    }
?>

<div class="sidebar sidebar-style-2" <?php if(request()->cookie('admin-theme') == 'dark'): ?> data-background-color="dark2" <?php endif; ?>>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <?php if(!empty(Auth::guard('admin')->user()->image)): ?>
                        <img src="<?php echo e(asset('assets/admin/img/propics/'.Auth::guard('admin')->user()->image)); ?>" alt="..."
                             class="avatar-img rounded">
                    <?php else: ?>
                        <img src="<?php echo e(asset('assets/admin/img/propics/blank_user.jpg')); ?>" alt="..."
                             class="avatar-img rounded">
                    <?php endif; ?>
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
            <span>
              <?php echo e(Auth::guard('admin')->user()->first_name); ?>

               <span class="user-level"><?php echo e(__('Admin')); ?></span>
              <span class="caret"></span>
            </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="<?php echo e(route('admin.editProfile')); ?>">
                                    <span class="link-collapse"><?php echo e(__('Edit Profile')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.changePass')); ?>">
                                    <span class="link-collapse"><?php echo e(__('Change Password')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.logout')); ?>">
                                    <span class="link-collapse"><?php echo e(__('Logout')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">

                <div class="row mb-2">
                    <div class="col-12">
                        <form action="">
                            <div class="form-group py-0">
                                <input name="term" type="text" class="form-control sidebar-search ltr" value="" placeholder="<?php echo e(__('Search Menu Here')); ?>...">
                            </div>
                        </form>
                    </div>
                </div>

                
                <li class="nav-item <?php if(request()->path() == 'admin/dashboard'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="la flaticon-paint-palette"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                
                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Packages', $permissions))): ?>
                <li class="nav-item
                    <?php if(request()->path() == 'admin/package/settings'): ?> active 
                    <?php elseif(request()->path() == 'admin/packages'): ?> active
                    <?php elseif(request()->path() == 'admin/package/features'): ?> active
                    <?php elseif(request()->is('admin/package/*/edit')): ?> active
                    <?php elseif(request()->path() == 'admin/coupon'): ?> active
                    <?php elseif(request()->routeIs('admin.coupon.edit')): ?> active <?php endif; ?>">
                    <a data-toggle="collapse" href="#packageManagement">
                        <i class="fas fa-receipt"></i>
                        <p><?php echo e(__('Package Management')); ?></p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse
                        <?php if(request()->path() == 'admin/package/settings'): ?> show 
                        <?php elseif(request()->path() == 'admin/packages'): ?> show
                        <?php elseif(request()->path() == 'admin/package/features'): ?> show
                        <?php elseif(request()->is('admin/package/*/edit')): ?> show
                        <?php elseif(request()->path() == 'admin/coupon'): ?> show
                        <?php elseif(request()->routeIs('admin.coupon.edit')): ?> show <?php endif; ?>" id="packageManagement">
                        <ul class="nav nav-collapse">
                            <li class="<?php if(request()->path() == 'admin/package/settings'): ?> active <?php endif; ?>">
                                <a href="<?php echo e(route('admin.package.settings')); ?>">
                                <span class="sub-item"><?php echo e(__('Settings')); ?></span>
                                </a>
                            </li>
                            <li class="<?php if(request()->path() == 'admin/coupon'): ?> active
                                <?php elseif(request()->routeIs('admin.coupon.edit')): ?> active <?php endif; ?>">
                                <a href="<?php echo e(route('admin.coupon.index')); ?>">
                                    <span class="sub-item">Coupons</span>
                                </a>
                            </li>
                            <li class="<?php if(request()->path() == 'admin/package/features'): ?> active <?php endif; ?>">
                                <a href="<?php echo e(route('admin.package.features')); ?>">
                                <span class="sub-item"><?php echo e(__('Package Features')); ?></span>
                                </a>
                            </li>
                            <li class="<?php if(request()->path() == 'admin/packages'): ?> active
                                <?php elseif(request()->is('admin/package/*/edit')): ?> active
                                <?php endif; ?>">
                                <a href="<?php echo e(route('admin.package.index') . '?language=' . $default->code); ?>">
                                <span class="sub-item"><?php echo e(__('Packages')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Payment Log', $permissions))): ?>
                    <li class="nav-item
                    <?php if(request()->path() == 'admin/payment-log'): ?> active
                    <?php endif; ?>">
                        <a href="<?php echo e(route('admin.payment-log.index')); ?>">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <p><?php echo e(__('Payment Log')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Custom Domains', $permissions))): ?>
                    <li class="nav-item
                        <?php if(request()->path() == 'admin/domains'): ?> active
                        <?php elseif(request()->path() == 'admin/domain/texts'): ?> active
                        <?php endif; ?>">
                        <a data-toggle="collapse" href="#customDomains">
                            <i class="fas fa-link"></i>
                            <p><?php echo e(__('Custom Domains')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
                            <?php if(request()->path() == 'admin/domains'): ?> show
                            <?php elseif(request()->path() == 'admin/domain/texts'): ?> show
                            <?php endif; ?>" id="customDomains">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/domain/texts'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.custom-domain.texts')); ?>">
                                        <span class="sub-item"><?php echo e(__('Request Page Texts')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/domains' && empty(request()->input('type'))): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.custom-domain.index')); ?>">
                                        <span class="sub-item"><?php echo e(__('All Requests')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/domains' && request()->input('type') == 'pending'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.custom-domain.index', ['type' => 'pending'])); ?>">
                                        <span class="sub-item"><?php echo e(__('Pending Requests')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/domains' && request()->input('type') == 'connected'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.custom-domain.index', ['type' => 'connected'])); ?>">
                                        <span class="sub-item"><?php echo e(__('Connected Requests')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/domains' && request()->input('type') == 'rejected'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.custom-domain.index', ['type' => 'rejected'])); ?>">
                                        <span class="sub-item"><?php echo e(__('Rejected Requests')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Subdomains', $permissions))): ?>
                    <li class="nav-item
                        <?php if(request()->path() == 'admin/subdomains'): ?> active
                        <?php endif; ?>">
                        <a data-toggle="collapse" href="#subDomains">
                            <i class="fas fa-link"></i>
                            <p><?php echo e(__('Subdomains')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
                            <?php if(request()->path() == 'admin/subdomains'): ?> show
                            <?php endif; ?>" id="subDomains">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/subdomains' && empty(request()->input('type'))): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.subdomain.index')); ?>">
                                        <span class="sub-item"><?php echo e(__('All Subdomains')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/subdomains' && request()->input('type') == 'pending'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.subdomain.index', ['type' => 'pending'])); ?>">
                                        <span class="sub-item"><?php echo e(__('Pending Subdomains')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/subdomains' && request()->input('type') == 'connected'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.subdomain.index', ['type' => 'connected'])); ?>">
                                        <span class="sub-item"><?php echo e(__('Connected Subdomains')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                
                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Registered Users', $permissions))): ?>
                    <li class="nav-item
                    <?php if(request()->path() == 'admin/register/users'): ?> active
                    <?php elseif(request()->is('admin/register/user/details/*')): ?> active
                    <?php elseif(request()->routeIs('register.user.changePass')): ?> active
                    <?php endif; ?>">
                        <a href="<?php echo e(route('admin.register.user')); ?>">
                            <i class="la flaticon-users"></i>
                            <p><?php echo e(__('Registered Users')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Menu Builder', $permissions))): ?>
                    
                    <li class="nav-item
            <?php if(request()->path() == 'admin/menu-builder'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.menu_builder.index') . '?language=' . $default->code); ?>">
                            <i class="fas fa-bars"></i>
                            <p><?php echo e(__('Menu Builder')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Home Page', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/features'): ?> active
          <?php elseif(request()->path() == 'admin/introsection'): ?> active
          <?php elseif(request()->routeIs('admin.herosection.imgtext')): ?> active
          <?php elseif(request()->is('admin/feature/*/edit')): ?> active
          <?php elseif(request()->is('admin/process')): ?> active
          <?php elseif(request()->is('admin/process/*/edit')): ?> active
          <?php elseif(request()->path() == 'admin/testimonials'): ?> active
          <?php elseif(request()->is('admin/testimonial/*/edit')): ?> active
          <?php elseif(request()->path() == 'admin/menu/section'): ?> active
          <?php elseif(request()->path() == 'admin/special/section'): ?> active
          <?php elseif(request()->path() == 'admin/herosection/video'): ?> active
          <?php elseif(request()->path() == 'admin/home-page-text-section'): ?> active
          <?php elseif(request()->path() == 'admin/partners'): ?> active
          <?php elseif(request()->is('admin/partner/*/edit')): ?> active
          <?php elseif(request()->path() == 'admin/sections'): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#home">
                            <i class="la flaticon-home"></i>
                            <p><?php echo e(__('Home Page')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/features'): ?> show
            <?php elseif(request()->path() == 'admin/introsection'): ?> show
            <?php elseif(request()->routeIs('admin.herosection.imgtext')): ?> show
            <?php elseif(request()->is('admin/feature/*/edit')): ?> show
            <?php elseif(request()->is('admin/process')): ?> show
            <?php elseif(request()->is('admin/process/*/edit')): ?> show
            <?php elseif(request()->path() == 'admin/testimonials'): ?> show
            <?php elseif(request()->is('admin/testimonial/*/edit')): ?> show
            <?php elseif(request()->path() == 'admin/special/section'): ?> show
            <?php elseif(request()->path() == 'admin/home-page-text-section'): ?> show
            <?php elseif(request()->path() == 'admin/partners'): ?> show
            <?php elseif(request()->is('admin/partner/*/edit')): ?> show
            <?php elseif(request()->path() == 'admin/sections'): ?> show
            <?php endif; ?>" id="home">
                            <ul class="nav nav-collapse">

                                <li class="<?php if(request()->routeIs('admin.herosection.imgtext')): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.herosection.imgtext') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Hero Section')); ?></span>
                                    </a>
                                </li>

                                <li class="<?php if(request()->path() == 'admin/introsection'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.introsection.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Intro Section')); ?></span>
                                    </a>
                                </li>

                                <li class="
                <?php if(request()->path() == 'admin/features'): ?> active
                <?php elseif(request()->is('admin/feature/*/edit')): ?> active
                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.feature.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Features')); ?></span>
                                    </a>
                                </li>

                                <li class="
                <?php if(request()->path() == 'admin/process'): ?> active
                <?php elseif(request()->is('admin/process/*/edit')): ?> active
                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.process.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Work Process')); ?></span>
                                    </a>
                                </li>

                                <li class="
                <?php if(request()->path() == 'admin/testimonials'): ?> active
                <?php elseif(request()->is('admin/testimonial/*/edit')): ?> active
                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.testimonial.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Testimonials')); ?></span>
                                    </a>
                                </li>
                                <li class="
                <?php if(request()->path() == 'admin/partners'): ?> active
                <?php elseif(request()->is('admin/partner/*/edit')): ?> active
                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.partner.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Partners')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/home-page-text-section'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.home.page.text.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Section Titles')); ?></span>
                                    </a>
                                </li>
                                <li class="
                                <?php if(request()->path() == 'admin/sections'): ?> active
                                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.sections.index')); ?>">
                                        <span class="sub-item"><?php echo e(__('Section Hide / Show')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Footer', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/footers'): ?> active
          <?php elseif(request()->path() == 'admin/ulinks'): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#footer">
                            <i class="fas fa-shoe-prints"></i>
                            <p><?php echo e(__('Footer')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/footers'): ?> show
            <?php elseif(request()->path() == 'admin/ulinks'): ?> show
            <?php endif; ?>" id="footer">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/footers'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.footer.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Image & Text')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/ulinks'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.ulink.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Useful Links')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>



                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Pages', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/page/create'): ?> active
          <?php elseif(request()->path() == 'admin/pages'): ?> active
          <?php elseif(request()->is('admin/page/*/edit')): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#pages">
                            <i class="la flaticon-file"></i>
                            <p><?php echo e(__('Pages')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/page/create'): ?> show
            <?php elseif(request()->path() == 'admin/pages'): ?> show
            <?php elseif(request()->is('admin/page/*/edit')): ?> show
            <?php endif; ?>" id="pages">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/page/create'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.page.create')); ?>">
                                        <span class="sub-item"><?php echo e(__('Create Page')); ?></span>
                                    </a>
                                </li>
                                <li class="
                <?php if(request()->path() == 'admin/pages'): ?> active
                <?php elseif(request()->is('admin/page/*/edit')): ?> active
                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.page.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Pages')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Blogs', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/bcategorys'): ?> active
          <?php elseif(request()->path() == 'admin/blogs'): ?> active
          <?php elseif(request()->is('admin/blog/*/edit')): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#blog">
                            <i class="fas fa-blog"></i>
                            <p>Blog</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/bcategorys'): ?> show
            <?php elseif(request()->path() == 'admin/blogs'): ?> show
            <?php elseif(request()->is('admin/blog/*/edit')): ?> show
            <?php endif; ?>" id="blog">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/bcategorys'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.bcategory.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Category')); ?></span>
                                    </a>
                                </li>
                                <li class="
                <?php if(request()->path() == 'admin/blogs'): ?> active
                <?php elseif(request()->is('admin/blog/*/edit')): ?> active
                <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.blog.index') . '?language=' . $default->code); ?>">
                                        <span class="sub-item">Blog</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('FAQ Management', $permissions))): ?>
                    
                    <li class="nav-item
           <?php if(request()->path() == 'admin/faqs'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.faq.index') . '?language=' . $default->code); ?>">
                            <i class="la flaticon-round"></i>
                            <p><?php echo e(__('FAQ Management')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Contact Page', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/contact'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.contact.index') . '?language=' . $default->code); ?>">
                            <i class="la flaticon-whatsapp"></i>
                            <p><?php echo e(__('Contact Page')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>


                
                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Announcement Popup', $permissions))): ?>
                <li class="nav-item
                    <?php if(request()->path() == 'admin/popup/create'): ?> active
                    <?php elseif(request()->path() == 'admin/popup/types'): ?> active
                    <?php elseif(request()->is('admin/popup/*/edit')): ?> active
                    <?php elseif(request()->path() == 'admin/popups'): ?> active
                    <?php endif; ?>">
                    <a data-toggle="collapse" href="#announcementPopup">
                        <i class="fas fa-bullhorn"></i>
                        <p><?php echo e(__('Announcement Popup')); ?></p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse
                        <?php if(request()->path() == 'admin/popup/create'): ?> show
                        <?php elseif(request()->path() == 'admin/popup/types'): ?> show
                        <?php elseif(request()->path() == 'admin/popups'): ?> show
                        <?php elseif(request()->is('admin/popup/*/edit')): ?> show
                        <?php endif; ?>" id="announcementPopup">
                        <ul class="nav nav-collapse">
                            <li class="<?php if(request()->path() == 'admin/popup/types'): ?> active
                                <?php elseif(request()->path() == 'admin/popup/create'): ?> active
                                <?php endif; ?>">
                                <a href="<?php echo e(route('admin.popup.types')); ?>">
                                <span class="sub-item"><?php echo e(__('Add Popup')); ?></span>
                                </a>
                            </li>
                            <li class="<?php if(request()->path() == 'admin/popups'): ?> active
                                <?php elseif(request()->is('admin/popup/*/edit')): ?> active
                                <?php endif; ?>">
                                <a href="<?php echo e(route('admin.popup.index') . '?language=' . $default->code); ?>">
                                <span class="sub-item"><?php echo e(__('Popups')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Subscribers', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/subscribers'): ?> active
          <?php elseif(request()->path() == 'admin/mailsubscriber'): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#subscribers">
                            <i class="la flaticon-envelope"></i>
                            <p><?php echo e(__('Subscribers')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/subscribers'): ?> show
            <?php elseif(request()->path() == 'admin/mailsubscriber'): ?> show
            <?php endif; ?>" id="subscribers">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/subscribers'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.subscriber.index')); ?>">
                                        <span class="sub-item"><?php echo e(__('Subscribers')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/mailsubscriber'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.mailsubscriber')); ?>">
                                        <span class="sub-item"><?php echo e(__('Mail to Subscribers')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Payment Gateways', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/gateways'): ?> active
          <?php elseif(request()->path() == 'admin/offline/gateways'): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#gateways">
                            <i class="la flaticon-paypal"></i>
                            <p><?php echo e(__('Payment Gateways')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/gateways'): ?> show
            <?php elseif(request()->path() == 'admin/offline/gateways'): ?> show
            <?php endif; ?>" id="gateways">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/gateways'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.gateway.index')); ?>">
                                        <span class="sub-item"><?php echo e(__('Online Gateways')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/offline/gateways'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.gateway.offline') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Offline Gateways')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                <?php endif; ?>



                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Settings', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/favicon'): ?> active
          <?php elseif(request()->path() == 'admin/logo'): ?> active
          <?php elseif(request()->path() == 'admin/preloader'): ?> active
          <?php elseif(request()->path() == 'admin/basicinfo'): ?> active
          <?php elseif(request()->path() == 'admin/social'): ?> active
          <?php elseif(request()->is('admin/social/*')): ?> active
          <?php elseif(request()->path() == 'admin/breadcrumb'): ?> active
          <?php elseif(request()->path() == 'admin/heading'): ?> active
          <?php elseif(request()->path() == 'admin/script'): ?> active
          <?php elseif(request()->path() == 'admin/seo'): ?> active
          <?php elseif(request()->path() == 'admin/maintainance'): ?> active
          <?php elseif(request()->path() == 'admin/cookie-alert'): ?> active
          <?php elseif(request()->path() == 'admin/mail-from-admin'): ?> active
          <?php elseif(request()->path() == 'admin/mail-to-admin'): ?> active
          <?php elseif(request()->path() == 'admin/email-templates'): ?> active
          <?php elseif(request()->routeIs('admin.product.tags')): ?> active
          <?php elseif(request()->routeIs('admin.email.edit_mail_template')): ?> show
          <?php elseif(request()->routeIs('admin.mail_templates')): ?> show
          <?php elseif(request()->path() == 'admin/seo'): ?> active
          <?php endif; ?>">
                        <a data-toggle="collapse" href="#basic">
                            <i class="la flaticon-settings"></i>
                            <p><?php echo e(__('Settings')); ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
            <?php if(request()->path() == 'admin/favicon'): ?> show
            <?php elseif(request()->path() == 'admin/logo'): ?> show
            <?php elseif(request()->path() == 'admin/preloader'): ?> show
            <?php elseif(request()->path() == 'admin/basicinfo'): ?> show
            <?php elseif(request()->path() == 'admin/social'): ?> show
            <?php elseif(request()->is('admin/social/*')): ?> show
            <?php elseif(request()->path() == 'admin/breadcrumb'): ?> show
            <?php elseif(request()->path() == 'admin/heading'): ?> show
            <?php elseif(request()->path() == 'admin/script'): ?> show
            <?php elseif(request()->path() == 'admin/seo'): ?> show
            <?php elseif(request()->path() == 'admin/maintainance'): ?> show
            <?php elseif(request()->path() == 'admin/cookie-alert'): ?> show
            <?php elseif(request()->path() == 'admin/mail-from-admin'): ?> show
            <?php elseif(request()->path() == 'admin/mail-to-admin'): ?> show
            <?php elseif(request()->path() == 'admin/email-templates'): ?> show
            <?php elseif(request()->routeIs('admin.product.tags')): ?> show
            <?php elseif(request()->routeIs('admin.email.edit_mail_template')): ?> show
            <?php elseif(request()->routeIs('admin.mail_templates')): ?> show
            <?php elseif(request()->path() == 'admin/seo'): ?> show
            <?php endif; ?>" id="basic">
                            <ul class="nav nav-collapse">
                                <li class="<?php if(request()->path() == 'admin/favicon'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.favicon')); ?>">
                                        <span class="sub-item"><?php echo e(__('Favicon')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/logo'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.logo')); ?>">
                                        <span class="sub-item"><?php echo e(__('Logo')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/basicinfo'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.basicinfo')); ?>">
                                        <span class="sub-item"><?php echo e(__('General Settings')); ?></span>
                                    </a>
                                </li>

                                <li class="submenu
                                <?php if(request()->routeIs('admin.mail_from_admin')): ?> selected
                                <?php elseif(request()->routeIs('admin.mail_to_admin')): ?> selected
                                <?php elseif(request()->routeIs('admin.mail_templates')): ?> selected
                                <?php elseif(request()->routeIs('admin.edit_mail_template')): ?> selected
                                <?php endif; ?>">
                                    <a data-toggle="collapse" href="#emailset"
                                       aria-expanded="<?php echo e((request()->path() == 'admin/mail-from-admin' || request()->path() == 'admin/mail-to-admin' || request()->routeIs('admin.mail_templates') || request()->routeIs('admin.edit_mail_template')) ? 'true' : 'false'); ?>">
                                        <span class="sub-item"><?php echo e(__('Email Settings')); ?></span>
                                        <span class="caret"></span>
                                    </a>
                                    <div
                                        class="collapse <?php echo e((request()->path() == 'admin/mail-from-admin' || request()->path() == 'admin/mail-to-admin' || request()->routeIs('admin.mail_templates') || request()->routeIs('admin.edit_mail_template')) ? 'show' : ''); ?>"
                                        id="emailset">
                                        <ul class="nav nav-collapse subnav">
                                            <li class="<?php if(request()->path() == 'admin/mail-from-admin'): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(route('admin.mailFromAdmin')); ?>">
                                                    <span class="sub-item"><?php echo e(__('Mail from Admin')); ?></span>
                                                </a>
                                            </li>
                                            <li class="<?php if(request()->path() == 'admin/mail-to-admin'): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(route('admin.mailToAdmin')); ?>">
                                                    <span class="sub-item"><?php echo e(__('Mail to Admin')); ?></span>
                                                </a>
                                            </li>
                                            <li class="
                                            <?php if(request()->routeIs('admin.mail_templates')): ?> active
                                            <?php elseif(request()->routeIs('admin.edit_mail_template')): ?> active
                                            <?php endif; ?>"
                                            >
                                                <a href="<?php echo e(route('admin.mail_templates')); ?>">
                                                    <span class="sub-item"><?php echo e(__('Mail Templates')); ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/preloader'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.preloader')); ?>">
                                    <span class="sub-item"><?php echo e(__('Preloader')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/breadcrumb'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.breadcrumb')); ?>">
                                        <span class="sub-item"><?php echo e(__('Breadcrumb')); ?></span>
                                    </a>
                                </li>

                                <li class="<?php if(request()->path() == 'admin/social'): ?> active
                                <?php elseif(request()->is('admin/social/*')): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.social.index')); ?>">
                                        <span class="sub-item"><?php echo e(__('Social Links')); ?></span>
                                    </a>
                                </li>

                                <li class="<?php if(request()->path() == 'admin/script'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.script')); ?>">
                                        <span class="sub-item"><?php echo e(__('Plugins')); ?></span>
                                    </a>
                                </li>

                                <li class="<?php if(request()->path() == 'admin/maintainance'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.maintainance')); ?>">
                                        <span class="sub-item"><?php echo e(__('Maintainance Mode')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/cookie-alert'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.cookie.alert') . '?language=' . $default->code); ?>">
                                        <span class="sub-item"><?php echo e(__('Cookie Alert')); ?></span>
                                    </a>
                                </li>
                                <li class="<?php if(request()->path() == 'admin/seo'): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.seo', ['language' => $default->code])); ?>">
                                    <span class="sub-item"><?php echo e(__('SEO Information')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Language Management', $permissions))): ?>
                    
                    <li class="nav-item
         <?php if(request()->path() == 'admin/languages'): ?> active
         <?php elseif(request()->is('admin/language/*/edit')): ?> active
         <?php elseif(request()->is('admin/language/*/edit/keyword')): ?> active
         <?php endif; ?>">
                        <a href="<?php echo e(route('admin.language.index')); ?>">
                            <i class="la flaticon-chat-8"></i>
                            <p><?php echo e(__('Language Management')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Role Management', $permissions))): ?>
                    
                    <li class="nav-item
          <?php if(request()->path() == 'admin/roles'): ?> active
          <?php elseif(request()->is('admin/role/*/permissions/manage')): ?> active
          <?php endif; ?>">
                        <a href="<?php echo e(route('admin.role.index')); ?>">
                            <i class="la flaticon-multimedia-2"></i>
                            <p><?php echo e(__('Role Management')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>



                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Admins Management', $permissions))): ?>
                    
                    <li class="nav-item
           <?php if(request()->path() == 'admin/users'): ?> active
           <?php elseif(request()->is('admin/user/*/edit')): ?> active
           <?php endif; ?>">
                        <a href="<?php echo e(route('admin.user.index')); ?>">
                            <i class="la flaticon-user-5"></i>
                            <p><?php echo e(__('Admins Management')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(empty($admin->role) || (!empty($permissions) && in_array('Sitemap', $permissions))): ?>
                    
                    <li class="nav-item
            <?php if(request()->path() == 'admin/sitemap'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.sitemap.index') . '?language=' . $default->code); ?>">
                            <i class="fa fa-sitemap"></i>
                            <p><?php echo e(__('Sitemap')); ?></p>
                        </a>
                    </li>
                <?php endif; ?>


                
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.cache.clear')); ?>">
                        <i class="la flaticon-close"></i>
                        <p><?php echo e(__('Clear Cache')); ?></p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\coursemat\resources\views/admin/partials/side-navbar.blade.php ENDPATH**/ ?>