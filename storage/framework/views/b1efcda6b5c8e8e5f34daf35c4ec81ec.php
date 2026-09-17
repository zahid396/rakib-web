<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header" style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <h1>Products</h1>
            <p>Manage all your digital products.</p>
        </div>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">&#43; Add Product</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="filter-bar">
                <input type="text" name="search" class="form-control" placeholder="Search by title or subtitle..." value="<?php echo e(request('search')); ?>" style="flex:1; min-width:200px;">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="available" <?php echo e(request('status') == 'available' ? 'selected' : ''); ?>>Available</option>
                    <option value="coming_soon" <?php echo e(request('status') == 'coming_soon' ? 'selected' : ''); ?>>Coming Soon</option>
                    <option value="sold_out" <?php echo e(request('status') == 'sold_out' ? 'selected' : ''); ?>>Sold Out</option>
                    <option value="hidden" <?php echo e(request('status') == 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <?php if(request('search') || request('status')): ?>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline btn-sm">Clear</a>
                <?php endif; ?>
            </form>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Active</th>
                            <th>Sort</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php if($product->image): ?>
                                        <img src="<?php echo e(asset('storage/products/' . $product->image)); ?>" class="thumb">
                                    <?php else: ?>
                                        <div class="thumb thumb-placeholder">&#9679;</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-weight:500;"><?php echo e($product->title); ?></div>
                                    <div style="font-size:0.75rem; color:var(--text-secondary);"><?php echo e(Str::limit($product->subtitle, 40)); ?></div>
                                </td>
                                <td>
                                    <div><?php echo e(number_format($product->price, 2)); ?></div>
                                    <?php if($product->old_price && $product->old_price > $product->price): ?>
                                        <div style="font-size:0.75rem; color:var(--text-secondary); text-decoration:line-through;">
                                            <?php echo e(number_format($product->old_price, 2)); ?>

                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $statusBadges = [
                                            'available' => 'badge-success',
                                            'coming_soon' => 'badge-info',
                                            'sold_out' => 'badge-warning',
                                            'hidden' => 'badge-secondary',
                                        ];
                                    ?>
                                    <span class="badge <?php echo e($statusBadges[$product->status] ?? 'badge-secondary'); ?>">
                                        <?php echo e(ucwords(str_replace('_', ' ', $product->status))); ?>

                                    </span>
                                </td>
                                <td>
                                    <label class="toggle">
                                        <input type="checkbox"
                                               <?php echo e($product->is_active ? 'checked' : ''); ?>

                                               onchange="toggleActive(this)"
                                               data-url="<?php echo e(route('admin.products.toggle', $product)); ?>">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td><?php echo e($product->sort_order); ?></td>
                                <td>
                                    <div class="actions-cell btn-group">
                                        <button class="btn btn-sm btn-outline" onclick="openModal('previewModal<?php echo e($product->id); ?>')">View</button>
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-outline">Edit</a>
                                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" onsubmit="return deleteConfirm(this)">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal-overlay" id="previewModal<?php echo e($product->id); ?>">
                                <div class="modal">
                                    <div class="modal-header">
                                        <h3><?php echo e($product->title); ?></h3>
                                        <button class="modal-close" onclick="closeModal('previewModal<?php echo e($product->id); ?>')">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="display:flex; gap:1rem; align-items:flex-start;">
                                            <?php if($product->image): ?>
                                                <img src="<?php echo e(asset('storage/products/' . $product->image)); ?>" style="width:100px; height:100px; object-fit:cover; border-radius:var(--radius); border:1px solid var(--border);">
                                            <?php endif; ?>
                                            <div style="flex:1;">
                                                <h4 style="font-size:1rem; margin-bottom:0.5rem;"><?php echo e($product->title); ?></h4>
                                                <p style="font-size:0.8125rem; color:var(--text-secondary); margin-bottom:0.5rem;"><?php echo e($product->subtitle); ?></p>
                                                <span class="badge <?php echo e($statusBadges[$product->status] ?? 'badge-secondary'); ?>"><?php echo e(ucwords(str_replace('_', ' ', $product->status))); ?></span>
                                            </div>
                                        </div>
                                        <hr style="border:none; border-top:1px solid var(--border); margin:1rem 0;">
                                        <p style="font-size:0.875rem; color:var(--text-secondary);"><?php echo e($product->description); ?></p>
                                        <?php if($product->features): ?>
                                            <hr style="border:none; border-top:1px solid var(--border); margin:1rem 0;">
                                            <h4 style="font-size:0.8125rem; font-weight:600; margin-bottom:0.5rem;">Features</h4>
                                            <ul style="font-size:0.8125rem; color:var(--text-secondary); padding-left:1.25rem;">
                                                <?php $__currentLoopData = $product->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($feature); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-primary btn-sm">Edit</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">&#9733;</div>
                                        <h3>No products found</h3>
                                        <p>Start by adding your first digital product.</p>
                                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-sm">Add Product</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($products->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($products->links('vendor.pagination.admin')); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/products/index.blade.php ENDPATH**/ ?>