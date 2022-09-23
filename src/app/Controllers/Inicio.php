<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class Inicio extends CoreController
{
    private $coreModel;

    public function __construct()
    {
        parent::__construct();
        $this->coreModel = new \App\Models\CoreModel();
    }

    public function index()
	{
        $data['titulo'] = 'Início';
        $data['sidebar'] = $this->sidebar;
        $data['d_inicio'] = date('Y-m-d', strtotime('today'));
        $data['d_limite'] = $data['d_inicio'];
        $data['s_inicio'] = date('Y-m-d', strtotime('monday this week'));
        $data['s_limite'] = date('Y-m-d', strtotime('sunday this week'));
        $data['m_inicio'] = date('Y-m-d', strtotime('first day of this month'));
        $data['m_limite'] = date('Y-m-t', strtotime('last day of this month'));
        // debug($data);
        return view('inicio',$data);
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
        // debug($data);
        $dt_inicio = $data['dt_inicio'];
        $dt_limite = $data['dt_limite'];
        $listagem = $this->coreModel->listagemInicio($start, $length, $campo, $direcao, $search, $dt_inicio, $dt_limite);
        echo json_encode($listagem);
    }


}