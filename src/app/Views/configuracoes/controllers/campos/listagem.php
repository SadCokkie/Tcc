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
                                                <a class="btn btn-primary" title="Inserir" href="/Campos/formulario/?Cd_controle=<?= $Cd_controle ?>"><i class="fas fa-plus"></i></a>
                                                <a class="btn btn-secondary" href="/Controllers" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Rótulo</th>
                                                <th>Id</th>
                                                <th>Tamanho</th>
                                                <th>Valor inicial</th>
                                                <th>Tipo</th>
                                                <th>Array</th>
                                                <th>Atributo adicional</th>
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
            $('#datatable').DataTable({
                ajax: {
                    url: "/Campos/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_controle) ? ",data: {Cd_controle: ".$Cd_controle." }" : "" ?>,
                },
                columns:[
                    { data: "Rotulo" },
                    { data: "Id" },
                    { data: "Tamanho" },
                    { data: "Valor_inicial" },
                    { data: "Tipo" },
                    { data: "Array" },
                    { data: "Atributo_adicional" },
                    { data: null },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_campo);
                    var botoes = '<a href="/Campos/formulario/'+ data.Cd_campo +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#datatable').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Campos/formulario/" + $(this).attr("data-id"),"_blank");
            });
        });
    </script>
</body>
</html>