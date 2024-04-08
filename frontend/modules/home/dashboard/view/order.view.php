<?php
$title = 'Orders';
include ('../inc/head.php');
?>

<body>
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
                                <th scope="col">#</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                                <th scope="col" style="width: 15%;" class="text-end">
                                    <button type="button" class="btn btn-sm btn-success align-middle">
                                        <span data-feather="plus"></span>
                                        Add
                                    </button>
                                </th>
                            </tr>
                        </thead>

                        <!-- BODY DATABASE -->
                        <tbody>
                            <tr class="align-middle">
                                <td>1,001</td>
                                <td>random</td>
                                <td>data</td>
                                <td>placeholder</td>
                                <td>text</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-warning">
                                        <span data-feather="tool"></span>
                                        Update
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <span data-feather="trash-2"></span>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>

            <?php include ('../inc/script.php'); ?>
</body>

</html>