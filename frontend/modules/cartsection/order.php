<div class="order-confirm">
    <h2>Order Comfirm</h2>
    <form class="row g-1 ">
        <h4>Customer Info</h4>
            <div class="col-4">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="inputName">
            </div>
            <div class="col-3">
                <label for="inputText" class="form-label">Phone Number</label>
                <input type="text" class="form-control form-control-sm" id="inputText">
            </div>
            <div class="col-5">
                <label for="inputText" class="form-label">Note</label>
                <textarea class="form-control form-control-sm" rows="1"></textarea>
            </div>
            <div class="col-6">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control form-control-sm" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="col-2">
                <label for="inputPayment" class="form-label">Payment Method</label>
                <select id="inputPayment" class="form-select form-select-sm">
                <option selected>Cash</option>
                <option>ATM</option>
                <option>Credit Card</option>
                </select>
            </div>
        
        <h4 class="pt-3">Product List</h4>
        <div id="order-confirm-product">
            <table class="table table-striped col-12 align-middle table-borderless text-center table-secondary" >
                <thead>
                    <tr>
                        <th scope="col" colspan="2" class="text-start">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody id="productList">
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>
                    <tr class="">
                        <td class="col-1"><img src=".\templates\images\pic2.png" alt="" class="cart-item-img"></td>
                        <td class="col-4 cart-item-name text-start">Shoe</td>
                        <td class="col-2 cart-item-price">1</td>
                        <td class="col-1 cart-item-quantity">1</td>
                        <td class="col-2 cart-item-discount">1</td>
                        <td class="col-2 cart-item-total">1</td>
                    </tr>


                </tbody>
        </table>
        </div>
        <div class="btn-group ">
            <input type="button" id="btnBack" value="Back" >
            <p>Total: 100000</p>
            <input type="submit" id="order-confirm-submit" value="Submit" >
        </div>
        
    </form>
</div>