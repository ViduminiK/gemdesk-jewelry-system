<div class="section-card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--gold); padding-bottom: 15px; margin-bottom: 20px;">
        <div>
            <h2>GemDesk Luxury Jewelry</h2>
            <p style="font-size:13px; color:#777;">Official Sales Invoice</p>
        </div>
        <div style="text-align: right;">
            <h3>Invoice #<?php echo $sale['id']; ?></h3>
            <p style="font-size:13px; color:#777;"><?php echo $sale['sale_date']; ?></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; font-size: 14px;">
        <div>
            <strong>Customer Details:</strong><br>
            Name: <?php echo htmlspecialchars($sale['customer_name'] ?? 'Walk-in Customer'); ?><br>
            Phone: <?php echo htmlspecialchars($sale['customer_phone'] ?? '-'); ?><br>
            Address: <?php echo htmlspecialchars($sale['customer_address'] ?? '-'); ?>
        </div>
        <div>
            <strong>Processed By:</strong><br>
            Cashier: <?php echo htmlspecialchars($sale['cashier_name']); ?><br>
            Status: <span style="color:var(--success); font-weight:600;">Paid & Completed</span>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Unit Price (LKR)</th>
                <th>Subtotal (LKR)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['sku']); ?></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['unit_price'], 2); ?></td>
                    <td><strong><?php echo number_format($item['subtotal'], 2); ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 20px; font-size: 18px;">
        <strong>Total Amount: LKR <?php echo number_format($sale['total_amount'], 2); ?></strong>
    </div>

    <div style="margin-top: 40px; display: flex; gap: 10px;">
        <a href="index.php?controller=sales&action=history" class="btn" style="background:var(--gray-light); color:var(--charcoal); text-decoration:none;">Back to Sales History</a>
        <button onclick="window.print();" class="btn btn-primary">Print Invoice</button>
    </div>
</div>