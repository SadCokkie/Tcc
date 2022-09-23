<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\isEmpty;

class Usuarios extends CoreController
{
    private $usuarioModel;
    private $gdModel;
    protected $request;
    protected $direito;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new \App\Models\TeuserModel();
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
            'Cd_USUARIO' => 'trim',
            'Usuario' => ['rules' => 'required', 'errors' => ['required' => 'Campo Nome do Usuário é obrigatório.']],
            'Cd_unidade_n' => ['rules' => 'required', 'errors' => ['required' => 'Campo Unidade de Negócio é obrigatório.']],
            'Email' => ['rules' => 'required', 'errors' => ['required' => 'Campo Email é obrigatório.']],
            'Cd_empresa' => ['rules' => 'required', 'errors' => ['required' => 'Campo Empresa é obrigatório.']],
        ])) {
            return $this->formulario($_POST);
        } else {
            $_POST['Cd_empresa'] = substr($_POST['Cd_empresa'],0,6);
            $id = $_POST['Cd_USUARIO'];
            unset($_POST['Cd_USUARIO']);
            if($id == '') {
                $_POST['Cd_USUARIO'] = $this->usuarioModel->proximo_usuario();
                // debug($_POST);
                $this->usuarioModel->inserir($_POST);
            } else {
                // debug($id);
                // debug($_POST);
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
                return redirect()->to("alterar_senha/?usuario='".$_POST['username']."'");
            }else{
                $direitos = $this->gdModel->lista_direitos($usuario->Cd_gdirei);
                $ses_data = [
                    'Cd_usuario'    => $usuario->Cd_USUARIO,
                    'Usuario'       => $usuario->Nome,
                    'Cd_gdirei'     => $usuario->Cd_gdirei,
                    'direitos'      => $direitos,
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                }
        } else {
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

    public function proximo_usuario()
    {
        return $this->usuarioModel->proximo_usuario();
    }

    public function alterar_senha()
    {
        $post['usuario'] = $_GET['usuario'];
        // debug($post);
        $post['titulo'] = 'Portal CIGAM | Alterar Senha';
        $post['senhaAtual'] = '';
        return view('usuarios/alterarSenha', $post);
    }

    public function salvar_alteracao_senha()
    {
        //conferir se o usuário tem senha em branco e se está logado,
        //caso o usuário já tenha senha e não esteja logado não pode alterar a senha
        // debug($_POST);
        $usuario = $this->usuarioModel->getUsuario($_POST['usuario']);
        if($usuario['Senha'] == '' && session()->get('logged_in') == null){
            // debug($usuario);
            $senhaLogar = $_POST['newpassword'];
            $senhaNova = md5('ABACATE'.strtoupper($_POST['newpassword']));
            $confirmaSenhaNova = md5('ABACATE'.strtoupper($_POST['confirmnewpassword']));
            if($senhaNova == $confirmaSenhaNova){
                $usuario['Senha'] = $senhaNova;
                $this->usuarioModel->editar($usuario['Id'], $usuario);
                unset($_POST);
                $_POST['userpassword'] = $senhaLogar;
                $_POST['username'] = $usuario['Usuario'];
                return $this->logar();
                debug('finalizou alteração');
            }
        }
    }
}
