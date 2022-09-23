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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Disciplinas/formulario" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NOME</th>
                                                <th>MESTRE</th>
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
                <?= $this->include('iecg/disciplinas/inscrever') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>

    <script type="text/javascript">

        var Cd_disciplina;
        var mestre = function (id) {
            Cd_disciplina = id;
            $('#inscrever_modal').modal('show');
        }


        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: {
                    url: "/Disciplinas/listagem",
                    dataSrc: "data",
                    type: "post",
                },
                columns:[
                    { data: "Nome" },
                    { data: "Nome_completo" , className: 'dt-center'},
                    { data: "Ativo" , className: 'dt-center'},
                    { data: null , className: 'dt-center'},
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_disciplina);
                    var botoes = '<a href="/Disciplinas/formulario/'+ data.Cd_disciplina +'" title="Editar" class="meutooltip"><i class= "fas fa-edit" ></i></a>';
                    botoes += ' <a onclick="mestre('+data.Cd_disciplina+')"  title="Mestre" class="meutooltip"><i class= "fas fa-chalkboard-teacher" ></i></a>';
                    botoes += ' <a href="/Aulas/?Cd_disciplina='+ data.Cd_disciplina +'" title="Aulas" class="meutooltip"><i class= "fas fa-calendar-alt" ></i></a>';
                    botoes += ' <a href="/Avaliacoes/?Cd_disciplina='+ data.Cd_disciplina +'" title="Avaliações" class="meutooltip"><i class= "fas fa-file-alt" ></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#datatable').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Disciplinas/formulario/" + $(this).attr("data-id"));
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
                    $(row).attr('data-id', data.Cd_empresa);
                }
            });

            $('#cadastros').on("dblclick", "tr:has(td)", function(e) {
                $.ajax({
                    url: "/Disciplinas/inscrever",
                    type: "post",
                    data: {
                        Cd_disciplina: Cd_disciplina,
                        Cd_empresa: $(this).attr("data-id"),
                    },
                    success: function (data) {
                        $('#datatable').DataTable().ajax.reload();
                        $('#inscrever_modal').modal('hide');
                    }
                })
            });
        });
    </script>
</body>
</html>