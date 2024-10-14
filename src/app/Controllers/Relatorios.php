<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class Relatorios extends CoreController
{
    private $relatoriosModel;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->relatoriosModel = new \App\Models\RelatoriosModel();
        $this->materialModel   = new \App\Models\MateriaisModel();
    }

    public function estoque()
    {
        $data['titulo'] = 'Estoque';
        $data['grupos'] = $this->materialModel->listaGrupos();
        $data['movimentos'][1] = ['id' => 0, 'descricao' => 'Entrada'];
        $data['movimentos'][2] = ['id' => 1, 'descricao' => 'Baixa'];
        $data['movimentos'][3] = ['id' => 2, 'descricao' => 'Transferência'];
        return view('relatorios/estoque_filtro',$data);
    }

    public function buscar_estoque()
    {
        $data['titulo'] = 'Estoque';
        if(!empty($_POST['Id_material'])){
            $aux = explode('-', trim($_POST['Id_material']));
            $_POST['Id_material'] = $aux[0];
        }
        if(!empty($_POST['Id_Ca'])){
            $aux = explode('-', trim($_POST['Id_Ca']));
            $_POST['Id_Ca'] = $aux[0];
        }
        $data['estoque'] = $this->relatoriosModel->busca_estoque($_POST['Id_Ca'], $_POST['Id_material'], $_POST['IdGrupo'], $_POST['movimento'], $_POST['Data_inicio'], $_POST['Data_fim']);
        // debug($data['estoque']);
        
        return view('relatorios/estoque',$data);
    }
}