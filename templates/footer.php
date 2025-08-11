<?php
require_once '../config/config.php';
?>

<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <!-- Bloco da Logo com fundo escuro -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer__about dark-logo-box">
                    <div class="footer__about__logo">
                        <a href="../pages/index.php">
                            <img src="../assets/img/logo/logo.png" alt="Logo da loja" style="max-height: 160px;">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Links úteis -->
            <div class="col-lg-3 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Principais Links</h6>
                    <ul>
                        <li><a href="../pages/contact.php">Contatos</a></li>
                        <li><a href="../pages/about.php">Sobre</a></li>
                        <li><a href="../pages/shopping-cart.php">Carrinho</a></li>
                        <li><a href="../pages/blog.php">Blog</a></li>
                        <li><a href="../pages/product-list.php">Lista de Produtos</a></li>
                        <li><a href="../pages/categories.php">Categorias</a></li>
                    </ul>
                </div>
            </div>

            <!-- Cadastro e redes sociais -->
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Ainda não possui Cadastro?</h6>
                    <p>Insira seu email para se cadastrar em nosso site!</p>
                    <form action="#">
                        <input type="email" placeholder="Insira seu Email" required>
                        <button type="submit" class="site-btn">Cadastre-se</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="https://www.instagram.com/user.luzdeesther/" target="_blank" title="Instagram">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=<?= $whatsapp_link ?>" target="_blank" title="WhatsApp">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                        <a href="mailto:<?= $email_shop ?>?subject=Dúvidas%20sobre%20os%20produtos" title="Email">
                            <i class="fa fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Direitos Autorais -->
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p>
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script>
                        Luz de Esther | Moda Feminina
                        <a href="#" target="_blank" style="color: #c5a880 !important;">Flmzin DEV</a> |
                        Template por <a href="https://colorlib.com/wp/templates/"target="_blank" style="color: #c5a880 !important;">Colorlib</a>

                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Js Plugins -->
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/contact.js"></script> <!-- <-- ADICIONE AQUI -->
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.nice-select.min.js"></script>
<script src="../assets/js/jquery-ui.min.js"></script>
<script src="../assets/js/jquery.slicknav.js"></script>
<script src="../assets/js/mixitup.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/main.js"></script>

<!-- Plugin para Máscaras -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../assets/js/mask.js"></script>

</body>

</html>