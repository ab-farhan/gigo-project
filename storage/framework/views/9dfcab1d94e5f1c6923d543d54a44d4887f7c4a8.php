<?php if(!empty($page->language) && $page->language->rtl == 1): ?>
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
    <h4 class="page-title"><?php echo e(__('Pages')); ?></h4>
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
        <a href="#"><?php echo e(__('Edit Page')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Pages')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block"><?php echo e(__('Edit Page')); ?></div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="<?php echo e(route('admin.page.index') . '?language=' . request()->input('language')); ?>">
						<span class="btn-label">
							<i class="fas fa-backward"></i>
						</span>
						<?php echo e(__('Back')); ?>

					</a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              <form id="ajaxForm" action="<?php echo e(route('admin.page.update')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="pageid" value="<?php echo e($page->id); ?>">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Name')); ?> **</label>
                      <input type="text" name="name" class="form-control" placeholder="<?php echo e(__('Enter Name')); ?>" value="<?php echo e($page->name); ?>">
                      <p id="errname" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Title')); ?> **</label>
                      <input type="text" class="form-control" name="title" placeholder="<?php echo e(__('Enter Title')); ?>" value="<?php echo e($page->title); ?>">
                      <p id="errtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Status')); ?> **</label>
                      <select class="form-control ltr" name="status">
                        <option value="1" <?php echo e($page->status == 1 ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
                        <option value="0" <?php echo e($page->status == 0 ? 'selected' : ''); ?>><?php echo e(__('Deactive')); ?></option>
                      </select>
                      <p id="errstatus" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('Body')); ?> **</label>
                  <textarea id="body" class="form-control summernote" name="body" data-height="500"><?php echo e(replaceBaseUrl($page->body)); ?></textarea>
                  <p id="errbody" class="em text-danger mb-0"></p>
                </div>
                <div class="form-group">
                   <label><?php echo e(__('Meta Keywords')); ?></label>
                   <input class="form-control" name="meta_keywords" value="<?php echo e($page->meta_keywords); ?>" placeholder="<?php echo e(__('Enter meta keywords')); ?>" data-role="tagsinput">
                </div>
                <div class="form-group">
                   <label><?php echo e(__('Meta Description')); ?></label>
                   <textarea class="form-control" name="meta_description" rows="5" placeholder="<?php echo e(__('Enter meta description')); ?>"><?php echo e($page->meta_description); ?></textarea>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/page/edit.blade.php ENDPATH**/ ?>