<div class="modal fade" id="lancar_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal">Inserir atestados</h5>
            </div>
            <div class="modal-body">
                <form id="formulario" style="position: static;" width="100%" action="/Atestados/salvar" method="post">
                    <div class="row">
                        <?= empresa('Aluno','Cd_empresa',4,null) ?>
                        <?= input('Data','Data',2,null,'date') ?>
                        <?= input('Duracao','Duracao',2,null,'number') ?>
                    </div>
                    <div class="right" style="margin-top: 5px;">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('modals/cadastros') ?>
<script type="text/javascript">
    var empresa = function () {
        $('#cadastros_modal').modal('show');
    }
</script>