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
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-6">
                                            <span class="left"><?= $titulo ?></span>
                                        </div>
                                        <div class="col-6">
                                            <div class="btn btn-group-sm width-xs right">
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Chamada" onclick="chamada()" role="button" >Chamada</a>
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" onclick="cadastros()" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/Aulas/?Cd_disciplina=<?= $Cd_disciplina?>" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ALUNO</th>
                                                <th>PRESENTE</th>
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
                <?= $this->include('iecg/presencas/chamada') ?>
                <?= $this->include('modals/cadastros') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
    <script type="text/javascript">
        var chamada = function () {
            console.log('chamada');
            $('#chamada_modal').modal('show');
        }

        var cadastros = function () {
            console.log('cadastros');
            $('#cadastros_modal').modal('show');
        }

        var presenca = function (empresa) {
            $.ajax({
                url: "/Presencas/adicionar",
                type: "post",
                data: {
                    Cd_empresa: empresa,
                    Presente: 1,
                    Cd_aula: <?= $Cd_aula ?>
                },
                success: function (data) {
                    $('#datatable').DataTable().ajax.reload();
                }
            })
        }

        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: {
                    url: "/Presencas/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_aula) ? ",data: {Cd_aula: ".$Cd_aula." }" : "" ?>,
                },
                columns:[
                    { data: "Nome_completo" },
                    { data: "Presente" },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_presenca);
                }
            });

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
                presenca($(this).attr("data-id"));
                $('#cadastros_modal').modal('hide');
            });
        });
    </script>
</body>
</html>