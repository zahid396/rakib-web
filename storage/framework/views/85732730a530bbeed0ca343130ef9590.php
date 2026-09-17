<?php $__env->startSection('title', 'Payment Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Payment Settings</h1>
        <p>Configure your payment methods for checkout.</p>
    </div>

    <?php
        $methods = [
            'bkash' => ['label' => 'bKash', 'color' => 'danger'],
            'nagad' => ['label' => 'Nagad', 'color' => 'warning'],
        ];
    ?>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap:1.5rem;">
        <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $setting = $key == 'bkash' ? $bkash : $nagad;
                $isActive = $setting && $setting->is_active;
            ?>
            <div class="card">
                <div class="card-header">
                    <h3><?php echo e($method['label']); ?> Settings</h3>
                    <label class="toggle">
                        <input type="checkbox" name="<?php echo e($key); ?>_is_active" value="1"
                               <?php echo e($isActive ? 'checked' : ''); ?>

                               onchange="togglePaymentActive(this, '<?php echo e($key); ?>')"
                               data-url="<?php echo e(route('admin.payment-settings.toggle', $key)); ?>">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <form method="POST" action="<?php echo e(route('admin.payment-settings.update', $key)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="<?php echo e($key); ?>_number"><?php echo e($method['label']); ?> Number</label>
                            <input type="text" id="<?php echo e($key); ?>_number" name="number" class="form-control" value="<?php echo e(old('number', $setting->number ?? '')); ?>" placeholder="01XXX-XXXXXX" required>
                        </div>
                        <div class="form-group">
                            <label for="<?php echo e($key); ?>_account_type">Account Type</label>
                            <input type="text" id="<?php echo e($key); ?>_account_type" name="account_type" class="form-control" value="<?php echo e(old('account_type', $setting->account_type ?? '')); ?>" placeholder="e.g. Personal / Agent / Merchant">
                        </div>
                        <div class="form-group">
                            <label for="<?php echo e($key); ?>_instructions">Payment Instructions</label>
                            <textarea id="<?php echo e($key); ?>_instructions" name="instructions" class="form-control" rows="3"><?php echo e(old('instructions', $setting->instructions ?? '')); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>QR Code Image</label>
                            <?php if($setting && $setting->qr_image): ?>
                                <div style="margin-bottom:0.75rem;">
                                    <img src="<?php echo e(asset('storage/payments/' . $setting->qr_image)); ?>" style="width:120px; height:120px; object-fit:contain; border:1px solid var(--border); border-radius:var(--radius); background:#fff;">
                                </div>
                            <?php endif; ?>
                            <div class="upload-area" onclick="document.getElementById('<?php echo e($key); ?>QrInput').click()">
                                <div class="upload-icon">&#128444;</div>
                                <p>Click to upload <?php echo e($method['label']); ?> QR code</p>
                                <input type="file" id="<?php echo e($key); ?>QrInput" name="qr_image" accept="image/*" class="form-control" onchange="previewQr(this, '<?php echo e($key); ?>')">
                            </div>
                            <div class="upload-preview">
                                <img id="<?php echo e($key); ?>QrPreview" style="display:none;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Payment Method Logo</label>
                            <?php if($setting && $setting->logo): ?>
                                <div style="margin-bottom:0.75rem;">
                                    <img src="<?php echo e(asset('storage/payments/' . $setting->logo)); ?>" style="max-height:56px; object-fit:contain; border:1px solid var(--border); border-radius:var(--radius); padding:0.25rem; background:#fff;">
                                </div>
                            <?php endif; ?>
                            <div class="upload-area" onclick="document.getElementById('<?php echo e($key); ?>LogoInput').click()">
                                <div class="upload-icon">&#128444;</div>
                                <p>Click to upload <?php echo e($method['label']); ?> logo</p>
                                <input type="file" id="<?php echo e($key); ?>LogoInput" name="logo" accept="image/*" class="form-control" onchange="previewLogo(this, '<?php echo e($key); ?>')">
                            </div>
                            <div class="upload-preview">
                                <img id="<?php echo e($key); ?>LogoPreview" style="display:none;">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save <?php echo e($method['label']); ?> Settings</button>
                    </div>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewQr(input, key) {
        const preview = document.getElementById(key + 'QrPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                preview.style.width = '120px';
                preview.style.height = '120px';
                preview.style.objectFit = 'contain';
                preview.style.border = '1px solid var(--border)';
                preview.style.borderRadius = 'var(--radius)';
                preview.style.background = '#fff';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewLogo(input, key) {
        const preview = document.getElementById(key + 'LogoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                preview.style.maxHeight = '56px';
                preview.style.objectFit = 'contain';
                preview.style.border = '1px solid var(--border)';
                preview.style.borderRadius = 'var(--radius)';
                preview.style.padding = '0.25rem';
                preview.style.background = '#fff';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePaymentActive(el, method) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = el.dataset.url;
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                el.checked = data.is_active;
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/payment-settings/index.blade.php ENDPATH**/ ?>