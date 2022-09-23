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
                                    <form id="formulario" style="position: static;" width="100%" action="/Campos/salvar" method="post">
                                        <?= hidden('Cd_campo',isset($registro) ? $registro['Cd_campo'] : ''); ?>
                                        <?= hidden('Cd_controle',$Cd_controle); ?>
                                        <div class="row">
                                            <?= input('Rótulo','Rotulo',3,isset($registro) ? $registro['Nome'] : '','text'); ?>
                                            <?= input('Id','Id', 3, isset($registro) ? $registro['Cd_direito'] : '','text'); ?>
                                            <?= input('Tamanho','Tamanho',3,isset($registro) ? $registro['Formulario'] : '','text'); ?>
                                            <?= input('Valor inicial','Valor_inicial',3,isset($registro) ? $registro['Controller'] : '','text'); ?>
                                            <?= input('Tipo','Tipo',3,isset($registro) ? $registro['Controller'] : '','select', $tipos); ?>
                                            <?= input('Array','Array',3,isset($registro) ? $registro['Controller'] : '','text'); ?>
                                            <?= input('Atributo adicional','Atributo_adicional',3,isset($registro) ? $registro['Controller'] : '','text'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Endereco/" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <a href="/Campos/?Cd_controle=<?= $Cd_controle ?>" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <?= $edit == true ? '<a href="/Campos/excluir/'.$registro['Cd_campo'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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