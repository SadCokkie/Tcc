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
                                            <div class="btn btn-group-sm width-xs right" >
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Cursos/formulario" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NOME</th>
                                                <th>MATRÍCULA</th>
                                                <th>APOSTILA</th>
                                                <th>VALOR</th>
                                                <th>ATIVO</th>
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
                    url: "/Cursos/listagem",
                    dataSrc: "data",
                    type: "post",
                },
                columns:[
                    { data: "Nome" },
                    { data: "Matricula" },
                    { data: "Apostila" },
                    { data: "Valor" },
                    { data: "Ativo" },
                    { data: null },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_curso);
                    var botoes = '<a href="/Cursos/formulario/'+ data.Cd_curso +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    botoes += ' <a href="/Ementa/?Cd_curso='+ data.Cd_curso + '" title="Contatos" class="meutooltip"><i class= "fas fa-list" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#datatable').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Cursos/formulario/" + $(this).attr("data-id"));
            });
        });
    </script>
</body>
</html>