<?php if(isset($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger" style="margin-bottom: 20px;">
        <?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
    </div>
<?php endif; ?>

<div class="section-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h3>Product Inventory</h3>
            <p class="section-desc">Manage jewelry stock, prices, and search products.</p>
        </div>
        <a href="index.php?controller=product&action=create" class="btn btn-primary">+ Add New Product</a>
    </div>

    <!-- Search & Filter Form -->
    <form method="GET" action="index.php" style="display: flex; gap: 15px; margin-bottom: 20px;">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="index">
        <input type="text" name="search" class="form-control" placeholder="Search by name or SKU..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="max-width: 300px;">
        <select name="category_id" class="form-control" style="max-width: 200px;">
            <option value="">All Categories</option>
            <?php foreach($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo (isset($category_id) && $category_id == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="index.php?controller=product&action=index" class="btn" style="background:var(--gray-light);">Reset</a>
    </form>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price (LKR)</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr><td colspan="6" style="text-align:center;">No products found.</td></tr>
                <?php else: ?>
                    <?php foreach($products as $prod): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prod['sku']); ?></td>
                            <td><strong><?php echo htmlspecialchars($prod['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($prod['category_name']); ?></td>
                            <td><?php echo number_format($prod['price'], 2); ?></td>
                            <td>
                                <?php echo $prod['stock_quantity']; ?>
                                <?php if($prod['stock_quantity'] <= $prod['min_stock_level']): ?>
                                    <span class="badge badge-danger">Low</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?controller=product&action=edit&id=<?php echo $prod['id']; ?>" style="color:var(--gold-dark); text-decoration:none; font-weight:600; margin-right:10px;">Edit</a>
                                <a href="index.php?controller=product&action=delete&id=<?php echo $prod['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" style="color:#A94442; text-decoration:none; font-weight:600;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>