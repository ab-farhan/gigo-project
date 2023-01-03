<?php if(!empty($testimonial->language) && $testimonial->language->rtl == 1): ?>
<?php $__env->startSection('styles'); ?>
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Edit Testimonial')); ?></h4>
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
        <a href="#"><?php echo e(__('Home Page')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Edit Testimonial')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block"><?php echo e(__('Edit Testimonial')); ?></div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="<?php echo e(route('admin.testimonial.index') . '?language=' . request()->input('language')); ?>">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form id="ajaxForm" class="" action="<?php echo e(route('admin.testimonial.update')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <div class="col-12 mb-2">
                        <label for="image"><strong> <?php echo e(__('Image')); ?></strong></label>
                      </div>
                      <div class="col-md-12 showImage mb-3">
                        <img src="<?php echo e($testimonial->image ? asset('assets/front/img/testimonials/'.$testimonial->image) : asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                      </div>
                      <input type="file" name="image" id="image" class="form-control image">
                      <p id="errimage" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="testimonial_id" value="<?php echo e($testimonial->id); ?>">
                <div class="form-group">
                  <label for=""><?php echo e(__('Comment')); ?> **</label>
                  <textarea class="form-control" name="comment" rows="3" cols="80" placeholder="<?php echo e(__('Enter comment')); ?>"><?php echo e($testimonial->comment); ?></textarea>
                  <p id="errcomment" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('Name')); ?> **</label>
                  <input type="text" class="form-control" name="name" value="<?php echo e($testimonial->name); ?>" placeholder="<?php echo e(__('Enter name')); ?>">
                  <p id="errname" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('Rank')); ?> **</label>
                  <input type="text" class="form-control" name="rank" value="<?php echo e($testimonial->rank); ?>" placeholder="<?php echo e(__('Enter rank')); ?>">
                  <p id="errrank" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('Serial Number')); ?> **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="<?php echo e($testimonial->serial_number); ?>" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the testimonial will be shown.')); ?></small></p>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success"><?php echo e(__('Update')); ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/testimonial/edit.blade.php ENDPATH**/ ?>