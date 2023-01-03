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
    <h4 class="page-title"><?php echo e(__('Blog Categories')); ?></h4>
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
        <a href="#"><?php echo e(__('Blog')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Categories')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block"><?php echo e(__('Categories')); ?></div>
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
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> <?php echo e(__('Add Blog Category')); ?></a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="<?php echo e(route('admin.bcategory.bulk.delete')); ?>"><i class="flaticon-interface-5"></i> <?php echo e(__('Delete')); ?></button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($bcategorys) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO BLOG CATEGORY FOUND')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col"><?php echo e(__('Name')); ?></th>
                        <th scope="col"><?php echo e(__('Status')); ?></th>
                        <th scope="col"><?php echo e(__('Serial Number')); ?></th>
                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $bcategorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="<?php echo e($bcategory->id); ?>">
                          </td>
                          <td><?php echo e($bcategory->name); ?></td>
                          <td>
                            <?php if($bcategory->status == 1): ?>
                              <h2 class="d-inline-block"><span class="badge badge-success"><?php echo e(__('Active')); ?></span></h2>
                            <?php else: ?>
                              <h2 class="d-inline-block"><span class="badge badge-danger"><?php echo e(__('Deactive')); ?></span></h2>
                            <?php endif; ?>
                          </td>
                          <td><?php echo e($bcategory->serial_number); ?></td>
                          <td>
                            <a class="btn btn-secondary btn-sm editbtn" href="#editModal" data-toggle="modal" data-bcategory_id="<?php echo e($bcategory->id); ?>" data-name="<?php echo e($bcategory->name); ?>" data-status="<?php echo e($bcategory->status); ?>" data-serial_number="<?php echo e($bcategory->serial_number); ?>">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              <?php echo e(__('Edit')); ?>

                            </a>
                            <form class="deleteform d-inline-block" action="<?php echo e(route('admin.bcategory.delete')); ?>" method="post">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="bcategory_id" value="<?php echo e($bcategory->id); ?>">
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


  <!-- Create Blog Category Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Blog Category')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form create" action="<?php echo e(route('admin.bcategory.store')); ?>" method="POST">
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
              <label for=""><?php echo e(__('Status')); ?> **</label>
              <select class="form-control ltr" name="status">
                <option value="" selected disabled><?php echo e(__('Select a status')); ?></option>
                <option value="1"><?php echo e(__('Active')); ?></option>
                <option value="0"><?php echo e(__('Deactive')); ?></option>
              </select>
              <p id="errstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Serial Number')); ?> **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the blog category will be shown.')); ?></small></p>
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

  <!-- Edit Blog Category Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Blog Category')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" class="" action="<?php echo e(route('admin.bcategory.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input id="inbcategory_id" type="hidden" name="bcategory_id" value="">
            <div class="form-group">
              <label for=""><?php echo e(__('Name')); ?> **</label>
              <input id="inname" type="name" class="form-control" name="name" value="" placeholder="<?php echo e(__('Enter name')); ?>">
              <p id="eerrname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Status')); ?> **</label>
              <select id="instatus" class="form-control ltr" name="status">
                <option value="" selected disabled><?php echo e(__('Select a status')); ?></option>
                <option value="1"><?php echo e(__('Active')); ?></option>
                <option value="0"><?php echo e(__('Deactive')); ?></option>
              </select>
              <p id="eerrstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Serial Number')); ?> **</label>
              <input id="inserial_number" type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
              <p id="eerrserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the blog category will be shown.')); ?></small></p>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/blog/bcategory/index.blade.php ENDPATH**/ ?>