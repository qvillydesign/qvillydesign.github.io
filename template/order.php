<?php

use Inc\Utils\User;
use Inc\Utils\Order;
use Inc\Utils\Cart;
use Inc\Utils\GeneralPrice;
use Inc\Database\DbAddress;
use Inc\Database\DbItem;
use Inc\Database\DbCategory;

if (!$user = User::getCurrentUser()) {
    die();
}
$orders = Order::getUserOrders($user->id);

require_once($baseController->website_path . "/template/_header.php");
?>
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">Мой аккаунт</a></li>
                    <li class="breadcrumb-item active">Заказы</li>
                </ol>
            </nav>
        </div>
    </section>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container">
                <h1 class="display-4">Заказы</h1>
                <h4>Количество заказов: <span class="badge badge-primary "><?php echo count($orders); ?></span></h4>
            </div>
        </div>

        <div class="container">
            <?php if ($orders) { ?>
                <div id="accordion">
                    <?php
                    foreach ($orders as $order) {
                        $itemsOrder = Cart::getCartItems($order->id);
                        $address = DbAddress::getSingle(["id" => $order->idAddress], "object");
                        ?>
                        <div class="card">
                            <div class="card-header ch-order container" id="headingOne" data-toggle="collapse"
                                 data-target="#collapse<?php echo $order->id; ?>"
                                 aria-expanded="true" aria-controls="collapse<?php echo $order->id; ?>">
                                <div class="row">
                                    <div class="col-6 col-sm-3 col-md-3 col-lg-2">
                                    <span>
                                        Дата заказа: <br><strong><?php echo date("d M Y", strtotime($order->dateCheckout)); ?></strong>
                                    </span>
                                    </div>
                                    <div class="col-6 col-sm-2 col-md-2 col-lg-1">
                                    <span>
                                        Сумма: <br><strong><?php echo $order->finalPrice; ?> BYN</strong>
                                    </span>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                    <span>
                                        Адрес доставки: <br><strong><?php echo $address->department . " - " . $address->class; ?></strong>
                                    </span>
                                    </div>
                                    <div class="ml-auto col-6 col-sm-3 col-md-3 col-lg-2 text-md-center">
                                    <span>
                                        <small class="text-muted">Заказ: # <strong><?php echo $order->id; ?></strong></small>
                                    </span>
                                        <br>
                                        <span>
                                        <small class="text-muted">Количество товаров: <strong><?php echo count($itemsOrder); ?></strong></small>
                                    </span>
                                    </div>

                                </div>
                            </div>

                            <div id="collapse<?php echo $order->id; ?>" class="collapse"
                                 aria-labelledby="heading<?php echo $order->id; ?>"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <h5>О товаре</h5>
                                            <ul>
                                                <?php
                                                foreach ($itemsOrder as $itemOrder) {
                                                    $item = DbItem::getSingle(["id" => $itemOrder->idItem], 'object');
                                                    $category = DbCategory::getSingle(["id" => $item->idCategory], 'object');
                                                    ?>
                                                    <li>
                                                        <h7><?php echo $item->title; ?></h7>
                                                        <ul>
                                                            <li>Количество: <?php echo $itemOrder->quantity; ?></li>
                                                            <li>Цена: <?php echo $item->price; ?> BYN</li>
                                                            <li>Сумма:
                                                                <?php echo $itemOrder->quantity * $item->price; ?> BYN</li>
                                                            <li>Описание: <?php echo $item->description; ?></li>
                                                            <li>Категория: <a
                                                                        href="<?php echo $baseController->website_url . "/page.php?name=category&category=" . $category->slug; ?>">
                                                                    <?php echo $category->title; ?></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <p>
                                                <?php
                                                $price = GeneralPrice::getCartShippmentPayment($order->id);
                                                echo "Цена доставки: " . $price." BYN";
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="row">
                    <p class='lead'>Ваш список заказов пуст.</p>
                </div>
                <div class="row">
                    <a class="btn btn-success" href='page.php?name=shop'>Перейти в каталог товаров</a>
                </div>
                <?php
            }
            ?>
        </div>
    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
