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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Contratos/formulario" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Condicao de pagamento</th>
                                                <th>Parcelas</th>
                                                <th>Entrada</th>
                                                <th>Curso</th>
                                                <th>Aluno</th>
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
                <?= $this->include('iecg/contratos/parcelas') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>

    <script type="text/javascript">
        var parcelas;
        var pagar = function (parcela) {
            $.ajax({
                url: "/Contratos/pagar_parcela",
                type: "post",
                data: {
                    Cd_parcela: parcela,
                },
                success: function (data) {
                    $('#parcelas').DataTable().ajax.reload();
                }
            });
        }

        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: {
                    url: "/Contratos/listagem",
                    dataSrc: "data",
                    type: "post",
                },
                columns:[
                    { data: "Condicao_pagamento" },
                    { data: "Parcelas" },
                    { data: "Entrada" },
                    { data: "Nome_curso" },
                    { data: "Nome_aluno" },
                    { data: null },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_contrato);
                    var botoes = '<a href="/Contratos/formulario/'+ data.Cd_contrato +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    botoes += ' <a href="/Historico/?Cd_empresa='+ data.Cd_empresa + '" title="Histórico" class="meutooltip"><i class= "fas fa-list" ></i></a>';
                    if(data.Parcelas >= 1) {
                        botoes += ' <a onclick="parcelas('+ data.Cd_contrato +')" title="Parcelas" class="meutooltip"><i class= "fas fa-dollar-sign" ></i></a>';
                    }
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#datatable').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Contratos/formulario/" + $(this).attr("data-id"));
            });

            parcelas = function (contrato) {
                $('#parcelas').DataTable({
                    ajax: {
                        url: "/Contratos/listagem_parcelas",
                        dataSrc: "data",
                        type: "post",
                        data: {contrato: contrato},
                    },
                    columns:[
                        { data: "Tipo" },
                        { data: "Valor" },
                        { data: "Validade" },
                        { data: "Situacao" },
                        { data: "Data_pagamento" },
                        { data: null },
                    ],
                    columnDefs: [
                    {className: "dt-center", targets: "_all"}
                    ],
                    createdRow: function (row, data, dataIndex) {
                        $(row).attr('data-id', data.Cd_parcela);
                        var botoes = '<a onclick="pagar('+ data.Cd_parcela +')" title="Pagar" class="meutooltip"><i class= "fas fa-money-bill" ></i></a>';
                        if (data.Situacao == 'PAGO') {
                            botoes = '';
                        }
                        $('td', row).eq(row.childElementCount-1).html(botoes);
                    }
                });

                $('#parcelas_modal').modal('show');
            }

            $('#parcelas_modal').on('hide.bs.modal',function () {
                $('#parcelas').DataTable().destroy();
            });
        });
    </script>
</body>
</html>