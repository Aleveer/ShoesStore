<?php
    $title = 'Product';

    include ('../inc/head.php');

    use backend\bus\ProductBUS;

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
                        <!-- TODO: Add Button -->
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        
                    </div>
                </div>
            </main>


            <?php include('../inc/script.php'); ?>
</body>

</html>

