<?php
require_once("../templates/header.php"); /* Importando o header.php */
?>

<?php
require_once("../templates/header_search.php"); /* Importando a busca */
?>
<!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Categorias</h4>
                            <ul>
                                <li><a href="#">Fresh Meat</a></li>
                                <li><a href="#">Vegetables</a></li>
                                <li><a href="#">Fruit & Nut Gifts</a></li>
                                <li><a href="#">Fresh Berries</a></li>
                                <li><a href="#">Ocean Foods</a></li>
                                <li><a href="#">Butter & Eggs</a></li>
                                <li><a href="#">Fastfood</a></li>
                                <li><a href="#">Fresh Onion</a></li>
                                <li><a href="#">Papayaya & Crisps</a></li>
                                <li><a href="#">Oatmeal</a></li>
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <h4>Filtrar Por Valor</h4>
                            <div class="price-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="10" data-max="540">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <form method="get" action="../pages/product-list.php">
                                            <input type="text" id="minamount">
                                            <input type="text" id="maxamount">
                                            <a class="tex-dark" type="submit">
                                                <i class="fa fa-search ml-2"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Lançamentos</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <div class="latest-prdouct__slider__item">
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="../assets/img/latest-product/lp-1.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>Crab Pool Security</h6>
                                                <span>$30.00</span>
                                            </div>
                                        </a>
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="../assets/img/latest-product/lp-2.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>Crab Pool Security</h6>
                                                <span>$30.00</span>
                                            </div>
                                        </a>
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="../assets/img/latest-product/lp-3.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>Crab Pool Security</h6>
                                                <span>$30.00</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="latest-prdouct__slider__item">
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="../assets/img/latest-product/lp-1.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>Crab Pool Security</h6>
                                                <span>$30.00</span>
                                            </div>
                                        </a>
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="../assets/img/latest-product/lp-2.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>Crab Pool Security</h6>
                                                <span>$30.00</span>
                                            </div>
                                        </a>
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="../assets/img/latest-product/lp-3.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>Crab Pool Security</h6>
                                                <span>$30.00</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Promoções</h2>
                            <span class="ml-2">
                                <a class="text-muted" href="../pages/promotions.php" title="Ver todas as Promoções"><small>
                                        <i class="fa fa-eye mr-1"></i>Ver Todas</small></title></a></span>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="../assets/img/promotions/product-3.png">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li>
                                                    <a href="#"><i class="fa fa-eye"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                </li></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Blusa Feminina</span>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="../assets/img/promotions/product-3.png">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li>
                                                    <a href="#"><i class="fa fa-eye"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                </li></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Blusa Feminina</span>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="../assets/img/promotions/product-3.png">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li>
                                                    <a href="#"><i class="fa fa-eye"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                </li></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Blusa Feminina</span>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="../assets/img/promotions/product-3.png">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li>
                                                    <a href="#"><i class="fa fa-eye"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                </li></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Blusa Feminina</span>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="../assets/img/promotions/product-3.png">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li>
                                                    <a href="#"><i class="fa fa-eye"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                </li></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Blusa Feminina</span>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="../assets/img/product/discount/pd-1.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <h5><a href="#">Raisin’n’nuts</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-title product__discount__title">
                        <h2>Produtos Mais Vendidos</h2>
                        <span class="ml-2">
                            <a class="text-muted" href="../pages/product-list.php" title="Ver todos os Produtos"><small>
                                    <i class="fa fa-eye mr-1"></i>Ver Todos</small></title></a></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                    <h5>$30.00</h5></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-2.jpg">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                    <h5>$30.00</h5></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-3.jpg">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                    <h5>$30.00</h5></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-4.jpg">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                    <h5>$30.00</h5></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-5.jpg">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                    <h5>$30.00</h5></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-6.jpg">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href=../pages/product.php">Crab Pool Security </h6>
                                    <h5>$30.00</h5></a>
                                </div>
                            </div>
                        </div>

                        <div class="section-title product__discount__title">
                            <h2>Combos Mais Vendidos</h2>
                            <span class="ml-2">
                                <a class="text-muted" href="../pages/product.php" title="Ver todos os Combos"><small>
                                        <i class="fa fa-eye mr-1"></i>Ver Todos</small></title></a></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                        <h5>$30.00</h5></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                        <h5>$30.00</h5></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                        <h5>$30.00</h5></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                        <h5>$30.00</h5></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                        <h5>$30.00</h5></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../assets/img/product/product-1.jpg">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="../pages/product.php">Crab Pool Security </h6>
                                        <h5>$30.00</h5></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
    </section>
<!-- Product Section End -->

<?php
require_once("../templates/footer.php"); /* Importando o header.php */
?>