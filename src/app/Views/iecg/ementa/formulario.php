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
                                    <form id="formulario" style="position: static;" width="100%" action="/Ementa/salvar" method="post">
                                        <?php echo hidden('Cd_curso',$Cd_curso);
                                        foreach ($disciplinas as $key => $value) : 
                                            echo switch_button($value['Nome'],$value['Cd_disciplina'],$value['possui']);
                                        endforeach ?>
                                        <div class="right" style="margin-top: 5px;">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <a href="/Cursos" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
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