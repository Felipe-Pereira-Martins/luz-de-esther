<?php 
require_once '../config/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Venda de Roupas Femininas Moda Feminina">
    <meta name="keywords" content="Roupas femininas, saias, vestidos, camisas, blusas, Moda Evangélica ">  <!-- 15 palavras chaves -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $name_store ?></title>

   <!-- font Style -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/style.css" type="text/css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">

</head>



<body>

    <!-- Humberger Begin Version Mobile -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="../pages/index.php">
                <img src="../assets/img/logo/logo_header.png" alt="Logo do site">
            </a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">Itens: <span>R$160,00</span></div>

            <div class="header__top__right__auth ml-4">
                <a href="../system/index.php"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="pages/index.php">Início</a></li>
                <li><a href="./pages/categories.php">Categorias</a></li>
                <li><a href="#">Produtos</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="pages/products.php">Lista de Produtos</a></li>
                        <li><a href="pages/shopping-cart.php">Carrinho</a></li>
                        <li><a href="pages/checkout.php">Finalizar Compra</a></li>
                        <li><a href="pages/blog-details.php">Detalhes do Blog</a></li>
                    </ul>
                </li>
                <li><a href="../pages/blog.php">Blog</a></li>
                <li><a href="../pages/contact.php">Contato</a></li>
            </ul>
        </nav>
        <div class="header__top__right__social">
            <a href="https://www.instagram.com/user.luzdeesther/" target="_blank" title="Instagram">
                <i class="fa fa-instagram"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=<?= $whatsapp_link ?>" target="_blank" title="<?= $whatsapp ?>">
                <i class="fa fa-whatsapp"></i>
            </a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> <?= $email_shop ?></li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> <?= $email_shop ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="https://www.instagram.com/user.luzdeesther/" target="_blank" title="Instagram">
                                    <i class="fa fa-instagram insta_icon text-danger"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone=<?= $whatsapp_link ?>" target="_blank" title="<?= $whatsapp ?>">
                                    <i class="fa fa-whatsapp text-success"></i>
                                </a>
                            </div>
                            <div class="header__top__right__auth">
                                <a href="/store/system/index.php"><i class="fa fa-user"></i> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="../pages/index.php">
                            <img src="../assets/img/logo/logo_header.png" alt="Luz de Esther" class="logo-header">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="../pages/index.php">Início</a></li>
                            <li><a href="./categories.php">Categorias</a></li>
                            <li><a href="../pages/products.php">Produtos</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="../pages/products.php">Produtos</a></li>
                                    <li><a href="../pages/product-list.php">Lista de Produtos</a></li>
                                    <li><a href="../pages/promotions.php">Promoções</a></li>
                                    <li><a href="../pages/sets.php">Combos</a></li>
                                </ul>
                            </li>
                            <li><a href="../pages/blog.php">Blog</a></li>
                            <li><a href="../pages/contact.php">Contato</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="../pages/shopping-cart.php">
                                <i class="fa fa-shopping-bag"></i> <span>3</span>
                            </a></li>
                        </ul>
                        <div class="header__cart__price">Itens: <span>R$150,00</span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
