<div class="modal fade" id="inserir_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal">Inserir avaliações</h5>
            </div>
            <div class="modal-body">
                <form id="formulario" style="position: static;" width="100%" action="/Avaliacoes/salvar" method="post">
                    <?= hidden('Cd_disciplina',isset($Cd_disciplina) ? $Cd_disciplina : null); ?>
                    <div class="row">
                        <?= input('Nome','Nome',4,null,'text'); ?>
                        <?= input('Data','data',4,null,'date'); ?>
                        <?= input('Horário','hora',4,null,'time'); ?>
                    </div>
                    <div class="right" style="margin-top: 5px;">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>