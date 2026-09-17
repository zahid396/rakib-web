<?php $__env->startSection('title', 'Banners'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header" style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <h1>Banners</h1>
            <p>Manage homepage banner slides.</p>
        </div>
        <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary">&#43; Add Banner</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Action Type</th>
                        <th>Link Destination</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($banner->isVideo()): ?>
                                    <img src="https://i.ytimg.com/vi/<?php echo e($banner->youtubeId()); ?>/hqdefault.jpg" class="thumb" alt="">
                                <?php elseif($banner->image): ?>
                                    <img src="<?php echo e(asset('storage/banners/' . $banner->image)); ?>" class="thumb" alt="">
                                <?php else: ?>
                                    <div class="thumb thumb-placeholder">&#9654;</div>
                                <?php endif; ?>
                                <div style="margin-top:0.25rem;">
                                    <span class="badge badge-primary" style="font-size:0.65rem;"><?php echo e($banner->isVideo() ? 'VIDEO' : 'IMAGE'); ?></span>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:500;"><?php echo e($banner->title); ?></div>
                                <div style="font-size:0.75rem; color:var(--text-secondary);"><?php echo e(Str::limit($banner->subtitle, 40)); ?></div>
                            </td>
                            <td>
                                <?php
                                    $actionTypes = [
                                        'none' => 'None',
                                        'product' => 'Open Specific Product',
                                        'product_page' => 'Product Details Page',
                                        'external_url' => 'External URL',
                                    ];
                                ?>
                                <span class="badge badge-primary"><?php echo e($actionTypes[$banner->action_type] ?? $banner->action_type); ?></span>
                            </td>
                            <td>
                                <?php if($banner->action_type == 'product' && $banner->actionProduct): ?>
                                    <a href="<?php echo e(route('products.show', $banner->actionProduct->slug)); ?>" target="_blank"><?php echo e($banner->actionProduct->title); ?></a>
                                <?php elseif($banner->action_type == 'product_page' && $banner->action_product_id): ?>
                                    Product #<?php echo e($banner->action_product_id); ?>

                                <?php elseif($banner->action_type == 'external_url'): ?>
                                    <a href="<?php echo e($banner->action_url); ?>" target="_blank"><?php echo e(Str::limit($banner->action_url, 40)); ?></a>
                                <?php else: ?>
                                    <span style="color:var(--text-secondary);">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <label class="toggle">
                                    <input type="checkbox"
                                           <?php echo e($banner->is_active ? 'checked' : ''); ?>

                                           onchange="toggleActive(this)"
                                           data-url="<?php echo e(route('admin.banners.toggle', $banner)); ?>">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                            <td><?php echo e($banner->sort_order); ?></td>
                            <td>
                                <div class="actions-cell btn-group">
                                    <a href="<?php echo e(route('admin.banners.edit', $banner)); ?>" class="btn btn-sm btn-outline">Edit</a>
                                    <form action="<?php echo e(route('admin.banners.destroy', $banner)); ?>" method="POST" onsubmit="return deleteConfirm(this)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-state-icon">&#9654;</div>
                                    <h3>No banners found</h3>
                                    <p>Create your first homepage banner.</p>
                                    <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary btn-sm">Add Banner</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/banners/index.blade.php ENDPATH**/ ?>