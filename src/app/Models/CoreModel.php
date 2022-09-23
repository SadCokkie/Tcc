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
                Disciplina LIKE '%".$search."%' OR
                Tipo LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("WITH AGENDA AS (
            SELECT A.Data, D.Nome Disciplina, 'Aula' Tipo FROM TEAULAS A
            LEFT OUTER JOIN TEDISCIPLINAS D ON A.Cd_disciplina = D.Cd_disciplina
            UNION ALL
            SELECT A.Data, D.Nome Disciplina, 'Avaliação' Tipo FROM TEAVALIACOES A
            LEFT OUTER JOIN TEDISCIPLINAS D ON A.Cd_disciplina = D.Cd_disciplina
        ) SELECT (select FORMAT(Data, 'dd/MM/yyyy HH:mm')) Data, Disciplina, Tipo FROM AGENDA  
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

    public function busca_cep ($cep = null)
    {
        return $this->db->query("SELECT 
            Cidade,
            Estado,
            Bairro_inicial Bairro,
            CONCAT(RTRIM(Tipo_de_logrado),' ',RTRIM(Nome_da_rua)) Endereco
            FROM GECEP 
            WHERE Cep_novo = '$cep'")
            ->getRowArray();
    }

    public function atualiza_tabela_ultimo_id($tabela, $campo, $quantidadeCaracteres, $preenchimento, $direcaoPreenchimento)
    {
        
        // get no $campo da $tabela
        $ultimoRegistro = $this->db->table($tabela)->select($campo)->get()->getRowArray();
        // soma +1 no Id 
        $novaId = intval($ultimoRegistro[$campo]) + 1;
        //preencher a Id com $preenchimento na $direcaoPreenchimento até completar $quantidadeCaracteres 
        // valores aceitaveis para $direcaoPreenchimento = STR_PAD_LEFT, STR_PAD_BOTH, STR_PAD_RIGHT
        $novaId = str_pad(strval($novaId), $quantidadeCaracteres, $preenchimento, $direcaoPreenchimento);
        //salva a nova Id na tabela 
        $data[$campo] = $novaId;
        $this->db->table($tabela)->where($campo, $ultimoRegistro[$campo])->update($data);
        //retorna nova Id
        return $novaId;
    }
}