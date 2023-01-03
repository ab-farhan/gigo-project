<?php if(!empty($process->language) && $process->language->rtl == 1): ?>
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
    <h4 class="page-title"><?php echo e(__('Work Process')); ?></h4>
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
        <a href="#"><?php echo e(__('Work Process')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="<?php echo e(route('admin.process.update')); ?>" method="post" enctype="multipart/form-data">
          <div class="card-header">
            <div class="card-title d-inline-block"><?php echo e(__('Edit Process')); ?></div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="<?php echo e(route('admin.process.index') . '?language=' . request()->input('language')); ?>">
                <span class="btn-label">
                    <i class="fas fa-backward"></i>
                </span>
                <?php echo e(__('Back')); ?>

            </a>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="process_id" value="<?php echo e($process->id); ?>">
                  <div class="form-group">
                      <label for=""><?php echo e(__('Icon')); ?> **</label>
                      <div class="btn-group d-block">
                          <button type="button" class="btn btn-primary iconpicker-component"><i class="<?php echo e($process->icon); ?>"></i></button>
                          <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                  data-selected="fa-car" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu"></div>
                      </div>
                      <input id="inputIcon" type="hidden" name="icon" value="<?php echo e($process->icon); ?>">
                      <?php if($errors->has('icon')): ?>
                          <p class="mb-0 text-danger"><?php echo e($errors->first('icon')); ?></p>
                      <?php endif; ?>
                      <div class="mt-2">
                          <small><?php echo e(__('NB: click on the dropdown sign to select an icon.')); ?></small>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for=""><?php echo e(__('Title')); ?> **</label>
                    <input class="form-control" name="title" placeholder="Enter title" value="<?php echo e($process->title); ?>">
                    <?php if($errors->has('title')): ?>
                      <p class="mb-0 text-danger"><?php echo e($errors->first('title')); ?></p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for=""><?php echo e(__('Text')); ?> **</label>
                    <input class="form-control" name="text" placeholder="Enter Text" value="<?php echo e($process->text); ?>">
                    <?php if($errors->has('text')): ?>
                      <p class="mb-0 text-danger"><?php echo e($errors->first('text')); ?></p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for=""><?php echo e(__('Serial Number')); ?> **</label>
                    <input type="number" class="form-control ltr" name="serial_number" value="<?php echo e($process->serial_number); ?>" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
                    <?php if($errors->has('serial_number')): ?>
                      <p class="mb-0 text-danger"><?php echo e($errors->first('serial_number')); ?></p>
                    <?php endif; ?>
                    <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the process will be shown.')); ?></small></p>
                  </div>
              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success"><?php echo e(__('Update')); ?></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/process/edit.blade.php ENDPATH**/ ?>