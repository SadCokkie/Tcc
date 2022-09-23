<?= $this->include('partials/header') ?>
    <div style="margin-left: 0; margin-right: 0; padding-left: 0;">
        <div id="layout-wrapper">
            <?= $this->include('partials/menu') ?>
            <div class="main-content">
                <div class="page-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- ============================================================== -->
                                <!-- Start Content here -->
                                <!-- ============================================================== -->
                                <div class="card-body">
                                    <div class="row" style="margin-bottom: 30px;">
                                        <?= empresa('Aluno','empresa',11,null) ?>
                                        <div class="col-1"><a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" onclick="filtrar()" role="button" >Filtrar</a></div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Disciplina</th>
                                                <th>Data</th>
                                                <th>Presente</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- ============================================================== -->
                                <!-- END Content here -->
                                <!-- ============================================================== -->
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
        var filtrar;
        var colunas;
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
                $('#empresa').val($(this).attr("data-id"));
                $('#cadastros_modal').modal('hide');
            });

            filtrar = function () {
                if ($.fn.dataTable.isDataTable("#datatable")) {
                    $('#datatable').DataTable().destroy();
                }
                $('#datatable').DataTable({
                    ajax: {
                        url: "/Relatorios/buscar_atestados",
                        type: "post",
                        data: {empresa : $('#empresa').val()}
                    },
                    columns:[
                        { data: "Nome_completo", orderable: false },
                        { data: "Data", orderable: false },
                        { data: "Duracao" , orderable: false},
                    ],
                    createdRow: function (row, data, dataIndex) {
                        $(row).attr('data-id', data.Nome_completo);
                    }
                });
            }
        });
    </script>
</body>
</html>