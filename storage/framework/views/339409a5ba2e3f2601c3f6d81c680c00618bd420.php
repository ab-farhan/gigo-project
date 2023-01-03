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
    <h4 class="page-title"><?php echo e(__('Basic Informations')); ?></h4>
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
        <a href="#"><?php echo e(__('Basic Informations')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="<?php echo e(route('admin.basicinfo.update')); ?>" method="post">
          <?php echo csrf_field(); ?>
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-10">
                      <div class="card-title"><?php echo e(__('Update Basic Informations')); ?></div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-8 offset-lg-2">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <h3 class="text-warning"><?php echo e(__('Information')); ?></h3>
                  <hr class="divider"><br>

                  <label><?php echo e(__('Website Title')); ?> **</label>
                  <input class="form-control" name="website_title" value="<?php echo e($abs->website_title); ?>">
                  <?php if($errors->has('website_title')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('website_title')); ?></p>
                  <?php endif; ?>
                </div>
                  <div class="form-group">
                      <label><?php echo e(__('Timezone')); ?> **</label>
                      <select name="timezone" class="form-control select2">
                          <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($timezone->timezone); ?>" <?php echo e($timezone->timezone == $abe->timezone ? "selected" : ""); ?>><?php echo e($timezone->timezone); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                      <?php if($errors->has('timezone')): ?>
                          <p class="mb-0 text-danger"><?php echo e($errors->first('timezone')); ?></p>
                      <?php endif; ?>
                  </div>

                <div class="form-group">
                  <br>
                  <h3 class="text-warning"><?php echo e(__('Website Appearance')); ?></h3>
                  <hr class="divider"><br>

                    <div class="row">
                        <div class="col-lg-6">
                            <label><?php echo e(__('Base Color Code 1')); ?> **</label>
                            <input class="jscolor form-control ltr" name="base_color" value="<?php echo e($abs->base_color); ?>">
                            <?php if($errors->has('base_color')): ?>
                                <p class="mb-0 text-danger"><?php echo e($errors->first('base_color')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <label><?php echo e(__('Base Color Code 2')); ?> **</label>
                            <input class="jscolor form-control ltr" name="base_color2" value="<?php echo e($abs->base_color2); ?>">
                            <?php if($errors->has('base_color')): ?>
                                <p class="mb-0 text-danger"><?php echo e($errors->first('base_color')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>




                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <br>
                            <h3 class="text-warning"><?php echo e(__('Currency Settings')); ?></h3>
                            <hr class="divider">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">

                            <label><?php echo e(__('Base Currency Symbol')); ?> **</label>
                            <input type="text" class="form-control ltr" name="base_currency_symbol" value="<?php echo e($abe->base_currency_symbol); ?>">
                            <?php if($errors->has('base_currency_symbol')): ?>
                              <p class="mb-0 text-danger"><?php echo e($errors->first('base_currency_symbol')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php echo e(__('Base Currency Symbol Position')); ?> **</label>
                            <select name="base_currency_symbol_position" class="form-control ltr">
                                <option value="left" <?php echo e($abe->base_currency_symbol_position == 'left' ? 'selected' : ''); ?>><?php echo e(__('Left')); ?></option>
                                <option value="right" <?php echo e($abe->base_currency_symbol_position == 'right' ? 'selected' : ''); ?>><?php echo e(__('Right')); ?></option>
                            </select>
                            <?php if($errors->has('base_currency_symbol_position')): ?>
                              <p class="mb-0 text-danger"><?php echo e($errors->first('base_currency_symbol_position')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label><?php echo e(__('Base Currency Text')); ?> **</label>
                            <input type="text" class="form-control ltr" name="base_currency_text" value="<?php echo e($abe->base_currency_text); ?>">
                            <?php if($errors->has('base_currency_text')): ?>
                              <p class="mb-0 text-danger"><?php echo e($errors->first('base_currency_text')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label><?php echo e(__('Base Currency Text Position')); ?> **</label>
                            <select name="base_currency_text_position" class="form-control ltr">
                                <option value="left" <?php echo e($abe->base_currency_text_position == 'left' ? 'selected' : ''); ?>><?php echo e(__('Left')); ?></option>
                                <option value="right" <?php echo e($abe->base_currency_text_position == 'right' ? 'selected' : ''); ?>><?php echo e(__('Right')); ?></option>
                            </select>
                            <?php if($errors->has('base_currency_text_position')): ?>
                              <p class="mb-0 text-danger"><?php echo e($errors->first('base_currency_text_position')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label><?php echo e(__('Base Currency Rate')); ?> **</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo e(__('1 USD')); ?> =</span>
                                </div>
                                <input type="text" name="base_currency_rate" class="form-control ltr" value="<?php echo e($abe->base_currency_rate); ?>">
                                <div class="input-group-append">
                                  <span class="input-group-text"><?php echo e($abe->base_currency_text); ?></span>
                                </div>
                            </div>

                            <?php if($errors->has('base_currency_rate')): ?>
                              <p class="mb-0 text-danger"><?php echo e($errors->first('base_currency_rate')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <br>
                            <h3 class="text-warning"><?php echo e(__('Course File & Video Upload Size')); ?></h3>
                            <hr class="divider">
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label><?php echo e(__('Maximum Size of Single Video') . '*'); ?></label>
                        <div class="input-group mb-2">
                          <input type="text" step="0.01" name="max_video_size" class="form-control" value="<?php echo e($abe->max_video_size); ?>">
                          <div class="input-group-append">
                            <span class="input-group-text"><?php echo e(__('MB')); ?></span>
                          </div>
                        </div>
                        <p class="text-warning mb-0"><?php echo e(__('Please increase the file upload size from Hosting')); ?></p>
                        <?php if($errors->has('max_video_size')): ?>
                          <p class="mb-0 text-danger"><?php echo e($errors->first('max_video_size')); ?></p>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label><?php echo e(__('Maximum Size of Single File') . '*'); ?></label>
                        <div class="input-group mb-2">
                          <input type="text" step="0.01" name="max_file_size" class="form-control" value="<?php echo e($abe->max_file_size); ?>">
                          <div class="input-group-append">
                            <span class="input-group-text"><?php echo e(__('MB')); ?></span>
                          </div>
                        </div>
                        <p class="text-warning mb-0"><?php echo e(__('Please increase the file upload size from Hosting')); ?></p>
                        <?php if($errors->has('max_file_size')): ?>
                          <p class="mb-0 text-danger"><?php echo e($errors->first('max_file_size')); ?></p>
                        <?php endif; ?>
                      </div>
                    </div>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/basic/basicinfo.blade.php ENDPATH**/ ?>