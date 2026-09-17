<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $isAvailable = ($product->status ?? 'available') === 'available';
?>
<div class="pcard" onclick="openProductModal(<?php echo e($product->id); ?>)">
    <div class="pcard-img">
        <?php if($product->image): ?>
            <img src="<?php echo e(asset('storage/products/' . $product->image)); ?>" alt="<?php echo e($product->title); ?>" loading="lazy">
        <?php else: ?>
            <div class="pcard-placeholder">
                <svg width="48" height="48" fill="none" stroke="#9ca3af" stroke-width="1.5"><rect x="6" y="6" width="36" height="36" rx="4"/><circle cx="18" cy="18" r="4"/><path d="M6 32l10-10 8 8 6-6 12 12"/></svg>
            </div>
        <?php endif; ?>
        <?php if($product->discount_percentage && $product->discount_percentage > 0): ?>
            <span class="pcard-badge">-<?php echo e($product->discount_percentage); ?>%</span>
        <?php endif; ?>
        <?php if(!$isAvailable): ?>
            <span class="pcard-unavailable">Sold Out</span>
        <?php endif; ?>
    </div>
    <div class="pcard-body">
        <h3 class="pcard-title"><?php echo e($product->title); ?></h3>
        <?php if($product->subtitle): ?>
            <p class="pcard-subtitle"><?php echo e(Str::limit($product->subtitle, 60)); ?></p>
        <?php endif; ?>
        <div class="pcard-price">
            <span class="pcard-current">৳<?php echo e(number_format($product->effective_price, 2)); ?></span>
            <?php if($product->old_price && $product->old_price > $product->price): ?>
                <span class="pcard-old">৳<?php echo e(number_format($product->old_price, 2)); ?></span>
            <?php endif; ?>
        </div>
        <button class="pcard-btn" <?php echo e(!$isAvailable ? 'disabled' : ''); ?>>
            <?php echo e($isAvailable ? 'View Product' : 'Unavailable'); ?>

        </button>
    </div>
</div>
<?php /**PATH /home/drgroupb/public_html/resources/views/partials/product-card.blade.php ENDPATH**/ ?>