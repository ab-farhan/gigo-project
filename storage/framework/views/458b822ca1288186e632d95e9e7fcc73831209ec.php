<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4 class="page-title"><?php echo e(empty(request()->input('type')) ? 'All' : ucfirst(request()->input('type'))); ?> Custom Domains</h4>
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
            <a href="#"><?php echo e(__('Custom Domains')); ?></a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"><?php echo e(empty(request()->input('type')) ? __('All') : ucfirst(request()->input('type'))); ?> <?php echo e(__('Requests')); ?></a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-title d-inline-block"><?php echo e(__('All Custom Domains')); ?></div>
                    </div>
                    <div class="col-lg-6 offset-lg-2 mt-2 mt-lg-0">
                        <button class="btn btn-danger float-right btn-sm ml-2 d-none bulk-delete" data-href="<?php echo e(route('admin.custom-domain.bulk.delete')); ?>"><i class="flaticon-interface-5"></i> <?php echo e(__('Delete')); ?></button>
                        <form action="<?php echo e(request()->url()); ?>" class="float-right d-flex">
                            <?php if(!empty(request()->input('type'))): ?>
                                <input type="hidden" name="type" value="<?php echo e(request()->input('type')); ?>">
                            <?php endif; ?>
                            <input name="username" class="min-w-250 form-control mr-2" type="text" placeholder="Search by Username" value="<?php echo e(request()->input('username')); ?>">
                            <input name="domain" class="min-w-250 form-control" type="text" placeholder="Search by Domain" value="<?php echo e(request()->input('domain')); ?>">
                            <button type="submit" class="d-none"></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(count($rcDomains) == 0): ?>
                        <h3 class="text-center"><?php echo e(__('NO REQUEST FOUND')); ?></h3>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" class="bulk-check" data-val="all">
                                        </th>
                                        <th><?php echo e(__('Username')); ?></th>
                                        <th scope="col"><?php echo e(__('Requested Domain')); ?></th>
                                        <th scope="col"><?php echo e(__('Current Domain')); ?></th>
                                        <th scope="col"><?php echo e(__('Status')); ?></th>
                                        <th><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rcDomains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rcDomain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="bulk-check" data-val="<?php echo e($rcDomain->id); ?>">
                                        </td>
                                        <?php if(!empty($rcDomain->user)): ?>
                                        <td><a href="<?php echo e(route('register.user.view', $rcDomain->user->id)); ?>" target="_blank"><?php echo e($rcDomain->user->username); ?></a></td>
                                        <?php else: ?>
                                        <td>-</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if(!empty($rcDomain->requested_domain)): ?>
                                            <a href="//<?php echo e($rcDomain->requested_domain); ?>" target="_blank"><?php echo e($rcDomain->requested_domain); ?></a>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($rcDomain->current_domain)): ?>
                                            <a href="//<?php echo e($rcDomain->current_domain); ?>" target="_blank"><?php echo e($rcDomain->current_domain); ?></a>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form id="statusForm<?php echo e($rcDomain->id); ?>" action="<?php echo e(route('admin.custom-domain.status')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="domain_id" value="<?php echo e($rcDomain->id); ?>">
                                                <select class="max-w-130 form-control form-control-sm
                                                    <?php if($rcDomain->status == 0): ?>
                                                    bg-warning text-white
                                                    <?php elseif($rcDomain->status == 1): ?>
                                                    bg-success text-white
                                                    <?php elseif($rcDomain->status == 2): ?>
                                                    bg-danger text-white
                                                    <?php elseif($rcDomain->status == 3): ?>
                                                    bg-dark text-white
                                                    <?php endif; ?>
                                                    " name="status" onchange="document.getElementById('statusForm<?php echo e($rcDomain->id); ?>').submit();">
                                                <option value="0" <?php echo e($rcDomain->status == 0 ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                                <option value="1" <?php echo e($rcDomain->status == 1 ? 'selected' : ''); ?>><?php echo e(__('Connected')); ?></option>
                                                <option value="2" <?php echo e($rcDomain->status == 2 ? 'selected' : ''); ?>><?php echo e(__('Rejected')); ?></option>
                                                <option value="3" <?php echo e($rcDomain->status == 3 ? 'selected' : ''); ?>><?php echo e(__('Removed')); ?></option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="btn btn-secondary btn-sm editbtn" data-toggle="modal" data-target="#mailModal" data-email="<?php echo e(!empty($rcDomain->user) ? $rcDomain->user->email : ''); ?>"><?php echo e(__('Mail')); ?></button>
                                            <form class="d-inline-block deleteform" action="<?php echo e(route('admin.custom-domain.delete')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="domain_id" value="<?php echo e($rcDomain->id); ?>">
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

            <div class="card-footer">
                <?php echo e($rcDomains->appends(['type' => request()->input('type'), 'username' => request()->input('username'), 'domain' => request()->input('domain')])->links()); ?>

            </div>


            <!-- Send Mail Modal -->
            <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Send Mail')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="ajaxEditForm" class="" action="<?php echo e(route('admin.custom-domain.mail')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for=""><?php echo e(__('Email Address')); ?> **</label>
                                    <input id="inemail" type="text" class="form-control" name="email" value="" placeholder="Enter email">
                                    <p id="eerremail" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo e(__('Subject')); ?> **</label>
                                    <input id="insubject" type="text" class="form-control summernote" name="subject" value="" placeholder="<?php echo e(__('Enter subject')); ?>">
                                    <p id="eerrsubject" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo e(__('Message')); ?> **</label>
                                    <textarea id="inmessage" class="form-control" name="message" placeholder="<?php echo e(__('Enter message')); ?>" data-height="150"></textarea>
                                    <p id="eerrmessage" class="mb-0 text-danger em"></p>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                            <button id="updateBtn" type="button" class="btn btn-primary"><?php echo e(__('Send Mail')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/domains/custom.blade.php ENDPATH**/ ?>