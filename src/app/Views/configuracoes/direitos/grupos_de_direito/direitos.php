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
                                    <form id="formulario" style="position: static;" width="100%" action="/GruposDireitos/vincular" method="post">
                                        <?php echo hidden('Cd_gdirei',$Cd_gdirei);
                                        foreach ($direitos as $key => $value) : 
                                            echo switch_button($value['Nome'],$value['Cd_direito'],$value['possui']);
                                        endforeach ?>
                                        <div class="right" style="margin-top: 5px;">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <a href="/GruposDireitos" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
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