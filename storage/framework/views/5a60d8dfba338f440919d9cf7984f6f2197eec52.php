<?php if(!empty($abe->language) && $abe->language->rtl == 1): ?>
<?php $__env->startSection('styles'); ?>
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Cookie Alert')); ?></h4>
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
        <a href="#"><?php echo e(__('Cookie Alert')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="<?php echo e(route('admin.cookie.update', $lang_id)); ?>" method="post">
          <?php echo csrf_field(); ?>
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-10">
                      <div class="card-title"><?php echo e(__('Update Cookie Alert')); ?></div>
                  </div>
                  <div class="col-lg-2">
                      <?php if(!empty($langs)): ?>
                          <select name="language" class="form-control" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>'+this.value">
                              <option value="" selected disabled><?php echo e(__('Select a Language')); ?></option>
                              <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($lang->code); ?>" <?php echo e($lang->code == request()->input('language') ? 'selected' : ''); ?>><?php echo e($lang->name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <label><?php echo e(__('Cookie Alert Status')); ?> **</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                        <input type="radio" name="cookie_alert_status" value="1" class="selectgroup-input" <?php echo e($abe->cookie_alert_status == 1 ? 'checked' : ''); ?>>
                        <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="cookie_alert_status" value="0" class="selectgroup-input" <?php echo e($abe->cookie_alert_status == 0 ? 'checked' : ''); ?>>
                        <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                    </label>
                  </div>
                  <?php if($errors->has('cookie_alert_status')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('cookie_alert_status')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label><?php echo e(__('Cookie Alert Button Text')); ?> **</label>
                  <input class="form-control" name="cookie_alert_button_text" value="<?php echo e($abe->cookie_alert_button_text); ?>">
                  <?php if($errors->has('cookie_alert_button_text')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('cookie_alert_button_text')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('Cookie Alert Text')); ?> **</label>
                  <textarea class="form-control summernote" name="cookie_alert_text" rows="3" placeholder="<?php echo e(__('Enter Cookie Alert Text')); ?>" data-height="100"><?php echo e(replaceBaseUrl($abe->cookie_alert_text)); ?></textarea>
                  <p id="errcontent" class="mb-0 text-danger em"></p>
                  <?php if($errors->has('cookie_alert_text')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('cookie_alert_text')); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success"><?php echo e(__('Update')); ?></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/basic/cookie.blade.php ENDPATH**/ ?>