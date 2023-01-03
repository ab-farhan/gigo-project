<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title">
        <?php echo e(__('Registered Users')); ?>

    </h4>
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
        <a href="#"><?php echo e(__('Registered Users')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-title">
                        <?php echo e(__('Registered Users')); ?>

                    </div>
                </div>
                <div class="col-lg-6 mt-2 mt-lg-0">
                    <button class="btn btn-danger float-lg-right float-none btn-sm ml-2 mt-1 d-none bulk-delete" data-href="<?php echo e(route('register.user.bulk.delete')); ?>"><i class="flaticon-interface-5"></i> <?php echo e(__('Delete')); ?></button>

                    <button class="btn btn-primary float-lg-right float-none btn-sm ml-2 mt-1" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-plus"></i> <?php echo e(__('Add User')); ?></button>
                    
                    <form action="<?php echo e(url()->full()); ?>" class="float-lg-right float-none">
                        <input type="text" name="term" class="form-control min-w-250" value="<?php echo e(request()->input('term')); ?>" placeholder="Search by Username / Email">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($users) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO USER FOUND')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col"><?php echo e(__('Username')); ?></th>
                        <th scope="col"><?php echo e(__('Email')); ?></th>
                        <th scope="col"><?php echo e(__('Featured')); ?></th>
                        <th scope="col"><?php echo e(__('Preview Template')); ?></th>
                        <th scope="col"><?php echo e(__('Email Status')); ?></th>
                        <th scope="col"><?php echo e(__('Account')); ?></th>
                        <td scope="col"><?php echo e(__('Action')); ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                              <input type="checkbox" class="bulk-check" data-val="<?php echo e($user->id); ?>">
                          </td>
                          <td><?php echo e($user->username); ?></td>
                          <td><?php echo e($user->email); ?></td>

                          <td>
                              <form id="userFrom<?php echo e($user->id); ?>" class="d-inline-block" action="<?php echo e(route('register.user.featured')); ?>" method="post">
                                  <?php echo csrf_field(); ?>
                                  <select class="form-control <?php echo e($user->featured == 1 ? 'bg-success' : 'bg-danger'); ?>"
                                          name="featured" onchange="document.getElementById('userFrom<?php echo e($user->id); ?>').submit();">
                                      <option value="1" <?php echo e($user->featured == 1 ? 'selected' : ''); ?>><?php echo e(__('Yes')); ?></option>
                                      <option value="0" <?php echo e($user->featured == 0 ? 'selected' : ''); ?>><?php echo e(__('No')); ?></option>
                                  </select>
                                  <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                              </form>
                          </td>

                          <td>
                              <div class="d-inline-block">
                                  <select data-user_id="<?php echo e($user->id); ?>"
                                      class="template-select form-control form-control-sm <?php echo e($user->preview_template == 1 ? 'bg-success' : 'bg-danger'); ?>"
                                      name="preview_template">
                                      <option value="1"
                                          <?php echo e($user->preview_template == 1 ? 'selected' : ''); ?>>
                                          <?php echo e(__('Yes')); ?></option>
                                      <option value="0"
                                          <?php echo e($user->preview_template == 0 ? 'selected' : ''); ?>>
                                          <?php echo e(__('No')); ?></option>
                                  </select>
                              </div>
                              <?php if($user->preview_template == 1): ?>
                                  <button type="button" class="btn btn-primary btn-sm"
                                      data-toggle="modal"
                                      data-target="#templateImgModal<?php echo e($user->id); ?>"><?php echo e(__('Edit')); ?></button>
                              <?php endif; ?>
                          </td>

                          <?php if ($__env->exists('admin.register_user.template-modal')) echo $__env->make('admin.register_user.template-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                          <?php if ($__env->exists('admin.register_user.template-image-modal')) echo $__env->make('admin.register_user.template-image-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                          <td>
                          <form id="emailForm<?php echo e($user->id); ?>" class="d-inline-block" action="<?php echo e(route('register.user.email')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <select class="form-control form-control-sm <?php echo e(strtolower($user->email_verified) == 1 ? 'bg-success' : 'bg-danger'); ?>" name="email_verified" onchange="document.getElementById('emailForm<?php echo e($user->id); ?>').submit();">
                                <option value="1" <?php echo e(strtolower($user->email_verified) == 1 ? 'selected' : ''); ?>><?php echo e(__('Verified')); ?></option>
                                <option value="0" <?php echo e(strtolower($user->email_verified) == 0 ? 'selected' : ''); ?>><?php echo e(__('Unverified')); ?></option>
                            </select>
                            <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                            </form>
                          </td>

                          <td>
                          <form id="userFrom<?php echo e($user->id); ?>" class="d-inline-block" action="<?php echo e(route('register.user.ban')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <select class="form-control form-control-sm <?php echo e($user->status == 1 ? 'bg-success' : 'bg-danger'); ?>" name="status" onchange="document.getElementById('userFrom<?php echo e($user->id); ?>').submit();">
                                <option value="1" <?php echo e($user->status == 1 ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
                                <option value="0" <?php echo e($user->status == 0 ? 'selected' : ''); ?>><?php echo e(__('Deactive')); ?></option>
                            </select>
                            <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                            </form>
                          </td>
                          <td>
                            <div class="dropdown">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <?php echo e(__('Actions')); ?>

                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="<?php echo e(route('register.user.view',$user->id)); ?>"><?php echo e(__('Details')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.payment-log.index',['username' => $user->username])); ?>"><?php echo e(__('Payment Log')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('register.user.changePass',$user->id)); ?>"><?php echo e(__('Change Password')); ?></a>
                                    <form class="deleteform d-block" action="<?php echo e(route('register.user.delete')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                        <button type="submit" class="deletebtn">
                                        <?php echo e(__('Delete')); ?>

                                        </button>
                                    </form>
                                </div>
                            </div>
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
              <?php echo e($users->appends(['term' => request()->input('term')])->links()); ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(route('register.user.store')); ?>" method="POST" id="ajaxForm">
          <?php echo csrf_field(); ?>
          <div class="form-group">
            <label for="">Username *</label>
            <input class="form-control" type="text" name="username">
            <p id="errusername" class="text-danger mb-0 em"></p>
          </div>
          <div class="form-group">
            <label for="">Email *</label>
            <input class="form-control" type="email" name="email">
            <p id="erremail" class="text-danger mb-0 em"></p>
          </div>
          <div class="form-group">
            <label for="">Password *</label>
            <input class="form-control" type="password" name="password">
            <p id="errpassword" class="text-danger mb-0 em"></p>
          </div>
          <div class="form-group">
            <label for="">Confirm Password *</label>
            <input class="form-control" type="password" name="password_confirmation">
          </div>
          <div class="form-group">
            <label for="">Package / Plan *</label>
            <select name="package_id" class="form-control">
              <?php if(!empty($packages)): ?>
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($package->id); ?>"><?php echo e($package->title); ?> (<?php echo e($package->term); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
            <p id="errpackage_id" class="text-danger mb-0 em"></p>
          </div>
          <div class="form-group">
            <label for="">Payment Gateway *</label>
            <select name="payment_gateway" class="form-control">
              <?php if(!empty($gateways)): ?>
                <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($gateway->name); ?>"><?php echo e($gateway->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
            <p id="errpayment_gateway" class="text-danger mb-0 em"></p>
          </div>
          <div class="form-group">
            <label for="">Publicly Hidden *</label>
            <select name="online_status" class="form-control">
              <option value="1">No</option>
              <option value="0">Yes</option>
            </select>
            <p id="erronline_status" class="text-danger mb-0 em"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer text-center">
        <button id="submitBtn" type="button" class="btn btn-primary">Add User</button>
      </div>
    </div>
  </div>
</div> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/register_user/index.blade.php ENDPATH**/ ?>