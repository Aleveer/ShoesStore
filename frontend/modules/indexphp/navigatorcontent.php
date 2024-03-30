<?php
require_once __DIR__ . "/../../../backend/bus/product_bus.php";
//require_once __DIR__ . "/../backend/bus/size_items_bus.php";
//require_once __DIR__.'/../../backend/models/product_model.php';

$products = ProductBUS::getInstance()->getAllModels();
//$sizeItemsProduct = SizeItemsBUS::getInstance()->getAllModels();
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
                //TODO: Fix the UI, it only shows 1 item. The data is retrieved from the database successfully.
                foreach ($products as $product) {
                ?>
                    <li>
                        <div class="product-item">
                            <div>
                                <a href>
                                    <img src="<?php echo $product->getImage(); ?>" alt>
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><?php echo $product->getName(); ?></a>
                                <div class="product-price">
                                    <ul class="price"><span>$<?php echo $product->getPrice(); ?></span>
                                        <a href="#"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a>
                                    </ul>
                                    <!-- <ul class="star-rating">
                                            <?php for ($i = 0; $i < $product->getRating(); $i++) : ?>
                                                <i class="fa fa-star checked" style="color: #FFD43B;"></i>
                                            <?php endfor; ?>
                                            <span><?php echo $product->getReviewsCount(); ?>k</span>
                                        </ul> -->
                                </div>
                            </div>
                    </li>
                <?php
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