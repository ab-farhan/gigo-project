<?php
	$admin = Auth::guard('admin')->user();
	if (!empty($admin->role)) {
		$permissions = $admin->role->permissions;
		$permissions = json_decode($permissions, true);
	}
?>

<?php $__env->startSection('content'); ?>
  <div class="mt-2 mb-4">
    <h2 class="text-white pb-2"><?php echo e(__('Welcome back')); ?>, <?php echo e(Auth::guard('admin')->user()->first_name); ?> <?php echo e(Auth::guard('admin')->user()->last_name); ?>!</h2>
  </div>
  <div class="row">
		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Registered Users', $permissions))): ?>
		<div class="col-sm-6 col-md-4">
			<a class="card card-stats card-info card-round" href="<?php echo e(route('admin.register.user')); ?>">
				<div class="card-body">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="fas fa-users"></i>
							</div>
						</div>
						<div class="col-7 col-stats">
							<div class="numbers">
								<p class="card-category"><?php echo e(__('Registered Users')); ?></p>
								<h4 class="card-title"><?php echo e(App\Models\User::count()); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php endif; ?>


		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Subscribers', $permissions))): ?>
		<div class="col-sm-6 col-md-4">
			<a class="card card-stats card-warning card-round" href="<?php echo e(route('admin.subscriber.index')); ?>">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="fas fa-mail-bulk"></i>
							</div>
						</div>
						<div class="col-7 col-stats">
							<div class="numbers">
								<p class="card-category"><?php echo e(__('Subscribers')); ?></p>
								<h4 class="card-title"><?php echo e(App\Models\Subscriber::count()); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php endif; ?>


		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Packages', $permissions))): ?>
		<div class="col-sm-6 col-md-4">
			<a class="card card-stats card-success card-round" href="<?php echo e(route('admin.package.index')); ?>">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="fas fa-list-ul"></i>
							</div>
						</div>
						<div class="col-7 col-stats">
							<div class="numbers">
								<p class="card-category"><?php echo e(__('Packages')); ?></p>
								<h4 class="card-title"><?php echo e(App\Models\Package::count()); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php endif; ?>


		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Payment Log', $permissions))): ?>
		<div class="col-sm-6 col-md-4">
			<a class="card card-stats card-danger card-round" href="<?php echo e(route('admin.payment-log.index')); ?>">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="fas fa-money-check-alt"></i>
							</div>
						</div>
						<div class="col-7 col-stats">
							<div class="numbers">
								<p class="card-category"><?php echo e(__('Payment Logs')); ?></p>
								<h4 class="card-title"><?php echo e(App\Models\Membership::count()); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php endif; ?>

		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Admins Management', $permissions))): ?>
		<div class="col-sm-6 col-md-4">
			<a class="card card-stats card-secondary card-round" href="<?php echo e(route('admin.user.index')); ?>">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="fas fa-users-cog"></i>
							</div>
						</div>
						<div class="col-7 col-stats">
							<div class="numbers">
								<p class="card-category"><?php echo e(__('Admins')); ?></p>
								<h4 class="card-title"><?php echo e(App\Models\Admin::count()); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php endif; ?>

		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Blogs', $permissions))): ?>
		<div class="col-sm-6 col-md-4">
			<a class="card card-stats card-primary card-round" href="<?php echo e(route('admin.blog.index', ['language' => $defaultLang->code])); ?>">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="fas fa-users-cog"></i>
							</div>
						</div>
						<div class="col-7 col-stats">
							<div class="numbers">
								<p class="card-category"><?php echo e(__('Blog')); ?></p>
								<h4 class="card-title"><?php echo e($defaultLang->blogs()->count()); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php endif; ?>
	</div>



	<div class="row">
		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Payment Log', $permissions))): ?>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<div class="card-title"><?php echo e(__('Monthly Income')); ?> (<?php echo e(date('Y')); ?>)</div>
				</div>
				<div class="card-body">
					<div class="chart-container">
						<canvas id="lineChart"></canvas>
					</div>
				</div>
			</div>		  
		</div>
		<?php endif; ?>

		<?php if(empty($admin->role) || (!empty($permissions) && in_array('Registered Users', $permissions))): ?>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<div class="card-title"><?php echo e(__('Monthly Premium Users')); ?> (<?php echo e(date('Y')); ?>)</div>
				</div>
				<div class="card-body">
					<div class="chart-container">
						<canvas id="usersChart"></canvas>
					</div>
				</div>
			</div>		  
		</div>
		<?php endif; ?>
	  </div>




<?php $__env->stopSection(); ?>

<?php
	$months = [];
	$inTotals = [];

	for ($i=1; $i <= 12; $i++) { 
		$monthNum  = $i;
		$dateObj   = DateTime::createFromFormat('!m', $monthNum);
		$months[] = $dateObj->format('M');

		$inFound = 0;
		foreach ($incomes as $key => $income) {
			if ($income->month == $i) {
				$inTotals[] = $income->total;
				$inFound = 1;
				break;
			}
		}
		if ($inFound == 0) {
			$inTotals[] = 0;
		}

		$userFound = 0;
		foreach ($users as $key => $user) {
			if ($user->month == $i) {
				$userTotals[] = $user->total;
				$userFound = 1;
				break;
			}
		}
		if ($userFound == 0) {
			$userTotals[] = 0;
		}
	}

?>
<?php $__env->startSection('scripts'); ?>
	<!-- Chart JS -->
	<script src="<?php echo e(asset('assets/admin/js/plugin/chart.min.js')); ?>"></script>
	<script>
		"use strict";
		var months = <?php echo json_encode($months) ?>;
		var inTotals = <?php echo json_encode($inTotals) ?>;
		var userTotals = <?php echo json_encode($userTotals) ?>;
	</script>
	<script src="<?php echo e(asset('assets/admin/js/dashboard.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>