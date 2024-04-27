<div class="table-responsive">
    <table class="table table-striped table-hover">
        <!-- HEADER TABLE -->
            <thead>
                <tr>
                    <th scope="col" class="col-1">ID Order</th>
                    <th scope="col" class="col-1">User ID</th>
                    <th scope="col" class="col-2">Customer Name</th>
                    <th scope="col" class="col-2">Order Date</th>
                    <th scope="col" class="col-2">Total Amount</th>
                    <th scope="col" class="col-1 text-center">Status</th>
                    <th scope="col" class="col-1 text-center">Info</th>
                </tr>
            </thead>

            <!-- BODY DATABASE -->
            <?php foreach ($orderList as $order): ?>
            <tbody>
                <!-- TESTING STATIC -->
                <tr class="align-middle">
                    <td><?= $order->getId() ?></td>
                    <td><?= $order->getUserId() ?></td>
                    <td><?= $order->getCustomerName() ?></td>
                    <td><?= $order->getOrderDate() ?></td>
                    <td><?= $order->getTotalAmount() ?></td>
                    <td class="text-center"><?= $order->getStatus() ?></td>
                    <td class="text-center">
                        <!-- Button to Trigger Modal-->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <span data-feather="eye"></span>
                            View
                        </button>

                        <!-- Modal -->
                        <!-- TODO: Fix the modal GUI, it's not good -->
                        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Order ID:
                                            1,001</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <div class="row p-3 overflow-hidden">
                                            <h3 class="p-0">Order Details</h3>
                                            <div style="display: flex; flex-direction: row; justify-content: space-between;"
                                                class="border border-black p-2">
                                                <!-- TODO: Add some database here -->
                                                <div class="col-5">
                                                    <h5 class="p-0">Customer ID: 01</h5>
                                                    <p>User ID: 101</p>
                                                    <p>Order Date: 03/03/2025</p>
                                                    <p>Total Amount: 1.000.0000 Đ</p>
                                                    <p>Discount: </p>
                                                    <p>Final Price: </p>
                                                </div>
                                                <div class="scrollbar-listItem col-7 overflow-y-scroll">
                                                    <div>
                                                        <p>Product ID: 20</p>
                                                        <p>Quantity: 1</p>
                                                        <p>Price: 1.000.0000 Đ</p>
                                                        <img style="width: 12rem; aspect-ratio: 1;"
                                                            class="img-fluid rounded-3"
                                                            src="../../../../../img/Running%20Shoes/Asics%20Gel-Excite%209.avif"
                                                            alt="IMG">
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <h3 class="p-0">User Details</h3>
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
        <?php endforeach; ?>
    </table>
</div>