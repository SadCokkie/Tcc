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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" onclick="inscrever()" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/Turmas/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NOME</th>
                                                <th>FUNÇÃO</th>
                                                <th></th>
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
                <?= $this->include('iecg/inscritos/inscrever') ?>
                <?= $this->include('iecg/inscritos/transferir') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>

    <script type="text/javascript">
        var inscrever = function () {
            $('#Cd_turma').val(<?= $Cd_turma; ?>);
            $('#cadastros').DataTable({
                ajax: {
                    url: "/Empresas/listagem_empresas",
                    type: "post"
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
                    $(row).attr('data-id', data.Cd_empresa);
                }
            });
            $('#inscrever_modal').modal('show');
        }

        var remover = function (Cd_inscrito) {
            $.ajax({
                url: "/Inscritos/remover",
                type: "post",
                data: {
                    Cd_inscrito: Cd_inscrito,
                },
                success: function (data) {
                    $('#datatable').DataTable().ajax.reload();
                }
            })
        }

        var inscrito;

        var transferir = function (Cd_inscrito) {
            inscrito = Cd_inscrito;
            console.log(inscrito);
            $('#transferir').DataTable({
                ajax: {
                    url: "/Turmas/listagem_transferencia",
                    type: "post",
                    data: {
                        Cd_turma: <?= $Cd_turma ?>,
                        },
                },
                columns:[
                    { data: "Descricao" },
                    ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_turma);
                }
            });
            $('#transferir_modal').modal('show');
        }

        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: {
                    url: "/Inscritos/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_turma) ? ",data: {Cd_turma: ".$Cd_turma." }" : "" ?>,
                },
                columns:[
                    { data: "Nome_completo" },
                    { data: "Descricao_divis" },
                    { data: null },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                    ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_inscrito);
                    var botoes = '<a onclick="remover('+data.Cd_inscrito+')" title="Remover" class="meutooltip"><i class= "fas fa-trash" ></i></a>';
                    botoes += '  <a onclick="transferir('+data.Cd_inscrito+')" title="Transferir" class="meutooltip"><i class= "fas fa-exchange-alt" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

           

            $('#cadastros').on("dblclick", "tr:has(td)", function(e) {
                $.ajax({
                    url: "/Inscritos/inscrever",
                    type: "post",
                    data: {
                        Cd_turma: <?= $Cd_turma ?>,
                        Cd_empresa: $(this).attr("data-id"),
                    },
                    success: function (data) {
                        $('#datatable').DataTable().ajax.reload();
                        $('#inscrever_modal').modal('hide');
                    }
                })
            });

            $('#transferir').on("dblclick", "tr:has(td)", function(e) {
                $.ajax({
                    url: "/Inscritos/transferir",
                    type: "post",
                    data: {
                        Cd_inscrito: inscrito,
                        Cd_turma: $(this).attr("data-id"),
                    },
                    success: function (data) {
                        $('#datatable').DataTable().ajax.reload();
                        $('#transferir_modal').modal('hide');
                    }
                })
            });
            // on modal dismiss dttable destroy
            $('#transferir_modal').on('hide.bs.modal',function () {
                $('#transferir').DataTable().destroy();
                $('#datatable').DataTable().ajax.reload();
            });

            $('#inscrever_modal').on('hide.bs.modal',function () {
                $('#cadastros').DataTable().destroy();
                $('#datatable').DataTable().ajax.reload();
            });
        });
    </script>
</body>
</html>