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
    <h4 class="page-title"><?php echo e(__('Userful Links')); ?></h4>
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
        <a href="#"><?php echo e(__('Userful Links')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block"><?php echo e(__('Userful Links')); ?></div>
                </div>
                <div class="col-lg-3">
                    <?php if(!empty($langs)): ?>
                        <select name="language" class="form-control" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>'+this.value">
                            <option value="" selected disabled><?php echo e(__('Select a Language')); ?></option>
                            <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lang->code); ?>" <?php echo e($lang->code == request()->input('language') ? 'selected' : ''); ?>><?php echo e($lang->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> <?php echo e(__('Add Userful Link')); ?></a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($aulinks) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO USEFUL LINK FOUND')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo e(__('Name')); ?></th>
                        <th scope="col"><?php echo e(__('URL')); ?></th>
                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $aulinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $aulink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($loop->iteration); ?></td>
                          <td><?php echo e($aulink->name); ?></td>
                          <td><?php echo e($aulink->url); ?></td>
                          <td>
                            <a class="btn btn-secondary btn-sm editbtn" href="#editModal" data-toggle="modal" data-ulink_id="<?php echo e($aulink->id); ?>" data-name="<?php echo e($aulink->name); ?>" data-url="<?php echo e($aulink->url); ?>">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              <?php echo e(__('Edit')); ?>

                            </a>
                            <form class="deleteform d-inline-block" action="<?php echo e(route('admin.ulink.delete')); ?>" method="post">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="ulink_id" value="<?php echo e($aulink->id); ?>">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                <?php echo e(__('Delete')); ?>

                              </button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Userful Link Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Userful Link')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form create" action="<?php echo e(route('admin.ulink.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for=""><?php echo e(__('Language')); ?> **</label>
                <select name="language_id" class="form-control">
                    <option value="" selected disabled><?php echo e(__('Select a language')); ?></option>
                    <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lang->id); ?>"><?php echo e($lang->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Name')); ?> **</label>
              <input type="text" class="form-control" name="name" value="" placeholder="<?php echo e(__('Enter name')); ?>">
              <p id="errname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('URL')); ?> **</label>
              <input class="form-control ltr" name="url" placeholder="<?php echo e(__('Enter url')); ?>">
              <p id="errurl" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
          <button id="submitBtn" type="button" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Userful Link Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Userful Link')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" action="<?php echo e(route('admin.ulink.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input id="inulink_id" type="hidden" name="ulink_id" value="">
            <div class="form-group">
              <label for=""><?php echo e(__('Name')); ?> **</label>
              <input id="inname" type="text" class="form-control" name="name" value="" placeholder="<?php echo e(__('Enter name')); ?>">
              <p id="eerrname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('URL')); ?> **</label>
              <input id="inurl" class="form-control ltr" name="url" placeholder="<?php echo e(__('Enter url')); ?>">
              <p id="eerrurl" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
          <button id="updateBtn" type="button" class="btn btn-primary"><?php echo e(__('Save Changes')); ?></button>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/footer/ulink/index.blade.php ENDPATH**/ ?>