<?php $__env->startSection('title', 'Legal Pages'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header" style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <h1>Legal Pages</h1>
            <p>Manage legal pages like privacy policy, terms, refund policy, etc.</p>
        </div>
        <a href="<?php echo e(route('admin.legal-pages.create')); ?>" class="btn btn-primary">&#43; Add Page</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="font-weight:500;"><?php echo e($page->title); ?></td>
                            <td>
                                <span class="badge badge-secondary">/<?php echo e($page->slug); ?></span>
                            </td>
                            <td>
                                <div class="actions-cell btn-group">
                                    <a href="<?php echo e(route('admin.legal-pages.edit', $page)); ?>" class="btn btn-sm btn-outline">Edit</a>
                                    <form action="<?php echo e(route('admin.legal-pages.destroy', $page)); ?>" method="POST" onsubmit="return deleteConfirm(this)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-state-icon">&#9998;</div>
                                    <h3>No legal pages yet</h3>
                                    <p>Create pages like privacy policy, terms of service, refund policy, etc.</p>
                                    <a href="<?php echo e(route('admin.legal-pages.create')); ?>" class="btn btn-primary btn-sm">Add Page</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/legal-pages/index.blade.php ENDPATH**/ ?>