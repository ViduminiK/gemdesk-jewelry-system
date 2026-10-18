<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'GemDesk'; ?> - Jewelry Shop Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar Navigation -->
        <nav class="sidebar">
            <div class="sidebar-brand">
                <h2>GemDesk</h2>
                <p>Luxury Jewelry</p>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php?controller=dashboard&action=index" class="<?php echo ($controller == 'dashboard') ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="index.php?controller=product&action=index" class="<?php echo ($controller == 'product') ? 'active' : ''; ?>">Products & Inventory</a></li>
                <li><a href="index.php?controller=category&action=index" class="<?php echo ($controller == 'category') ? 'active' : ''; ?>">Categories</a></li>
                <li><a href="index.php?controller=customer&action=index" class="<?php echo ($controller == 'customer') ? 'active' : ''; ?>">Customers</a></li>
                <li><a href="index.php?controller=sales&action=create" class="<?php echo ($controller == 'sales' && $action == 'create') ? 'active' : ''; ?>">POS / New Sale</a></li>
                <li><a href="index.php?controller=sales&action=history" class="<?php echo ($controller == 'sales' && $action == 'history') ? 'active' : ''; ?>">Sales History</a></li>
                <li><a href="index.php?controller=sales&action=report" class="<?php echo ($controller == 'sales' && $action == 'report') ? 'active' : ''; ?>">Sales Reports</a></li>
            </ul>
            <div class="sidebar-footer">
                <p>Logged in as: <strong><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Admin'); ?></strong></p>
                <a href="index.php?controller=auth&action=logout" class="btn-logout">Logout</a>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="top-bar">
                <h3><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h3>
                <span class="date-display"><?php echo date('F j, Y'); ?></span>
            </header>
            <div class="content-body">