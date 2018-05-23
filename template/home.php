<?php
require_once($baseController->website_path . "/template/_header.php");
?>
<!--Slider-->

<section class="section-slide">
        <div class="wrap-slick1 rs2-slick1">
            <div class="slick1">
                <div class="item-slick1 bg-overlay1" style="background-image: url(images/slide-05.jpg);" data-thumb="images/thumb-01.jpg" data-caption="СВИТШОТЫ">
                    <div class="container h-full">
                        <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                <span class="ltext-202 txt-center cl0 respon2">
                                    ОЧЕРЕДНОЕ ОБНОВЛЕНИЕ АССОРТИМЕНТА
                                </span>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                   СВИТШОТЫ, ТОЛСТОВКИ, ХУДИ
                                </h2>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=hoody" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                    Купить сейчас
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-slick1 bg-overlay1" style="background-image: url(images/slide-06.jpg);" data-thumb="images/thumb-02.jpg" data-caption="ДЖИНСЫ">
                    <div class="container h-full">
                        <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
                                <span class="ltext-202 txt-center cl0 respon2">
                                    БОЛЬШОЙ ВЫБОР
                                </span>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
                                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                    ДЖОГГЕРЫ, ДЖИНСЫ, БРЮКИ, ШОРТЫ
                                </h2>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
                                <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=jeans" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                    Купить сейчас
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-slick1 bg-overlay1" style="background-image: url(images/slide-07.jpg);" data-thumb="images/thumb-03.jpg" data-caption="АКСЕССУАРЫ">
                    <div class="container h-full">
                        <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
                                <span class="ltext-202 txt-center cl0 respon2">
                                    НОВОЕ ПОСТУПЛЕНИЕ
                                </span>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
                                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                    АКСЕССУАРЫ
                                </h2>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
                                <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=-accessories" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                    Купить сейчас
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrap-slick1-dots p-lr-10"></div>
        </div>
    </section>
<!--/////////////////////////////////////////////////////////////////////////////////////////-->
<div class="sec-banner bg0 p-t-95 p-b-55">
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/img-home/hoody.jpg" alt="IMG-BANNER">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=hoody" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                СВИТШОТЫ, ТОЛСТОВКИ, ХУДИ
                            </span>
                            <span class="block1-info stext-102 trans-04">
                                Новое поступление
                            </span>
                        </div>
                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Купить сейчас
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/img-home/jeans.jpg" alt="IMG-BANNER">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=jeans" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                ДЖОГГЕРЫ, ДЖИНСЫ, БРЮКИ, ШОРТЫ
                            </span>
                            <span class="block1-info stext-102 trans-04">
                                Новое поступление
                            </span>
                        </div>
                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Купить сейчас
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/img-home/jackets.jpg" alt="IMG-BANNER">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=jacket" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                КУРТКИ, ВЕТРОВКИ, АНОРАКИ, ПАРКИ
                            </span>
                            <span class="block1-info stext-102 trans-04">
                                Новое поступление
                            </span>
                        </div>
                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Купить сейчас
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/img-home/tshirts.jpg" alt="IMG-BANNER">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=-t-shirt" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                ФУТБОЛКИ
                            </span>
                            <span class="block1-info stext-102 trans-04">
                                Новое поступление
                            </span>
                        </div>
                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Купить сейчас
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/img-home/acsess.jpg" alt="IMG-BANNER">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=category&category=-accessories" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                АКСЕССУАРЫ
                            </span>
                            <span class="block1-info stext-102 trans-04">
                                Новое поступление
                            </span>
                        </div>
                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Купить сейчас
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo '
<script type="text/javascript">
$(".owl-carousel").owlCarousel({
loop:true,
margin:0,
nav:false,
autoplay:true,
autoplayTimeout:5000,
responsive:{
0:{
items:1
},
600:{
items:1
},
1000:{
items:1
}
}
})</script>
';
require_once($baseController->website_path . "/template/_footer.php");