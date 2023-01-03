<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Mail From Admin')); ?></h4>
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
        <a href="#"><?php echo e(__('Email Settings')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Mail From Admin')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="<?php echo e(route('admin.mailfromadmin.update')); ?>" method="post">
          <?php echo csrf_field(); ?>
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title"><?php echo e(__('Mail From Admin')); ?></div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="alert alert-warning text-center" role="alert">
                    <strong><?php echo e(__('This mail addres will be used to send all mails from this website.')); ?></strong>
                </div>
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <label><?php echo e(__('SMTP Status')); ?> **</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="is_smtp" value="1" class="selectgroup-input" <?php echo e($abe->is_smtp == 1 ? 'checked' : ''); ?>>
                      <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="is_smtp" value="0" class="selectgroup-input" <?php echo e($abe->is_smtp == 0 ? 'checked' : ''); ?>>
                      <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                    </label>
                  </div>
                  <?php if($errors->has('is_smtp')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('is_smtp')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('SMTP Host')); ?> **</label>
                    <input class="form-control" name="smtp_host" value="<?php echo e($abe->smtp_host); ?>">
                    <?php if($errors->has('smtp_host')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('smtp_host')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('SMTP Port')); ?> **</label>
                    <input class="form-control" name="smtp_port" value="<?php echo e($abe->smtp_port); ?>">
                    <?php if($errors->has('smtp_port')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('smtp_port')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('Encryption')); ?> **</label>
                    <input class="form-control" name="encryption" value="<?php echo e($abe->encryption); ?>">
                    <?php if($errors->has('encryption')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('encryption')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('SMTP Username')); ?> **</label>
                    <input class="form-control" name="smtp_username" value="<?php echo e($abe->smtp_username); ?>">
                    <?php if($errors->has('smtp_username')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('smtp_username')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('SMTP Password')); ?> **</label>
                    <input class="form-control" name="smtp_password" value="<?php echo e($abe->smtp_password); ?>">
                    <?php if($errors->has('smtp_password')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('smtp_password')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('From Email')); ?> **</label>
                    <input class="form-control" type="email" name="from_mail" value="<?php echo e($abe->from_mail); ?>">
                    <?php if($errors->has('from_mail')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('from_mail')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo e(__('From Name')); ?> **</label>
                    <input class="form-control" name="from_name" value="<?php echo e($abe->from_name); ?>">
                    <?php if($errors->has('from_name')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('from_name')); ?></p>
                    <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samiulalimpratik/Sites/coursemat/coursemat/resources/views/admin/basic/email/mail_from_admin.blade.php ENDPATH**/ ?>