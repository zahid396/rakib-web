<?php $__env->startSection('content'); ?>
<div class="jobs-page">
    <div class="container">
        <div class="jobs-header">
            <h1>Job Circulars</h1>
            <p>Find your next career opportunity and apply with your email</p>
        </div>

        <form method="GET" action="<?php echo e(route('jobs.index')); ?>">
            <div class="jobs-toolbar">
                <input type="text" name="search" class="jt-input" placeholder="Search jobs, companies, locations..." value="<?php echo e(request('search')); ?>">
                <select name="type" class="jt-input" onchange="this.form.submit()">
                    <option value="">All Job Types</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type); ?>" <?php echo e(request('type') == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <noscript><button type="submit" class="jt-btn">Search</button></noscript>
            </div>
        </form>

        <?php if($jobs->count()): ?>
            <div class="jcard-grid">
                <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('partials.job-card', ['job' => $job], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($jobs->hasPages()): ?>
                <div class="pagination"><?php echo e($jobs->withQueryString()->links('vendor.pagination.site')); ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <svg width="64" height="64" fill="none" stroke="#9ca3af" stroke-width="1.5"><circle cx="12" cy="7" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/><path d="M10 12l2-2 2 2"/></svg>
                <h3>No jobs found</h3>
                <p>Try adjusting your search or filter criteria.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/jobs/index.blade.php ENDPATH**/ ?>