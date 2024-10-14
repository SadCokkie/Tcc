<?php
namespace App\Models;
class RelatoriosModel extends CoreModel
{
    public function busca_estoque($ca = null, $material = null, $grupo = null, $entrada = null, $data_inicio = null, $data_fim = null)
    {
        $where = "WHERE 1=1";

        if(!empty($ca)) $where .= " AND C.Id = $ca";
        if(!empty($material)) $where .= " AND I.Id = $material";
        if(!empty($grupo)) $where .= " AND G.Id = $grupo";
        if(!empty($entrada)) $where .= " AND M.Entrada = $entrada";
        if(!empty($data_inicio)) $where .= " AND M.data > '$data_inicio'";
        if(!empty($data_fim)) $where .= " AND M.data < '$data_fim'";
        // debug($where);

        $select = "
        SELECT DISTINCT  I.Id Material, I.Descricao";
        
        $query =$this->db->query("$select 
        FROM Materiais I 
        LEFT OUTER JOIN Estoque E ON E.Id_material = I.Id
        LEFT OUTER JOIN Movimentacoes M ON E.Id = M.Id_estoque
        LEFT OUTER JOIN CAs C ON C.Id = E.Id_ca
        LEFT OUTER JOIN GruposMateriais G ON G.Id = I.IdGrupo 
        $where");
        $response['material'] = $query->getResultArray();
        // debug($this->db->getLastQuery());

        $materiais = "";
        if(empty($material)){
            foreach ($response['material'] as $key => $value) {
                // debug($value);
                $materiais .= $value['Material'].",";
            }
            $materiais = substr($materiais, 0, -1);
            $where .= " AND I.Id in ($materiais)";
        }
        // debug($where);
        

        $select = "
        SELECT 
        (SELECT SUM(M2.Quantidade) FROM Movimentacoes M2 LEFT OUTER JOIN Estoque E2 ON E2.Id = M2.Id_estoque WHERE E2.Id_material = I.Id AND M2.Entrada = 0 ) Total_entrada,
		(SELECT SUM(M2.Quantidade) FROM Movimentacoes M2 LEFT OUTER JOIN Estoque E2 ON E2.Id = M2.Id_estoque WHERE E2.Id_material = I.Id AND M2.Entrada = 1 ) Total_saida,
		(SELECT SUM(M2.Quantidade) FROM Movimentacoes M2 LEFT OUTER JOIN Estoque E2 ON E2.Id = M2.Id_estoque WHERE E2.Id_material = I.Id AND M2.Entrada = 2 ) Total_transferencia,
        CASE 
        WHEN M.Entrada = 0 THEN 'Entrada'
        WHEN M.Entrada = 1 THEN 'Baixa'
        WHEN M.Entrada = 2 THEN 'Transferência'
        END Entrada, M.data, M.Quantidade Movimentacao,
        M.Id_estoque, E.Quantidade Estoque,
        E.Id_material, I.Descricao Material,
        G.Nome, C.Descricao Ca";
        
        $query =$this->db->query("$select 
        FROM Movimentacoes M 
        LEFT OUTER JOIN Estoque E ON E.Id = M.Id_estoque
        LEFT OUTER JOIN Materiais I ON I.Id = E.Id_material
        LEFT OUTER JOIN CAs C ON C.Id = E.Id_ca
        LEFT OUTER JOIN GruposMateriais G ON G.Id = I.IdGrupo 
        $where 
        ORDER BY M.data ASC");
        $response['data'] = $query->getResultArray();
        // debug($this->db->getLastQuery());
        // debug($query->getResultArray());
        return $response;
    }
}
