<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\isEmpty;

class Usuarios extends CoreController
{
    private $usuarioModel;
    protected $request;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new \App\Models\UsuariosModel();
        $this->request = \Config\Services::request();
        helper('functions');
    }

    public function index()
    {
        // debug('a');
        $data['titulo'] = 'Usuários';
        $data['sidebar'] = $this->sidebar;
        return view('usuarios/listagem',$data);
    }

    public function listagem_usuarios()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->usuarioModel->listagem_usuarios($start, $length, $campo, $direcao, $search);
        echo json_encode($listagem);
    }

    public function buscar($id=null)
    {   
        $rs = $this->find($id,$this->usuarioModel);
        return $rs[0] != false ? $this->respond($rs, 200) : $this->fail('Usuário não encontrado!', 400, $rs[1]);
    }

    public function salvar()
    {
        $_POST['Admin'] = isset($_POST['Admin']) ? 1 : 0;
        // debug($_POST);
        if (!$this->validate([
            'Id' => 'trim',
            'Usuario' => ['rules' => 'required', 'errors' => ['required' => 'Campo Nome do Usuário é obrigatório.']],
            ])) {
            // debug('teste');
            return $this->formulario($_POST);
        } else {
            $id = $_POST['Id'];
            unset($_POST['Id']);
            if($id == '') {
                $this->usuarioModel->inserir($_POST);
            } else {
                $this->usuarioModel->editar($id, $_POST);
            }
            notificacao($id == '' ? 'Inserido com sucesso!' : 'Dados atualizados!');
            return redirect()->to('/Usuarios');
        }
    }

    public function excluir($id = null)
    {
        // debug($id);
        $this->usuarioModel->excluir($id);
        notificacao($id == '' ? 'Usuário não encontrado!' : 'Excluido com sucesso!');
        return redirect()->to('/Usuarios');
    }

    public function login()
    {
        $data['titulo'] = 'Portal AgroSyS | Login';
        return view('usuarios/login', $data);
    }

    public function logar()
    {
        $session = session();
        // debug($_POST);
        $usuario = null;
        $senha = $_POST['userpassword'] != '' ? md5('ABACATE'.strtoupper($_POST['userpassword'])) : '';
        
        $usuario = $this->usuarioModel->login(strtoupper($_POST['username']), $senha);
        $url = '/';
        if($usuario != null) {
            if ((!isset($_POST['userpassword']) || $_POST['userpassword'] == '') ) {
                // debug('teste');
                return redirect()->to("alterar_senha/?Usuario='".$_POST['username']."'");
            }else{
                $ses_data = [
                    'Id'            => $usuario->Id,
                    'Usuario'       => $usuario->Nome,
                    'Admin'         => $usuario->Admin,
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                }
        } else {
            // debug('deu merda');
            $url = 'login';
        }
        return redirect()->to($url);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('login');
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
            $data['registro'] = $this->find($id,$this->usuarioModel);
            $data['edit'] = true;
        }
        
        if(count($_POST) > 0){
            $data['registro'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
        }
        // debug($data['registro']);
        return view('usuarios/formulario',$data); 
    }    

    public function alterar_senha()
    {
        $post['Usuario'] = $_GET['Usuario'];
        // debug($post);
        $post['titulo'] = 'Portal AGROSYS | Alterar Senha';
        $usuario = $this->usuarioModel->getUsuario($post['Usuario']);
        // debug($usuario);
        $post['senhaAtual'] = $usuario['Senha'];
        if(($usuario['Senha'] == '' && session()->get('logged_in') == null) || ($usuario['Senha'] != '' && session()->get('logged_in') != null)){
            // debug($usuario);
            return view('usuarios/alterarSenha', $post);
        }else{
            return redirect()->to('login');
        }
    }

    public function salvar_alteracao_senha()
    {
        //conferir se o usuário tem senha em branco e se está logado,
        //caso o usuário já tenha senha e não esteja logado não pode alterar a senha
        // debug($_POST);
        $usuario = $this->usuarioModel->getUsuario($_POST['Usuario']);        
        // debug($usuario);
        $senhaLogar = $_POST['newpassword'];
        $senhaNova = md5('ABACATE'.strtoupper($_POST['newpassword']));
        $confirmaSenhaNova = md5('ABACATE'.strtoupper($_POST['confirmnewpassword']));
        if($senhaNova == $confirmaSenhaNova){
            $usuario['Senha'] = $senhaNova;
            // debug($usuario);
            $id = $usuario['Id'];
            unset($usuario['Id']);
            $this->usuarioModel->editar($id, $usuario);
            unset($_POST);
            $_POST['userpassword'] = $senhaLogar;
            $_POST['username'] = $usuario['Usuario'];
            return redirect()->to('login');
        }
        
    }

}
