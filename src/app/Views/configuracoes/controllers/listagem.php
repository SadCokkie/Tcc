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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Controllers/formulario<?= (isset($Cd_pai) ? "/?Cd_pai=".$Cd_pai : "") ?>" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Controller</th>
                                                <th>Formulario</th>
                                                <th>Direito</th>
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
                    url: "/Controllers/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_pai) ? ",data: {Cd_pai: ".$Cd_pai." }" : "" ?>,
                },
                columns:[
                    { data: "Nome" },
                    { data: "Controller" },
                    { data: "Formulario" },
                    { data: "Direito" },
                    { data: null },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_controle);
                    var botoes = '<a href="/Controllers/formulario/'+ data.Cd_controle +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    botoes += ' <a href="/Campos/?Cd_controle='+ data.Cd_controle + '" title="Campos" class="meutooltip"><i class= "fas fa-list" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#datatable').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Controllers/formulario/" + $(this).attr("data-id"),"_blank");
            });
        });
    </script>
</body>
</html>