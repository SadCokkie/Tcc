<?php 
namespace App\Models;
class GruposModel extends CoreModel
{
    protected $table = 'GruposMateriais';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Id', 'Nome'];
    protected $validationRules = [
        'Id' => 'required|is_unique[GruposMateriais.Id]'
    ];

    public function listagem($start = null, $length = null, $campo = null, $direcao = null, $search = null)
    {
        $where = "WHERE 1=1";

        if ($search != "") {
            $where .= " AND
                (M.Id LIKE '%".$search."%' OR
                M.Nome LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("SELECT 
            M.Id,
            RTRIM(M.Nome) Nome
        FROM GruposMateriais M
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        // debug($response['data']);
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM GruposMateriais M $where")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;

        return $response;
    }

    public function inserir($data)
    {
        return $this->db->table('GruposMateriais')->insert($data);
    }

    public function editar($id, $data)
    {
        // debug($data);
        return $this->db->table('GruposMateriais')->where('Id',$id)->set($data)->update();
    }

    public function excluir($id)
    {
        return $this->db->table('GruposMateriais')->where('Id',$id)->delete();
    }
}