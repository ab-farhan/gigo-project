<?php if(!empty($abs->language) && $abs->language->rtl == 1): ?>
<?php $__env->startSection('styles'); ?>
<style>
    form input,
    form textarea,
    form select,
    select {
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
    <h4 class="page-title"><?php echo e(__('Intro Section')); ?></h4>
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
        <a href="#"><?php echo e(__('Intro Section')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title"><?php echo e(__('Update Intro Section')); ?></div>
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
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form id="ajaxForm" action="<?php echo e(route('admin.introsection.update', $lang_id)); ?>" method="post">
                <?php echo csrf_field(); ?>



                <div class="form-group">
                  <label for=""><?php echo e(__('Title')); ?> </label>
                  <input type="text" class="form-control" name="intro_title" value="<?php echo e($abs->intro_title); ?>">
                  <p id="errintro_title" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for=""><?php echo e(__('Subtitle')); ?></label>
                  <input type="text" class="form-control" name="intro_subtitle" value="<?php echo e($abs->intro_subtitle); ?>">
                  <p id="errintro_subtitle" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for=""><?php echo e(__('Text')); ?> </label>
                  <textarea name="intro_text" class="form-control" rows="4"><?php echo e($abs->intro_text); ?></textarea>
                  <p id="errintro_text" class="em text-danger mb-0"></p>
                </div>
                  <div class="form-group">
                      <label for=""><?php echo e(__('Button Text')); ?> </label>
                      <input type="text" class="form-control" name="intro_section_button_text" value="<?php echo e($abs->intro_section_button_text); ?>">
                      <p id="errintro_section_button_text" class="em text-danger mb-0"></p>
                  </div>

                          <div class="form-group">
                              <label for=""><?php echo e(__('Button URL')); ?> </label>
                              <input type="text" class="form-control ltr" name="intro_section_button_url" value="<?php echo e($abs->intro_section_button_url); ?>">
                              <p id="errintro_section_button_url" class="em text-danger mb-0"></p>
                          </div>


                          <div class="form-group">
                              <label for=""><?php echo e(__('Video URL')); ?> </label>
                              <input type="text" class="form-control ltr" name="intro_section_video_url" value="<?php echo e($abs->intro_section_video_url); ?>">
                              <p id="errintro_section_video_url" class="em text-danger mb-0"></p>
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


<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/intro-section.blade.php ENDPATH**/ ?>