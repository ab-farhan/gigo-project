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
    <h4 class="page-title"><?php echo e(__('Payment Logs')); ?></h4>
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
            <a href="#"><?php echo e(__('Payment')); ?></a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"><?php echo e(__('Payment Log Page')); ?></a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-title d-inline-block"><?php echo e(__('Payment Log')); ?></div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0 justify-content-end">
                        <form action="<?php echo e(url()->current()); ?>" class="d-inline-block d-flex">
                            <input class="form-control mr-2" type="text" name="search"
                                placeholder="<?php echo e(__('Search by Transaction ID')); ?>"
                                value="<?php echo e(request()->input('search') ? request()->input('search') : ''); ?>">
                            <input class="form-control" type="text" name="username"
                                placeholder="<?php echo e(__('Search by Username')); ?>"
                                value="<?php echo e(request()->input('username') ? request()->input('username') : ''); ?>">
                            <button class="dis-none" type="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(count($memberships) == 0): ?>
                        <h3 class="text-center"><?php echo e(__('NO MEMBERSHIP FOUND')); ?></h3>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo e(__('Transaction Id')); ?></th>
                                        <th scope="col"><?php echo e(__('Username')); ?></th>
                                        <th scope="col"><?php echo e(__('Amount')); ?></th>
                                        <th scope="col"><?php echo e(__('Payment Status')); ?></th>
                                        <th scope="col"><?php echo e(__('Payment Method')); ?></th>
                                        <th scope="col"><?php echo e(__('Receipt')); ?></th>
                                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(strlen($membership->transaction_id) > 30 ? mb_substr($membership->transaction_id, 0, 30, 'UTF-8') . '...' : $membership->transaction_id); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('register.user.view', $membership->user_id)); ?>"><?php echo e($membership->user->username); ?></a>
                                        </td>
                                        <?php
                                        $bex = json_decode($membership->settings);
                                        ?>
                                        <td>
                                            <?php if($membership->price == 0): ?>
                                            <?php echo e(__('Free')); ?>

                                            <?php else: ?>
                                            <?php echo e(format_price($membership->price)); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(json_decode($membership->transaction_details) !== "offline"): ?>
                                                <?php if($membership->status == 1): ?>
                                                <h3 class="d-inline-block badge badge-success"><?php echo e(__('Success')); ?></h3>
                                                <?php elseif($membership->status == 0): ?>
                                                <h3 class="d-inline-block badge badge-warning"><?php echo e(__('Pending')); ?></h3>
                                                <?php elseif($membership->status == 2): ?>
                                                <h3 class="d-inline-block badge badge-danger"><?php echo e(__('Rejected')); ?></h3>
                                                <?php endif; ?>
                                            <?php else: ?>
                                            <form id="statusForm<?php echo e($membership->id); ?>" class="d-inline-block"
                                                action="<?php echo e(route('admin.payment-log.update')); ?>"
                                                method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($membership->id); ?>">
                                                <select class="form-control form-control-sm
                                                    <?php if($membership->status == 1): ?>
                                                    bg-success
                                                    <?php elseif($membership->status == 0): ?>
                                                    bg-warning
                                                    <?php elseif($membership->status == 2): ?>
                                                    bg-danger
                                                    <?php endif; ?>
                                                    " name="status"
                                                    onchange="document.getElementById('statusForm<?php echo e($membership->id); ?>').submit();">
                                                    <option value=0 <?php echo e($membership->status == 0 ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                                    <option value=1 <?php echo e($membership->status == 1 ? 'selected' : ''); ?>><?php echo e(__('Success')); ?></option>
                                                    <option value=2 <?php echo e($membership->status == 2 ? 'selected' : ''); ?>><?php echo e(__('Rejected')); ?></option>
                                                </select>
                                            </form>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($membership->payment_method); ?></td>
                                        <td>
                                            <?php if(!empty($membership->receipt)): ?>
                                            <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                                data-target="#receiptModal<?php echo e($membership->id); ?>">Show</a>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($membership->name !== "anonymous")): ?>
                                            <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                                data-target="#detailsModal<?php echo e($membership->id); ?>"><?php echo e(__('Detail')); ?></a>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="receiptModal<?php echo e($membership->id); ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Receipt Image')); ?>

                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img
                                                        src="<?php echo e(asset('assets/front/img/membership/receipt/' . $membership->receipt)); ?>"
                                                        alt="Receipt" width="100%">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"><?php echo e(__('Close')); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="detailsModal<?php echo e($membership->id); ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Owner Details')); ?>

                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h3 class="text-warning"><?php echo e(__('User details')); ?></h3>
                                                    <label><?php echo e(__('Name')); ?></label>
                                                    <p><?php echo e(!empty($membership->user) ? $membership->user->first_name.' '.$membership->user->last_name : '-'); ?></p>
                                                    <label><?php echo e(__('Username')); ?></label>
                                                    <p><?php echo e(!empty($membership->user) ? $membership->user->username : '-'); ?></p>
                                                    <label><?php echo e(__('Company')); ?></label>
                                                    <p><?php echo e(!empty($membership->user) ? $membership->user->company_name : '-'); ?></p>
                                                    <label><?php echo e(__('Email')); ?></label>
                                                    <p><?php echo e(!empty($membership->user) ? $membership->user->email : '-'); ?></p>
                                                    <label><?php echo e(__('Phone')); ?></label>
                                                    <p><?php echo e(!empty($membership->user->phone_number) ? $membership->user->phone_number : '-'); ?></p>
                                                    <h3 class="text-warning"><?php echo e(__('Payment details')); ?></h3>
                                                    <p><strong><?php echo e(__('Package Price')); ?>: </strong> <?php echo e($membership->package_price); ?>

                                                    </p>
                                                    <?php if($membership->discount > 0): ?>
                                                    <p><strong><?php echo e(__('Discount')); ?>: </strong> <?php echo e($membership->discount); ?>

                                                    </p>
                                                    <p><strong><?php echo e(__('Total')); ?>: </strong> <?php echo e($membership->price); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                    <p><strong><?php echo e(__('Currency')); ?>: </strong> <?php echo e($membership->currency); ?>

                                                    </p>
                                                    <p><strong><?php echo e(__('Method')); ?>: </strong> <?php echo e($membership->payment_method); ?>

                                                    </p>
                                                    <h3 class="text-warning"><?php echo e(__('Package Details')); ?></h3>
                                                    <p><strong><?php echo e(__('Title')); ?>: </strong><?php echo e(!empty($membership->package) ? $membership->package->title : ''); ?>

                                                    </p>
                                                    <p><strong><?php echo e(__('Term')); ?>: </strong> <?php echo e(!empty($membership->package) ? $membership->package->term : ''); ?>

                                                    </p>
                                                    <p><strong><?php echo e(__('Start Date')); ?>: </strong>
                                                        <?php if(\Illuminate\Support\Carbon::parse($membership->start_date)->format('Y') == '9999'): ?>
                                                            <span class="badge badge-danger"><?php echo e(__('Never Activated')); ?></span>
                                                        <?php else: ?>
                                                            <?php echo e(\Illuminate\Support\Carbon::parse($membership->start_date)->format('M-d-Y')); ?> 
                                                        <?php endif; ?>
                                                    </p>
                                                    <p><strong><?php echo e(__('Expire Date')); ?>: </strong>
                                                        
                                                        <?php if(\Illuminate\Support\Carbon::parse($membership->start_date)->format('Y') == '9999'): ?>
                                                            -
                                                        <?php else: ?>
                                                            <?php if($membership->modified == 1): ?>
                                                                <?php echo e(\Illuminate\Support\Carbon::parse($membership->expire_date)->addDay()->format('M-d-Y')); ?>

                                                                <span class="badge badge-primary btn-xs"><?php echo e(__('modified by Admin')); ?></span>
                                                            <?php else: ?>
                                                                <?php echo e($membership->package->term == 'lifetime' ? 'Lifetime' : \Illuminate\Support\Carbon::parse($membership->expire_date)->format('M-d-Y')); ?>

                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    <p>
                                                        <strong><?php echo e(__('Purchase Type')); ?>: </strong>
                                                        <?php if($membership->is_trial == 1): ?>
                                                        <?php echo e(__('Trial')); ?>

                                                        <?php else: ?>
                                                        <?php echo e($membership->price == 0 ? "Free" : "Regular"); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <?php echo e(__('Close')); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="d-inline-block mx-auto">
                        <?php echo e($memberships->appends(['search' => request()->input('search'), 'username' => request()->input('username')])->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/payment_log/index.blade.php ENDPATH**/ ?>