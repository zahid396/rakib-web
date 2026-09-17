<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Categories</h1>
        <p>Organize your products into categories.</p>
    </div>

    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header">
            <h3>Add New Category</h3>
        </div>
        <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name')); ?>" required oninput="generateSlug(this)">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug <span class="required">*</span></label>
                        <input type="text" id="slug" name="slug" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('slug')); ?>" required>
                        <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-check" style="margin-bottom:0;">
                    <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active') ? 'checked' : 'checked'); ?>>
                    <label for="is_active">Active</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Existing Categories (<?php echo e($categories->count()); ?>)</h3>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Sort</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Products</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="actions-cell" style="white-space:nowrap;">
                                    <button class="btn btn-sm btn-outline" title="Move Up" onclick="reorderCategory(this, '<?php echo e($category->id); ?>', -1)">&#8593;</button>
                                    <button class="btn btn-sm btn-outline" title="Move Down" onclick="reorderCategory(this, '<?php echo e($category->id); ?>', 1)">&#8595;</button>
                                </div>
                            </td>
                            <td style="font-weight:500;"><?php echo e($category->name); ?></td>
                            <td>
                                <span class="badge badge-secondary">/<?php echo e($category->slug); ?></span>
                            </td>
                            <td><?php echo e(Str::limit($category->description, 40)); ?></td>
                            <td><?php echo e($category->products_count ?? $category->products->count()); ?></td>
                            <td>
                                <label class="toggle">
                                    <input type="checkbox"
                                           <?php echo e($category->is_active ? 'checked' : ''); ?>

                                           onchange="toggleActive(this)"
                                           data-url="<?php echo e(route('admin.categories.toggle', $category)); ?>">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                            <td>
                                <div class="actions-cell btn-group">
                                    <button class="btn btn-sm btn-outline" onclick="openEditModal('<?php echo e($category->id); ?>')">Edit</button>
                                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" onsubmit="return deleteConfirm(this)">
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
                                    <div class="empty-state-icon">&#9776;</div>
                                    <h3>No categories yet</h3>
                                    <p>Create categories to organize your products.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal-overlay" id="editModal<?php echo e($category->id); ?>">
            <div class="modal">
                <div class="modal-header">
                    <h3>Edit Category</h3>
                    <button class="modal-close" onclick="closeModal('editModal<?php echo e($category->id); ?>')">&times;</button>
                </div>
                <form method="POST" action="<?php echo e(route('admin.categories.update', $category)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name<?php echo e($category->id); ?>">Name</label>
                            <input type="text" id="edit_name<?php echo e($category->id); ?>" name="name" class="form-control" value="<?php echo e($category->name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_slug<?php echo e($category->id); ?>">Slug</label>
                            <input type="text" id="edit_slug<?php echo e($category->id); ?>" name="slug" class="form-control" value="<?php echo e($category->slug); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description<?php echo e($category->id); ?>">Description</label>
                            <textarea id="edit_description<?php echo e($category->id); ?>" name="description" class="form-control" rows="3"><?php echo e($category->description); ?></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="edit_active<?php echo e($category->id); ?>" name="is_active" value="1" <?php echo e($category->is_active ? 'checked' : ''); ?>>
                            <label for="edit_active<?php echo e($category->id); ?>">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('editModal<?php echo e($category->id); ?>')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function generateSlug(input) {
        const slug = input.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    }

    function openEditModal(id) {
        document.getElementById('editModal' + id).classList.add('active');
    }

    function reorderCategory(el, id, dir) {
        const row = el.closest('tr');
        if (dir === -1 && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
        } else if (dir === 1 && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
        }
        const rows = document.querySelectorAll('tbody tr');
        const items = Array.from(rows).map((r, i) => ({
            id: r.querySelector('button[onclick*="reorderCategory"]').getAttribute('onclick').match(/'(\d+)'/)[1],
            sort_order: i
        }));
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('<?php echo e(route("admin.categories.reorder")); ?>', {
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>