<!-- Modal -->
<div class="modal fade" id="templateImgModal<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Preview Template')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
        <form action="<?php echo e(route('register.user.updateTemplate')); ?>" id="editTemplateForm<?php echo e($user->id); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
          <div class="form-group">
            <label for=""><?php echo e(__('Preview Image')); ?> **</label>
            <div class="col-md-12 showImage mb-3">
              <img src="<?php echo e(asset('assets/front/img/template-previews/' . $user->template_img)); ?>" alt="..." class="img-thumbnail">
            </div>
            <input type="file" name="preview_image" class="image" class="form-control image">
            <p class="eerrpreview_image mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for=""><?php echo e(__('Serial Number')); ?> **</label>
            <input type="number" class="form-control ltr" name="serial_number" value="<?php echo e($user->template_serial_number); ?>" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
            <p class="eerrserial_number mb-0 text-danger em"></p>
            <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the template will be shown.')); ?></small></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary update-btn" data-form_id="editTemplateForm<?php echo e($user->id); ?>"><?php echo e(__('Update')); ?></button>
      </div>
    </div>
  </div>
</div><?php /**PATH D:\laragon\www\gigo\resources\views/admin/register_user/template-image-modal.blade.php ENDPATH**/ ?>