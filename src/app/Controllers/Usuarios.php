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
        // debug("salvar");
        if (! $this->validate([
            'Id' => 'trim',
            'Usuario' => ['rules' => 'required', 'errors' => ['required' => 'Campo Nome do Usuário é obrigatório.']],
            'Admin' => ['rules' => 'required', 'errors' => ['required' => 'Campo Admin é obrigatório.']],
        ])) {
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
            return $this->index();
        }
    }

    public function excluir($id = null)
    {
        $this->usuarioModel->excluir($id);
        notificacao($id == '' ? 'Usuário não encontrado!' : 'Excluido com sucesso!');
        return $this->index();
    }

    public function login()
    {
        $data['titulo'] = 'Portal AgroSyS | Login';
        return view('usuarios/login', $data);
    }

    public function logar()
    {
        $session = session();
        // debug($post);
        $usuario = null;
        $senha = $_POST['userpassword'] != '' ? md5('ABACATE'.strtoupper($_POST['userpassword'])) : '';
        $usuario = $this->usuarioModel->login(strtoupper($_POST['username']), $senha);
        // debug($usuario);
        $url = '/';
        if($usuario != null) {
            if (!isset($_POST['userpassword']) || $_POST['userpassword'] == '') {
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
        $data['titulo'] = $id == null ? 'Inserir' : 'Editar';
        $data['edit'] = false;
        $data['sidebar'] = $this->sidebar;
        $data['direitos'] = $this->direitos;
        $data['unidades'] = $this->datalist('Cd_unidade_de_n','Nome_completo', 'GEUNIDNE');
        
        if ($id != null && ! is_array($id)) {
            $data['registro'] = $this->find($id,$this->usuarioModel);
            $data['edit'] = true;
        }
        
        if(count($_POST) > 0){
            $data['registro'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
        }
        return view('usuarios/formulario',$data);
    }    

    public function testeview()
    {
        $data['title_meta'] = 'teste';
        $data['page_title'] = 'teste';
        $data['sidebar'] = $this->sidebar;
        $page = "icons-materialdesign";
        return view("examples/".$page, $data);
    }

    public function alterar_senha()
    {
        $post['Usuario'] = $_GET['Usuario'];
        $post['titulo'] = 'Portal CIGAM | Alterar Senha';
        $post['senhaAtual'] = '';
        // debug($post);
        return view('usuarios/alterarSenha', $post);
    }

    public function salvar_alteracao_senha()
    {
        //conferir se o usuário tem senha em branco e se está logado,
        //caso o usuário já tenha senha e não esteja logado não pode alterar a senha
        // debug($_POST);
        $usuario = $this->usuarioModel->getUsuario($_POST['Usuario']);
        // debug($usuario);
        if($usuario['Senha'] == '' && session()->get('logged_in') == null){
            $senhaLogar = $_POST['newpassword'];
            $senhaNova = md5('ABACATE'.strtoupper($_POST['newpassword']));
            $confirmaSenhaNova = md5('ABACATE'.strtoupper($_POST['confirmnewpassword']));
            if($senhaNova == $confirmaSenhaNova){
                $usuario['Senha'] = $senhaNova;
                $id = $usuario['Id'];
                unset($usuario['Id']);
                // debug($usuario);
                $this->usuarioModel->editar($id, $usuario);

                unset($_POST);
                $_POST['userpassword'] = $senhaLogar;
                $_POST['username'] = $usuario['Usuario'];
                return $this->logar();
            }
        }
    }
}
