<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Maintenance Mode')); ?></h4>
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
        <a href="#"><?php echo e(__('Basic Settings')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Maintenance Mode')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title"><?php echo e(__('Update Maintenance Mode')); ?></div>
            </div>
          </div>
        </div>

        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="maintenanceForm" action="<?php echo e(route('admin.maintainance.update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <div class="col-12 mb-2">
                        <label for="image"><strong><?php echo e(__('Maintainance Image')); ?> **</strong></label>
                      </div>
                      <div class="col-md-12 showImage mb-3">
                        <img src="<?php echo e(asset('assets/front/img/'. $bs->maintenance_img)); ?>" alt="..." class="img-thumbnail">
                      </div>
                      <input type="file" name="file" id="image" class="form-control">
                      <p id="errfile" class="mb-0 text-danger em"></p>
                      <p class="text-warning mb-0"><?php echo e(__('Upload 770 X 720 image for best quality')); ?></p>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label><?php echo e(__('Maintenance Status*')); ?></label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input
                        type="radio"
                        name="maintenance_status"
                        value="1"
                        class="selectgroup-input"
                        <?php echo e($data->maintenance_status == 1 ? 'checked' : ''); ?>

                      >
                      <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                    </label>
                    <label class="selectgroup-item">
                      <input
                        type="radio"
                        name="maintenance_status"
                        value="0"
                        class="selectgroup-input"
                        <?php echo e($data->maintenance_status == 0 ? 'checked' : ''); ?>

                      >
                      <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                    </label>
                  </div>
                  <?php if($errors->has('maintenance_status')): ?>
                    <p class="mt-2 mb-0 text-danger"><?php echo e($errors->first('maintenance_status')); ?></p>
                  <?php endif; ?>
                </div>

                <div class="form-group">
                  <label><?php echo e(__('Maintenance Message*')); ?></label>
                  <textarea
                    class="form-control"
                    name="maintainance_text"
                    rows="3"
                    cols="80"
                  ><?php echo e($data->maintainance_text); ?></textarea>
                  <?php if($errors->has('maintainance_text')): ?>
                    <p class="mt-2 mb-0 text-danger"><?php echo e($errors->first('maintainance_text')); ?></p>
                  <?php endif; ?>
                </div>

                <div class="form-group">
                  <label>Secret Path</label>
                  <input name="secret_path" type="text" class="form-control" value="<?php echo e($data->secret_path); ?>">
                  <p class="text-warning"><?php echo e(__('After activating maintenance mode, You can access the website via')); ?> <strong class="text-danger"><?php echo e(url('{secret_path}')); ?></strong></p>
                  <p class="text-warning"><?php echo e(__('Try to avoid using special characters')); ?></p>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" form="maintenanceForm" class="btn btn-success">
                <?php echo e(__('Update')); ?>

              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/basic/maintainance.blade.php ENDPATH**/ ?>