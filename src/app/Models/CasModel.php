<?php 
namespace App\Models;
class CasModel extends CoreModel
{
    protected $table = 'CAs';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Id', 'Descricao', 'Grupo', 'Unidade_de_medida'];
    protected $validationRules = [
        'Id' => 'required|is_unique[CAs.Id]'
    ];

    public function listagem_cas($start = null, $length = null, $campo = null, $direcao = null, $search = null, $ca = null)
    {
        $where = "WHERE 1=1";

        if($ca != null){
            $where .= " AND Id <> $ca";
        }

        if ($search != "") {
            $where .= " AND
                (C.Id LIKE '%".$search."%' OR
                C.Descricao LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("SELECT 
            C.Id,
            RTRIM(C.Descricao) Descricao
        FROM CAs C
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        // debug($response['data']);
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM CAs C $where")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;

        return $response;
    }

    public function inserir($data)
    {
        return $this->db->table('cas')->insert($data);
    }

    public function editar($id, $data)
    {
        // debug($data);
        return $this->db->table('cas')->where('Id',$id)->set($data)->update();
    }

    public function excluir($id)
    {
        return $this->db->table('cas')->where('Id',$id)->delete();
    }
}