<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Orders</h1>
        <p>Manage all customer orders.</p>
    </div>

    <?php
        $tabs = [
            '' => 'All',
            'pending' => 'Pending',
            'verified' => 'Verified',
            'delivered' => 'Delivered',
            'rejected' => 'Rejected',
        ];
        $counts = [
            '' => $orders->total(),
        ];
        $statusCounts = App\Models\Order::selectRaw("status, count(*) as total")->groupBy('status')->pluck('total', 'status')->all();
    ?>

    <div class="filter-tabs">
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.orders.index', array_filter(['status' => $value ?: null]))); ?>"
               class="filter-tab <?php echo e(request('status') === $value ? 'active' : ''); ?>">
                <?php echo e($label); ?>

                <?php if($value): ?>
                    <span class="count"><?php echo e($statusCounts[$value] ?? 0); ?></span>
                <?php else: ?>
                    <span class="count"><?php echo e($counts['']); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Sender No</th>
                        <th>Transaction</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="font-weight:500;">#<?php echo e($order->order_id); ?></td>
                            <td><?php echo e(Str::limit($order->product->title ?? 'N/A', 25)); ?></td>
                            <td><?php echo e($order->customer_email); ?></td>
                            <td><?php echo e(number_format($order->amount, 2)); ?></td>
                            <td>
                                <span class="badge badge-secondary"><?php echo e(ucfirst($order->payment_method)); ?></span>
                            </td>
                            <td><?php echo e($order->sender_number); ?></td>
                            <td><?php echo e(Str::limit($order->transaction_id, 15)); ?></td>
                            <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                            <td>
                                <?php
                                    $statusBadges = [
                                        'pending' => 'badge-warning',
                                        'verified' => 'badge-info',
                                        'delivered' => 'badge-success',
                                        'rejected' => 'badge-danger',
                                    ];
                                ?>
                                <span class="badge <?php echo e($statusBadges[$order->status] ?? 'badge-secondary'); ?>"><?php echo e(ucfirst($order->status)); ?></span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-outline">View</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-state-icon">&#9993;</div>
                                    <h3>No orders found</h3>
                                    <p>Orders placed by customers will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($orders->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($orders->links('vendor.pagination.admin')); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/drgroupb/public_html/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>