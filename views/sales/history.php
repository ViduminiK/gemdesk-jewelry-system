<div class="section-card">
    <h3>Sales History</h3>
    <p class="section-desc">View all past transactions and invoices.</p>

    <div class="table-responsive" style="margin-top: 20px;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Date & Time</th>
                    <th>Customer</th>
                    <th>Cashier</th>
                    <th>Total Amount (LKR)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sales)): ?>
                    <tr><td colspan="6" style="text-align:center;">No sales recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach($sales as $s): ?>
                        <tr>
                            <td><strong>#<?php echo $s['id']; ?></strong></td>
                            <td><?php echo $s['sale_date']; ?></td>
                            <td><?php echo htmlspecialchars($s['customer_name'] ?? 'Walk-in Customer'); ?></td>
                            <td><?php echo htmlspecialchars($s['cashier_name']); ?></td>
                            <td><strong><?php echo number_format($s['total_amount'], 2); ?></strong></td>
                            <td>
                                <a href="index.php?controller=sales&action=view&id=<?php echo $s['id']; ?>" style="color:var(--gold-dark); text-decoration:none; font-weight:600;">View Invoice</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>