<div class="section-card">
    <h3>Sales Reports & Analytics</h3>
    <p class="section-desc">Filter sales by date range and calculate total revenue.</p>

    <form method="GET" action="index.php" style="display: flex; gap: 15px; margin-top: 20px; align-items: flex-end;">
        <input type="hidden" name="controller" value="sales">
        <input type="hidden" name="action" value="report">
        <div class="form-group" style="margin-bottom:0;">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date ?? ''); ?>">
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date ?? ''); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
        <a href="index.php?controller=sales&action=report" class="btn" style="background:var(--gray-light);">Reset</a>
    </form>

    <div style="margin-top: 30px; background: var(--bg-cream); padding: 20px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h4 style="font-size: 14px; color: #777;">Total Revenue in Selected Period</h4>
            <h2 style="color: var(--charcoal); font-size: 28px; margin-top: 5px;">LKR <?php echo number_format($totalRevenue, 2); ?></h2>
        </div>
        <div>
            <h4 style="font-size: 14px; color: #777;">Total Transactions</h4>
            <h2 style="color: var(--charcoal); font-size: 28px; margin-top: 5px; text-align: right;"><?php echo count($sales); ?></h2>
        </div>
    </div>

    <div class="table-responsive" style="margin-top: 20px;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Cashier</th>
                    <th>Total Amount (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sales)): ?>
                    <tr><td colspan="5" style="text-align:center;">No sales found for this period.</td></tr>
                <?php else: ?>
                    <?php foreach($sales as $s): ?>
                        <tr>
                            <td>#<?php echo $s['id']; ?></td>
                            <td><?php echo $s['sale_date']; ?></td>
                            <td><?php echo htmlspecialchars($s['customer_name'] ?? 'Walk-in'); ?></td>
                            <td><?php echo htmlspecialchars($s['cashier_name']); ?></td>
                            <td><strong><?php echo number_format($s['total_amount'], 2); ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>