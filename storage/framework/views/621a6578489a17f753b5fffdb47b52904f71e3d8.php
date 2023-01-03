<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Favicon')); ?></h4>
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
        <a href="#"><?php echo e(__('Favicon')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title"><?php echo e(__('Update Favicon')); ?></div>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form  enctype="multipart/form-data" action="<?php echo e(route('admin.favicon.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <div class="col-12 mb-2">
                        <label for="image"><strong><?php echo e(__('Favicon')); ?> **</strong></label>
                      </div>
                      <div class="col-md-12 showImage mb-3">
                        <img src="<?php echo e($bs->favicon ? asset('assets/front/img/'.$bs->favicon) :  asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                      </div>
                      <input type="file" name="favicon" id="image" class="form-control">
                      <p id="errfavicon" class="mb-0 text-danger em"></p>
                      <p class="text-warning mb-0"><?php echo e(__('Upload 40 X 40 image for best quality')); ?></p>
                    </div>
                  </div>
                </div>

                <div class="card-footer">
                  <div class="form">
                    <div class="form-group from-show-notify row">
                      <div class="col-12 text-center">
                        <button type="submit"  class="btn btn-success"><?php echo e(__('Update')); ?></button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/basic/favicon.blade.php ENDPATH**/ ?>