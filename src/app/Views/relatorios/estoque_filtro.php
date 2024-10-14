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
                                    <form id="formulario_relatorio" style="position: static;" width="100%" action="/Relatorios/buscar_estoque" method="post">
                                        <div class="row">
                                            <?= buscar('Centro de Armazenagem','Id_Ca',4,''); ?>
                                            <?= buscar('Material','Id_material',4,''); ?>
                                            <?= input('Grupo','IdGrupo',3,'','datalist', $grupos); ?>
                                            <?= input('Tipo de Movimentação','movimento',3,'','datalist', $movimentos); ?>
                                            <?= input('Data Inicial','Data_inicio',2,'','date'); ?>
                                            <?= input('Data Final','Data_fim',2,'','date'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
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
                <?= $this->include('modals/materiais') ?>
                <?= $this->include('modals/cas') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
    <script type="text/javascript">
         $('#Id_material').click(function(){
            $('#materiais_modal').modal('show');
        });
        
        $('#Id_Ca').click(function(){
            $('#cas_modal').modal('show');
        });

        $(document).ready(function() {
            var index = {};

            $('#materiais').on("dblclick", "tr:has(td)", function(e) {
                $('#Id_material').val($(this).attr("data-id"));
                $('#materiais_modal').modal('hide');
            });

            $('#materiais').DataTable({
                ajax: {
                    url: "/Materiais/listagem_materiais",
                    type: "post"
                },
                columns:[
                    { data: "Descricao" },
                    { data: "Nome" },
                    { data: "Unidade_de_medida" },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Id + ' - ' + data.Descricao);
                }
            });

            $('#cas').DataTable({
                ajax: {
                    url: "/Cas/listagem_cas",
                    type: "post"
                },
                columns:[
                    { data: "Descricao" },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Id + ' - ' + data.Descricao);
                }
            });

            $('#cas').on("dblclick", "tr:has(td)", function(e) {
                $('#Id_Ca').val($(this).attr("data-id"));
                $('#cas_modal').modal('hide');
            });

        })
    </script>
</body>

</html>