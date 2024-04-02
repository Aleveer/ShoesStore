<?php
use backend\bus\ProductBUS;
$products = ProductBUS::getInstance()->getAllModels();
?>

<div class="container">
    <div class="text__content">
        <ul>
            <i class="fa-sharp fa-regular fa-square-check" style="color: #0e5fec;"></i>
            ORIGINAL PRODUCT
        </ul>
        <ul>
            <i class="fa-regular fa-bell" style="color: #0e5fec;"></i>
            INTERESTING PROMO & DEALS
        </ul>
        <ul>
            <i class="fa-solid fa-rotate-left" style="color: #0e5fec;"></i>
            30 DAYS MONEY-BACK GUARANTE
        </ul>
        <ul>
            <i class="fa-solid fa-medal" style="color: #0e5fec;"></i>
            EXPEREINCED SELLER
        </ul>
    </div>

    <div id="card__area">
        <div class="wrap">
            <div class="box__area">
                <div class="box">
                    <img src="../picture/class11.webp" alt>
                    <div class="overlay__box">
                        <h3>RUNNING</h3>
                        <p><a href>SEE PRODUCT</a></p>
                    </div>
                </div>
                <div class="box">
                    <img src="../picture/class2.jpg" alt>
                    <div class="overlay__box">
                        <h3>WOMAN</h3>
                        <p><a href>SEE PRODUCT</a></p>
                    </div>
                </div>
                <div class="box">
                    <img src="../picture/class3.jpg" alt>
                    <div class="overlay__box">
                        <h3>MAN</h3>
                        <p><a href>SEE PRODUCT</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="list__product">
        <div class="in__wrap">
            <ul id="content" class="products">
                <?php
                for ($i = 0; $i < count($products); $i++) {
                    $product = $products[$i];
                    echo '
                    <li>
                        <div class="product-item">
                            <div>
                                <a href>
                                    <img src="' . $product->getImage() . '" alt>
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name">' . $product->getName() . '</a>
                                <div class="product-price">
                                    <ul class="price"><span>$' . $product->getPrice() . '</span>
                                        <a href="#"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a>
                                    </ul>
                                </div>
                            </div>
                    </li>
                    ';
                }
                ?>
            </ul>
            <div class="in-wrap">
                <div class="swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <img src="<?php echo _WEB_HOST_TEMPLATE ?> /images/img/Fila.jpg" alt="">
                            <div class="title">
                                <span>Fila</span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo _WEB_HOST_TEMPLATE ?> /images/img/Fashion.jpg" alt="">
                            <div class="title">
                                <span>Fashion</span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo _WEB_HOST_TEMPLATE ?> /images/img/Sneakers.jpg" alt="">
                            <div class="title">
                                <span>Sneakers</span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo _WEB_HOST_TEMPLATE ?> /images/img/Naked Wolfe Pink.jpg" alt="">
                            <div class="title">
                                <span>Naked Wolfe Pink</span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo _WEB_HOST_TEMPLATE ?> /images/img/Autumn.jpg" alt="">
                            <div class="title">
                                <span>Autumn</span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo _WEB_HOST_TEMPLATE ?> /images/img/Naked Wolfe.jpg" alt="">
                            <div class="title">
                                <span>Naked Wolfe</span>
                            </div>
                        </div>

                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>

                </div>
            </div>
        </div>