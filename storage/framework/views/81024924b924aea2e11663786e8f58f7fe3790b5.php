<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h4 class="page-title"><?php echo e(__('Admins')); ?></h4>
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
                <a href="#"><?php echo e(__('Admins Management')); ?></a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?php echo e(__('Admins')); ?></a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block"><?php echo e(__('Admins')); ?></div>
                    <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> <?php echo e(__('Add Admin')); ?></a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(count($users) == 0): ?>
                                <h3 class="text-center"><?php echo e(__('NO USER FOUND')); ?></h3>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"><?php echo e(__('Picture')); ?></th>
                                            <th scope="col"><?php echo e(__('Username')); ?></th>
                                            <th scope="col"><?php echo e(__('Email')); ?></th>
                                            <th scope="col"><?php echo e(__('First Name')); ?></th>
                                            <th scope="col"><?php echo e(__('Last Name')); ?></th>
                                            <th scope="col"><?php echo e(__('Role')); ?></th>
                                            <th scope="col"><?php echo e(__('Status')); ?></th>
                                            <th scope="col"><?php echo e(__('Actions')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($user->id != Auth::guard('admin')->user()->id): ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td>
                                                        <img src="<?php echo e(isset($user->image) ?  asset('assets/admin/img/propics/'.$user->image) : asset('assets/admin/img/noimage.jpg')); ?>" alt="" width="45">
                                                    </td>
                                                    <td><?php echo e($user->username); ?></td>
                                                    <td><?php echo e($user->email); ?></td>
                                                    <td><?php echo e($user->first_name); ?></td>
                                                    <td><?php echo e($user->last_name); ?></td>
                                                    <td>
                                                      <?php echo e($user->role->name); ?>

                                                    </td>
                                                    <td>
                                                        <?php if($user->status == 1): ?>
                                                            <span class="badge badge-success"><?php echo e(__('Active')); ?></span>
                                                        <?php elseif($user->status == 0): ?>
                                                            <span class="badge badge-danger"><?php echo e(__('Deactive')); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm" href="<?php echo e(route('admin.user.edit', $user->id)); ?>">
                                <span class="btn-label">
                                  <i class="fas fa-edit"></i>
                                </span>
                                                            <?php echo e(__('Edit')); ?>

                                                        </a>
                                                        <form class="deleteform d-inline-block" action="<?php echo e(route('admin.user.delete')); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                                <span class="btn-label">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                <?php echo e(__('Delete')); ?>

                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
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


    <!-- Create Users Modal -->
    <?php if ($__env->exists('admin.user.create')) echo $__env->make('admin.user.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/user/index.blade.php ENDPATH**/ ?>