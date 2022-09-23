<div class="modal fade" id="anexos_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="label_modal">Anexos</h5>
                <div class="right" style="margin-top: 5px;">
                    <form id="form_anexos" action="/Anexos/salvar" method="post" enctype='multipart/form-data'>
                        <?= hidden('tipo'); ?>
                        <?= hidden('id'); ?>
                        <?= hidden('id_relacional'); ?>
                        <input id="image" type="file" name="image" accept=".pdf,.doc,.docx,.txt,.pptx,.ppt">
                    
                    </form>
                </div>
            </div>
            <div class="modal-body">
                <table id="anexos" class="table table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>DATA</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>