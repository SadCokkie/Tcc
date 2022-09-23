<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class Controllers extends CoreController
{
    private $controllerModel;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->controllerModel = new \App\Models\TecontrollerModel();
    }

    public function index()
    {
        $data['titulo'] = 'Controllers';
        $data['sidebar'] = $this->sidebar;
        return view('configuracoes/controllers/listagem',$data);
    }

    public function listagem()
    {   
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->controllerModel->listagem($start, $length, $campo, $direcao, $search);
        echo json_encode($listagem);
    }

    public function formulario ($id = null)
    {
        $data['titulo'] = $id == null ? 'Inserir' : 'Editar';
        $data['edit'] = false;
        $data['sidebar'] = $this->sidebar;
        $data['direitos'] = $this->direitos;
        
        if ($id != null && ! is_array($id)) {
            $data['registro'] = $this->find($id,$this->controllerModel);
            $data['edit'] = true;
        }
        
        if(count($_POST) > 0){
            $data['registro'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
        }
        return view('configuracoes/controllers/formulario',$data);
    }

    public function salvar()
    {
        if (! $this->validate([
            'Cd_controle' => 'trim',
            'Nome' => ['rules' => 'required', 'errors' => ['required' => 'Campo Nome é obrigatório.']],
            'Cd_direito' => ['rules' => 'required', 'errors' => ['required' => 'Campo Direito é obrigatório.']],
            'Formulario' => ['rules' => 'required', 'errors' => ['required' => 'Campo Formulário é obrigatório.']],
            'Controller' => ['rules' => 'required', 'errors' => ['required' => 'Campo Controller é obrigatório.']],
        ])) {
            return $this->formulario($_POST);
        } else {
            $id = $_POST['Cd_controle'];
            unset($_POST['Cd_controle']);
            if($id == '') {
                $this->controllerModel->inserir($_POST);
            } else {
                $this->controllerModel->editar($id, $_POST);
            }
            notificacao($id == '' ? 'Inserido com sucesso!' : 'Dados atualizados!');
            return $this->index();
        }
    }

    public function excluir($id = null)
    {
        if ($this->valida_excluir($id)) {
            $this->controllerModel->excluir($id);
            notificacao($id == '' ? 'Inserido com sucesso!' : 'Dados atualizados!');
            return $this->index();
        }
    }

    public function valida_excluir($id = null)
    {
        # code...
        return true;
    }
}
