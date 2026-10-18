<div class="section-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h3>Customer Directory</h3>
            <p class="section-desc">Manage buyer records and contact details.</p>
        </div>
        <a href="index.php?controller=customer&action=create" class="btn btn-primary">+ Add New Customer</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="index.php" style="display: flex; gap: 15px; margin-bottom: 20px;">
        <input type="hidden" name="controller" value="customer">
        <input type="hidden" name="action" value="index">
        <input type="text" name="search" class="form-control" placeholder="Search by name, phone or email..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="max-width: 350px;">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="index.php?controller=customer&action=index" class="btn" style="background:var(--gray-light);">Reset</a>
    </form>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr><td colspan="5" style="text-align:center;">No customers found.</td></tr>
                <?php else: ?>
                    <?php foreach($customers as $cust): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($cust['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($cust['phone']); ?></td>
                            <td><?php echo htmlspecialchars($cust['email'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($cust['address'] ?? '-'); ?></td>
                            <td>
                                <a href="index.php?controller=customer&action=edit&id=<?php echo $cust['id']; ?>" style="color:var(--gold-dark); text-decoration:none; font-weight:600; margin-right:10px;">Edit</a>
                                <a href="index.php?controller=customer&action=delete&id=<?php echo $cust['id']; ?>" onclick="return confirm('Are you sure you want to delete this customer?');" style="color:#A94442; text-decoration:none; font-weight:600;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>