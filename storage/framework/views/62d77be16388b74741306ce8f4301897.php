<?php $__env->startSection('title', 'Social Links'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Social Links</h1>
        <p>Manage your social media and contact links.</p>
    </div>

    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header">
            <h3>Add New Social Link</h3>
        </div>
        <form method="POST" action="<?php echo e(route('admin.social-links.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="platform">Platform</label>
                        <select id="platform" name="platform" class="form-control" required>
                            <option value="">Select Platform</option>
                            <?php $__currentLoopData = ['facebook', 'whatsapp', 'messenger', 'telegram', 'instagram', 'tiktok', 'youtube', 'twitter', 'linkedin', 'email']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p); ?>" <?php echo e(old('platform') == $p ? 'selected' : ''); ?>><?php echo e(ucfirst($p === 'twitter' ? 'X (Twitter)' : $p)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['platform'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="label">Label</label>
                        <input type="text" id="label" name="label" class="form-control <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('label')); ?>" placeholder="e.g. Facebook Page">
                        <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="url" id="url" name="url" class="form-control <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('url')); ?>" placeholder="https://...">
                        <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="form-check" style="margin-bottom:0;">
                    <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active') ? 'checked' : 'checked'); ?>>
                    <label for="is_active">Active</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add Link</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Existing Links (<?php echo e($socialLinks->count()); ?>)</h3>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Sort</th>
                        <th>Platform</th>
                        <th>Label</th>
                        <th>URL</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $socialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="actions-cell" style="white-space:nowrap;">
                                    <button class="btn btn-sm btn-outline" title="Move Up" onclick="reorderSocial(this, '<?php echo e($link->id); ?>', -1)">&#8593;</button>
                                    <button class="btn btn-sm btn-outline" title="Move Down" onclick="reorderSocial(this, '<?php echo e($link->id); ?>', 1)">&#8595;</button>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-primary"><?php echo e($link->platform); ?></span>
                            </td>
                            <td style="font-weight:500;"><?php echo e($link->label ?? '-'); ?></td>
                            <td>
                                <?php if($link->url): ?>
                                    <a href="<?php echo e($link->url); ?>" target="_blank" style="font-size:0.8125rem;"><?php echo e(Str::limit($link->url, 40)); ?></a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <label class="toggle">
                                    <input type="checkbox"
                                           <?php echo e($link->is_active ? 'checked' : ''); ?>

                                           onchange="toggleActive(this)"
                                           data-url="<?php echo e(route('admin.social-links.toggle', $link)); ?>">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                            <td>
                                <div class="actions-cell btn-group">
                                    <button class="btn btn-sm btn-outline" onclick="openEditModal('<?php echo e($link->id); ?>')">Edit</button>
                                    <form action="<?php echo e(route('admin.social-links.destroy', $link)); ?>" method="POST" onsubmit="return deleteConfirm(this)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">&#9742;</div>
                                    <h3>No social links</h3>
                                    <p>Add your social media links using the form above.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $__currentLoopData = $socialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal-overlay" id="editModal<?php echo e($link->id); ?>">
            <div class="modal">
                <div class="modal-header">
                    <h3>Edit Social Link</h3>
                    <button class="modal-close" onclick="closeModal('editModal<?php echo e($link->id); ?>')">&times;</button>
                </div>
                <form method="POST" action="<?php echo e(route('admin.social-links.update', $link)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_platform<?php echo e($link->id); ?>">Platform</label>
                            <select id="edit_platform<?php echo e($link->id); ?>" name="platform" class="form-control" required>
                                <?php $__currentLoopData = ['facebook', 'whatsapp', 'messenger', 'telegram', 'instagram', 'tiktok', 'youtube', 'twitter', 'linkedin', 'email']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p); ?>" <?php echo e($link->platform == $p ? 'selected' : ''); ?>><?php echo e(ucfirst($p === 'twitter' ? 'X (Twitter)' : $p)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_label<?php echo e($link->id); ?>">Label</label>
                            <input type="text" id="edit_label<?php echo e($link->id); ?>" name="label" class="form-control" value="<?php echo e($link->label); ?>">
                        </div>
                        <div class="form-group">
                            <label for="edit_url<?php echo e($link->id); ?>">URL</label>
                            <input type="url" id="edit_url<?php echo e($link->id); ?>" name="url" class="form-control" value="<?php echo e($link->url); ?>">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="edit_active<?php echo e($link->id); ?>" name="is_active" value="1" <?php echo e($link->is_active ? 'checked' : ''); ?>>
                            <label for="edit_active<?php echo e($link->id); ?>">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('editModal<?php echo e($link->id); ?>')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function openEditModal(id) {
        document.getElementById('editModal' + id).classList.add('active');
    }

    function reorderSocial(el, id, dir) {
        const row = el.closest('tr');
        if (dir === -1 && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
        } else if (dir === 1 && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
        }
        const rows = document.querySelectorAll('tbody tr');
        const items = Array.from(rows).map((r, i) => ({
            id: r.querySelector('button[onclick*="reorderSocial"]').getAttribute('onclick').match(/'(\d+)'/)[1],
            sort_order: i
        }));
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('<?php echo e(route("admin.social-links.reorder")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ items })
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/social-links/index.blade.php ENDPATH**/ ?>