<?php
    require_once("../templates/header.php");
?>

<?php
    require_once("../templates/header_search.php");
?>

<!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">   
            <div class="checkout__form">
                <h4>Confirmar Dados</h4>
                <form action="#">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Nome Completo<span>*</span></p>
                                        <input type="text" name="name" id="name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>CPF<span>*</span></p>
                                        <input type="text" name="cpf" id="cpf">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Telefone<span>*</span></p>
                                        <input type="text" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Rua<span>*</span></p>
                                        <input type="text" name="roaad" id="road">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="checkout__input">
                                        <p>Número<span>*</span></p>
                                        <input type="text" name="number" id="number">
                                    </div>
                                </div>
                                  <div class="col-lg-4">
                                    <div class="checkout__input">
                                        <p>Bairro<span>*</span></p>
                                        <input type="text" name="neighborhood" id="neighborhood">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="checkout__input">
                                        <p>Complemento<span></span></p>
                                        <input type="text" name="complement" id="complement">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="checkout__input">
                                        <p>CEP<span>*</span></p>
                                        <input type="text" name="cep" id="cep">
                                    </div>
                                </div>
                                  <div class="col-lg-3">
                                    <div class="checkout__input">
                                        <p>Cidade<span>*</span></p>
                                        <input type="text" name="city" id="city">
                                    </div>
                                </div>
                                 <div class="col-lg-2">
                                    <div class="checkout__input">
                                        <p>Estado<span>*</span></p>
                                        <input type="text" name="neighborhood" id="neighborhood">
                                    </div>
                                </div>
                            </div>
                            
                          
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Sua Compra</h4>
                                <div class="checkout__order__products">Produtos <span>Total</span></div>
                                <ul>
                                    <li>Vegetable’s Package <span>$75.99</span></li>
                                    <li>Fresh Vegetable <span>$151.99</span></li>
                                    <li>Organic Bananas <span>$53.99</span></li>
                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span>$750.99</span></div>
                                <div class="checkout__order__total">Total <span>$750.99</span></div>
                               
                               
                                
                                <button data-toggle="modal" data-target="#modalPayment" type="submit" class="site-btn">FINALIZAR COMPRA</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Modal -->
    <div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal Pagamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    
<?php
    require_once("../templates/footer.php"); /* Importando o footer.php */
?>