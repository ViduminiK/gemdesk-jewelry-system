<?php if(!empty($error)): ?>
    <div class="alert alert-danger" style="background:#F2DEDE; color:#A94442; border:1px solid #EBCCD1; padding:12px; border-radius:4px; margin-bottom:20px;"><?php echo $error; ?></div>
<?php endif; ?>

<?php if(!empty($success)): ?>
    <div class="alert alert-success" style="background:#DFF0D8; color:#3C763D; border:1px solid #D6E9C6; padding:12px; border-radius:4px; margin-bottom:20px;"><?php echo $success; ?></div>
<?php endif; ?>

<div class="category-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Category Form -->
    <div class="section-card">
        <h3>Add New Category</h3>
        <p class="section-desc">Create a new jewelry category.</p>
        
        <form action="index.php?controller=category&action=index" method="POST" style="margin-top: 20px;">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Bangles">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Optional description..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
    </div>

    <!-- Category List Table -->
    <div class="section-card">
        <h3>Existing Categories</h3>
        <p class="section-desc">List of all product categories.</p>

        <div class="table-responsive" style="margin-top: 20px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Products</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr><td colspan="4" style="text-align:center;">No categories found.</td></tr>
                    <?php else: ?>
                        <?php foreach($categories as $cat): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($cat['description']); ?></td>
                                <td><?php echo $cat['product_count']; ?></td>
                                <td>
                                    <a href="index.php?controller=category&action=delete&id=<?php echo $cat['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this category?');" style="color:#A94442; text-decoration:none; font-weight:600; font-size:13px;">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>