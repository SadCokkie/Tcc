<?php 
namespace App\Models;
class MovimentacoesModel extends CoreModel
{
    protected $table = 'Movimentacoes';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Id', 'Id_estoque', 'Quantidade', 'Entrada'];
    protected $validationRules = [ 			
        'Id' => 'required|is_unique[Movimentacoes.Id]'
    ];

    public function listagem($start = null, $length = null, $campo = null, $direcao = null, $search = null, $tipo = null)
    {
        $where = "WHERE 1=1";

        if ($search != "") {
            $where .= " AND
                (M.Id LIKE '%".$search."%' OR
                M.Id_estoque LIKE '%".$search."%' OR
                M.Quantidade LIKE '%".$search."%' OR
                M.Entrada LIKE '%".$search."%' OR
                A.Descricao LIKE '%".$search."%' OR
                C.Descricao LIKE '%".$search."%')
            ";
        }

        switch ($tipo) {
            case 0:
                $where .= " AND M.Entrada = 0";
                break;
            case 1:
                $where .= " AND M.Entrada = 1";
                break;
            case 2:
                $where .= " AND M.Entrada = 2";
                break;
        }

        $query =$this->db->query("SELECT 
            M.Id,
            M.Id_estoque,
            M.Quantidade,
            M.Entrada,
            RTRIM(A.Descricao) Descricao_material,
            RTRIM(C.Descricao) Descricao_ca,
            A.Unidade_de_medida
        FROM Movimentacoes M
        LEFT OUTER JOIN Estoque E ON M.Id_estoque = E.Id
        LEFT OUTER JOIN Materiais A ON A.Id = E.Id_material
        LEFT OUTER JOIN CAs C ON C.Id = E.Id_ca
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        // debug($response['data']);
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM Movimentacoes M $where")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;

        return $response;
    }

    public function inserir($data)
    {
        return $this->db->table('Movimentacoes')->insert($data);
    }

    public function editar($id, $data)
    {
        // debug($data);
        return $this->db->table('Movimentacoes')->where('Id',$id)->set($data)->update();
    }

    public function excluir($id)
    {
        return $this->db->table('Movimentacoes')->where('Id',$id)->delete();
    }

    public function listaGrupos()
    {
        $query = $this->db->query("SELECT * FROM GruposMateriais");
        $data = $query->getResultArray();
        foreach ($data as $key => $value) {
            $response[$key + 1] = ['id' => $value['Id'], 'Id_estoque' => $value['Nome']];
        }
        // debug($response);
        return $response;
    }
}