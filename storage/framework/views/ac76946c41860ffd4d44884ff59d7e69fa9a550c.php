<?php
$selLang = \App\Models\Language::where('code', request()->input('language'))->first();
?>
<?php if(!empty($selLang) && $selLang->rtl == 1): ?>
<?php $__env->startSection('styles'); ?>
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Logo & Text')); ?></h4>
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
        <a href="#"><?php echo e(__('Footer')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Logo & Text')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title"><?php echo e(__('Update Logo & Text')); ?></div>
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

              <form id="ajaxForm" action="<?php echo e(route('admin.footer.update', $lang_id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <div class="mb-2">
                        <label for="image"><strong><?php echo e(__('Logo')); ?></strong></label>
                      </div>
                      <div class="showImage mb-3">
                        <img src="<?php echo e(!empty($abs->footer_logo) ? asset('assets/front/img/' . $abs->footer_logo) :  asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                      </div>
                      <input type="file" name="file" id="image" class="form-control image">
                      <p id="errimage" class="mb-0 text-danger em"></p>
                      <p class="text-warning mb-0"><?php echo e(__('Upload 185 X 50 image for best quality')); ?></p>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for=""><?php echo e(__('Footer Text')); ?></label>
                  <input type="text" class="form-control" name="footer_text" value="<?php echo e($abs->footer_text); ?>">
                  <p id="errfooter_text" class="em text-danger mb-0"></p>
                </div>
                
                <div class="form-group">
                  <label for=""><?php echo e(__('Useful Links Title')); ?></label>
                  <input type="text" class="form-control" name="useful_links_title" value="<?php echo e($abs->useful_links_title); ?>">
                  <p id="erruseful_links_title" class="em text-danger mb-0"></p>
                </div>
                
                <div class="form-group">
                  <label for=""><?php echo e(__('Newsletter Title')); ?></label>
                  <input type="text" class="form-control" name="newsletter_title" value="<?php echo e($abs->newsletter_title); ?>">
                  <p id="errnewsletter_title" class="em text-danger mb-0"></p>
                </div>
                
                <div class="form-group">
                  <label for=""><?php echo e(__('Newsletter Subtitle')); ?></label>
                  <input type="text" class="form-control" name="newsletter_subtitle" value="<?php echo e($abs->newsletter_subtitle); ?>">
                  <p id="errnewsletter_subtitle" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for=""><?php echo e(__('Copyright Text')); ?></label>
                  <textarea id="copyright_text" name="copyright_text" class="form-control summernote" data-height="100"><?php echo e(replaceBaseUrl($abs->copyright_text)); ?></textarea>
                  <p id="errcopyright_text" class="em text-danger mb-0"></p>
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


<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/footer/logo-text.blade.php ENDPATH**/ ?>