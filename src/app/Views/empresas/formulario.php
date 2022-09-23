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
                                    <form id="formulario_empresas" style="position: static;" width="100%" action="/Empresas/salvar" method="post">
                                        <?= hidden('Cd_empresa',isset($registro) ? $registro['Cd_empresa'] : ''); ?>
                                        <?= hidden('Ativo',isset($registro) ? $registro['Ativo'] : 1); ?>
                                        <?= hidden('Cd_direito', isset($registro) ? $registro['Cd_direito'] : ''); ?>
                                        <?= hidden('Divisao', isset($registro) ? $registro['Divisao'] : '30') ?>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <?= input('Nome','Nome_completo',6,isset($registro) ? $registro['Nome_completo'] : '','text'); ?>
                                            <?= input('CPF','Cnpj_cpf',6,isset($registro) ? $registro['Cnpj_cpf'] : '','text'); ?>
                                            <?= input('Telefone','Fone',4,isset($registro) ? $registro['Fone'] : '','text'); ?>
                                            <?= input('Data de Nascimento','Dt_aniversario',2,isset($registro) ? $registro['Dt_aniversario'] : '','date'); ?>
                                            <?= input('Geração','Tipo_de_empresa',4,isset($registro)?$registro['Tipo_de_empresa']:'', 'datalist',$geracoes); ?> <!--  -->
                                            <?= input('Data do Encontro','Dt_admissao',2,isset($registro) ? $registro['Dt_admissao'] : '','date'); ?>
                                        </div>
                                        <div class="row">
                                            <?= empresa_multipla('Pastor(a)','Cd_responsavel',6, isset($registro) ? $registro['Cd_responsavel'] : null)?>
                                            <?= empresa_multipla('Líder','Cd_representant',6,isset($registro) ? $registro['Cd_representant'] : null)?>
                                        </div>
                                        <!-- Desc_centralizadora  
                                        Cd_centralizado -->
                                        <div class="row" style="margin-top: 20px;">
                                            <h4 class="card-title">Endereço</h4>
                                        </div>
                                        <div class="row"> <!-- Endereço 0 -->
                                            <?= input('CEP','Cep', 2, isset($registro) ? $registro['Cep'] : '','text'); ?>
                                            <?= input('Endereço','Endereco',4,isset($registro) ? $registro['Endereco'] : '','text'); ?>
                                            <?= input('Número','Numero',2,isset($registro) ? $registro['Numero'] : '','text'); ?>
                                            <?= input('Bairro','Bairro',4,isset($registro) ? $registro['Bairro'] : '','text'); ?>
                                            <?= input('UF','Uf',1,isset($registro) ? $registro['Uf'] : '','text'); ?>
                                            <?= input('Município','Municipio',5,isset($registro) ? $registro['Municipio'] : '','text'); ?>
                                            <?= input('Complemento','Complemento',6,isset($registro) ? $registro['Complemento'] : '','text'); ?>
                                        </div>
                                        <div class="right" style="margin-top: 5px;">
                                            <a href="/Empresas" class="btn btn-secondary"><i class="fas fa-reply"></i></a>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                                            <?= $edit == true ? '<a href="/Empresas/excluir/'.$registro['Cd_empresa'].'" class="btn btn-dark"><i class="fas fa-trash"></i></a>' : '' ?>
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
                <?= $this->include('modals/cadastros') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
    <script type="text/javascript">
        var tipo; 
        var doc = this;

        var empresa = function(id){
            if(id.id == 'Cd_representant'){
                tipo = "representante";
            }else{
                tipo = "responsavel";
            }
            $('#cadastros_modal').modal('show');
        }

        $('#Cep').blur(function(){
            $.ajax({
                url: "/Empresas/preencheEndereco",
                type: "POST",
                data: {"Cep": $('#Cep').val()},
                dataType: "json",
                success: function(data){
                    if(!data.valida){
                            msg = 'Cep inválido';
                            console.log(msg);
                            $('#Cep').parent().addClass('has-error');
                            $.bootstrapGrowl(msg, {
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
                            $("#Cep").val('').focus();
                        }else{
                            $('#Endereco').val(data.Endereco);
                            $('#Bairro').val(data.Bairro);
                            $('#Uf').val(data.Estado);
                            $('#Municipio').val(data.Cidade);
                        }
                }
            });
        });

        
        $('#Cnpj_cpf').blur(function(){
            if($('#Cnpj_cpf').val().length == 11 && $('#Cnpj_cpf').val() != ""){
                $.ajax({
                    url: "/Empresas/validaCpf",
                    type: "POST",
                    data: {"cpf": $('#Cnpj_cpf').val()},
                    dataType: "json",
                    success: function(data){
                        // console.log("teste cpf");
                        if(!data){
                            msg = 'CPF inválido';
                            console.log(msg);
                            $('#Cnpj_cpf').parent().addClass('has-error');
                            $.bootstrapGrowl(msg, {
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
                            $("#Cnpj_cpf").val('').focus();
                        }
                    }
                });
            }else if($('#Cnpj_cpf').val().length == 14 && $('#Cnpj_cpf').val() != ""){
                $.ajax({
                    url: "/Empresas/validaCnpj",
                    type: "POST",
                    data: {"cnpj": $('#Cnpj_cpf').val()},
                    dataType: "json",
                    success: function(data){
                        if(!data){
                            msg = 'CNPJ inválido';
                            console.log(msg);
                            $('#Cnpj_cpf').parent().addClass('has-error');
                            $.bootstrapGrowl(msg, {
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
                            $("#Cnpj_cpf").val('').focus();
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
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
                console.log($(this).attr("data-id"));
                if(tipo == 'representante'){
                    console.log(tipo);
                    $('#Cd_representant').val($(this).attr("data-id"));
                }else{
                    console.log(tipo);
                    $('#Cd_responsavel').val($(this).attr("data-id"));
                }
                $('#cadastros_modal').modal('hide');
            });

            // $('#cadastros_modal').on('hide.bs.modal', function () { 
            //     $('#cadastros').DataTable().destroy();
            // }); 
            
        });
    </script>
</body>

</html>