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
                                    <!-- Button to Trigger Modal-->
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <span data-feather="eye"></span>
                                        View
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Order ID: 1,001</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <div class="row p-3 overflow-hidden">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;" class="border border-black p-2">
                                                            <div class="col-5">
                                                                <h5 class="p-0">Customer ID: 01</h5>
                                                                <p>User ID: 101</p>
                                                                <p>Order Date: 03/03/2025</p>
                                                                <p>Total Amount: 1.000.0000 Đ</p>
                                                            </div>
                                                            <div class="scrollbar-listItem col-7 overflow-y-scroll">
                                                                <div>
                                                                    <p>Product ID: 20</p>
                                                                    <p>Quantity: 1</p>
                                                                    <p>Price: 1.000.0000 Đ</p>
                                                                    <img
                                                                            style="width: 200px; border-radius: 16px"
                                                                            src="../../../../../img/Running%20Shoes/Asics%20Gel-Excite%209.avif"
                                                                            alt="IMG"
                                                                    >
                                                                    <hr>
                                                                </div>
                                                                <div>
                                                                    <p>Product ID: 20</p>
                                                                    <p>Quantity: 1</p>
                                                                    <p>Price: 1.000.0000 Đ</p>
                                                                    <img
                                                                            style="width: 200px; border-radius: 16px"
                                                                            src="../../../../../img/Running%20Shoes/Asics%20Gel-Excite%209.avif"
                                                                            alt="IMG"
                                                                    >
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3">
                                                        <div class="border border-black p-2">
                                                            <h5>Name: </h5>
                                                            <p>User ID: </p>
                                                            <p>Email: </p>
                                                            <p>Phone: </p>
                                                            <p>Status: </p>
                                                            <p>Address: </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer flex flex-row justify-content-end">
                                                    <button type="button" class="btn btn-success">Print</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>

            <?php include('../inc/app/app.php'); ?>
</body>

</html>