<?php if(!empty($abe->language) && $abe->language->rtl == 1): ?>
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
    <h4 class="page-title"><?php echo e(__('Hero Section')); ?></h4>
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
        <a href="#"><?php echo e(__('Hero Section')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Static Version')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title"><?php echo e(__('Update Hero Section')); ?></div>
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
              <form id="ajaxForm" action="<?php echo e(route('admin.herosection.update', $lang_id)); ?>" method="post">
                <?php echo csrf_field(); ?>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="mb-2">
                              <label for="image"><strong><?php echo e(__('Image')); ?></strong></label>
                            </div>
                            <div class="showImage mb-3">
                              <img src="<?php echo e(!empty($abe->hero_img) ? asset('assets/front/img/'.$abe->hero_img) : asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail w-100">
                            </div>
                            <input type="file" name="image" class="form-control image">
                            <p id="errimage" class="mb-0 text-danger em"></p>
                            <p class="text-warning mb-0"><?php echo e(__('Upload 743 X 518 image for best quality')); ?></p>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Title')); ?></label>
                            <input name="hero_section_title" class="form-control" value="<?php echo e($abe->hero_section_title); ?>">
                            <p id="errhero_section_title" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label for=""><?php echo e(__('Text')); ?></label>
                        <input name="hero_section_text" class="form-control" value="<?php echo e($abe->hero_section_text); ?>">
                        <p id="errhero_section_text" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                          <label for=""><?php echo e(__('Button Text')); ?> </label>
                          <input type="text" class="form-control" name="hero_section_button_text" value="<?php echo e($abe->hero_section_button_text); ?>">
                          <p id="errhero_section_button_text" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Button URL')); ?> </label>
                            <input type="text" class="form-control ltr" name="hero_section_button_url" value="<?php echo e($abe->hero_section_button_url); ?>">
                            <p id="errhero_section_button_url" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Video URL')); ?> </label>
                            <input type="text" class="form-control ltr" name="hero_section_video_url" value="<?php echo e($abe->hero_section_video_url); ?>">
                            <p id="errhero_section_video_url" class="em text-danger mb-0"></p>
                        </div>
                    </div>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/hero/img-text.blade.php ENDPATH**/ ?>