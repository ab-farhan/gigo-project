<?php
    use App\Models\Language;
    $setLang = Language::where('code', request()->input('language'))->first();
?>
<?php if(!empty($setLang->language) && $setLang->language->rtl == 1): ?>
    <?php $__env->startSection('styles'); ?>
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    <?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h4 class="page-title"><?php echo e(__('Edit package')); ?></h4>
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
                <a href="#"><?php echo e(__('Packages')); ?></a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?php echo e(__('Edit')); ?></a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block"><?php echo e(__('Edit package')); ?></div>
                    <a class="btn btn-info btn-sm float-right d-inline-block" href="<?php echo e(route('admin.package.index')); ?>">
                        <span class="btn-label">
                            <i class="fas fa-backward"></i>
                        </span>
                        <?php echo e(__('Back')); ?>

                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form id="ajaxForm" class="" action="<?php echo e(route('admin.package.update')); ?>" method="post"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">
                                <div class="form-group">
                                    <label for="title"><?php echo e(__('Package title')); ?>*</label>
                                    <input id="title" type="text" class="form-control" name="title"
                                        value="<?php echo e($package->title); ?>" placeholder="<?php echo e(__('Enter name')); ?>">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="price"><?php echo e(__('Price')); ?> (<?php echo e($bex->base_currency_text); ?>)*</label>
                                    <input id="price" type="number" class="form-control" name="price"
                                        placeholder="<?php echo e(__('Enter Package price')); ?>" value="<?php echo e($package->price); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('If price is 0 , than it will appear as free')); ?></small>
                                    </p>
                                    <p id="errprice" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="plan_term"><?php echo e(__('Package term')); ?>*</label>
                                    <select id="plan_term" name="term" class="form-control">
                                        <option value="" selected disabled><?php echo e(__('Select a Term')); ?></option>
                                        <option value="monthly" <?php echo e($package->term == 'monthly' ? 'selected' : ''); ?>>
                                            <?php echo e(__('monthly')); ?></option>
                                        <option value="yearly" <?php echo e($package->term == 'yearly' ? 'selected' : ''); ?>>
                                            <?php echo e(__('yearly')); ?></option>
                                        <option value="lifetime" <?php echo e($package->term == 'lifetime' ? 'selected' : ''); ?>>
                                            <?php echo e('lifetime'); ?></option>
                                    </select>
                                    <p id="errterm" class="mb-0 text-danger em"></p>
                                </div>
                                <?php
                                    $permissions = $package->features;
                                    if (!empty($package->features)) {
                                        $permissions = json_decode($permissions, true);
                                    }
                                ?>

                                <div class="form-group">
                                    <label class="form-label"><?php echo e(__('Package Features')); ?></label>
                                    <div class="selectgroup selectgroup-pills">
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Domain"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('Custom Domain', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Custom Domain')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Subdomain"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('Subdomain', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Subdomain')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service Form Builder"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('Service Form Builder', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Service Form Builder')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" id="shopManagement" name="features[]"
                                                value="Shop Management" class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Shop Management', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Shop Management')); ?></span>
                                        </label>
                                        
                                        

                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Page"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('Custom Page', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Custom Page')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Contact Form"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('Contact Form', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Contact Form')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Support Tickets"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('Support Tickets', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Support Tickets')); ?></span>
                                        </label>

                                        <label class="selectgroup-item" id="vCard">
                                            <input type="checkbox" name="features[]" value="vCard"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('vCard', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('vCard')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="QR Builder"
                                                class="selectgroup-input" <?php if(is_array($permissions) && in_array('QR Builder', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('QR Builder')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom CSS"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Custom CSS', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Custom CSS')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Analytics"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Google Analytics', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Google Analytics')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Facebook Pixel"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Facebook Pixel', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Facebook Pixel')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Disqus"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Disqus', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Disqus')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Recaptcha"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Google Recaptcha', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Google Recaptcha')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Whatsapp"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Whatsapp', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Whatsapp')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Login"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Google Login', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Google Login')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Facebook Login"
                                                class="selectgroup-input"
                                                <?php if(is_array($permissions) && in_array('Facebook Login', $permissions)): ?> checked <?php endif; ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Facebook Login')); ?></span>
                                        </label>

                                        
                                        
                                        
                                        
                                        

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="service_categories"><?php echo e(__('Number Of Service Categories')); ?>*</label>
                                    <input id="service_categories" type="number" class="form-control"
                                        name="service_categories" placeholder="<?php echo e(__('Enter Service Categories')); ?>"
                                        value="<?php echo e($package->service_categories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errservice_categories" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label
                                        for="service_subcategories "><?php echo e(__('Number Of Service Subcategories')); ?>*</label>
                                    <input id="service_subcategories " type="number" class="form-control"
                                        name="service_subcategories "
                                        placeholder="<?php echo e(__('Enter Service Subcategories ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errservice_subcategories" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="services "><?php echo e(__('Number Of Services ')); ?>*</label>
                                    <input id="services " type="number" class="form-control" name="services "
                                        placeholder="<?php echo e(__('Enter Services   ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errservices" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="service_orders "><?php echo e(__('Number Of Service Orders ')); ?>*</label>
                                    <input id="service_orders " type="number" class="form-control"
                                        name="service_orders " placeholder="<?php echo e(__('Enter Service Orders   ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errservice_orders" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="invoices "><?php echo e(__('Number Of Invoices ')); ?>*</label>
                                    <input id="invoices " type="number" class="form-control" name="invoices "
                                        placeholder="<?php echo e(__('Enter Invoices')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errinvoices" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="users "><?php echo e(__('Number Of Users ')); ?>*</label>
                                    <input id="users " type="number" class="form-control" name="users "
                                        placeholder="<?php echo e(__('Enter Users')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errusers" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group" id="products_input">
                                    <label for="products "><?php echo e(__('Number Of Products')); ?>*</label>
                                    <input id="products " type="number" class="form-control" name="products"
                                        placeholder="<?php echo e(__('Enter Products')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errproducts" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group" id="product_orders_input">
                                    <label for="product_orders "><?php echo e(__('Number Of Product Orders ')); ?>*</label>
                                    <input id="product_orders " type="number" class="form-control"
                                        name="product_orders " placeholder="<?php echo e(__('Enter Product Orders   ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errproduct_orders" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="posts"><?php echo e(__('Number Of Posts  ')); ?>*</label>
                                    <input id="posts" type="number" class="form-control" name="posts"
                                        placeholder="<?php echo e(__('Enter Posts    ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errposts" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group" id="vCard_input">
                                    <label for="vCards "><?php echo e(__('Number Of vCards')); ?>*</label>
                                    <input id="vCards " type="number" class="form-control" name="vCards "
                                        placeholder="<?php echo e(__('Enter vCards     ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errvCards " class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="languages"><?php echo e(__('Number Of Languages   ')); ?>*</label>
                                    <input id="languages" type="number" class="form-control" name="languages "
                                        placeholder="<?php echo e(__('Enter Languages     ')); ?>"
                                        value="<?php echo e($package->service_subcategories); ?>">
                                    <p class="text-warning">
                                        <small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small>
                                    </p>
                                    <p id="errlanguages" class="mb-0 text-danger em"></p>
                                </div>
                                

                                <div class="form-group">
                                    <label class="form-label"><?php echo e(__('Featured')); ?> *</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="featured" value="1"
                                                class="selectgroup-input" <?php echo e($package->featured == 1 ? 'checked' : ''); ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Yes')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="featured" value="0"
                                                class="selectgroup-input" <?php echo e($package->featured == 0 ? 'checked' : ''); ?>>
                                            <span class="selectgroup-button"><?php echo e(__('No')); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label"><?php echo e(__('Trial')); ?> *</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_trial" value="1"
                                                class="selectgroup-input" <?php echo e($package->is_trial == 1 ? 'checked' : ''); ?>>
                                            <span class="selectgroup-button"><?php echo e(__('Yes')); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_trial" value="0"
                                                class="selectgroup-input" <?php echo e($package->is_trial == 0 ? 'checked' : ''); ?>>
                                            <span class="selectgroup-button"><?php echo e(__('No')); ?></span>
                                        </label>
                                    </div>
                                </div>


                                <?php if($package->is_trial == 1): ?>
                                    <div class="form-group dis-block" id="trial_day">
                                        <label for="trial_days_2"><?php echo e(__('Trial days')); ?>*</label>
                                        <input id="trial_days_2" type="number" class="form-control" name="trial_days"
                                            placeholder="<?php echo e(__('Enter trial days')); ?>"
                                            value="<?php echo e($package->trial_days); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="form-group dis-none" id="trial_day">
                                        <label for="trial_days_1"><?php echo e(__('Trial days')); ?>*</label>
                                        <input id="trial_days_1" type="number" class="form-control" name="trial_days"
                                            placeholder="<?php echo e(__('Enter trial days')); ?>"
                                            value="<?php echo e($package->trial_days); ?>">
                                    </div>
                                <?php endif; ?>
                                <p id="errtrial_days" class="mb-0 text-danger em"></p>

                                <div class="form-group">
                                    <label class="form-label">Recommended *</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="recommended" value="1"
                                                class="selectgroup-input"<?php echo e($package->recommended == 1 ? 'checked' : ''); ?>>
                                            <span class="selectgroup-button">Yes</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="recommended" value="0"
                                                class="selectgroup-input"
                                                <?php echo e($package->recommended == 0 ? 'checked' : ''); ?>>
                                            <span class="selectgroup-button">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Icon **</label>
                                    <div class="btn-group d-block">
                                        <button type="button" class="btn btn-primary iconpicker-component"><i
                                                class="<?php echo e($package->icon); ?>"></i></button>
                                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                            data-selected="fa-car" data-toggle="dropdown">
                                        </button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input id="inputIcon" type="hidden" name="icon" value="<?php echo e($package->icon); ?>">
                                    <?php if($errors->has('icon')): ?>
                                        <p class="mb-0 text-danger"><?php echo e($errors->first('icon')); ?></p>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <small>NB: click on the dropdown sign to select an icon.</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status"><?php echo e(__('Status')); ?>*</label>
                                    <select id="status" class="form-control ltr" name="status">
                                        <option value="" selected disabled><?php echo e(__('Select a status')); ?></option>
                                        <option value="1" <?php echo e($package->status == '1' ? 'selected' : ''); ?>>
                                            <?php echo e(__('Active')); ?></option>
                                        <option value="0" <?php echo e($package->status == '0' ? 'selected' : ''); ?>>
                                            <?php echo e(__('Deactive')); ?></option>
                                    </select>
                                    <p id="errstatus" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords"><?php echo e(__('Meta Keywords')); ?></label>
                                    <input id="meta_keywords" type="text" class="form-control" name="meta_keywords"
                                        value="<?php echo e($package->meta_keywords); ?>" data-role="tagsinput">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                                    <textarea id="meta_description" type="text" class="form-control" name="meta_description" rows="5"><?php echo e($package->meta_description); ?></textarea>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn"
                                    class="btn btn-success"><?php echo e(__('Update')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        "use strict";
        var permission = <?php echo json_encode($permissions) ?>;
    </script>
    <script src="<?php echo e(asset('assets/admin/js/edit-package.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/packages/edit.blade.php ENDPATH**/ ?>