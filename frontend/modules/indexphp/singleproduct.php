<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../fontend/singleproduct.css">
    <script>
        $(".hover").mouseleave(
        function () {
            $(this).removeClass("hover");
        }
        );
            
                    
        $(".active").mouseleave(
        function () {
            $(this).removeClass("active");
        }
        );
    </script>
</head>
<body>

    <div class="singleproduct">
        <button id="closepitem">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <hr>
        <h2>Chi Tiết Sản Phẩm</h2>
        <hr>
        <div class="pitem">
            <!-- <div class="pimg">
                
                <div class="imgcontent">FILLO</div>
            </div> -->

            <figure class="pimg">
            <img src="../../../img/Basketball Shoes/Adidas Dame 7.avif" alt="">
                <figcaption>
                <h3>FILLO </h3>
                <p>
                    The sole is thick and hard, providing support when running up and down the court.
                    The shoe collar is high, covering the ankle.
                </p>
                </figcaption><i class="ion-ios-personadd-outline"></i>
            </figure>
            <div class="productcontent">
                <div class="productname">
                    <h2> <span>Adidas Dame 7</span></h2>
                </div>
                <div class="price">
                    100.000<sup> đ</sup>
                   
                </div>
                <div class="des">
                  <fieldset>
                    <legend>Description</legend>
                    The sole is thick and hard, providing support when running up and down the court.
                    The shoe collar is high, covering the ankle.
                  </fieldset>
                </div>
                <div class="psize">
                    Size :
                    <div class="button-container"><button class="squish-in">36</button></div>
                    <div class="button-container"><button class="squish-in">37</button></div>
                    <div class="button-container"><button class="squish-in">38</button></div>
                    <div class="button-container"><button class="squish-in">39</button></div>
                    <div class="button-container"><button class="squish-in">40</button></div>

                </div>
                <div class="quantity">
                    <label for="pquantity">Quantity :</label>
                    <input type="number" name="pquantity" id="pquantity" placeholder="1" min="1">
                </div>
                <button class="addtocart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    ADD TO CART
                </button>
                
            </div>
        </div>
    </div>
    
</body>
</html>