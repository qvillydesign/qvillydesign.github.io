<?php
/**
* Created by PhpStorm.
* User: aleric
* Date: 20/01/2018
* Time: 01:42
*/
namespace Inc\Utils;
use Inc\Base\BaseController;
use Inc\Base\DirController;
use Inc\Database\DbAddress;
use Inc\Database\DbCart;
use Inc\Database\DbCartItem;
use Inc\Database\DbImage;
use Inc\Database\DbItem;
class Cart {
/**
* Function to be called when you want to add an item in the cart.
* It will be checked if the cart exist (if doesn't exist, it will
* be created) and then connected the new item with the relative
* quantity.
*
* @param $idUser
* @param $idItem
* @param $quantity
*
* @return bool true on success, false otherwise.
*/
public static function addItem($idUser, $idItem, $quantity) {
# Check if the cart exist
if (!$cart = self::getCartUser($idUser)) {
return false;
}
$idCart = $cart->id;
return self::addItemToCart($idCart, $idItem, $quantity);
}
/**
*
*
* @param $idUser
* @param $idItem
* @param $quantity
*
* @return bool true on success, false otherwise.
*/
public static function changeQuantity($idUser, $idItem, $quantity) {
# Check if the cart exist
if (!$cart = self::getCartUser($idUser)) {
return false;
}
$idCart = $cart->id;
# check if the item is already stored in cart (addiction the quantity)
$items = self::getCartItems($idCart, $idItem);
if (!empty($items)) {
# the item is already stored
foreach ($items as $item) {
if ($item->idItem == $idItem) {
$newQuantity = $quantity;
$data = [
"quantity" => $newQuantity,
];
$where = [
"idCart" => $idCart,
"idItem" => $idItem,
];
return DbCartItem::update($data, $where) ? true : false;
}
}
}
}
/**
* Get current cart of a specific user, if doesn't
* exist it will be created.
*
* @param int $idUser
*
* @return false|object
*/
public static function getCartUser($idUser) {
$returnCart = null; #the cart that will be return
while (true) {
# try to find one already existing
$where = ["idUser" => $idUser];
$carts = DbCart::get($where, "object");
foreach ($carts as $cart) {
if ($cart && !$cart->dateCheckout) {
return $cart;
}
}
# If doesn't exist we create it
$dataC = [
"idUser" => $idUser,
"dateCreation" => DbCart::now(),
];
DbCart::insert($dataC);
}
}
/**
* @param int $idCart
* @param int $idItem
*
* @return array
*/
public static function getCartItems($idCart, $idItem = null) {
$where = ["idCart" => $idCart];
if ($idItem != null) $where["idItem"] = $idItem;
$carts = DbCartItem::get($where, "object");
return $carts;
}
/**
* @param $idUser
*
* @return array
*/
public static function getUserCartItem($idUser) {
$cart = self::getCartUser($idUser);
$cartItems = self::getCartItems($cart->id);
return $cartItems;
}
/**
* Add an item in the cart and it can be used also for change
* quantity (positive or negative).
*
* @param $idCart
* @param $idItem
* @param $quantity
*
* @return bool true on success, false otherwise.
*/
public static function addItemToCart($idCart, $idItem, $quantity) {
# check if the item is already stored in cart (addiction the quantity)
$items = self::getCartItems($idCart, $idItem);
if (!empty($items)) {
# the item is already stored
foreach ($items as $item) {
if ($item->idItem == $idItem) {
$newQuantity = $item->quantity + $quantity;
$data = [
"quantity" => $newQuantity,
];
$where = [
"idCart" => $idCart,
"idItem" => $idItem,
];
return DbCartItem::update($data, $where) ? true : false;
}
}
} else {
# it's necessary to store the item inside the cart
if ($idCart) {
# data cart_item
$dataCI = [
"idCart" => "$idCart",
"idItem" => $idItem,
"quantity" => $quantity,
];
return DbCartItem::insert($dataCI) ? true : false;
}
}
}
/**
* @param $idUser
*/
public static function displayCart($idUser) {
$dirC = new DirController();
$baseC = new BaseController();
$cart = Cart::getCartUser($idUser);
$cartItems = Cart::getCartItems($cart->id);
if (!empty($cartItems)) {
?>
<div class="wrap-table-shopping-cart">
    <table class="table-shopping-cart">
        
            <tr class="table_head">
                <th class="column-1"><h3>Товар</h3></th>
                <th class="column-2"></th>
                <th class="column-3">Цена</th>
                <th class="column-4">Количество</th>
                <th class="column-5">Сумма</th>
            </tr>
       
        
            <?php
            foreach ($cartItems as $cartItem) {
            $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
            if($item->idImage) {
            $where = ["id" => $item->idImage];
            $image = DbImage::getSingle($where, 'object');
            $imageUrl = $baseC->website_url . $image->path;
            } else {
            $imageUrl = $baseC->website_url ."/assets/img/no-image.jpg";
            }
            ?>
            <tr class="table_row">
                <td class="column-1">
                    <div class="how-itemcart1 btn-trash" data-item="<?php echo $item->id ?>"
                        data-user="<?php echo $idUser ?>">
                        <img id='card-item-img' class='card-item-img middle-h-item'
                        src="<?php echo $imageUrl; ?>"
                        alt="<?php echo $item->title; ?>">
                        
                    </div>
                </td>
                <td class="column-2">
                    <?php echo $item->title; ?>
                </td>
                <td class="column-3">
                    <?php echo $item->price; ?> BYN
                </td>
                <td class="column-4">
                    <div class="middle-h-cont ml-auto quantity-cont">
                        <input class="change-quantity middle-h-item"
                        value="<?php echo $cartItem->quantity; ?>"
                        type="number" data-item="<?php echo $item->id ?>"
                        data-user="<?php echo $idUser ?>">
                        <div class="cont-btn-change-quantity"></div>
                    </div>
                </td>
                <td class="column-5">
                    
                    <?php echo $cartItem->quantity * $item->price; ?> BYN
                    
                </td>
                
            </tr>
            <?php
            } ?>
        
    </table>
</div>
<?php
} else { ?>
<div class="row">
    <p class='lead'>Ваша корзина пуста, перейдите в каталог товаров, и когда вы увидите что-то, что может вас заинтересовать, выберите количество и нажмите «Добавить».</p>
    <a class="btn btn-success" href='page.php?name=shop'>Перейти в каталог</a>
</div>
<?php
}
}
public static function displayReport($idUser) {
$user = User::getBy($idUser, "id");
$cart = Cart::getCartUser($idUser);
$cartItems = Cart::getCartItems($cart->id);
$address = Address::getAddress($user->id);
$price = 0;
$totPrice = 0;
if (!empty($cartItems)) {
foreach ($cartItems as $cartItem) {
$item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
$price = ($price + ($item->price * $cartItem->quantity));
}
$shipPayment = GeneralPrice::getCartShippmentPayment($price);
$totPrice = $price + $shipPayment;
?>

    <h4 class="mtext-109 cl2 p-b-30">
                            Итого
                        </h4>
    <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Цена без доставки:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    <?php echo $price; ?> BYN
                                </span>
                            </div>
                        </div>
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0">Цена доставки:</h6>
            <ul class="shipping-info-cart">
                <?php if ($address && !empty($address->department) && !empty($address->class)) { ?>
                <li>
                    Страна: <span><?php echo $address->department ?></span>
                </li>
                <li>
                    Адрес: <span><?php echo $address->class ?></span>
                </li>
                <li>
                    <small class="text-muted"><a href="page.php?name=edit-address">Изменить</a>
                    </small>
                </li>
                <?php } else { ?>
                <li>
                    <small class="text-muted"><a href="page.php?name=edit-address">Задать</a>
                    </small>
                </li>
                <?php } ?>
            </ul>
        </div>
        <span class="text-muted"><?php echo $shipPayment; ?> BYN</span>
    </li>
   
    
    <div class="flex-w flex-t p-t-27 p-b-33">
        <div class="size-208">
            <span class="mtext-101 cl2">
                Всего:
            </span>
        </div>
        <div class="size-209 p-t-1">
            <span class="mtext-110 cl2">
                <?php echo $totPrice; ?> BYN
            </span>
        </div>
    </div>
    <a href="page.php?name=checkout" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
        <span>Оформить заказ</span>
    </a>
</div>
</div>
<?php
} else {
echo "<style>.bor10 {
    border: 0px solid #e6e6e6;
}</style> ";
}
}
}