<?php $__env->startSection('title', 'Create Banner'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Add New Banner</h1>
        <p>Create a new homepage banner.</p>
    </div>

    <form method="POST" action="<?php echo e(route('admin.banners.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card">
            <div class="card-body">
                <div class="form-section">
                    <h4 class="form-section-title">Banner Text <span style="font-weight:400; font-size:0.75rem; color:var(--text-secondary);">(optional)</span></h4>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title')); ?>" placeholder="Optional - shown over the banner">
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('subtitle')); ?>" placeholder="Optional - shown under the title">
                        <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="button_text">Button Text</label>
                        <input type="text" id="button_text" name="button_text" class="form-control <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('button_text')); ?>" placeholder="Optional - e.g. Buy Now">
                        <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div style="font-size:0.75rem; color:var(--text-secondary); margin-top:0.375rem;">Banners look great with or without text. The whole image is clickable when a target is set.</div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Banner Media</h4>
                    <div class="form-group">
                        <label>Media Type</label>
                        <div style="display:flex; flex-wrap:wrap; gap:1.5rem; margin-top:0.375rem;">
                            <label class="form-check">
                                <input type="radio" name="media_type" value="image" <?php echo e(old('media_type', 'image') == 'image' ? 'checked' : ''); ?> onchange="toggleMediaField()">
                                <span>Uploaded Image</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="media_type" value="youtube" <?php echo e(old('media_type') == 'youtube' ? 'checked' : ''); ?> onchange="toggleMediaField()">
                                <span>YouTube Video</span>
                            </label>
                        </div>
                        <?php $__errorArgs = ['media_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div id="imageMediaBlock">
                        <div class="upload-area" onclick="document.getElementById('imageInput').click()">
                            <div class="upload-icon">&#128444;</div>
                            <p>Click to upload banner image</p>
                            <input type="file" id="imageInput" name="image" accept="image/*" class="form-control" onchange="previewImage(this)">
                        </div>
                        <div class="upload-preview">
                            <img id="imagePreview" style="display:none;">
                        </div>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div id="videoMediaBlock" style="display:none;">
                        <div class="form-group">
                            <label for="video_url">YouTube Video URL</label>
                            <input type="url" id="video_url" name="video_url" class="form-control <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('video_url')); ?>" placeholder="https://www.youtube.com/watch?v=VIDEO_ID">
                            <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div style="font-size:0.75rem; color:var(--text-secondary); margin-top:0.375rem;">Visitors click the thumbnail to play the video directly on your website. The video must be public and allow embedding on other sites.</div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Click Action <span style="font-weight:400; font-size:0.75rem; color:var(--text-secondary);">(optional)</span></h4>
                    <div class="form-group">
                        <label>Action Type</label>
                        <div style="display:flex; flex-wrap:wrap; gap:1.5rem; margin-top:0.375rem;">
                            <label class="form-check">
                                <input type="radio" name="action_type" value="none" <?php echo e(old('action_type', 'none') == 'none' ? 'checked' : ''); ?> onchange="toggleActionFields()">
                                <span>None</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="action_type" value="product" <?php echo e(old('action_type') == 'product' ? 'checked' : ''); ?> onchange="toggleActionFields()">
                                <span>Open Specific Product</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="action_type" value="product_page" <?php echo e(old('action_type') == 'product_page' ? 'checked' : ''); ?> onchange="toggleActionFields()">
                                <span>Product Details Page</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="action_type" value="external_url" <?php echo e(old('action_type') == 'external_url' ? 'checked' : ''); ?> onchange="toggleActionFields()">
                                <span>External URL</span>
                            </label>
                        </div>
                        <?php $__errorArgs = ['action_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div style="font-size:0.75rem; color:var(--text-secondary); margin-top:0.375rem;">Visitors can click anywhere on the banner image to be taken to this destination.</div>
                    </div>
                    <div class="form-group" id="productSelect" style="display:none;">
                        <label for="action_product_id">Select Product</label>
                        <select id="action_product_id" name="action_product_id" class="form-control">
                            <option value="">Select Product</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" <?php echo e(old('action_product_id') == $product->id ? 'selected' : ''); ?>><?php echo e($product->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['action_product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group" id="externalUrlField" style="display:none;">
                        <label for="action_url">External URL</label>
                        <input type="url" id="action_url" name="action_url" class="form-control <?php $__errorArgs = ['action_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('action_url')); ?>" placeholder="https://example.com">
                        <?php $__errorArgs = ['action_url'];
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
                    <h4 class="form-section-title">Options</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" id="sort_order" name="sort_order" min="0" class="form-control" value="<?php echo e(old('sort_order', 0)); ?>">
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active') ? 'checked' : 'checked'); ?>>
                        <label for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Banner</button>
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

    function toggleMediaField() {
        const checked = document.querySelector('input[name="media_type"]:checked');
        const isVideo = checked && checked.value === 'youtube';
        document.getElementById('imageMediaBlock').style.display = isVideo ? 'none' : 'block';
        document.getElementById('videoMediaBlock').style.display = isVideo ? 'block' : 'none';
    }

    function toggleActionFields() {
        const checked = document.querySelector('input[name="action_type"]:checked');
        if (!checked) return;
        const value = checked.value;
        document.getElementById('productSelect').style.display = value === 'product' ? 'block' : 'none';
        document.getElementById('externalUrlField').style.display = value === 'external_url' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleMediaField();
        toggleActionFields();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/banners/create.blade.php ENDPATH**/ ?>