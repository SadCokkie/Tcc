<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class Relatorios extends CoreController
{
    private $contratosModel;
    private $cursosModel;
    private $notasModel;
    private $presencasModel;
    private $empresasModel;
    private $relatoriosModel;
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->contratosModel = new \App\Models\TecontratosModel();
        $this->parcelasModel = new \App\Models\TeparcelasModel();
        $this->notasModel = new \App\Models\TenotasModel();
        $this->presencasModel = new \App\Models\TepresencasModel();
        $this->empresasModel = new \App\Models\GeempresModel();
        $this->relatoriosModel = new \App\Models\RelatoriosModel();
    }

    public function notas()
    {
        $data['titulo'] = 'Notas';
        $data['sidebar'] = $this->sidebar;
        return view('iecg/relatorios/notas',$data);
    }

    public function buscar_notas()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->relatoriosModel->buscar_notas($start, $length, $campo, $direcao, $search, substr($data['empresa'],0,6));
        echo json_encode($listagem);
    }

    public function presencas()
    {
        $data['titulo'] = 'Presenças';
        $data['sidebar'] = $this->sidebar;
        return view('iecg/relatorios/presencas',$data);
    }

    public function buscar_presencas()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->relatoriosModel->buscar_presencas($start, $length, $campo, $direcao, $search, substr($data['empresa'],0,6));
        echo json_encode($listagem);
    }

    public function atestados()
    {
        $data['titulo'] = 'Atestados';
        $data['sidebar'] = $this->sidebar;
        return view('iecg/relatorios/atestados',$data);
    }

    public function buscar_atestados()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->relatoriosModel->buscar_atestados($start, $length, $campo, $direcao, $search, substr($data['empresa'],0,6));
        echo json_encode($listagem);
    }

    public function financeiro()
    {
        $data['titulo']  = 'Financeiro';
        $data['sidebar'] = $this->sidebar;
        $data['empresa'] = null;
        if (isset($_GET['empresa'])) {
            $empresa = $this->empresasModel->find($_GET['empresa']);
            $data['empresa'] = $empresa['Cd_empresa']." - ".$empresa['Nome_completo'];
        }
        return view('iecg/relatorios/financeiro',$data);
    }

    public function buscar_financeiro()
    {
        $data    = $this->request->getPost();
        $start	 = $data["start"]; // valor inicial limit
        $length	 = $data["length"]; 
        $search  = $data["search"]["value"];
        $order	 = $data["order"]; // pega qual campo vai ser ordenado
        $campo   = $data["columns"][$order[0]["column"]]["data"]; // pega o nome do campo que sera ordenado
        $direcao = $order[0]["dir"]; // pega o nome do campo que sera ordenado
        $listagem = $this->relatoriosModel->buscar_financeiro($start, $length, $campo, $direcao, $search, substr($data['empresa'],0,6));
        echo json_encode($listagem);
    }
}