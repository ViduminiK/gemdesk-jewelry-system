<div class="section-card" style="max-width: 600px; margin: 0 auto;">
    <h3>Edit Customer</h3>
    <p class="section-desc">Update customer contact details.</p>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger" style="margin-top: 15px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="index.php?controller=customer&action=edit&id=<?php echo $customer['id']; ?>" method="POST" style="margin-top: 20px;">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($customer['name']); ?>">
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" required value="<?php echo htmlspecialchars($customer['phone']); ?>">
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($customer['email'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($customer['address'] ?? ''); ?></textarea>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="index.php?controller=customer&action=index" class="btn" style="background:var(--gray-light); color:var(--charcoal); text-decoration:none;">Cancel</a>
        </div>
    </form>
</div>