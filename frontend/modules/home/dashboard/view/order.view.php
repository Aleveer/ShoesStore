<?php
    $title = 'Orders';

    include ('../inc/head.php');

    // Namespace
    use backend\bus\OrdersBUS;
    use backend\bus\OrderItemsBUS;
?>

<body>
    <!-- HEADER -->
    <?php include ('../inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR MENU -->
            <?php include ('../inc/sidebar.php'); ?>

            <!-- MAIN -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?= $title ?>
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                        <!-- Function Button -->
                        <!-- Drop Down Menu -->
                        <!-- TODO: Fix this piece of shit that doesn't drop down, wtf -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle align-middle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <span data-feather="calendar"></span>
                                This week
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Last Month</a></li>
                                <li><a class="dropdown-item" href="#">Last Year</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- BODY DATABASE -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <!-- HEADER TABLE -->
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">ID Order</th>
                                <th scope="col" class="col-2">Customer ID</th>
                                <th scope="col" class="col-2">User ID</th>
                                <th scope="col" class="col-2">Order Date</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col" class="col-1 text-center">Info</th>
                            </tr>
                        </thead>

                        <!-- BODY DATABASE -->
                        <tbody>
                            <!-- TESTING STATIC -->
                            <tr class="align-middle">
                                <td>1,001</td>
                                <td>01</td>
                                <td>101</td>
                                <td>03/03/2025 </td>
                                <td>1.000.0000 Đ</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">
                                        <span data-feather="eye"></span>
                                        View
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>

            <?php include('../inc/script.php'); ?>
</body>

</html>