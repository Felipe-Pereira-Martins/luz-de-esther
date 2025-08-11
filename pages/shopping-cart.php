<?php
require_once("../templates/header.php");
?>

<?php
require_once("../templates/header_search.php");
?>
<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Produtos</th>
                                <th>Valor</th>
                                <th>Quantidade</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="../assets/cart/cart-.jpg" alt="" width="100" height="100">
                                    <h5>Vegetable’s Package</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    $55.00
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    $110.00
                                </td>
                                <td class="shoping__cart__item__close">
                                    <span class="icon_close"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="./assets/cart/cart-2.jpg" alt="" width="100" height="100"> 
                                    <h5>Fresh Garden Vegetable</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    $39.00
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    $39.99
                                </td>
                                <td class="shoping__cart__item__close">
                                    <span class="icon_close"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="./assets/cart/cart-3.jpg" alt="" width="100" height="100">
                                    <h5>Organic Bananas</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    $69.00
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    $69.99
                                </td>
                                <td class="shoping__cart__item__close">
                                    <span class="icon_close"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="../pages/product-list.php" class="primary-btn cart-btn cart-btn-right bg-success text-light">
                       <span class="icon_loading"></span>
                        CONTINUE COMPRANDO</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Código Promocional</h5>
                        <form action="#">
                            <input type="text" placeholder="Digite o código promocional">
                            <button type="submit" class="site-btn">APLIQUE O CUPOM</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Totais</h5>
                    <ul>
                        <li>Subtotal <span>$454.98</span></li>
                        <li>Total <span>$454.98</span></li>
                    </ul>
                    <a href="checkout.php" class="primary-btn">FINALIZAR COMPRA</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->

<?php
require_once("../templates/footer.php");
?>