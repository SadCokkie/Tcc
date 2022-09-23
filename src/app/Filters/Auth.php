<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Auth implements FilterInterface
{  
    public function before(RequestInterface $request, $arguments = null)
    {
        // se usuário não estiver logado
        if(session()->get('logged_in') == null){
            // retorna resposta de usuário não autenticado
            $erro['mensagem'] = 'Usuário não autenticado';
            $erro['erro'] = 400;
            return redirect()->to(base_url('Usuarios/login'));
        } else {
            // se usuário não possui acesso retorna resposta de usuário não autorizado
            $possui_direitos = true; //TODO
            if (! $possui_direitos) {
                $erro['mensagem'] = 'Usuário não possui direitos de acesso';
                $erro['erro'] = 400;
                return redirect()->to(base_url('/'));
            }
            return true;
        }
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}