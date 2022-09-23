<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
// use App\Models\TecfgModel;

class Configuracao extends CoreController
{
    private $TecfgModel;
    protected $request;
    protected $direito;

    public function __construct()
    {
        parent::__construct();
        // $this->TecfgModel = new \App\Models\TecfgModel;
        // $this->direito = new Direito();
        $this->request = \Config\Services::request();
    }
}