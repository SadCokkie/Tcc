<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class Teste extends CoreController
{
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->direito = new Direitos();
        $this->request = \Config\Services::request();
        helper('functions');
    }

    public function index()
    {
        $data['titulo'] = 'Teste';
        $data['title_meta'] = 'Teste';
        $data['page_title'] = 'Teste';
        $data['sidebar'] = $this->sidebar;
        // return view('examples/calendar',$data);
        return view('examples/icons-fontawesome',$data);
        // return view('examples/ui-buttons',$data);
        // return view('examples/form-advanced',$data);
        // return view('examples/form-elements',$data);
        // return view('examples/form-editors',$data);
        // return view('examples/form-mask',$data);
        // return view('examples/form-repeater',$data);
        // return view('examples/tables-datatable',$data);
        // return view('examples/form-repeater',$data);
        // return view('examples/form-repeater',$data);
        // return view('examples/form-repeater',$data);
    }
}
