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
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title"><?= $titulo ?></h4>
                                        </div>
                                        <div class="col-6">
                                            <div class="btn btn-group-sm width-xs right">
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Movimentacoes/formulario?Tipo=<?= $Tipo?>" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="movimentacoes" class="table responsive table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Movimentação</th>
                                                <th>Material</th>
                                                <th>Unidade de Medida</th>
                                                <th>Quantidade</th>
                                                <th>Centro de Armazenagem</th>
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
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#movimentacoes').DataTable({
                ajax: {
                    url: "/Movimentacoes/listagem_movimentacoes",
                    data: {"Tipo" : <?= $Tipo?>},
                    type: "post"
                },
                columns:[
                    { data: "Id" },
                    { data: "Descricao_material" },
                    { data: "Unidade_de_medida" },
                    { data: "Quantidade" },
                    { data: "Descricao_ca" },
                    { data: null, "orderable": false, 'responsivePriority': 1, "className": "dt-nowrap" },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Id);
                    var botoes = '<a href="/Movimentacoes/formulario/'+ data.Id +'?Tipo=<?= $Tipo?>" title="Editar" class="meutooltip"><i class= "mdi mdi-18px mdi-file-edit" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#movimentacoes').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Movimentacoes/formulario/" + $(this).attr("data-id"),"_blank");
            });
        });
    </script>
</body>

</html>