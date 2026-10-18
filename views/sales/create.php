<div class="section-card">
    <h3>Point of Sale (POS) Checkout</h3>
    <p class="section-desc">Select customer and add jewelry items to complete transaction.</p>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger" style="margin-top: 15px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="index.php?controller=sales&action=create" method="POST" style="margin-top: 20px;">
        <div class="form-group" style="max-width: 400px;">
            <label>Customer (Optional)</label>
            <select name="customer_id" class="form-control">
                <option value="">Walk-in Customer</option>
                <?php foreach($customers as $cust): ?>
                    <option value="<?php echo $cust['id']; ?>"><?php echo htmlspecialchars($cust['name'] . ' (' . $cust['phone'] . ')'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <h4 style="margin-top: 30px; margin-bottom: 15px; font-size:16px;">Sale Items</h4>
        
        <div id="cart-items">
            <div class="cart-row" style="display: flex; gap: 15px; margin-bottom: 15px; align-items: center;">
                <select name="product_ids[]" class="form-control" required style="flex: 2;">
                    <option value="">Select Product...</option>
                    <?php foreach($products as $prod): ?>
                        <option value="<?php echo $prod['id']; ?>">
                            <?php echo htmlspecialchars($prod['name'] . ' (SKU: ' . $prod['sku'] . ') - LKR ' . number_format($prod['price'], 2) . ' [Stock: ' . $prod['stock_quantity'] . ']'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="quantities[]" class="form-control" value="1" min="1" required style="flex: 0 0 120px;" placeholder="Qty">
                <button type="button" class="btn" onclick="removeRow(this)" style="background:#F2DEDE; color:#A94442;">Remove</button>
            </div>
        </div>

        <button type="button" class="btn" onclick="addRow()" style="background:var(--gray-light); margin-top: 10px;">+ Add Another Item</button>

        <div style="margin-top: 30px; border-top: 1px solid var(--gray-light); padding-top: 20px;">
            <button type="submit" class="btn btn-primary" style="padding: 14px 30px; font-size: 16px;">Complete Checkout & Generate Invoice</button>
        </div>
    </form>
</div>

<script>
function addRow() {
    const container = document.getElementById('cart-items');
    const firstRow = container.querySelector('.cart-row');
    const newRow = firstRow.cloneNode(true);
    newRow.querySelector('select').value = '';
    newRow.querySelector('input').value = '1';
    container.appendChild(newRow);
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.cart-row');
    if (rows.length > 1) {
        btn.closest('.cart-row').remove();
    } else {
        alert('At least one item is required.');
    }
}
</script>