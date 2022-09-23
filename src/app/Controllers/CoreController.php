<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;


class CoreController extends ResourceController 
{
    protected $helpers = ['functions'];
    protected $request;
    private $coreModel;
    public $sidebar;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->coreModel        = new \App\Models\CoreModel();
        $this->validation       = \Config\Services::validation();
        $this->request          = \Config\Services::request();
        helper('functions');
    }

    //Retorna um objeto
    public function find($id = null, $model = null) 
    {
        // $usuario = $this->request->getVar('user'); 
        // $valida_direito = $this->valida_direito($usuario->usuario, $model->table);
        $valida_direito[0] = true;
        if($valida_direito[0] == true) {
            $data = $model->find($id);
            return $data == null ? [false,"Não encontrado!"] : $data;
        } else {            
            return [false,"Sem direitos"];
        }
    }
    
    //Retorna um array de objetos com todos os resultados
    public function findAll($model = null)
    {
        // $usuario = $this->request->getVar('user'); 
        // $valida_direito = $this->valida_direito($usuario->usuario, $model->table);
        $valida_direito[0] = true;
        if($valida_direito[0] == true) {
            $data = $model->findAll();
            return $data;
        } else {            
            return false;
        }
    }    
    
    // 
	public function insert($data=null, $model = null)
	{     
        // $usuario = $this->request->getVar('user'); 
        // $valida_direito = $this->valida_direito($usuario->usuario, $model->table);
        $valida_direito[0] = true;
        if($valida_direito[0] == true) {
            $model->insert($data);
            return $this->respondCreated();
        } else {            
            return false;
        }
	}
        
    // 
	public function update($id = null, $data = null, $model = null)
	{   
        // $usuario = $this->request->getVar('user'); 
        // $valida_direito = $this->valida_direito($usuario->usuario, $model->table);
        $valida_direito[0] = true;
        if($valida_direito[0] == true) {
            $model->update($id,$data);        
            return $this->find($id,$model);
        } else {            
            return false;
        }
	}

	public function delete($id = null, $model = null)
	{
        // $usuario = $this->request->getVar('user'); 
        // $valida_direito = $this->valida_direito($usuario->usuario, $model->table);
        $valida_direito[0] = true;
        if($valida_direito[0] == true) {
            $rs = $model->delete($id); 
            return $this->respondDeleted($rs);
        } else {            
            return false;
        }
	}

    public function valida_direito($usuario = null, $chave = null)
    {
        
    }

    public function datalist($id = null, $descricao = null, $table = null, $where = null, $where_value = null)
    {
        return $this->coreModel->datalist($id, $descricao, $table, $where, $where_value);
    }

    public function existe($where = null, $table = null)
    {
        return $this->coreModel->existe($where, $table);
    }
}
