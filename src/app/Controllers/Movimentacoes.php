<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\isEmpty;

class Movimentacoes extends CoreController
{
    private $movimentacaoModel;
    protected $request;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->movimentacaoModel = new \App\Models\MovimentacoesModel();
        $this->request = \Config\Services::request();
        helper('functions');
    }
    
    public function index()
    {
        $data['Tipo'] = $_GET['Entrada'];
        // debug($data['Tipo']);
        $data['titulo'] = 'Movimentações';
        $data['sidebar'] = $this->sidebar;
        return view('movimentacoes/listagem',$data);
    }

    public function listagem_movimentacoes()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->movimentacaoModel->listagem($start, $length, $campo, $direcao, $search, $_POST['Tipo']);
        echo json_encode($listagem);
    }

    public function salvar()
    {
        switch ($_POST['Tipo']) {
            case 0:
                if (!$this->validate([
                    'Id' => 'trim',
                    'Tipo' => 'trim',
                    'Quantidade' => ['rules' => 'required', 'errors' => ['required' => 'Campo Quantidade é obrigatório.']],
                    'Id_material' => ['rules' => 'required', 'errors' => ['required' => 'Campo Material é obrigatório.']],
                    'Id_Ca' => ['rules' => 'required', 'errors' => ['required' => 'Campo CA é obrigatório.']],
                    ])) {
                    // debug('teste');
                    $_GET['Tipo'] = $_POST['Tipo'];
                    return $this->formulario($_POST['Id']);
                }else{
                    $aux = explode('-', trim($_POST['Id_material']));
                    $_POST['Id_material'] = $aux[0];
                    $aux = explode('-', trim($_POST['Id_Ca']));
                    $_POST['Id_Ca'] = $aux[0];
                }
                break;
            case 1:
                if (!$this->validate([
                    'Id' => 'trim',
                    'Tipo' => 'trim',
                    'Quantidade' => ['rules' => 'required', 'errors' => ['required' => 'Campo Quantidade é obrigatório.']],
                    'Id_material' => ['rules' => 'required', 'errors' => ['required' => 'Campo Material é obrigatório.']],
                    'Id_Ca' => ['rules' => 'required', 'errors' => ['required' => 'Campo CA é obrigatório.']],
                    ])) {
                    // debug('teste');
                    $_GET['Tipo'] = $_POST['Tipo'];
                    return $this->formulario($_POST['Id']);
                }else{
                    if($_POST['Estoque'] < $_POST['Quantidade']){
                        $_GET['Tipo'] = $_POST['Tipo'];
                        return $this->formulario($_POST['Id']);
                    }else{
                        // debug($_POST);
                        $aux = explode('-', trim($_POST['Id_material']));
                        $_POST['Id_material'] = $aux[0];
                        $aux = explode('-', trim($_POST['Id_Ca']));
                        $_POST['Id_Ca'] = $aux[0];
                    }
                }
                break;
            case 2:
                if (!$this->validate([
                    'Id' => 'trim',
                    'Tipo' => 'trim',
                    'Quantidade' => ['rules' => 'required', 'errors' => ['required' => 'Campo Quantidade é obrigatório.']],
                    'Id_material' => ['rules' => 'required', 'errors' => ['required' => 'Campo Material é obrigatório.']],
                    'Id_Ca' => ['rules' => 'required', 'errors' => ['required' => 'Campo CA é obrigatório.']],
                    'Id_recebe' => ['rules' => 'required', 'errors' => ['required' => 'Campo CA NOVO é obrigatório.']],
                    ])) {
                    // debug('teste');
                    $_GET['Tipo'] = $_POST['Tipo'];
                    return $this->formulario($_POST['Id']);
                }else{
                    if($_POST['Estoque'] < $_POST['Quantidade']){
                        $_GET['Tipo'] = $_POST['Tipo'];
                        return $this->formulario($_POST['Id']);
                    }else{
                        // debug($_POST);
                        $aux = explode('-', trim($_POST['Id_material']));
                        $_POST['Id_material'] = $aux[0];
                        $aux = explode('-', trim($_POST['Id_Ca']));
                        $_POST['Id_Ca'] = $aux[0];
                        $aux = explode('-', trim($_POST['Id_recebe']));
                        $_POST['Id_recebe'] = $aux[0];
                    }
                }
                break;
        }
        $id = $_POST['Id'];
        unset($_POST['Id']);
        // debug($_POST);
        if($id == '') {
            $this->movimentacaoModel->inserir($_POST);
        } else {
            $this->movimentacaoModel->editar($id, $_POST);
        }
        notificacao($id == '' ? 'Inserido com sucesso!' : 'Dados atualizados!');
        return redirect()->to('/movimentacoes/?Entrada='.$_POST['Tipo']);//$this->index();
    }

    public function excluir($id = null)
    {
        $this->movimentacaoModel->excluir($id);
        notificacao($id == '' ? 'Usuário não encontrado!' : 'Excluido com sucesso!');
        return $this->index();
    }

    public function formulario ($id = null)
    {
        // debug($id);
        if ($id == null) {
            $id = isset($_POST['Id']) ? $_POST['Id'] : null; 
        }
        // debug($id);
        $data['titulo'] = $id == null ? 'Inserir' : 'Editar';
        $data['edit'] = false;
        $data['Tipo'] = $_GET['Tipo'];
        
        if ($id != null && ! is_array($id)) {
            $data['registro'] = $this->find($id,$this->movimentacaoModel);
            $data['edit'] = true;
        }
        
        if(count($_POST) > 0){
            $data['registro'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
        }

        // debug($data['grupos']);
        switch ($data['Tipo']) {
            case 0:
                return view('movimentacoes/formulario_entrada',$data);
                break;
            case 1:
                return view('movimentacoes/formulario_saida',$data);
                break;
            case 2:
                return view('movimentacoes/formulario_transferencia',$data);
                break;
        }
        
    }

}
