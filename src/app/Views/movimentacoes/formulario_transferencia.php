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
                                    <form id="formulario_movimentacoes" style="position: static;" width="100%" action="/Movimentacoes/salvar" method="post">
                                        <div class="row">
                                            <?= hidden('Id', isset($registro) ? $registro['Id'] : '');?>
                                            <?= hidden('Tipo', $Tipo);?>
                                            <?= buscar('Centro de Armazenagem Atual','Id_Ca',4,isset($registro) ? rtrim($registro['Id_Ca']) : ''); ?>
                                            <?= buscar('Material','Id_material',4,isset($registro) ? rtrim($registro['Id_material']) : ''); ?>
                                            <?= input('Estoque','Estoque',2,isset($registro) ? rtrim($registro['Estoque']) : 0,'text', null, 'readonly'); ?>
                                            <?= input('Quantidade','Quantidade',2,isset($registro) ? rtrim($registro['Quantidade']) : '','text'); ?>
                                            <?= buscar('Centro de Armazenagem Novo','Id_recebe',4,isset($registro) ? rtrim($registro['Id_recebe']) : ''); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Movimentacoes?Entrada=<?= $Tipo?>" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Movimentacoes/excluir/'.$registro['Id'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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
                <?= $this->include('modals/cas_transferida') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
    <script type="text/javascript">
         $('#Id_material').click(function(){
            if($('#Id_Ca').val() == ''){
                document.getElementById("Id_Ca").focus();
            }else{
                $('#materiais_modal').modal('show');
            }
        });
        
        $('#Id_Ca').click(function(){
            $('#cas_modal').modal('show');
        });

        $('#Id_recebe').click(function(){
            if($('#Id_Ca').val() == ''){
                document.getElementById("Id_Ca").focus();
            }else{
                $('#cas_transferida_modal').modal('show'); //cas_transferida
            }
        });

        $(document).ready(function() {
            var index = {};

            $('#materiais').on("dblclick", "tr:has(td)", function(e) {
                $('#Id_material').val($(this).attr("data-id"));
                var id = $(this).attr("data-id");
                id = id.trim();
                var aux = id.split('-');
                id = aux[0].trim();
                console.log(id);
                console.log(index);
                // console.log($('#materiais').DataTable().rows().data().toArray()[2].Quantidade);
                $('#Estoque').val(index[id]);
                $('#materiais_modal').modal('hide');
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
                $('#materiais').DataTable({
                ajax: {
                    url: "/Materiais/listagem_saida",
                    data: {ca : $('#Id_Ca').val()},
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
                    index[data.Id] = data.Estoque;

                }
            });

            $('#cas_transferida').DataTable({
                ajax: {
                    url: "/Cas/listagem_cas",
                    data: {ca : $('#Id_Ca').val()},
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
            });

            $('#cas_transferida').on("dblclick", "tr:has(td)", function(e) {
                $('#Id_recebe').val($(this).attr("data-id"));
                $('#cas_transferida_modal').modal('hide');
            });

        })
    </script>
</body>

</html>