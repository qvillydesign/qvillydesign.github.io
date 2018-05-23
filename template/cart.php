<?php

use Inc\Utils\Cart;
use Inc\Utils\User;

if (!$user = User::getCurrentUser()) {
    die();
}

$cartItems = Cart::getUserCartItem($user->id);

require_once($baseController->website_path . "/template/_header.php");
?>
    <!-- breadcrumb -->

    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Корзина
        </h2>
        
    </section>  
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">Мой аккаунт</a></li>
                    <li class="breadcrumb-item active">Корзина</li>
                </ol>
            </nav>
        </div>
    </section>
<h4 align="center" style="padding-top: 10px;">Количество товаров: <span class="badge badge-primary cart-page-num-item"><?php echo count($cartItems); ?></span></h4>
    <form class="bg0 p-t-75 p-b-85">

        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl" id="cart">
                        <?php Cart::displayCart($user->id); ?>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm" id="report">
                        <?php Cart::displayReport($user->id); ?>
                    </div>
                </div>
            </div>
        </div>

    </form>


        

<?php

require_once($baseController->website_path . "/template/_footer.php");
