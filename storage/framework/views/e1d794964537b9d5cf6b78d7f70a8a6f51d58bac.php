<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h4 class="page-title">Coupons</h4>
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
                <a href="#">Packages</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Coupons</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-title d-inline-block">Coupons</div>
                        </div>
                        <div class="col-lg-4 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(count($coupons) == 0): ?>
                                <h3 class="text-center">NO COUPON FOUND</h3>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Discount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Created</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($coupon->name); ?></td>
                                                    <td><?php echo e($coupon->code); ?></td>
                                                    <td><?php echo e($coupon->type == 'fixed' && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''); ?><?php echo e($coupon->value); ?><?php echo e($coupon->type == 'percentage' ? '%' : ''); ?><?php echo e($coupon->type == 'fixed' && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''); ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                            $end = Carbon\Carbon::parse($coupon->end_date);
                                                            $start = Carbon\Carbon::parse($coupon->start_date);
                                                            $now = Carbon\Carbon::now();
                                                            $diff = $end->diffInDays($now);
                                                        ?>
                                                        <?php if($start->greaterThan($now)): ?>
                                                            <h3 class="d-inline-block badge badge-warning">Pending</h3>
                                                        <?php else: ?>
                                                            <?php if($now->lessThan($end)): ?>
                                                                <h3 class="d-inline-block badge badge-success">Active</h3>
                                                            <?php else: ?>
                                                                <h3 class="d-inline-block badge badge-danger">Expired</h3>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $created = Carbon\Carbon::parse($coupon->created_at);
                                                            $diff = $created->diffInDays($now);
                                                        ?>
                                                        <?php echo e($created->subDays($diff)->diffForHumans()); ?>

                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.coupon.edit', $coupon->id)); ?>"
                                                            class="btn btn-warning btn-sm">Edit</a>
                                                        <form class="d-inline-block deleteform"
                                                            action="<?php echo e(route('admin.coupon.delete')); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="coupon_id"
                                                                value="<?php echo e($coupon->id); ?>">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm deletebtn">Delete</button>
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
                <div class="card-footer">
                    <div class="row">
                        <div class="d-inline-block mx-auto">
                            <?php echo e($coupons->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Service Category Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Coupon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="ajaxForm" class="modal-form" action="<?php echo e(route('admin.coupon.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Name **</label>
                                    <input type="text" class="form-control" name="name" value="" placeholder="Enter name">
                                    <p id="errname" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Code **</label>
                                    <input type="text" class="form-control" name="code" value="" placeholder="Enter code">
                                    <p id="errcode" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Type **</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                    <p id="errtype" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Value **</label>
                                    <input type="text" class="form-control" name="value" value=""
                                        placeholder="Enter value" autocomplete="off">
                                    <p id="errvalue" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Start Date **</label>
                                    <input type="text" class="form-control datepicker" name="start_date" value=""
                                        placeholder="Enter start date" autocomplete="off">
                                    <p id="errstart_date" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">End Date **</label>
                                    <input type="text" class="form-control datepicker" name="end_date" value=""
                                        placeholder="Enter end date" autocomplete="off">
                                    <p id="errend_date" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Packages</label>
                                    <select class="select2" name="packages[]" multiple="multiple"
                                        placeholder="Select Packages">
                                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($package->id); ?>">
                                                <?php echo e($package->title); ?> <?php echo e(ucfirst($package->term)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <p class="mb-0 text-warning">This coupon can be applied to these packages</p>
                                    <p class="mb-0 text-warning">Leave this field blank for all packages</p>
                                    <p id="errpackages" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Maximum uses limit **</label>
                                    <input type="number" class="form-control " name="maximum_uses_limit" value=""
                                        placeholder="Enter Maximum uses limit" autocomplete="off">
                                    <p id="errmaximum_uses_limit" class="mb-0 text-danger em"></p>
                                    <p class="mb-0 text-warning">Enter 999999 to make it unlimited</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/packages/coupons/index.blade.php ENDPATH**/ ?>