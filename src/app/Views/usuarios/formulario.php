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
                                    <form id="formulario_usuarios" style="position: static;" width="100%" action="/Usuarios/salvar" method="post">
                                        <div class="row">
                                            <?= hidden('Id', isset($registro) ? $registro['Id'] : '');?>
                                            <?= input('Nome do Usuário','Usuario',4,isset($registro) ? rtrim($registro['Usuario']) : '','text'); ?>
                                        </div>
                                        <br>
                                        <div>
                                            <input type="checkbox" id="Admin" name="Admin" <?= isset($registro['Admin']) ? ($registro['Admin'] == 1 ? 'checked' : 'unchecked') : 'checked';?>>
                                            <label for="Admin">Admin</label>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Usuarios" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Usuarios/excluir/'.$registro['Id'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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