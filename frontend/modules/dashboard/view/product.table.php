<table class="table align-middle table-borderless table-hover">
    <thead class="table-light">
        <tr class="align-middle">
            <th></th>
            <th>Product Name</th>
            <th>Categories</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($productList as $product): ?>
            <tr>
                <td class='col-1'><img src='../../../../<?= $product -> getImage() ?>' alt='<?= $product -> getName() ?>' class='rounded float-start'>
                </td>
                <td class='col-3'><?= $product -> getName() ?></td>
                <td class='col-2'><?= $product -> getCategoryId() ?></td>
                <td class='col-4'><?= $product -> getDescription() ?></td>
                <td class='col-1'><?= $product -> getPrice() ?></td>
                <td class='col-1'>
                    <div class='product-action'>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                            <span data-feather="tool"></span>
                            Update
                        </button>
                        <button class="btn btn-sm btn-danger">
                            <span data-feather="trash-2"></span>
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    <?php endforeach; ?>
</table>