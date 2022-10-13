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
                                    <form id="formulario_materiais" style="position: static;" width="100%" action="/Materiais/salvar" method="post">
                                        <div class="row">
                                            <?= hidden('Id', isset($registro) ? $registro['Id'] : '');?>
                                            <?= input('Descrição','Descricao',4,isset($registro) ? rtrim($registro['Descricao']) : '','text'); ?>
                                            <?= input('Grupo','Grupo',4,isset($registro) ? rtrim($registro['Grupo']) : '','text'); ?>
                                            <?= input('Unidade de Medida','Unidade_de_medida',4,isset($registro) ? rtrim($registro['Unidade_de_medida']) : '','text'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Materiais" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Materiais/excluir/'.$registro['Id'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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
                <?= $this->include('modals/cadastros') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
</body>

</html>