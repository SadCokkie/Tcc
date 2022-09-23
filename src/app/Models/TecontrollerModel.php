<?php 
namespace App\Models;
class TecontrollerModel extends CoreModel
{
    protected $table = 'TECONTROLES';
    protected $primaryKey = 'Cd_controle';
    protected $allowedFields = ['Cd_controle','Nome','Cd_direito','Controller','Formulario'];
    protected $validationRules = [
        'Cd_controle' => 'required|is_unique[TECONTROLES.Cd_controle]'
    ];

    public function listagem($start = null, $length = null, $campo = null, $direcao = null, $search = null)
    {
        $where = "";

        if ($search != "") {
            $where = "WHERE
                E.Cd_controle LIKE '%".$search."%' OR
                E.Nome LIKE '%".$search."%' OR
                E.Cd_direito LIKE '%".$search."%' OR
                E.Controller LIKE '%".$search."%' OR
                E.Formulario LIKE '%".$search."%' OR
                E.Direito LIKE '%".$search."%' OR
            ";
        }
        
        $query =$this->db->query("SELECT
        C.Cd_controle
        ,RTRIM(C.Nome) Nome
        ,RTRIM(C.Cd_direito) Cd_direito
        ,RTRIM(C.Controller) Controller
        ,RTRIM(C.Formulario) Formulario
        ,RTRIM(D.Nome) Direito
        FROM TECONTROLES C
        LEFT OUTER JOIN TEDIREIT D ON D.Cd_direito = C.Cd_direito
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM TECONTROLES")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        
        return $response;
    }

    public function inserir($data)
    {
        return $this->db->table('TECONTROLES')->insert($data);
    }

    public function editar($id, $data)
    {
        return $this->db->table('TECONTROLES')->where('Cd_controle',$id)->update($data);
    }

    public function excluir($id)
    {
        return $this->db->table('TECONTROLES')->where('Cd_controle',$id)->delete();
    }
}