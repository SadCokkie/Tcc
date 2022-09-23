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
                                                <a class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Ementa/formulario<?= (isset($Cd_curso) ? "/?Cd_curso=".$Cd_curso : "") ?>" role="button" ><i class="fas fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Disciplinas</th>
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
                    url: "/Ementa/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_curso) ? ",data: {Cd_curso: ".$Cd_curso." }" : "" ?>,
                },
                columns:[
                    { data: "Nome_disciplina" },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_ementa);
                    // var botoes = '<a href="/Ementa/formulario/'+ data.Cd_ementa +'/?Cd_curso='+ $Cd_curso +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    // $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#datatable').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Ementa/formulario/" + $(this).attr("data-id"),"_blank");
            });
        });
    </script>
</body>
</html>