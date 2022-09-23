<div class="modal fade" id="notas_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_modal">Inserir avaliações</h5>
            </div>
            <div class="modal-body">
                <form id="formulario" style="position: static;" width="100%" action="/Notas/salvar" method="post">
                    <?php echo hidden('Cd_avaliacao',$Cd_avaliacao);
                    foreach ($alunos as $key => $value) : 
                        echo '<div class="row">';
                        echo '<div class="col-1"><input name="'.$value['Cd_nota'].'" class="form-control form-control-sm" type="text" value="'.$value['Nota'].'" id="'.$value['Cd_nota'].'"></div>';
                        echo '<div class="col-11">'.$value['Nome_completo'].'</div>';
                        echo '</div>';
                    endforeach ?>
                    <div class="right" style="margin-top: 5px;">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>