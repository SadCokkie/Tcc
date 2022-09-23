<?= $this->include('partials/header') ?>
    <div style="margin-left: 0; margin-right: 0; padding-left: 0;">
        <div id="layout-wrapper">
            <?= $this->include('partials/menu') ?>
            <div class="main-content">
                <div class="page-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?= $titulo ?></h4>
                                    <!-- ============================================================== -->
                                    <!-- Start Content here -->
                                    <!-- ============================================================== -->
                                    <form id="formulario" style="position: static;" width="100%" action="/Controllers/salvar" method="post">
                                        <?= hidden('Cd_controle',isset($registro) ? $registro['Cd_controle'] : ''); ?>
                                        <div class="row">
                                            <?= input('Nome','Nome',3,isset($registro) ? $registro['Nome'] : '','text'); ?>
                                            <?= input('Direito','Cd_direito', 3, isset($registro) ? $registro['Cd_direito'] : '','datalist', $direitos); ?>
                                            <?= input('Formulário','Formulario',3,isset($registro) ? $registro['Formulario'] : '','text'); ?>
                                            <?= input('Controller','Controller',3,isset($registro) ? $registro['Controller'] : '','text'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Controllers" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Controllers/excluir/'.$registro['Cd_controle'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
                                        </div>
                                    </form>
                                    <!-- ============================================================== -->
                                    <!-- END Content here -->
                                    <!-- ============================================================== -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->include('partials/footer') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
</body>

</html>