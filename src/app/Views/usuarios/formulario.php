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
                                            <?= hidden('Cd_USUARIO',isset($registro) ? $registro['Cd_USUARIO'] : ''); ?>
                                            <?= input('Email','Email',6,isset($registro) ? $registro['Email'] : '','text'); ?>
                                            <?= input('Unidade de Negócio','Cd_unidade_n',2,isset($registro) ? $registro['Cd_unidade_n'] : '','datalist', $unidades); ?>
                                        </div>
                                        <div class="row">
                                            <?= empresa('Empresa','Cd_empresa',6,isset($registro) ? $registro['Cd_empresa'] : ''); ?>
                                            <?= input('Nome do Usuário','Usuario',4,isset($registro) ? $registro['Usuario'] : '','text'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Usuarios" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Usuarios/excluir/'.$registro['Cd_USUARIO'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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
    <script type="text/javascript">
        var empresa = function () {
            $('#cadastros_modal').modal('show');
        }

        $('#cadastros').DataTable({
                ajax: {
                    url: "/Empresas/listagem_empresas",
                    type: "post",
                    data: {'divisao' : 30}
                },
                columns:[
                    { data: "Cd_empresa" },
                    { data: "Nome_completo" },
                    { data: "Fantasia" },
                    { data: "Fone" },
                    { data: "Municipio" },
                    { data: "Uf" },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_empresa + ' - ' + data.Nome_completo);
                }
            });

            $('#cadastros').on("dblclick", "tr:has(td)", function(e) {
                $('#Cd_empresa').val($(this).attr("data-id"));
                $('#cadastros_modal').modal('hide');
                $('#buscaUnidade_modal').modal('hide');
            });      
    </script>
</body>

</html>