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
    <h4 class="page-title"><?php echo e(__('Contact Page')); ?></h4>
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
        <a href="#"><?php echo e(__('Contact Page')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form   enctype="multipart/form-data" action="<?php echo e(route('admin.contact.update', $lang_id)); ?>" method="POST">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title"><?php echo e(__('Contact Page')); ?></div>
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
                  <label><?php echo e(__('Form Title')); ?> **</label>
                  <input class="form-control" name="contact_form_title" value="<?php echo e($abs->contact_form_title); ?>" placeholder="<?php echo e(__('Enter form Titlte')); ?>">
                  <?php if($errors->has('contact_form_title')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('contact_form_title')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label><?php echo e(__('Information Title')); ?> **</label>
                  <input class="form-control" name="contact_info_title" value="<?php echo e($abs->contact_info_title); ?>" placeholder="<?php echo e(__('Enter Information Title')); ?>">
                  <?php if($errors->has('contact_info_title')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('contact_info_title')); ?></p>
                  <?php endif; ?>
                </div>
               
                <div class="form-group">
                  <label><?php echo e(__('Address')); ?> **</label>
                  <textarea class="form-control" name="contact_addresses" rows="4" placeholder="<?php echo e(__('Enter Address')); ?>"><?php echo e($abe->contact_addresses); ?></textarea>
                  <div class="text-warning"><?php echo e(__('Use newline to seperate multiple addresses.')); ?></div>
                  <?php if($errors->has('contact_addresses')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('contact_addresses')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label><?php echo e(__('Contact Information Text')); ?> **</label>
                  <input class="form-control" name="contact_text" value="<?php echo e($abs->contact_text); ?>" placeholder="<?php echo e(__('Enter Information text')); ?>">
                  <?php if($errors->has('contact_text')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('contact_text')); ?></p>
                  <?php endif; ?>
                </div>

               
                <div class="form-group">
                  <label><?php echo e(__('Phone')); ?> **</label>
                  <input class="form-control" data-role="tagsinput" name="contact_numbers" value="<?php echo e($abe->contact_numbers); ?>" placeholder="<?php echo e(__('Enter Phone Number')); ?>">
                  <div class="text-warning"><?php echo e(__('Use comma (,) to add multiple Phone Numbers')); ?></div>
                  <?php if($errors->has('contact_numbers')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('contact_numbers')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label><?php echo e(__('Email')); ?> **</label>
                  <input class="form-control ltr" data-role="tagsinput"  name="contact_mails" value="<?php echo e($abe->contact_mails); ?>" placeholder="<?php echo e(__('Enter Email Addresses')); ?>">
                  <div class="text-warning"><?php echo e(__('Use comma (,) to add multiple Email Addresses')); ?></div>
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button id="displayNotif" class="btn btn-success"><?php echo e(__('Update')); ?></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/contact.blade.php ENDPATH**/ ?>