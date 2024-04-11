<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Varela+Round&display=swap');

    *{
        margin: 0;
        padding: 0;
        
    }
    .background{
       text-align: center;
       padding-top: 50px;
       background: url(../indexphp/FAQ.jpg);
   
    }

    .header{
        line-height: 1.5;
    }
    h1{
        text-shadow: 
            -1px -1px 0 ,
            5px -1px 0 rgb(255, 113, 57),
            -1px 5px 0 rgb(255, 113, 57),
            5px 5px 0 rgb(255, 113, 57);
        font-size: 80px;
        color: wheat;
        font-weight: bold;
    }
    h3{
        font-size: 40px;
        color: rgb(255, 113, 57);
        font-weight: bold;
    }
    h4{
       color: aliceblue;
       font-size: 30px;
       text-shadow: 
            -1px -1px 0 ,
            1px -1px 0 rgb(255, 113, 57),
            -1px 1px 0 rgb(255, 113, 57),
            1px 1px 0 rgb(255, 113, 57);
        font-size: 20px;
       opacity: 0.9;
    }
    h5{
        color: orange;
        font-size: 15px;
    }
    p{
        color: #ddd;
        font-size: 10px;
    }
    .text{
      display: flex;
      padding-top: 100px;
      justify-content: center;
    }
    .text h1 , h3,button{
        margin: 0 10px;
    }
    .box{
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
       text-align: left;
    }

    input{
        width: 400px;
        border-radius: 5px;
        opacity: 0.6;
        background-color: aqua;
    }

    button{
        padding: 10px;
        background-color: aquamarine;
        border-radius: 5px;
    }

    .shopping-item .hover-show {
    display: none;
}

.shopping-item:hover .hover-show {
    display: block;
    transition: all .4s ease-in-out;
}


</style>
<body>
    <div class="background">
        <div class="header">
                <h1>FAQ! Need Help?</h1>
                <h3>We've got you covered</h3>
        </div>
            <div class="text">
                <h3>Related questions</h3>
                <input type="text" name="search" placeholder="">
                <button>Search</button>
            </div>
            <div class="box">
                <li>
                    <h4>SHOPPING</h4>
                    <h5 class="shopping-item">How to Pay with Digital Wallet?
                    <p class="hover-show">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec.</p>
                    </h5>
                   
                    <h5 class="shopping-item">What is the warranty policy?
                    <p  class="hover-show">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec.</p>
                    </h5>
                    
                </li>
                <li>
                    <h4>DELIVERY</h4>
                    <h5 class="shopping-item">Can I Buy Sneaker Offline at Offline Store?
                    <p  class="hover-show">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec.</p>

                    </h5>
                </li>
                <li>
                    <h4>RETURNS & REFUNDS</h4>
                    <h5 class="shopping-item">How Long The Warranty Applies for Sneaker?
                    <p  class="hover-show">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec.</p>
                    </h5>
                    <h5 class="shopping-item"How The Return Policy for Sneaker?>
                    <p  class="hover-show">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec.</p>
                    </h5>
                </li>
            </div>
    </div>  
   
</body>
</html>