<div class="modal fade" id="notaIndividual_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal">Inserir avaliação</h5>
            </div>
            <div class="modal-body">
                <form id="formulario" style="position: static;" width="100%" action="/Notas/adicionar" method="post">
                    <?php echo hidden('Cd_avaliacao',$Cd_avaliacao);
                        echo '<div class="row">';
                        echo '<div class="row" style="margin-bottom: 30px;">'.empresa('Aluno','empresa',6,null);
                        echo input('Nota','Nota', 2  , isset($registro) ? $registro['Nota'] : '', 'text');
                        echo '</div></div>';
                    ?>
                    <div class="right" style="margin-top: 5px;">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
            <?= $this->include('modals/cadastros') ?>
        </div>
    </div>
</div>

<?= $this->include('partials/scripts') ?>
<script type="text/javascript">
    var empresa = function () {
            $('#cadastros_modal').modal('show');
        }

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
            $('#empresa').val($(this).attr("data-id"));
            $('#cadastros_modal').modal('hide');
        });
    });
</script>