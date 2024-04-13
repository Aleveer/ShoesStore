<div id="header">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <?php layouts("header") ?>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Varela+Round&display=swap');

    * {
        margin: 0;
        padding: 0;

    }

    .background {
        text-align: center;
        padding-top: 50px;
        background: url("<?php echo _WEB_HOST_TEMPLATE ?> /images/FAQ.jpg");

    }

    .header {
        line-height: 1.5;
    }

    .header h1 {
        text-shadow:
            -1px -1px 0,
            5px -1px 0 rgb(255, 113, 57),
            -1px 5px 0 rgb(255, 113, 57),
            5px 5px 0 rgb(255, 113, 57);
        font-size: 80px;
        color: wheat;
        font-weight: bold;
    }

    .header h3 {
        font-size: 40px;
        color: rgb(255, 113, 57);
        font-weight: bold;
    }

   .box h4 {
        color: aliceblue;
        font-size: 30px;
        text-shadow:
            -1px -1px 0,
            1px -1px 0 rgb(255, 113, 57),
            -1px 1px 0 rgb(255, 113, 57),
            1px 1px 0 rgb(255, 113, 57);
        font-size: 20px;
        opacity: 0.9;
    }

    .box h5 {
        color: orange;
        font-size: 15px;
    }

    p {
        font-weight: 700;
        color: #ddd;
        font-size: 10px !important;
    }

    .text {
        display: flex;
        padding-top: 100px;
        justify-content: center;
    }

    .text h1,
    h3,
    button {
        margin: 0 10px;
    }

    .box {
        display: flex;
        justify-content: space-between;
        padding-top: 80px;
        padding-bottom: 80px;
        width: 100%;
        list-style: none;
    }

    .box li {
        flex: 1;
        text-align: center;
        background-color: rgb(39, 75, 114);
        margin: 0 20px;
        padding: 70px;
        font-weight: bolder;
        line-height: 2;
        color: aliceblue;
        height: 300px;
        text-align: left;
        opacity: 0.8;
    }

    .shopping-item .hover-show {
        display: none;
    }

    .shopping-item:hover .hover-show {
        display: block;
        transition: all .5s ease-in-out;
    }

    h5 {
        font-size: 32px;
    }
</style>

<body>
    <div class="background">
        <div class="header">
            <h1>FAQ! Need Help?</h1>
            <h3>We've got you covered</h3>
        </div>
        <div class="box">
            <li>
                <h4>SHOPPING</h4>
                <h5 class="shopping-item">How to Pay with Digital Wallet?
                    <p class="hover-show"  style="font-size: 24px;">Paying with a digital wallet is easy and secure. Simply select the digital
                        wallet option at checkout, log into your account, and authorize the payment. Your information is
                        stored securely and transactions are encrypted for your protection.</p>
                </h5>
                <h5 class="shopping-item">What is the warranty policy?
                    <p class="hover-show" style="font-size: 24px;">Our warranty policy covers any manufacturing defects
                        for up to one year from
                        the date of purchase. Please note that this does not cover damage caused by misuse or normal
                        wear and tear.</p>
                </h5>
            </li>
            <li>
                <h4>DELIVERY</h4>
                <h5 class="shopping-item">Can I Buy Sneaker Offline at Offline Store?
                    <p class="hover-show" style="font-size: 24px;">Yes, you can purchase our sneakers at any of our
                        offline stores. Visit our
                        store locator on our website to find the nearest store to you.</p>
                </h5>
            </li>
            <li>
                <h4>RETURNS & REFUNDS</h4>
                <h5 class="shopping-item">How Long The Warranty Applies for Sneaker?
                    <p class="hover-show" style="font-size: 24px;">The warranty for our sneakers applies for one year
                        from the date of purchase.
                        It covers manufacturing defects but does not cover damage caused by misuse or normal wear and
                        tear.</p>
                </h5>
                <h5 class="shopping-item">How The Return Policy for Sneaker?
                    <p class="hover-show" style="font-size: 24px;">If you're not satisfied with your sneakers, you can
                        return them within 30 days
                        of purchase. The sneakers must be unworn, in the original packaging, and with the receipt for a
                        full refund.</p>
                </h5>
            </li>
        </div>
    </div>
</body>

<div id="footer">
    <?php layouts("footer") ?>
</div>