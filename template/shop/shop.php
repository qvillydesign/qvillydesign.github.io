<?php

$currentPage = null;

$categories = \Inc\Database\DbCategory::getAll('object');

require_once($baseController->website_path . "/template/_header.php");

?>
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-02.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Каталог товаров
        </h2>
    </section> 
    <main role="main" class="page container fit-height-section">
     
        <div class="row row-offcanvas row-offcanvas-right">

            <div class="col-12 col-md-12">
                
                

                <?php
                $i = 0;
                if ($categories) {
                    foreach ($categories as $category) {
                        $image = \Inc\Database\DbImage::getSingle(["id" => $category->idImage], 'object');
                        $imagePath = $image ? $image->path : "/assets/img/no-image.jpg";
                        ?>
                        <!-- Category -->
                       
<!-- item blog -->
                        <div class="p-b-63">
                            <a href="page.php?name=category&category=<?php echo $category->slug; ?>" class="hov-img0 how-pos5-parent">
                                <img src="<?php echo $baseController->website_url . $imagePath; ?>" alt="IMG-BLOG">
                            </a>

                            <div class="p-t-32">
                                <h4 class="p-b-15">
                                    <a href="page.php?name=category&category=<?php echo $category->slug; ?>" class="ltext-108 cl2 hov-cl1 trans-04">
                                        <?php echo $category->title; ?>
                                    </a>
                                </h4>

                                <p class="stext-117 cl6">
                                    <?php echo $category->description; ?>
                                </p>

                                <div class="flex-w flex-sb-m p-t-18">
                                   

                                    <a href="page.php?name=category&category=<?php echo $category->slug; ?>" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                        Перейти к товарам

                                        <i class="fa fa-long-arrow-right m-l-9"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php

                        if (($i + 1 < count($categories))) {
                            echo "<hr class='featurette-divider'>";
                        }
                        $i++;
                    }
                }
                ?>

            </div><!--/span-->

           
        </div><!--/row-->

    </main>

<?php

require_once($baseController->website_path . "/template/_footer.php");

