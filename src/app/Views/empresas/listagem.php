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
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" href="/Empresas/formulario" role="button" ><i class="fas fa-plus"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/" role="button" ><i class="fas fa-reply"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="empresas" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>CÓDIGO</th>
                                                <th>NOME COMPLETO</th>
                                                <th>FANTASIA</th>
                                                <th>FONE</th>
                                                <th>MUNICÍPIO</th>
                                                <th>UF</th>
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
            $('#empresas').DataTable({
                ajax: {
                    url: "/Empresas/listagem_empresas",
                    type: "post"
                },
                columns:[
                    { data: "Cd_empresa" },
                    { data: "Nome_completo" },
                    { data: "Fantasia" },
                    { data: "Fone" },
                    { data: "Municipio" },
                    { data: "Uf" },
                    { data: null, "orderable": false, 'responsivePriority': 1, "className": "dt-nowrap" },
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_empresa);
                    var botoes = '<a href="/Empresas/formulario/'+ data.Cd_empresa +'" title="Editar" class="meutooltip"><i class= "mdi mdi-18px mdi-file-edit" ></i></a>';
                    botoes += '<a href="/Contatos/inicio/'+ data.Cd_empresa + '" title="Contatos" class="meutooltip"><i class= "mdi mdi-18px mdi-contact-phone" ></i></a>';
                    botoes += '<a href="/Empresa_end/?id='+ data.Cd_empresa + '" title="Endereços Entrega" class="meutooltip"><i class = "mdi mdi-18px mdi-map-marker-radius"></i></a>';
                    $('td', row).eq(row.childElementCount-1).html(botoes);
                }
            });

            $('#empresas').on("dblclick", "tr:has(td)", function(e) {
                window.open("/Empresas/formulario/" + $(this).attr("data-id"),"_blank");
            });
        });
    </script>
</body>

</html>