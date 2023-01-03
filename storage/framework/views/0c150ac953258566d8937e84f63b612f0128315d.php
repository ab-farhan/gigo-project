<!-- Modal -->
<div class="modal fade" id="templateModal<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Preview Image')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo e(route('register.user.template')); ?>" id="templateForm<?php echo e($user->id); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
            <input type="hidden" name="template" value="">
            <div class="form-group">
              <div class="col-md-12 showImage mb-3">
                <img src="<?php echo e(asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
              </div>
              <input type="file" name="preview_image" class="image" class="form-control image">
              <p id="errpreview_image<?php echo e($user->id); ?>" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for=""><?php echo e(__('Serial Number')); ?> **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the feature will be shown.')); ?></small></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
          <button form="templateForm<?php echo e($user->id); ?>" type="submit" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
        </div>
      </div>
    </div>
  </div><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/register_user/template-modal.blade.php ENDPATH**/ ?>