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
                                    <form id="formulario" style="position: static;" width="100%" action="/GruposDireitos/salvar" method="post">
                                        <?= hidden('Cd_gdirei',isset($registro) ? $registro['Cd_gdirei'] : ''); ?>
                                        <div class="row">
                                            <?= input('Chave','Chave',3,isset($registro) ? $registro['Nome'] : '','text'); ?>
                                            <?= input('Nome','Nome', 3, isset($registro) ? $registro['Cd_gdirei'] : '','text'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/GruposDireitos" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/GruposDireitos/excluir/'.$registro['Cd_gdirei'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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