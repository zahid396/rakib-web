<?php $__env->startSection('title', 'Create Review'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Add New Review</h1>
        <p>Create a customer review.</p>
    </div>

    <form method="POST" action="<?php echo e(route('admin.reviews.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card">
            <div class="card-body">
                <div class="form-section">
                    <h4 class="form-section-title">Review Details</h4>
                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="">Select Product</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" <?php echo e(old('product_id') == $product->id ? 'selected' : ''); ?>><?php echo e($product->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Customer Name <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('customer_name')); ?>" required>
                        <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating <span class="required">*</span></label>
                        <select id="rating" name="rating" class="form-control" required>
                            <option value="">Select Rating</option>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('rating') == $i ? 'selected' : ''); ?>><?php echo e($i); ?> Star<?php echo e($i > 1 ? 's' : ''); ?></option>
                            <?php endfor; ?>
                        </select>
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="review_text">Review Text <span class="required">*</span></label>
                        <textarea id="review_text" name="review_text" class="form-control <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="5" required><?php echo e(old('review_text')); ?></textarea>
                        <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Customer Avatar</h4>
                    <div class="upload-area" onclick="document.getElementById('avatarInput').click()">
                        <div class="upload-icon">&#128100;</div>
                        <p>Click to upload customer avatar</p>
                        <input type="file" id="avatarInput" name="customer_avatar" accept="image/*" class="form-control" onchange="previewImage(this)">
                    </div>
                    <div class="upload-preview">
                        <img id="imagePreview" style="display:none;">
                    </div>
                    <?php $__errorArgs = ['customer_avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Options</h4>
                    <div style="display:flex; gap:2rem; flex-wrap:wrap;">
                        <div class="form-check">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                            <label for="is_featured">Featured</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active') ? 'checked' : 'checked'); ?>>
                            <label for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Review</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/reviews/create.blade.php ENDPATH**/ ?>