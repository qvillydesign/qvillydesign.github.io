<?php
use \Inc\Database\DbItem;
use \Inc\Database\DbCategory;
use \Inc\Utils\GeneralPrice;
use \Inc\Utils\User;
use \Inc\Utils\Order;
use \Inc\Utils\Cart;
use \Inc\Database\DbAddress;
if (!$user = User::getCurrentUser()) {
die();
}
# wait for database after confirmation of order
sleep(1);
$order = Order::getLastPayment($user->id);
# Redirect to user page if there'a
if (!$order) {
header("Location: $baseController->website_url/page.php?name=user");
}
$itemsOrder = Cart::getCartItems($order->id);
$address = DbAddress::getSingle(["id" => $order->idAddress], "object");
require_once($baseController->website_path . "/template/_header.php");
?>
<main role="main" class="fit-height-section mb-5">
    <div class="jumbotron jumbotron-fluid small-jumbotron bg-success text-white">
        <div class="container">
            <h1 class="display-4">Заявка отправлена</h1>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10">
                
                <p class="lead">
                    
                    Ваша заявка будет рассмотрена в течении суток.
                    
                </p>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="order-detail-success">
                    <h5>О заказе</h5>
                    
                    <ul>
                        <li>Номер заказа: <?php echo $order->id; ?></li>
                        <li>Дата заказа: <?php echo $order->dateCheckout; ?></li>
                        <li>Сумма: <?php echo $order->finalPrice; ?> BYN</li>
                        <li>
                            <span class="text-primary">Заказчик:</span>
                            <ul>
                                <li>Имя: <?php echo $user->firstName; ?></li>
                                <li>Фамилия: <?php echo $user->lastName; ?></li>
                            </ul>
                            <li>
                                <span class="text-primary">Адрес:</span>
                                <ul>
                                    <li>Страна: <?php echo $address->department; ?></li>
                                    <li>Адрес: <?php echo $address->class; ?></li>
                                </ul>
                            </li>
                        </ul>
                        <hr class="mb-4">
                        <div class="row">
                            <div class="col-12 col-md-9">
                                <h6>О товаре</h6>
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
                                            <li>Сумма: <?php echo $itemOrder->quantity * $item->price; ?> BYN</li>
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
        <br>
        <p>
            <a class="btn btn-success" href="page.php?name=user">Перейти к профилю</a>
        </p>
    </div>
</main>
<?php
require_once($baseController->website_path . "/template/_footer.php");