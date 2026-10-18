<div class="section-card" style="max-width: 600px; margin: 0 auto;">
    <h3>Edit Product</h3>
    <p class="section-desc">Update jewelry specifications and pricing.</p>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger" style="margin-top: 15px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" method="POST" style="margin-top: 20px;">
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <?php foreach($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo ($product['category_id'] == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="form-group">
            <label>SKU (Unique Code)</label>
            <input type="text" name="sku" class="form-control" required value="<?php echo htmlspecialchars($product['sku']); ?>">
        </div>
        <div class="form-group">
            <label>Price (LKR)</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="<?php echo $product['price']; ?>">
        </div>
        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" required value="<?php echo $product['stock_quantity']; ?>">
        </div>
        <div class="form-group">
            <label>Minimum Stock Level</label>
            <input type="number" name="min_stock_level" class="form-control" required value="<?php echo $product['min_stock_level']; ?>">
        </div>
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="index.php?controller=product&action=index" class="btn" style="background:var(--gray-light); color:var(--charcoal); text-decoration:none;">Cancel</a>
        </div>
    </form>
</div>