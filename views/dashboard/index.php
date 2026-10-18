<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Products</h4>
            <h2><?php echo $totalProducts; ?></h2>
        </div>
        <div class="stat-icon gold-bg">💎</div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Customers</h4>
            <h2><?php echo $totalCustomers; ?></h2>
        </div>
        <div class="stat-icon gold-bg">👥</div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h4>Sales Today</h4>
            <h2>LKR <?php echo number_format($salesToday, 2); ?></h2>
        </div>
        <div class="stat-icon gold-bg">💰</div>
    </div>
</div>

<div class="section-card" style="margin-top: 30px;">
    <h3>Low Stock Alerts</h3>
    <p class="section-desc">Products that have reached or fallen below their minimum stock threshold.</p>

    <?php if (empty($lowStockProducts)): ?>
        <p class="text-success" style="padding: 20px 0;">All inventory stock levels are healthy.</p>
    <?php else: ?>
        <div class="table-responsive" style="margin-top: 15px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Min Stock Level</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowStockProducts as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['sku']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><strong><?php echo $product['stock_quantity']; ?></strong></td>
                            <td><?php echo $product['min_stock_level']; ?></td>
                            <td><span class="badge badge-danger">Low Stock</span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>