<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Work Process')); ?></h4>
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
        <a href="#"><?php echo e(__('Work Process')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block"><?php echo e(__('Work Process')); ?></div>
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
                    <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> <?php echo e(__('Add Work Process')); ?></a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($processes) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO WORK PROCESS FOUND')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo e(__('Icon')); ?></th>
                        <th scope="col"><?php echo e(__('Title')); ?></th>
                        <th scope="col"><?php echo e(__('Text')); ?></th>

                        <th scope="col"><?php echo e(__('Serial Number')); ?></th>
                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $process): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($loop->iteration); ?></td>
                            <td><i class="<?php echo e($process->icon); ?>"></i></td>
                          <td><?php echo e($process->title); ?></td>
                            <td><?php echo e($process->text); ?></td>

                          <td><?php echo e($process->serial_number); ?></td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="<?php echo e(route('admin.process.edit', $process->id) . '?language=' . request()->input('language')); ?>">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              <?php echo e(__('Edit')); ?>

                            </a>
                            <form class="deleteform d-inline-block" action="<?php echo e(route('admin.process.delete')); ?>" method="post">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="process_id" value="<?php echo e($process->id); ?>">
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


  <!-- Create Feature Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Work Process')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="<?php echo e(route('admin.process.store')); ?>" method="post" enctype="multipart/form-data">
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
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <div class="col-12 mb-2">
                    <label for="image"><strong> <?php echo e(__('Icon')); ?>**</strong></label>
                  </div>
                    <div class="btn-group d-block">
                        <button type="button" class="btn btn-primary iconpicker-component"><i
                                class="fa fa-fw fa-heart"></i></button>
                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                data-selected="fa-car" data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu"></div>
                    </div>
                    <input id="inputIcon" type="hidden" name="icon" value="fas fa-heart">
                    <?php if($errors->has('icon')): ?>
                        <p class="mb-0 text-danger"><?php echo e($errors->first('icon')); ?></p>
                    <?php endif; ?>
                    <div class="mt-2">
                        <small>NB: click on the dropdown sign to select a icon.</small>
                    </div>
                  <p id="errimage" class="mb-0 text-danger em"></p>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for=""><?php echo e(__('Title')); ?> **</label>
              <input class="form-control" name="title" placeholder="<?php echo e(__('Enter title')); ?>">
              <p id="errtitle" class="mb-0 text-danger em"></p>
            </div>
              <div class="form-group">
                  <label for="">Text **</label>
                  <textarea class="form-control" name="text" placeholder="Enter text"></textarea>
                  <p id="errtitle" class="mb-0 text-danger em"></p>
              </div>

            <div class="form-group">
              <label for=""><?php echo e(__('Serial Number')); ?> **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the process will be shown.')); ?></small></p>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/home/process/index.blade.php ENDPATH**/ ?>