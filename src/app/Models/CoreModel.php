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
}