<div id="cart">
    <div class="cart-header">
        <div class="cart-header-wrapper">
            <h1>Cart</h1>
            <div class="cart-info">
                
                <div class="text-group">
                    <label class="cart-header-label" for="cart-total">Total:</label>
                    <div id="cart-total">0</div>
                </div>

            </div>
            <button id="order-continue" type="button">Continue</button>
        </div>
            
    </div>

    <div class="cart-content">
        <div class="cart-content-header">
            <div class="header-wrapper">
                <div class="cart-checkbox selectAll">
                    <input type="checkbox" name=" " id="cart-select-all" class="cart-select">
                </div>
                <p class="cart-product">Product</p>
                <p class="cart-size">Size</p>
                <p class="cart-price">Price</p>
                <p class="cart-quantity">Quantity</p>
                <p class="cart-total">Total</p>
                <p class="cart-action">Action</p>
            </div>
        </div>

        <div class="cart-content-body">
            <div class="item-container">
                <div class="cart-item cart-checkbox">
                    <input type="checkbox" name=" " id="cart-select-id" class="cart-select">
                </div>
                <div class="cart-item cart-product">
                    <img src="./templates/images/content1.png" alt="">
                    <p>Product name hehe adad ada adaaaaaaaa aaaaaaaaa</p>
                </div>
                <div class="cart-item cart-size">
                    <select name="txtSizeSelect" id="pr-cart-size">
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38" selected>38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                    </select>
                </div>
                <div class="cart-item cart-price">100000</div>
                <div class="cart-item cart-quantity">
                    <button class="minus-btn">-</button>
                    <input type="text" id="productQuantity" value="1" disabled>
                    <button class="plus-btn">+</button>
                </div>
                <div class="cart-item cart-total">200000</div>
                <div class="cart-item cart-action"><i class="fa-solid fa-trash" style="color: #ff0700a6;"></i></div>
            </div>

            <div class="item-container">
                <div class="cart-item cart-checkbox">
                    <input type="checkbox" name=" " id="cart-select-id" class="cart-select">
                </div>
                <div class="cart-item cart-product">
                    <img src="./templates/images/content1.png" alt="">
                    <p>Product name hehe</p>
                </div>
                <div class="cart-item cart-size">
                    <select name="txtSizeSelect" id="pr-cart-size">
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38" selected>38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                    </select>
                </div>
                <div class="cart-item cart-price">100000</div>
                <div class="cart-item cart-quantity">
                    <button class="minus-btn">-</button>
                    <input type="text" id="productQuantity" value="1" disabled>
                    <button class="plus-btn">+</button>
                </div>
                <div class="cart-item cart-total">200000</div>
                <div class="cart-item cart-action"><i class="fa-solid fa-trash" style="color: #ff0700a6;"></i></div>
            </div>

            

            <div class="no-product" style="display: none">
                <p>Your cart is empty.</p>
            </div>  
        </div>
    </div>


</div>