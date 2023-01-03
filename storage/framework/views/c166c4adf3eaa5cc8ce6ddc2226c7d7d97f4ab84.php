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
    <h4 class="page-title"><?php echo e(__('SEO Informations')); ?></h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="<?php echo e(route('user-dashboard')); ?>">
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
        <a href="#"><?php echo e(__('SEO Informations')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form
          action="<?php echo e(route('admin.seo.update')); ?>"
          method="post"
        >
          <?php echo csrf_field(); ?>
          <div class="card-header">
            <div class="row">
              <div class="col-lg-9">
                <div class="card-title"><?php echo e(__('Update SEO Informations')); ?></div>
              </div>

              <div class="col-lg-3">
                  <?php if(!empty($langs)): ?>
                    <select name="language" class="form-control float-right" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>'+this.value">
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

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Home Page')); ?></label>
                    <input
                      class="form-control"
                      name="home_meta_keywords"
                      value="<?php echo e($data->home_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Home Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="home_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->home_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Blog Page')); ?></label>
                    <input
                      class="form-control"
                      name="blogs_meta_keywords"
                      value="<?php echo e($data->blogs_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Blog Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="blogs_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->blogs_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Profiles Page')); ?></label>
                    <input
                      class="form-control"
                      name="profiles_meta_keywords"
                      value="<?php echo e($data->profiles_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Profiles Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="profiles_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->profiles_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Pricing Page')); ?></label>
                    <input
                      class="form-control"
                      name="pricing_meta_keywords"
                      value="<?php echo e($data->pricing_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Pricing Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="pricing_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->pricing_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For FAQs Page')); ?></label>
                    <input
                      class="form-control"
                      name="faqs_meta_keywords"
                      value="<?php echo e($data->faqs_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For FAQs Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="faqs_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->faqs_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Contact Page')); ?></label>
                    <input
                      class="form-control"
                      name="contact_meta_keywords"
                      value="<?php echo e($data->contact_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Contact Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="contact_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->contact_meta_description); ?></textarea>
                  </div>
                </div>
                
                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Login Page')); ?></label>
                    <input
                      class="form-control"
                      name="login_meta_keywords"
                      value="<?php echo e($data->login_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Login Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="login_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->login_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Forget Password Page')); ?></label>
                    <input
                      class="form-control"
                      name="forget_password_meta_keywords"
                      value="<?php echo e($data->forget_password_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Forget Password Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="forget_password_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->forget_password_meta_description); ?></textarea>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label><?php echo e(__('Meta Keywords For Checkout Page')); ?></label>
                    <input
                      class="form-control"
                      name="checkout_meta_keywords"
                      value="<?php echo e($data->checkout_meta_keywords); ?>"
                      placeholder="Enter Meta Keywords"
                      data-role="tagsinput"
                    >
                  </div>

                  <div class="form-group">
                    <label><?php echo e(__('Meta Description For Checkout Page')); ?></label>
                    <textarea
                      class="form-control"
                      name="checkout_meta_description"
                      rows="5"
                      placeholder="Enter Meta Description"
                    ><?php echo e($data->checkout_meta_description); ?></textarea>
                  </div>
                </div>
          </div>

          <div class="card-footer">
            <div class="form">
              <div class="row">
                <div class="col-12 text-center">
                  <button
                    type="submit"
                    class="btn btn-success <?php echo e($data == null ? 'd-none' : ''); ?>"
                  ><?php echo e(__('Update')); ?></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/basic/seo.blade.php ENDPATH**/ ?>