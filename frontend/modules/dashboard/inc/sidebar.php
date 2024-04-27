<?php
    // TODO: Set activate sidebar menu link

?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="?module=dashboard&view=dashboard.view">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?module=dashboard&view=order.view">
                    <span data-feather="file"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?module=dashboard&view=product.view">
                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?module=dashboard&view=inventory.view">
                    <span data-feather="archive"></span>
                    Inventory
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?module=dashboard&view=account.view">
                    <span data-feather="users"></span>
                    Accounts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?module=dashboard&view=permission.view">
                    <span data-feather="tool"></span>
                    Permissions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?module=dashboard&view=role.view">
                    <span data-feather="tool"></span>
                    Roles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                </a>
            </li>
        </ul>
    </div>
</nav>