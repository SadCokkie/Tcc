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
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-6">
                                            <div class="btn btn-group-md width-xs">
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light" onclick="previous()"><i class="fas fa-arrow-left"></i></a>
                                                <a id="descritivo" style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light"><?= substr($s_inicio,8,2).'/'.substr($s_inicio,5,2).'/'.substr($s_inicio,2,2) ?> - <?= substr($s_limite,8,2).'/'.substr($s_limite,5,2).'/'.substr($s_limite,2,2) ?></a>
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light" onclick="next()"><i class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="btn btn-group-md width-xs right">
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light" onclick="mes()" role="button" >MÊS</a>
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light" onclick="semana()" role="button" >SEMANA</a>
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light" onclick="dia()" role="button" >DIA</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>DATA</th>
                                                <th>MATERIAL</th>
                                                <th>QUANTIDADE</th>
                                                <th>MOVIMENTAÇÃO</th>
                                                <th>ID MOV.</th>
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
        var d_inicio = '<?= $d_inicio ?>';
        var d_limite = '<?= $d_limite ?>';        
        var s_inicio = '<?= $s_inicio ?>';
        var s_limite = '<?= $s_limite ?>';
        var m_inicio = '<?= $m_inicio ?>';
        var m_limite = '<?= $m_limite ?>'; 

        var modelo   = 'semana';

        var dt_inicio = '<?= $s_inicio ?>';
        var dt_limite = '<?= $s_limite ?>';

        var mes;
        var semana;
        var dia;
        var next;
        var previous;

        $(document).ready(function() {
            dia = function () {
                modelo = 'dia';
                dt_inicio = d_inicio;
                dt_limite = d_limite;
                console.log(dt_inicio.substring(8,10));
                document.getElementById("descritivo").innerHTML = dt_inicio.substring(8,10) + '/' + dt_inicio.substring(5,7)+ '/' + dt_inicio.substring(2,4);
                $('#datatable').DataTable().clear().draw();
            }
            semana = function () {
                modelo = 'semana';
                dt_inicio = s_inicio;
                dt_limite = s_limite;
                document.getElementById("descritivo").innerHTML = dt_inicio.substring(8,10) + '/' + dt_inicio.substring(5,7)+ '/' + dt_inicio.substring(2,4) + ' - ' + dt_limite.substring(8,10) + '/' + dt_limite.substring(5,7)+ '/' + dt_limite.substring(2,4);
                $('#datatable').DataTable().clear().draw();
            }
            mes = function () {
                modelo = 'mes';
                dt_inicio = m_inicio;
                dt_limite = m_limite;
                document.getElementById("descritivo").innerHTML = dt_inicio.substring(8,10) + '/' + dt_inicio.substring(5,7)+ '/' + dt_inicio.substring(2,4) + ' - ' + dt_limite.substring(8,10) + '/' + dt_limite.substring(5,7)+ '/' + dt_limite.substring(2,4);
                $('#datatable').DataTable().clear().draw();
            }
            previous = function () {
                switch (modelo) {
                    case 'dia':
                        parts = d_inicio.split('-');
                        dataAnterior = new Date(parts[0],parts[1] - 1, parts[2]);
                        dataAnterior.setDate(dataAnterior.getDate() - 1);
                        d_inicio = dataAnterior.toISOString().slice(0, 10);
                        d_limite = dataAnterior.toISOString().slice(0, 10); 
                        console.log(typeof d_inicio);
                        console.log( d_inicio);  
                        dia();
                        break;
                    case 'semana':
                        partsInicio = s_inicio.split('-');
                        partsLimite = s_limite.split('-');
                        semanaInicio = new Date(partsInicio[0],partsInicio[1] - 1, partsInicio[2]);
                        semanaInicio.setDate(semanaInicio.getDate() - 7);
                        semanaLimite = new Date(partsLimite[0],partsLimite[1] - 1, partsLimite[2]);
                        semanaLimite.setDate(semanaLimite.getDate() - 7);
                        s_inicio = semanaInicio.toISOString().slice(0, 10);
                        s_limite = semanaLimite.toISOString().slice(0, 10); 
                        console.log(typeof s_inicio);
                        console.log( s_inicio); 
                        console.log(typeof s_limite);
                        console.log( s_limite); 
                        semana();
                        break;
                    case 'mes':
                        parts = m_inicio.split('-');
                        if(parts[1] == 1){
                            parts[1] = 12;
                            parts[0] = parseInt(parts[0]) - 1;
                        }else{
                            parts[1] = parseInt(parts[1]) - 1;
                        }
                        mesInicio = new Date(parts[0],parts[1] - 1, 1);
                        mesLimite = new Date(parts[0],parts[1] , 0);
                        m_inicio = mesInicio.toISOString().slice(0, 10);
                        m_limite = mesLimite.toISOString().slice(0, 10);
                        mes();
                        break;
                }
            }
            next = function () {
                switch (modelo) {
                    case 'dia':
                        parts = d_inicio.split('-');
                        dataAnterior = new Date(parts[0],parts[1] - 1, parts[2]);
                        dataAnterior.setDate(dataAnterior.getDate() + 1);
                        d_inicio = dataAnterior.toISOString().slice(0, 10);
                        d_limite = dataAnterior.toISOString().slice(0, 10);  
                        dia();
                        break;
                    case 'semana':
                        partsInicio = s_inicio.split('-');
                        partsLimite = s_limite.split('-');
                        semanaInicio = new Date(partsInicio[0],partsInicio[1] - 1, partsInicio[2]);
                        semanaInicio.setDate(semanaInicio.getDate() + 7);
                        semanaLimite = new Date(partsLimite[0],partsLimite[1] - 1, partsLimite[2]);
                        semanaLimite.setDate(semanaLimite.getDate() + 7);
                        s_inicio = semanaInicio.toISOString().slice(0, 10);
                        s_limite = semanaLimite.toISOString().slice(0, 10); 
                        semana();
                        break;
                    case 'mes':
                        parts = m_inicio.split('-');
                        if(parts[1] == 12){
                            parts[1] = 1;
                            parts[0] = parseInt(parts[0]) + 1;
                        }else{
                            parts[1] = parseInt(parts[1]) + 1;
                        }
                        mesInicio = new Date(parts[0],parts[1] - 1, 1);
                        mesLimite = new Date(parts[0],parts[1] , 0);
                        m_inicio = mesInicio.toISOString().slice(0, 10);
                        m_limite = mesLimite.toISOString().slice(0, 10);
                        mes();
                        break;
                }
            }
            
            $('#datatable').DataTable({
                ajax: {
                    url: "/Inicio/listagem",
                    dataSrc: "data",
                    type: "post",
                    data: function name(d)  {
                        d.dt_inicio = dt_inicio, 
                        d.dt_limite = dt_limite 
                    }
                },
                columns:[
                    { data: "Data"},
                    { data: "Descricao"},
                    { data: "Quantidade"},
                    { data: "Entrada"},
                    { data: "Id"}
                ],
                columnDefs: [
                    {className: "dt-center", targets: "_all"}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Id);
                }
            });
        });
    </script>
</body>
</html>