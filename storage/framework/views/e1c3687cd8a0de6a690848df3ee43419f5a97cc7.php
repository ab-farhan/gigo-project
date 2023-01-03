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
    <h4 class="page-title"><?php echo e(__('Testimonials')); ?></h4>
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
        <a href="#"><?php echo e(__('Testimonials')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block"><?php echo e(__('Testimonials')); ?></div>
            </div>
            <div class="col-lg-4">
              <?php if(!empty($langs)): ?>
                  <select name="language" class="form-control" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>'+this.value">
                      <option value="" selected disabled><?php echo e(__('Select a Language')); ?></option>
                      <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($lang->code); ?>" <?php echo e($lang->code == request()->input('language') ? 'selected' : ''); ?>><?php echo e($lang->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              <?php endif; ?>
            </div>
            <div class="col-lg-4">
              <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> <?php echo e(__('Add Testimonial')); ?></a>
                <a href="#" class="btn btn-primary float-right btn-sm mr-3" data-toggle="modal" data-target="#sideImageModal"><i class="fas fa-plus"></i> Add Side Image</a>

            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($testimonials) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO TESTIMONIAL FOUND')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo e(__('Image')); ?></th>
                        <th scope="col"><?php echo e(__('Name')); ?></th>
                        <th scope="col"><?php echo e(__('Rank')); ?></th>
                        <th scope="col"><?php echo e(__('Serial Number')); ?></th>
                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($loop->iteration); ?></td>
                          <td><img src="<?php echo e(asset('assets/front/img/testimonials/'.$testimonial->image)); ?>" alt="" width="40"></td>
                          <td><?php echo e($testimonial->name); ?></td>
                          <td><?php echo e($testimonial->rank); ?></td>
                          <td><?php echo e($testimonial->serial_number); ?></td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="<?php echo e(route('admin.testimonial.edit', $testimonial->id) . '?language=' . request()->input('language')); ?>">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            <?php echo e(__('Edit')); ?>

                            </a>
                            <form class="deleteform d-inline-block" action="<?php echo e(route('admin.testimonial.delete')); ?>" method="post">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="testimonial_id" value="<?php echo e($testimonial->id); ?>">
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


  <!-- Create Testimonial Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Testimonial')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form id="ajaxForm" class="modal-form" action="<?php echo e(route('admin.testimonial.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <div class="col-12 mb-2">
                    <label for="image"><strong><?php echo e(__('Image')); ?></strong></label>
                  </div>
                  <div class="col-md-12 showImage mb-3">
                    <img src="<?php echo e(asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                  </div>
                  <input type="file" name="image" id="image" class="form-control image">
                  <p id="errimage" class="mb-0 text-danger em"></p>
                </div>
              </div>
            </div>
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
              <label for=""><?php echo e(__('Comment')); ?> **</label>
              <textarea class="form-control" name="comment" rows="3" cols="80" placeholder="<?php echo e(__('Enter comment')); ?>"></textarea>
              <p id="errcomment" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Name')); ?> **</label>
              <input type="text" class="form-control" name="name" value="" placeholder="<?php echo e(__('Enter name')); ?>">
              <p id="errname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Rank')); ?> **</label>
              <input type="text" class="form-control" name="rank" value="" placeholder="<?php echo e(__('Enter rank')); ?>">
              <p id="errrank" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Serial Number')); ?> **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the testimonial will be shown.')); ?></small></p>
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

  <div class="modal fade" id="sideImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Side Image</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                  <form  class="modal-form" action="<?php echo e(route('admin.testimonial.sideImageStore')); ?>" method="POST" enctype="multipart/form-data">
                      <?php echo csrf_field(); ?>
                      <div class="row">
                          <div class="col-lg-12">
                              <div class="form-group">
                                  <div class="col-12 mb-2">
                                      <label for="image"><strong>Image</strong></label>
                                  </div>
                                  <div class="col-md-12 showImage mb-3">
                                      <img src="<?php echo e(asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                                  </div>
                                  <input type="file" name="image" id="image" class="form-control image">
                                  <p id="errimage" class="mb-0 text-danger em"></p>
                              </div>
                          </div>
                      </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
              </div>
              </form>
          </div>
      </div>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/testimonial/index.blade.php ENDPATH**/ ?>