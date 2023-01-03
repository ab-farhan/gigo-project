<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Social Links')); ?></h4>
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
        <a href="#">Basic Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Social Links')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="socialForm" action="<?php echo e(route('admin.social.store')); ?>" method="post">
          <div class="card-header">
            <div class="card-title"><?php echo e(__('Add Social Link')); ?></div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <label for=""><?php echo e(__('Social Icon')); ?> **</label>
                  <div class="btn-group d-block">
                      <button type="button" class="btn btn-primary iconpicker-component"><i
                              class="fa fa-fw fa-heart"></i></button>
                      <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                              data-selected="fa-car" data-toggle="dropdown">
                      </button>
                      <div class="dropdown-menu"></div>
                  </div>
                  <input id="inputIcon" type="hidden" name="icon" value="">
                  <?php if($errors->has('icon')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('icon')); ?></p>
                  <?php endif; ?>
                  <div class="mt-2">
                    <small><?php echo e(__('NB: click on the dropdown icon to select a social link icon.')); ?></small>
                  </div>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('URL')); ?> **</label>
                  <input type="text" class="form-control" name="url" value="" placeholder="<?php echo e(__('Enter URL of social media account')); ?>">
                  <?php if($errors->has('url')): ?>
                    <p class="mb-0 text-danger"><?php echo e($errors->first('url')); ?></p>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for=""><?php echo e(__('Serial Number')); ?> **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small><?php echo e(__('The higher the serial number is, the later the social link will be shown.')); ?></small></p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-lg-3 col-md-3 col-sm-12">

                </div>
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success"><?php echo e(__('Submit')); ?></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title"><?php echo e(__('Social Links')); ?></div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($socials) == 0): ?>
                <h2 class="text-center"><?php echo e(__('NO LINK ADDED')); ?></h2>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?php echo e(__('Icon')); ?></th>
                            <th scope="col"><?php echo e(__('URL')); ?></th>
                            <th scope="col"><?php echo e(__('Serial Number<')); ?>/th>
                            <th scope="col"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><i class="<?php echo e($social->icon); ?>"></i></td>
                            <td><?php echo e($social->url); ?></td>
                            <td><?php echo e($social->serial_number); ?></td>
                            <td>
                            <a class="btn btn-secondary btn-sm" href="<?php echo e(route('admin.social.edit', $social->id)); ?>">
                                <span class="btn-label">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <?php echo e(__('Edit')); ?>

                            </a>
                            <form class="d-inline-block deleteform" action="<?php echo e(route('admin.social.delete')); ?>" method="post">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="socialid" value="<?php echo e($social->id); ?>">
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/basic/social/index.blade.php ENDPATH**/ ?>