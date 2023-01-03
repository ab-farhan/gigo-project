<!-- Create Gallery Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Create Admin')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ajaxForm" class="" action="<?php echo e(route('admin.user.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label for="image"><strong><?php echo e(__('Featured Image')); ?> **</strong></label>
                <div class="col-md-12 showImage mb-3">
                  <img src="<?php echo e(asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                </div>
                <input type="file" name="image" id="image" class="form-control image">
                <p id="errimage" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""><?php echo e(__('Username')); ?> **</label>
                <input type="text" class="form-control" name="username" placeholder="<?php echo e(__('Enter username')); ?>" value="">
                <p id="errusername" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""><?php echo e(__('Email')); ?> **</label>
                <input type="text" class="form-control" name="email" placeholder="<?php echo e(__('Enter email')); ?>" value="">
                <p id="erremail" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""><?php echo e(__('First Name')); ?> **</label>
                <input type="text" class="form-control" name="first_name" placeholder="<?php echo e(__('Enter first name')); ?>" value="">
                <p id="errfirst_name" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""><?php echo e(__('Last Name')); ?> **</label>
                <input type="text" class="form-control" name="last_name" placeholder="<?php echo e(__('Enter last name')); ?>" value="">
                <p id="errlast_name" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""><?php echo e(__('Password')); ?> **</label>
                <input type="password" class="form-control" name="password" placeholder="<?php echo e(__('Enter password')); ?>" value="">
                <p id="errpassword" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""><?php echo e(__('Re-type Password')); ?> **</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="<?php echo e(__('Enter your password again')); ?>" value="">
                <p id="errpassword_confirmation" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for=""><?php echo e(__('Role')); ?> **</label>
                <select class="form-control" name="role_id">
                  <option value="" selected disabled><?php echo e(__('Select a Role')); ?></option>
                  <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p id="errrole_id" class="mb-0 text-danger em"></p>
              </div>
            </div>
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
<?php /**PATH D:\laragon\www\gigo\resources\views/admin/user/create.blade.php ENDPATH**/ ?>