<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 29/01/2018
 * Time: 01:09
 */

namespace Inc\Admin;


use Inc\Base\BaseController;
use Inc\Database\DbAddress;
use Inc\Database\DbCart;
use Inc\Database\DbCartItem;
use Inc\Database\DbCategory;
use Inc\Database\DbItem;
use Inc\Database\DbUser;
use Inc\Utils\GeneralPrice;
use Inc\Utils\Order;
use Inc\Utils\User;

class OrderAdmin extends BaseController {

    /**
     * Product constructor.
     */
    public function __construct() {
        // BaseController
        parent::__construct();

        // Check if have privilege
        if (!User::isAdmin()) {
            return false;
        }
    }

    public function register() {
        // in this case unless class
        if (isset($_GET['order'])) {

            if (isset($_GET['see-order'])) {
                $this->seeOrder();
            } else {
                $this->getMain("Заказы");
            }

        }
    }

    public function seeOrder() {
        $idOrder = !empty($_GET["see-order"]) ? $_GET["see-order"] : null;
        $order = DbCart::getSingle(["id" => $idOrder], "object");
        $itemsOrder = DbCartItem::get(["idCart" => $order->id], "object");
        $user = DbUser::getSingle(["id" => $order->idUser], "object");
        $address = DbAddress::getSingle(["id" => $order->idAddress], "object");

        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="row">
                <div class="col-12 col-md-10">
                    <h1 class="admin-title">Заказ <?php if (!$order->dateDeliver) { ?><span
                                class="badge badge-secondary">Новый</span> <?php } ?></h1>
                    <p class="lead">
                        <?php if (!$order->dateDeliver) { ?>
                            Проверьте все данные для 
                            <span class="text-primary">отправки</span>.
                        <?php } else { ?>
                               Заказ уже отправлен.
                        <?php } ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 mb-4">
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
                                                            href="<?php echo $this->website_url . "/page.php?name=category&category=" . $category->slug; ?>">
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
                    <?php if (!$order->dateDeliver) { ?>
                        <form class="form-add-new" method="post"
                              action="?name=admin-area&order&see-order=<?php echo $idOrder; ?>"
                              enctype="multipart/form-data"
                              name="orderDelivered">
                            <button class="btn btn-primary btn-lg mt-3 ml-1" name="orderDelivered" type="submit">
                                Отправить
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </main>

        <?php
    }

    /**
     * @param $name
     */
    public function getMain($name) {
        $orders = Order::getAllOrders();

        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <h1 class="admin-title"><?php echo $name; ?></h1>
            <h4>Список заказов</h4>
            <div class="table-responsive">
                <table class="table table-admin table-striped table-sm">
                    <caption>Список всех заказов</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата заказа</th>
                        <th>Дата отправки</th>
                        <th>Цена</th>
                        <th>Пользователь</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Страна</th>
                        <th>Адрес</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($orders) {
                        foreach ($orders as $order) {
                            $user = DbUser::getSingle(["id" => $order->idUser], "object");
                            $address = DbAddress::getSingle(["id" => $order->idAddress], "object");
                            ?>

                            <tr class="<?php echo $order->dateDeliver ? "text-muted" : ""; ?>" onclick="
                                    window.location='?name=admin-area&order&see-order=<?php echo $order->id; ?>' ;">
                                <td><?php echo $order->id; ?></td>
                                <td><?php echo $order->dateCheckout; ?></td>
                                <td><?php echo $order->dateDeliver; ?></td>
                                <td><?php echo $order->finalPrice; ?> BYN</td>
                                <td><?php echo $user->userName; ?></a></td>
                                <td><?php echo $user->firstName; ?></a></td>
                                <td><?php echo $user->lastName; ?></td>
                                <td><?php echo $address->department ?></td>
                                <td><?php echo $address->class; ?></td>
                            </tr>
                            <?php
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php
    }

}