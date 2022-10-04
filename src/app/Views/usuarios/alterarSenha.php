<?= $this->include('partials/main') ?>

<head>
    <title><?= $titulo ?></title>
    <?= $this->include('partials/head-css') ?>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Portal CIGAM</h5>
                                <p class="text-white-50 mb-0"><?= $senhaAtual != '' ? 'Alterar Senha' : 'Criar senha'?></p>
                                <a href="/" class="logo logo-admin mt-4">
                                    <img src="/assets/images/logo-sm-dark.png" alt="logo-sm-dark" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form class="form-horizontal" method="post" name="form" id="form" enctype="multipart/form-data" action="salvar_alteracao_senha">
                                    <?php if($senhaAtual != '') :?>
                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Senha Atual</label>
                                        <input name="userpassword" type="text" class="form-control" id="userpassword" placeholder="Digite senha atual">
                                    </div>
                                    <?php endif?>
                                    <?= hidden('Usuario', isset($Usuario) ? $Usuario : '')?>
                                    <div class="mb-3">
                                        <label class="form-label" for="newpassword">Senha</label>
                                        <input name="newpassword" type="password" class="form-control" id="newpassword" placeholder="Digite senha">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="confirmnewpassword">Confirmar Senha</label>
                                        <input name="confirmnewpassword" type="password" class="form-control" id="confirmnewpassword" placeholder="Digite senha">
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button class="btn w-100 waves-effect waves-light" style="background-color:#FF6911; color:#ffffff;" type="submit"><b>Salvar</b></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <?= $this->include('partials/vendor-scripts') ?>

    <script src="/assets/js/app.js"></script>

</body>

</html>