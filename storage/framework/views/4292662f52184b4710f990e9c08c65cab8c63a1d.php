<?php if(!empty($abs->language) && $abs->language->rtl == 1): ?>
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
    <h4 class="page-title"><?php echo e(__('Section Titles')); ?></h4>
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
        <a href="#"><?php echo e(__('Section Titles')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title"><?php echo e(__('Update Section Titles')); ?></div>
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
            <div class="col-lg-8 offset-lg-2">

              <form id="ajaxForm" action="<?php echo e(route('admin.home.page.text.update', $lang_id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Work Process Section Title')); ?></label>
                      <input type="hidden" name="types[]" value="work_process_title">
                      <input name="work_process_title" class="form-control" value="<?php echo e($abs->work_process_title); ?>">
                      <p id="errwork_process_title" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Work Process Section Subtitle')); ?></label>
                       <input type="hidden" name="types[]" value="work_process_subtitle">
                      <input name="work_process_subtitle" class="form-control" value="<?php echo e($abs->work_process_subtitle); ?>">
                      <p id="errwork_process_subtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Preview Templates Section Title')); ?></label>
                            <input type="hidden" name="types[]" value="preview_templates_title">
                            <input name="preview_templates_title" class="form-control" value="<?php echo e($abs->preview_templates_title); ?>">
                            <p id="errpreview_templates_title" class="em text-danger mb-0"></p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Preview Templates Section Subtitle')); ?></label>
                            <input type="hidden" name="types[]" value="preview_templates_subtitle">
                            <input name="preview_templates_subtitle" class="form-control" value="<?php echo e($abs->preview_templates_subtitle); ?>">
                            <p id="errpreview_templates_subtitle" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for=""><?php echo e(__('Featured Users Section Title')); ?> **</label>
                        <input type="hidden" name="types[]" value="featured_users_title">
                        <input name="featured_users_title" class="form-control" value="<?php echo e($abs->featured_users_title); ?>">
                        <p id="errfeatured_users_title" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for=""><?php echo e(__('Featured Users Section Subtitle')); ?> **</label>
                        <input type="hidden" name="types[]" value="featured_users_subtitle">
                        <input name="featured_users_subtitle" class="form-control" value="<?php echo e($abs->featured_users_subtitle); ?>">
                        <p id="errfeatured_users_subtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Partner Section Title')); ?> **</label>
                            <input type="hidden" name="types[]" value="partner_title">
                            <input name="partner_title" class="form-control" value="<?php echo e($abs->partner_title); ?>">
                            <p id="errpartner_title" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""><?php echo e(__('Partner Section Subtitle')); ?> **</label>
                            <input type="hidden" name="types[]" value="partner_subtitle">
                            <input name="partner_subtitle" class="form-control" value="<?php echo e($abs->partner_subtitle); ?>">
                            <p id="errpartner_subtitle" class="em text-danger mb-0"></p>
                        </div>
                    </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Pricing Section Title')); ?> **</label>
                      <input type="hidden" name="types[]" value="pricing_title">
                      <input name="pricing_title" class="form-control" value="<?php echo e($abs->pricing_title); ?>">
                      <p id="errpricing_title" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Pricing Section Subtitle')); ?> **</label>
                      <input type="hidden" name="types[]" value="pricing_subtitle">
                      <input name="pricing_subtitle" class="form-control" value="<?php echo e($abs->pricing_subtitle); ?>">
                      <p id="errpricing_subtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Testimonial Section Title')); ?> **</label>
                      <input type="hidden" name="types[]" value="testimonial_title">
                      <input name="testimonial_title" class="form-control" value="<?php echo e($abs->testimonial_title); ?>">
                      <p id="errtestimonial_title" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for=""><?php echo e(__('Testimonial Section Subtitle')); ?> **</label>
                        <input type="hidden" name="types[]" value="testimonial_subtitle">
                        <input name="testimonial_subtitle" class="form-control" value="<?php echo e($abs->testimonial_subtitle); ?>">
                        <p id="errtestimonial_subtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Blog Section Title')); ?> **</label>
                      <input type="hidden" name="types[]" value="blog_title">
                      <input name="blog_title" class="form-control" value="<?php echo e($abs->blog_title); ?>">
                      <p id="errblog_title" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Blog Section Subtitle')); ?> **</label>
                      <input type="hidden" name="types[]" value="blog_subtitle">
                      <input name="blog_subtitle" class="form-control" value="<?php echo e($abs->blog_subtitle); ?>">
                      <p id="errblog_subtitle" class="em text-danger mb-0"></p>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/home-page-text.blade.php ENDPATH**/ ?>