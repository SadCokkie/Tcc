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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" onclick="inserir()" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/Disciplinas/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>DATA</th>
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
                <?= $this->include('iecg/aulas/inscrever') ?>
                <?= $this->include('modals/anexos') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>

    <script type="text/javascript">
        var Cd_disciplina;

        var inserir = function () {
            Cd_disciplina = <?= $Cd_disciplina ?>;
            $('#inserir_modal').modal('show');
        }

        var remover = function (aula) {
            $.ajax({
                url: "/Aulas/excluir",
                type: "post",
                data: {
                    Cd_aula: aula,
                },
                success: function (data) {
                    $('#datatable').DataTable().ajax.reload();
                }
            });
        }

        var deletar = function(anexo){
            $.ajax({
                url: "/Anexos/deletar",
                type: "post",
                data: {
                    Cd_anexo: anexo,
                },
                success: function(data){
                    $('#anexos').DataTable().ajax.reload();
                    console.log('sucesso exclusão');
                }
            });
        }

        var anexar = function(id){
            $('#id').val(id);
            $('#anexos').DataTable({
                ajax: {
                    url: "/Anexos/listagem",
                    dataSrc: "data",
                    type: "post",
                    data: {
                        id: id,
                        CampoFiltro: 'Aula',
                    },
                },
                columns:[
                    { data: "Nome" },
                    { data: "Data" },
                    { data: null },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                    ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_anexo);
                    var botoes = ' <a  title="Deletar" onClick = "deletar('+data.Cd_anexo+')" class="meutooltip"><i class= "fas fa-trash" ></i></a>';
                    botoes += ' <a  title="Baixar" href = "/Anexos/baixar/?nome='+data.Nome+'&origem=aulas" class="meutooltip"><i class= "fas fa-file-download" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                },
                success: function (data) {
                    $('#datatable').DataTable().ajax.reload();
                }
            });
            $('#anexos_modal').modal('show');
        }

        $(document).ready(function() {

            $('#id_relacional').val(<?= $Cd_disciplina ?>);
            $('#tipo').val("aulas");

            $('#datatable').DataTable({
                ajax: {
                    url: "/Aulas/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_disciplina) ? ",data: {Cd_disciplina: ".$Cd_disciplina." }" : "" ?>,
                },
                columns:[
                    { data: "Data" },
                    { data: null },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                    ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_aula);
                    var botoes = '<a href="/Aulas/formulario/'+ data.Cd_aula +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    botoes += ' <a href="/Presencas/?Cd_aula='+ data.Cd_aula +'" title="Presenças" class="meutooltip"><i class= "fas fa-map-marker" ></i></a>';
                    botoes += ' <a onclick="remover('+ data.Cd_aula +')" title="Remover" class="meutooltip"><i class= "fas fa-trash" ></i></a>';
                    botoes += ' <a onclick="anexar('+ data.Cd_aula +')" title="Anexos" class="meutooltip"><i class= "fas fa-file-alt" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#image').on('change', function (e) {
                e.preventDefault();
                $('#form_anexos').submit();
            });

            $('#anexos_modal').on('hide.bs.modal',function () {
                $('#anexos').DataTable().destroy();
                $('#datatable').DataTable().ajax.reload();
            });
        });
    </script>
</body>
</html>