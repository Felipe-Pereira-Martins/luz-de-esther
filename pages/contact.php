<?php
require_once("../templates/header.php"); /* Importando o header.php */
?>

<?php
require_once("../templates/header_search.php"); /* Importando a busca */
?>
    <!-- Contact Section Begin -->
    <section class="contact spad bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span><i class="fa fa-map-marker"></i></span>
                        <h4>Localização</h4>
                        <p><?php echo $name_city ?></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_whatsapp">
                        <a target="_blank"href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>"
                        title="<?php echo $whatsapp ?>"><i class="fa fa-whatsapp"></i></a>
                        </span>
                        <h4>Whatsapp</h4>
                        <p><?php echo $whatsapp ?></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span><i class="fa fa-history"></i></span>
                        <h4>Horário de Atendimento</h4>
                        <p>09:00 ás 19:00 </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span><i class="fa fa-envelope"></i></span>
                        <h4>Email</h4>
                        <p><?php echo $email ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Entre em Contato</h2>
                    </div>
                </div>
            </div>
            <form method="post" id="form-contact">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <input type="text" name="name" id="name" placeholder="Nome Completo" required>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <input type="text" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <input type="text" name="phone" id="phone" placeholder="Whatsapp" required>
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea name="message" id="message" placeholder="Sua Mensagem"></textarea>
                        <button name="btn-send-email" id="btn-send-email" type="button" class="site-btn">Enviar</button>
                    </div>
                    <div class="col-md-12 text-center mt-3" id="div-message"></div>
                </div>
            </form>
        </div>
    </div>
    <!-- Contact Form End -->

    <?php
        require_once("../templates/footer.php"); 
    ?>

   