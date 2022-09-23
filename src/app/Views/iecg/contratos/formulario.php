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
                                    <form id="formulario" style="position: static;" width="100%" action="/Contratos/salvar" method="post">
                                        <?= hidden('Cd_contrato',isset($registro) ? $registro['Cd_contrato'] : ''); ?>
                                        <div class="row">
                                            <?= input('Condição de pagamento','Condicao_pagamento',4,isset($registro) ? $registro['Condicao_pagamento'] : '','text'); ?>    
                                            <?= input('Parcelas','Parcelas',4,isset($registro) ? $registro['Parcelas'] : '','text'); ?>   
                                            <?= input('Vencimento','Vencimento',4,isset($registro) ? $registro['Vencimento'] : '','text'); ?>
                                            <?= input('Entrada','Entrada',4,isset($registro) ? $registro['Entrada'] : '','text'); ?>
                                            <?= input('Curso','Cd_curso', 4, isset($registro) ? $registro['Cd_curso'] : '','datalist', $cursos); ?>
                                            <?= empresa('Aluno','Cd_empresa',4,isset($registro) ? $registro['Cd_empresa'] : ''); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <a href="/Contratos" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <?= $edit == true ? '<a href="/Contratos/excluir/'.$registro['Cd_contrato'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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
        $(document).ready(function() {
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
            });
        });
    </script>
</body>

</html>