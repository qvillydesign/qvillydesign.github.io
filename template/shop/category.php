<?php
use \Inc\Database\DbCategory;
use \Inc\Database\DbItem;
use \Inc\Database\DbImage;
use \Inc\Utils\User;
$currentCategory = null;
if (!isset($_GET["category"]) && empty($_GET["category"])) {
header("Location: page.php?name=home");
}
// current User
$user = User::getCurrentUser();
// current category
$currentCategory = DbCategory::getSingle(["slug" => $_GET["category"]], 'object');
$imageCat = DbImage::getSingle(["id" => $currentCategory->idImage], 'object');
// current products
$products = DbItem::get(["idCategory" => $currentCategory->id], 'object');
//all categories
$categories = DbCategory::getAll('object');
require_once($baseController->website_path . "/template/_header.php");
?>
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image:
                    linear-gradient(to bottom, rgba(0,0,0,.20), rgba(0,0,0,.30)),
                    linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.05) 25%, rgba(0,0,0,0.5) 75%, rgba(0,0,0,0.8) 100%),
                    url('<?php echo $baseController->website_url . $imageCat->path ?>');">
    <h2 class="ltext-105 cl0 txt-center">
    <?php echo $currentCategory->title; ?>
    </h2>
    <p style="color: white"> <?php echo $currentCategory->description; ?> </p>
    </section>
    <main role="main" class="page container fit-height-section mb-5" data-id-cat="<?php echo $currentCategory->id; ?>">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-12 col-md-12">
                
               
                <div class="flex-w flex-sb-m p-b-52" id="sidebar">
                    <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                        <a href="<?php echo $baseController->website_url ?>/page.php?name=shop"
                        class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1">Все категории</a>
                        <?php
                        $i = 0;
                        if ($categories) {
                        foreach ($categories as $category) { ?>
                        <a href="<?php echo $baseController->website_url . "/page.php?name=category&category=" . $category->slug; ?>"
                        class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5"><?php echo $category->title; ?></a>
                        <?php }
                        } ?>
                    </div>
                    
                    </div><!--/span-->
                    
                    <!-- Search tools
                    <div class="search-tools">
                        <h5>Search tools</h5>
                        <form id="form-search-tools">
                            <div class="form-group">
                                <label for="filter-date">Сортировка</label>
                                <select class="filter-section form-control form-control-sm" id="filter-date">
                                    <option value="0">нет</option>
                                    <option value="1">Обычный</option>
                                    <option value="2">Новинки</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="filter-price">Цена:</label>
                                <select class="filter-section form-control form-control-sm" id="filter-price">
                                    <option value="0">Нет</option>
                                    <option value="1">По возрастанию</option>
                                    <option value="2">По убыванию</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="filter-title">По названию:</label>
                                <select class="filter-section form-control form-control-sm" id="filter-title">
                                    <option value="0">Нет</option>
                                    <option value="1">А-Я</option>
                                    <option value="2">Я-А</option>
                                </select>
                            </div>
                            <button class="btn btn-secondary btn-block" type="submit">Search</button>
                        </form>
                    </div>
                    -->
                    <div id="list-item">
                        <!-- Items Masonry -->
                        <div class="grid row">
                            <div class="grid-sizer col-xs-6 col-sm-4 col-md-4">
                            </div>
                            <?php
                            $i = 0;
                            foreach ($products as $product) {
                            $image = DbImage::getSingle(["id" => $product->idImage], 'object');
                            $imagePath = $image ? $image->path : "/assets/img/no-image.jpg";
                            ?>
                            <div class="grid-item col-xs-6 col-sm-4 col-md-4">
                                <div class="card">
                                    <div class="block2-pic hov-img0">
                                        <img src="<?php echo $baseController->website_url . $imagePath ?>"
                                        alt="<?php echo $product->title ?>">
                                        <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                            Быстрый просмотр
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                        <span class="title-prod" data-prod-id='<?php echo $product->id ?>'>
                                            <?php echo $product->title ?>
                                        </span>
                                        <span class="badge badge-secondary">
                                            <?php echo $product->price ?> BYN
                                        </span>
                                        </h5>
                                        <p class="card-text"><?php echo $product->description ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <div style="float: left; display: inline-block">
                                            <div class="cont-input-number">
                                                <span class="input-number-decrement">–</span>
                                                <input class="input-number" type="text" value="1" min="1" max="30"
                                                data-prod-id='<?php echo $product->id ?>'>
                                                <span class="input-number-increment">+</span>
                                            </div>
                                        </div>
                                        <div style="float: left; margin-left: 15px; display: inline-block">
                                            <button type="button" class="btn btn-success btn-sm btn-add"
                                            data-prod-id='<?php echo $product->id ?>'>
                                            Добавить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
        <!-- Modal or Pop-up -->
        <div class="modal fade" id="modalItemAdded" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" class="modalTitleItem">
                        <span class="modalTitleItem"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="modal-text">
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal1 -->
        <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
            <div class="overlay-modal1 js-hide-modal1"></div>
            <div class="container">
                <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                    <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                    <img src="images/icons/icon-close.png" alt="CLOSE">
                    </button>
                    <div class="row">
                        <div class="col-md-6 col-lg-7 p-b-30">
                            <div class="p-l-25 p-r-30 p-lr-0-lg">
                                <div class="wrap-slick3 flex-sb flex-w">
                                    <div class="wrap-slick3-dots"></div>
                                    <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                                    <div class="slick3 gallery-lb">
                                        <div class="item-slick3" data-thumb="<?php echo $baseController->website_url . $imagePath ?>">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="<?php echo $baseController->website_url . $imagePath ?>"
                                                alt="<?php echo $product->title ?>">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?php echo $baseController->website_url . $imagePath ?>">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item-slick3" data-thumb="<?php echo $baseController->website_url . $imagePath ?>">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="<?php echo $baseController->website_url . $imagePath ?>" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?php echo $baseController->website_url . $imagePath ?>">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item-slick3" data-thumb="<?php echo $baseController->website_url . $imagePath ?>">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="<?php echo $baseController->website_url . $imagePath ?>" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?php echo $baseController->website_url . $imagePath ?>">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-5 p-b-30">
                            <div class="p-r-50 p-t-5 p-lr-0-lg">
                                <h4 class="mtext-105 cl2 js-name-detail p-b-14" >
                                <?php echo $product->title ?>
                                </h4>
                                <span class="mtext-106 cl2">
                                    <?php echo $product->price ?> BYN
                                </span>
                                <p class="card-text"><?php echo $product->description ?></p>
                                
                                <!--
                                <div class="p-t-33">
                                    <div class="flex-w flex-r-m p-b-10">
                                        <div class="size-203 flex-c-m respon6">
                                            Size
                                        </div>
                                        <div class="size-204 respon6-next">
                                            <div class="rs1-select2 bor8 bg0">
                                                <select class="js-select2" name="time">
                                                    <option>Choose an option</option>
                                                    <option>Size S</option>
                                                    <option>Size M</option>
                                                    <option>Size L</option>
                                                    <option>Size XL</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-w flex-r-m p-b-10">
                                        <div class="size-203 flex-c-m respon6">
                                            Color
                                        </div>
                                        <div class="size-204 respon6-next">
                                            <div class="rs1-select2 bor8 bg0">
                                                <select class="js-select2" name="time">
                                                    <option>Choose an option</option>
                                                    <option>Red</option>
                                                    <option>Blue</option>
                                                    <option>White</option>
                                                    <option>Grey</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-w flex-r-m p-b-10">
                                        <div class="size-204 flex-w flex-m respon6-next">
                                            <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>
                                                <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">
                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                            <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>-->
                                <!--  -->
                                <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                    <div class="flex-m bor9 p-r-10 m-r-11">
                                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                            <i class="zmdi zmdi-favorite"></i>
                                        </a>
                                    </div>
                                    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once($baseController->website_path . "/template/_footer.php");