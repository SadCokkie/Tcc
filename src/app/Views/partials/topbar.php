<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-end">

                <!-- <div class="dropdown d-inline-block"> 
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>
                        <span class="badge rounded-pill bg-danger ">3</span>
                    </button>
                    
                </div> -->

                <div class="dropdown d-inline-block"> <!--USER-->
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1"><b><?= session()->get('Usuario') ?></b></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        
                        <a class="dropdown-item" href=<?php echo site_url("Usuarios/alterar_senha");?>><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                        Alterar senha</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href=<?php echo site_url("Usuarios/logout");?>><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Sair</a>
                    </div>
                </div>

            </div>
            <div>
                <!-- LOGO -->
                <div class="d-lg-inline-block" style="margin-right: 18px;">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-lg">
                            <img src="/assets/images/logo-dark.png" alt="logo" height="17">
                        </span>
                    </a>
                    <a href="/" class="logo logo-light">
                        <span class="logo-lg">
                            <img src="/assets/images/logo-light.png" alt="logo" height="25">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-inline-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Pesquisar">
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>