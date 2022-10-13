<?php 
namespace App\Models;
class MateriaisModel extends CoreModel
{
    protected $table = 'Materiais';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Id', 'Descricao', 'Grupo', 'Unidade_de_medida'];
    protected $validationRules = [
        'Id' => 'required|is_unique[Materiais.Id]'
    ];

    public function listagem_materiais($start = null, $length = null, $campo = null, $direcao = null, $search = null)
    {
        $where = "WHERE 1=1";

        if ($search != "") {
            $where .= " AND
                (M.Id LIKE '%".$search."%' OR
                M.Descricao LIKE '%".$search."%' OR
                M.Grupo LIKE '%".$search."%' OR
                M.Unidade_de_medida LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("SELECT 
            M.Id,
            RTRIM(M.Descricao) Descricao,
            RTRIM(M.Grupo) Grupo,
            RTRIM(M.Unidade_de_medida) Unidade_de_medida
        FROM Materiais M
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        // debug($response['data']);
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM Materiais M $where")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;

        return $response;
    }

    public function inserir($data)
    {
        return $this->db->table('Materiais')->insert($data);
    }

    public function editar($id, $data)
    {
        // debug($data);
        return $this->db->table('Materiais')->where('Id',$id)->set($data)->update();
    }

    public function excluir($id)
    {
        return $this->db->table('Materiais')->where('Id',$id)->delete();
    }
}