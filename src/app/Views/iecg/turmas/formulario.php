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
                                    <form id="formulario" style="position: static;" width="100%" action="/Turmas/salvar" method="post">
                                        <?= hidden('Cd_turma',isset($registro) ? $registro['Cd_turma'] : ''); ?>
                                        <div class="row">
                                            <?= input('Curso','Cd_curso', 4, isset($registro) ? $registro['Cd_curso'] : '','datalist', $cursos); ?>
                                            <?= input('Data turma','Data_criacao',4,isset($registro) ? $registro['Data_criacao'] : '','date'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Turmas" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Turmas/excluir/'.$registro['Cd_turma'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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