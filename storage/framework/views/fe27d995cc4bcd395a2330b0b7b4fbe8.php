<?php $__env->startSection('title', 'Reviews'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header" style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <h1>Reviews</h1>
            <p>Manage customer reviews and testimonials.</p>
        </div>
        <a href="<?php echo e(route('admin.reviews.create')); ?>" class="btn btn-primary">&#43; Add Review</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($review->customer_avatar): ?>
                                    <img src="<?php echo e(asset('storage/reviews/' . $review->customer_avatar)); ?>" class="thumb thumb-sm">
                                <?php else: ?>
                                    <div class="thumb thumb-sm thumb-placeholder"><?php echo e(strtoupper(substr($review->customer_name, 0, 1))); ?></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight:500;"><?php echo e($review->customer_name); ?></td>
                            <td><?php echo e(Str::limit($review->product->title ?? 'N/A', 30)); ?></td>
                            <td>
                                <div class="stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?php echo e($i <= $review->rating ? 'filled' : ''); ?>">&#9733;</span>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td><?php echo e(Str::limit($review->review_text, 60)); ?></td>
                            <td>
                                <label class="toggle">
                                    <input type="checkbox"
                                           <?php echo e($review->is_featured ? 'checked' : ''); ?>

                                           onchange="toggleActive(this)"
                                           data-url="<?php echo e(route('admin.reviews.feature', $review)); ?>">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                            <td>
                                <label class="toggle">
                                    <input type="checkbox"
                                           <?php echo e($review->is_active ? 'checked' : ''); ?>

                                           onchange="toggleActive(this)"
                                           data-url="<?php echo e(route('admin.reviews.toggle', $review)); ?>">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                            <td>
                                <div class="actions-cell btn-group">
                                    <a href="<?php echo e(route('admin.reviews.edit', $review)); ?>" class="btn btn-sm btn-outline">Edit</a>
                                    <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="POST" onsubmit="return deleteConfirm(this)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-state-icon">&#9734;</div>
                                    <h3>No reviews found</h3>
                                    <p>Add customer reviews to increase trust and conversions.</p>
                                    <a href="<?php echo e(route('admin.reviews.create')); ?>" class="btn btn-primary btn-sm">Add Review</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($reviews->hasPages()): ?>
            <?php echo e($reviews->links('vendor.pagination.admin')); ?>

        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/reviews/index.blade.php ENDPATH**/ ?>