<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\isEmpty;

class Materiais extends CoreController
{
    private $materialModel;
    protected $request;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->materialModel = new \App\Models\MateriaisModel();
        $this->request = \Config\Services::request();
        helper('functions');
    }

    public function index()
    {
        // debug('a');
        $data['titulo'] = 'Materiais';
        $data['sidebar'] = $this->sidebar;
        return view('materiais/listagem',$data);
    }

    public function listagem_materiais()
    {
        $data    = $this->request->getPost();
        // debug($data);
        $aux = explode('-', trim($_POST['ca']));
        $ca = $aux[0];
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->materialModel->listagem_materiais($start, $length, $campo, $direcao, $search,$ca);
        echo json_encode($listagem);
    }

    public function salvar()
    {
        // debug($_POST);
        if (!$this->validate([
            'Id' => 'trim',
            'Descricao' => ['rules' => 'required', 'errors' => ['required' => 'Campo Descrição é obrigatório.']],
            'Unidade_de_medida' => ['rules' => 'required', 'errors' => ['required' => 'Campo Unidade de Medida é obrigatório.']],
            ])) {
            // debug('teste');
            return $this->formulario($_POST);
        } else {
            $id = $_POST['Id'];
            unset($_POST['Id']);
            if($id == '') {
                $this->materialModel->inserir($_POST);
            } else {
                $this->materialModel->editar($id, $_POST);
            }
            notificacao($id == '' ? 'Inserido com sucesso!' : 'Dados atualizados!');
            return redirect()->to('/Materiais/');//$this->index();
        }
    }

    public function excluir($id = null)
    {
        $this->materialModel->excluir($id);
        notificacao($id == '' ? 'Usuário não encontrado!' : 'Excluido com sucesso!');
        return $this->index();
    }

    public function formulario ($id = null)
    {
        // debug("formulario");
        if ($id == null) {
            $id = isset($_POST['Id']) ? $_POST['Id'] : null; 
        }
        // debug($id);
        $data['titulo'] = $id == null ? 'Inserir' : 'Editar';
        $data['edit'] = false;
        $data['grupos'] = $this->materialModel->listaGrupos();
        
        if ($id != null && ! is_array($id)) {
            $data['registro'] = $this->find($id,$this->materialModel);
            $data['edit'] = true;
        }
        
        if(count($_POST) > 0){
            $data['registro'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
        }

        // debug($data['grupos']);
        return view('materiais/formulario',$data);
    }

}
