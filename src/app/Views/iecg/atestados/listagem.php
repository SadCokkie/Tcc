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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" onclick="lancar()" role="button" >Lançar atestado</a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ALUNO</th>
                                                <th>DATA</th>
                                                <th>DURAÇÃO</th>
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
                <?= $this->include('iecg/atestados/lancar') ?>
                <?= $this->include('modals/anexos') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
    <script type="text/javascript">
        var lancar = function () {
            $('#lancar_modal').modal('show');
        }

        var deletar = function(anexo){
            $.ajax({
                url: "/Anexos/deletar",
                type: "post",
                data: {
                    Cd_anexo: anexo,
                },
                success: function(data){
                    console.log(data);
                    if(!data.exclui){
                           $.bootstrapGrowl(data.msg, {
                                ele: "body",
                                type: "danger",
                                offset: {
                                    from: "top",
                                    amount: 60
                                },
                                align: "right",
                                width: 260,
                                delay: 5000,
                                allow_dismiss: 1,
                                stackup_spacing: 10
                            });
                        }else{
                            $('#anexos').DataTable().ajax.reload();
                            console.log('sucesso exclusão');
                        }
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
                        CampoFiltro: 'Empresa',
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
                    botoes += ' <a  title="Baixar" href = "/Anexos/baixar/?nome='+data.Nome+'&origem=empresas" class="meutooltip"><i class= "fas fa-file-download" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                },
                success: function (data) {
                    $('#datatable').DataTable().ajax.reload();
                }
            });
            $('#anexos_modal').modal('show');
        }

        $(document).ready(function() {
            $('#id_relacional').val('');
            $('#tipo').val("empresas");

            $('#datatable').DataTable({
                ajax: {
                    url: "/Atestados/listagem",
                    dataSrc: "data",
                    type: "post",
                },
                columns:[
                    { data: "Nome_completo" },
                    { data: "Data" },
                    { data: "Duracao" },
                    { data: null },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_atestado);
                    var botoes =' <a onclick="anexar('+ data.Cd_empresa +')" title="Anexos" class="meutooltip"><i class= "fas fa-file-alt" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
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
                $('#Cd_empresa').val($(this).attr("data-id"));
                $('#cadastros_modal').modal('hide');
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