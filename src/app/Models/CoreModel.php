<?php 
namespace App\Models;
use CodeIgniter\Model;
use PHPSQLParser\builders\OrderByBuilder;

class CoreModel extends Model
{
    public function checar_tabela($table = null, $where = null)
    {
        $db = db_connect();
        $query = $db->table($table)
            ->where($where)
            ->countAll();
        return $query;
    }

    public function excluir_registro($table = null, $where = null)
    {
        $db = db_connect();
        $query = $db->table($table)
            ->where($where)
            ->delete();
        return $query;
    }

    public function datalist($id = null, $descricao = null, $table = null, $where = null, $where_value = null)
    {
        $db = db_connect();
        if ($where != null && $where_value != null) {
            return $db->table($table)->select($id.' id,'.$descricao.' descricao')->where($where,$where_value)->orderBy($descricao)->get()->getResultArray();
        } else {
            return $db->table($table)->select($id.' id,'.$descricao.' descricao')->orderBy($descricao)->limit()->get()->getResultArray();
        }
    }

    public function existe($where = null, $table = null)
    {
        $db = db_connect();
        $builder = $db->table($table);
        foreach ($where as $key => $value) {
            $builder->where($value['campo'],$value['valor']);
        }
        $count = count($builder->get()->getResultArray());
        return $count > 0 ? true : false;
    }

    public function listagemInicio($start = null, $length = null, $campo = null, $direcao = null, $search = null, $dt_inicio = null, $dt_limite = null)
    {
        $where = "WHERE Data >= '".$dt_inicio."  00:00:00' AND Data <= '".$dt_limite." 23:59:59'";
        
        if ($search != "") {
            $where = " AND
                Data LIKE '%".$search."%' OR
                Entrada LIKE '%".$search."%' OR
                M.Quantidade LIKE '%".$search."%' OR
                I.Descricao LIKE '%".$search."%' OR
                M.Id LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("SELECT M.Quantidade,
            CASE
            WHEN M.Entrada = 0 THEN 'Entrada'
            WHEN M.Entrada = 1 THEN 'Saída'
            WHEN M.Entrada = 2 THEN 'Transferência'
            ELSE '' END Entrada,
            FORMAT(M.data, 'dd/MM/yyyy') as Data,
            I.Descricao, 
            M.Id
        FROM Movimentacoes M
        LEFT OUTER JOIN Estoque E ON E.Id = M.Id_estoque
        LEFT OUTER JOIN Materiais I ON I.Id = E.Id_material 
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = count($response['data']);
        $response['recordsFiltered'] = $countall;
        $response['recordsTotal'] = $countall;
        $response['where'] = $where;
        return $response;
    }

}