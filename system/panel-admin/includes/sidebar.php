<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark bg-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

                    <div class="sidebar-brand-text mx-3">Administrador</div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">                                                                                                                  
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Cadastros
                </div>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Produtos</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu1 ?>">Produtos</a>
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu2 ?>">Categorias</a>
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu3 ?>">Sub-Categorias</a>
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu9 ?>">Tipo Envios</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-percent"></i>
                        <span>Combos e Promoções</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu4 ?>">Combos</a>
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu5 ?>">Promoções</a>

                        </div>
                    </div>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Consultas
                </div>
                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pag=<?php echo $menu6 ?>">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Clientes</span></a>
                </li>
                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pag=<?php echo $menu7 ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Vendas</span></a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pag=<?php echo $menu8 ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Backup</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->