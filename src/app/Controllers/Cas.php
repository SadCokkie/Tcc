<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\isEmpty;

class Cas extends CoreController
{
    private $caModel;
    protected $request;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->caModel = new \App\Models\CasModel();
        $this->request = \Config\Services::request();
        helper('functions');
    }

    public function index()
    {
        // debug('a');
        $data['titulo'] = 'Centros de Armazenagem';
        $data['sidebar'] = $this->sidebar;
        return view('cas/listagem',$data);
    }

    public function listagem_cas()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->caModel->listagem_cas($start, $length, $campo, $direcao, $search);
        echo json_encode($listagem);
    }

    public function salvar()
    {
        // debug($_POST);
        if (!$this->validate([
            'Id' => 'trim',
            'Descricao' => ['rules' => 'required', 'errors' => ['required' => 'Campo Descrição é obrigatório.']],
            ])) {
            // debug('teste');
            return $this->formulario($_POST);
        } else {
            $id = $_POST['Id'];
            unset($_POST['Id']);
            if($id == '') {
                $this->caModel->inserir($_POST);
            } else {
                $this->caModel->editar($id, $_POST);
            }
            notificacao($id == '' ? 'Inserido com sucesso!' : 'Dados atualizados!');
            return $this->index();
        }
    }

    public function excluir($id = null)
    {
        $this->caModel->excluir($id);
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
        
        if ($id != null && ! is_array($id)) {
            $data['registro'] = $this->find($id,$this->caModel);
            $data['edit'] = true;
        }
        
        if(count($_POST) > 0){
            $data['registro'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
        }
        return view('cas/formulario',$data);
    }

}
