<div class="modal fade" id="chamada_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal">Inserir Presenças</h5>
            </div>
            <div class="modal-body">
                <form id="formulario" style="position: static;" width="100%" action="/Presencas/salvar" method="post">
                    <?php echo hidden('Cd_aula',$Cd_aula);
                    foreach ($alunos as $key => $value) : 
                        echo switch_button($value['Nome_completo'],$value['Cd_presenca'],$value['Presente']);
                    endforeach ?>
                    <div class="right" style="margin-top: 5px;">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>