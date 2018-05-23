<?php

use Inc\Utils\Cart;
use Inc\Utils\User;
use Inc\Utils\Address;
use Inc\Database\DbItem;
use \Inc\Utils\GeneralPrice;

if (!$user = User::getCurrentUser()) {
    die();
}

$cart = Cart::getCartUser($user->id);

if (!$cart)
    header("Location: $baseController->website_url/page.php?name=user");

$cartItems = Cart::getCartItems($cart->id);

if (!$cartItems)
    header("Location: $baseController->website_url/page.php?name=user");

$address = Address::getAddress($user->id);
$price = 0;
# Card field
$ccName = "";
$ccNumber = "";
$ccExpiration = "";
$ccCvv = "";

if (isset($_POST['cc-name']) && isset($_POST['cc-number']) &&
    isset($_POST['cc-expiration']) && isset($_POST['cc-cvv'])) {
    $ccName = !empty($_POST['cc-name']) ? $_POST['cc-name'] : "";
    $ccNumber = !empty($_POST['cc-number']) ? $_POST['cc-number'] : "";
    $ccExpiration = !empty($_POST['cc-expiration']) ? $_POST['cc-expiration'] : "";
    $ccCvv = !empty($_POST['cc-cvv']) ? $_POST['cc-cvv'] : "";
}

require_once($baseController->website_path . "/template/_header.php");


?>
    <!-- breadcrumb -->
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">Мой аккаунт</a></li>
                    <li class="breadcrumb-item"><a href="?name=cart">Корзина</a></li>
                    <li class="breadcrumb-item active" aria-current="">Оплата</li>
                </ol>
            </nav>
        </div>
    </section>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container">
                <h1 class="display-4">Оплата</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Ваша корзина</span>
                        <span class="badge badge-secondary badge-pill" style="margin-bottom: 5px"><?php echo count($cartItems); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php
                        foreach ($cartItems as $cartItem) {
                            $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                            $price = ($price + ($item->price * $cartItem->quantity));
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><?php echo $item->title; ?></h6>
                                    <small class="text-muted"><?php echo $cartItem->quantity; ?>
                                        товар<?php echo $cartItem->quantity > 1 ? "а" : "" ?></small>
                                </div>
                                <span class="text-muted"><?php echo($item->price * $cartItem->quantity); ?> BYN</span>
                            </li>

                        <?php }
                        $shipPayment = GeneralPrice::getCartShippmentPayment($price);
                        $finalPrice = $price + $shipPayment;
                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div class="text-muted">
                                <h6 class="my-0">Цена доставки:</h6>
                                <small class="text-muted">Бесплатная доставка</small>
                            </div>
                            <span class="text-muted"><?php echo $shipPayment ?> BYN</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Всего</span>
                            <strong><?php echo $finalPrice ?> BYN</strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-8 order-md-1 mb-4">
                    <form class="form-checkout" method="post" action="page.php?name=checkout" name="checkoutForm">
                        <h4 class="mb-3">Детали оплаты</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">Имя</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder=""
                                       value="<?php echo $user->firstName; ?>" required>
                                <div class="invalid-feedback">
                                    Требуется действительное имя.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Фамилия</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder=""
                                       value="<?php echo $user->lastName; ?>" required>
                                <div class="invalid-feedback">
                                    Требуется действительная фамилия.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com"
                                   value="<?php echo $user->userEmail; ?>" readonly>
                        </div>
                        <br>
                        <h4 class="mb-3">Адрес доставки</h4>
                        <p>Введите адрес для доставки товара.</p>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="zip">Страна</label>
                                <input type="text" class="form-control" id="department" name="department"
                                       placeholder="Department"
                                       value="<?php echo $address ? $address->department : ""; ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Адрес</label>
                                <input type="text" class="form-control" id="class" name="class"
                                       placeholder="Class" value="<?php echo $address ? $address->class : ""; ?>"
                                       required>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h4 class="mb-3">Вид оплаты</h4>
                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input"
                                       checked=""
                                       required="">
                                <label class="custom-control-label" for="credit">Кредитная карта</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input"
                                       required="">
                                <label class="custom-control-label" for="debit">Дебетовая карта</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input"
                                       required="">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Имя на карте</label>

                                <input type="text" class="form-control" id="cc-name" name="cc-name"
                                       placeholder="Mario Rossi" value="<?php echo $ccName; ?>" required>
                                <small class="text-muted">Полное имя, отображаемое на карточке</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Номер кредитной карты</label>
                                <input type="text" class="form-control" id="cc-number" name="cc-number"
                                       placeholder="2180 8229 8675 8684" value="<?php echo $ccNumber; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Срок</label>
                                <input type="text" class="form-control" id="cc-expiration" name="cc-expiration"
                                       placeholder="01/20" value="<?php echo $ccExpiration; ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">CVV код</label>
                                <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="123"
                                       value="<?php echo $ccCvv; ?>" required>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" name="checkoutForm" type="submit">
                            Оформить заказ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
