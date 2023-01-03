<?php
    use App\Models\Language;
    $setLang = Language::where('code', request()->input('language'))->first();
?>
<?php if(!empty($setLang) && $setLang->rtl == 1): ?>
<?php $__env->startSection('styles'); ?>
    <style>
        form:not(.modal-form) input,
        form:not(.modal-form) textarea,
        form:not(.modal-form) select,
        select[name='language'] {
            direction: rtl;
        }

        form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
            direction: rtl;
            text-align: right;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h4 class="page-title"><?php echo e(__('Packages')); ?></h4>
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
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block"><?php echo e(__('Package Page')); ?></div>
                        </div>
                        <div class="col-lg-4 offset-lg-4 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                               data-target="#createModal"><i class="fas fa-plus"></i>
                                <?php echo e(__('Add Package')); ?></a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                    data-href="<?php echo e(route('admin.package.bulk.delete')); ?>"><i
                                    class="flaticon-interface-5"></i>
                                <?php echo e(__('Delete')); ?>

                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(count($packages) == 0): ?>
                                <h3 class="text-center"><?php echo e(__('NO PACKAGE FOUND YET')); ?></h3>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col"><?php echo e(__('Title')); ?></th>
                                            <th scope="col"><?php echo e(__('Cost')); ?></th>
                                            <th scope="col"><?php echo e(__('Status')); ?></th>
                                            <th scope="col"><?php echo e(__('Actions')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check"
                                                           data-val="<?php echo e($package->id); ?>">
                                                </td>
                                                <td>
                                                    <?php echo e(strlen($package->title) > 30 ? mb_substr($package->title, 0, 30, 'UTF-8') . '...' : $package->title); ?>

                                                    <span class="badge badge-primary"><?php echo e($package->term); ?></span>
                                                </td>
                                                <td>
                                                    <?php if($package->price == 0): ?>
                                                        <?php echo e(__('Free')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(format_price($package->price)); ?>

                                                    <?php endif; ?>

                                                </td>
                                                <td>
                                                    <?php if($package->status == 1): ?>
                                                        <h2 class="d-inline-block">
                                                            <span class="badge badge-success"><?php echo e(__('Active')); ?></span>
                                                        </h2>
                                                    <?php else: ?>
                                                        <h2 class="d-inline-block">
                                                            <span class="badge badge-danger"><?php echo e(__('Deactive')); ?></span>
                                                        </h2>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm"
                                                       href="<?php echo e(route('admin.package.edit', $package->id) . '?language=' . request()->input('language')); ?>">
                                                           <span class="btn-label">
                                                             <i class="fas fa-edit"></i>
                                                           </span>
                                                           <?php echo e(__('Edit')); ?>

                                                    </a>
                                                    <form class="deleteform d-inline-block"
                                                          action="<?php echo e(route('admin.package.delete')); ?>" method="post">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                            <span class="btn-label">
                                                            <i class="fas fa-trash"></i>
                                                            </span>
                                                            <?php echo e(__('Delete')); ?>

                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Blog Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Package')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="ajaxForm" enctype="multipart/form-data" class="modal-form"
                          action="<?php echo e(route('admin.package.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="title"><?php echo e(__('Package title')); ?>*</label>
                            <input id="title" type="text" class="form-control" name="title"
                                   placeholder="<?php echo e(__('Enter Package title')); ?>" value="">
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="price"><?php echo e(__('Price')); ?> (<?php echo e($bex->base_currency_text); ?>)*</label>
                            <input id="price" type="number" class="form-control" name="price"
                                   placeholder="<?php echo e(__('Enter Package price')); ?>" value="">
                            <p class="text-warning"><small><?php echo e(__('If price is 0 , than it will appear as free')); ?></small></p>
                            <p id="errprice" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="term"><?php echo e(__('Package term')); ?>*</label>
                            <select id="term" name="term" class="form-control" required>
                                <option value="" selected disabled><?php echo e(__('Choose a Package term')); ?></option>
                                <option value="monthly"><?php echo e(__('monthly')); ?></option>
                                <option value="yearly"><?php echo e(__('yearly')); ?></option>
                                <option value="lifetime"><?php echo e(__('lifetime')); ?></option>
                            </select>
                            <p id="errterm" class="mb-0 text-danger em"></p>
                        </div>


                        <div class="form-group">
                            <label class="form-label"><?php echo e(__('Package Features')); ?></label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Custom Domain" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Custom Domain')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Subdomain" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Subdomain')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Amazon AWS s3" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Amazon AWS s3')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Storage Limit" class="selectgroup-input" id="storage">
                                    <span class="selectgroup-button"><?php echo e(__('Storage Limit')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="vCard" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('vCard')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="QR Builder" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('QR Builder')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Follow/Unfollow" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Follow/Unfollow')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Course Completion Certificate" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Course Completion Certificate')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Coupon" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Coupon')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Blog" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Blog')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Advertisement" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Advertisement')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="features[]" value="Custom Page" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Custom Page')); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="storage_input">
                            <label for="storage_limit"><?php echo e(__('Storage Limit')); ?>*</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="storage_limit"
                                       placeholder="<?php echo e(__('Enter Storage Limit')); ?>" value="">
                                <span class="input-group-text" id="basic-addon2">MB</span>
                                <p id="errstorage_limit" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="course_categories"><?php echo e(__('Number Of Course Categories Limit')); ?>*</label>
                            <input id="course_categories" type="number" class="form-control" name="course_categories_limit"
                                   placeholder="<?php echo e(__('Enter course categories limit')); ?>" value="">
                            <p class="text-warning"><small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small></p>
                            <p id="errcourse_categories_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="featured_course"><?php echo e(__('Number Of Featured Course Limit')); ?>*</label>
                            <input id="featured_course" type="number" class="form-control" name="featured_course_limit"
                                   placeholder="<?php echo e(__('Enter course limit')); ?>" value="">
                            <p class="text-warning"><small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small></p>
                            <p id="errfeatured_course_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="courses"><?php echo e(__('Number Of Course Limit')); ?>*</label>
                            <input id="courses" type="number" class="form-control" name="course_limit"
                                   placeholder="<?php echo e(__('Enter course limit')); ?>" value="">
                            <p class="text-warning"><small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small></p>
                            <p id="errcourse_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="modules"><?php echo e(__('Number Of Module Limit')); ?>*</label>
                            <input id="modules" type="number" class="form-control" name="module_limit"
                                   placeholder="<?php echo e(__('Enter module limit')); ?>" value="">
                            <p class="text-warning"><small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small></p>
                            <p id="errmodule_limit" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="lesson"><?php echo e(__('Number Of Lesson Limit')); ?>*</label>
                            <input id="lesson" type="number" class="form-control" name="lesson_limit"
                                   placeholder="<?php echo e(__('Enter lesson limit')); ?>" value="">
                            <p class="text-warning"><small><?php echo e(__('Enter 999999 , than it will appear as unlimited')); ?></small></p>
                            <p id="errlesson_limit" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?php echo e(__('Featured')); ?> *</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="featured" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Yes')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="featured" value="0" class="selectgroup-input" checked>
                                    <span class="selectgroup-button"><?php echo e(__('No')); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Recommended *</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="recommended" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="recommended" value="0" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Icon **</label>
                            <div class="btn-group d-block">
                                <button type="button" class="btn btn-primary iconpicker-component"><i
                                        class="fa fa-fw fa-heart"></i></button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fa-car" data-toggle="dropdown">
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input id="inputIcon" type="hidden" name="icon" value="fas fa-heart">
                            <?php if($errors->has('icon')): ?>
                                <p class="mb-0 text-danger"><?php echo e($errors->first('icon')); ?></p>
                            <?php endif; ?>
                            <div class="mt-2">
                                <small>NB: click on the dropdown sign to select a icon.</small>
                            </div>
                            <p id="erricon" class="mb-0 text-danger em"></p>
                        </div>


                        <div class="form-group">
                            <label class="form-label"><?php echo e(__('Trial')); ?> *</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_trial" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button"><?php echo e(__('Yes')); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_trial" value="0" class="selectgroup-input" checked>
                                    <span class="selectgroup-button"><?php echo e(__('No')); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group dis-none" id="trial_day">
                            <label for="trial_days"><?php echo e(__('Trial days')); ?>*</label>
                            <input id="trial_days" type="number" class="form-control" name="trial_days"
                                   placeholder="<?php echo e(__('Enter trial days')); ?>" value="">
                            <p id="errtrial_days" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="status"><?php echo e(__('Status')); ?>*</label>
                            <select id="status" class="form-control ltr" name="status">
                                <option value="" selected disabled><?php echo e(__('Select a status')); ?></option>
                                <option value="1"><?php echo e(__('Active')); ?></option>
                                <option value="0"><?php echo e(__('Deactive')); ?></option>
                            </select>
                            <p id="errstatus" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for=""><?php echo e(__('Meta Keywords')); ?></label>
                            <input type="text" class="form-control" name="meta_keywords" value="" data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                            <textarea id="meta_description" type="text" class="form-control" name="meta_description" rows="5">
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <button id="submitBtn" type="button" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/admin/js/packages.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>