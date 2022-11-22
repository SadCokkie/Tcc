<?php 
namespace App\Models;
class MateriaisModel extends CoreModel
{
    protected $table = 'Materiais';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Id', 'Descricao', 'IdGrupo', 'Unidade_de_medida'];
    protected $validationRules = [
        'Id' => 'required|is_unique[Materiais.Id]'
    ];

    public function listagem_materiais($start = null, $length = null, $campo = null, $direcao = null, $search = null, $ca = null)
    {
        $where = "WHERE 1=1";

        if($ca != null){
            $where .= " AND E.Id_ca = $ca";   
        }

        if ($search != "") {
            $where .= " AND
                (M.Id LIKE '%".$search."%' OR
                M.Descricao LIKE '%".$search."%' OR
                G.Nome LIKE '%".$search."%' OR
                M.Unidade_de_medida LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("SELECT 
            M.Id,
            M.IdGrupo,
            RTRIM(M.Descricao) Descricao,
            RTRIM(G.Nome) Nome,
            RTRIM(M.Unidade_de_medida) Unidade_de_medida,
            E.Quantidade
        FROM Materiais M
        LEFT OUTER JOIN GruposMateriais G ON M.IdGrupo = G.Id
        LEFT OUTER JOIN Estoque E ON M.Id = E.Id_material
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        // debug($response['lastQuery']);
        if($ca != null){
            $countall = $this->db->query("SELECT COUNT(*) Resultados FROM Materiais M LEFT OUTER JOIN Estoque E ON M.Id = E.Id_material $where")->getRowArray();
        }else{
            $countall = $this->db->query("SELECT COUNT(*) Resultados FROM Materiais M")->getRowArray();
        }
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

    public function listaGrupos()
    {
        $query = $this->db->query("SELECT * FROM GruposMateriais");
        $data = $query->getResultArray();
        foreach ($data as $key => $value) {
            $response[$key + 1] = ['id' => $value['Id'], 'descricao' => $value['Nome']];
        }
        // debug($response);
        return $response;
    }
}