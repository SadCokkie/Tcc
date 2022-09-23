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
                                                <a style="margin-left: 5px;" class="btn btn-secondary waves-effect waves-light right" title="Voltar" href="/Avaliacoes/?Cd_disciplina=<?= $Cd_disciplina?>" role="button" ><i class="fas fa-reply"></i></a>
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" onclick="notas()" role="button" >Notas</a>
                                                <a style="margin-left: 5px;" class="btn btn-primary waves-effect waves-light right" title="Inserir" onclick="notaIndividual()" role="button"><i class="fas fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table responsive  table-hover table-striped compact display" style="position: static;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ALUNO</th>
                                                <th>NOTA</th>
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
                <?= $this->include('iecg/notas/notas') ?>
                <?= $this->include('iecg/notas/notaIndividual') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>
    <script type="text/javascript">
        var notas = function () {
            console.log('notas');
            $('#notas_modal').modal('show');
        }

        var notaIndividual = function () {
            console.log('notaIndividual');
            $('#notaIndividual_modal').modal('show');
        }

        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: {
                    url: "/Notas/listagem",
                    dataSrc: "data",
                    type: "post"
                    <?= isset($Cd_avaliacao) ? ",data: {Cd_avaliacao: ".$Cd_avaliacao." }" : "" ?>,
                },
                columns:[
                    { data: "Nome_completo" },
                    { data: "Nota" , className: 'dt-center'},
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-id', data.Cd_nota);
                }
            });
        });
    </script>
</body>
</html>