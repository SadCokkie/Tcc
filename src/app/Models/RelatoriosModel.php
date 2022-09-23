<?php
namespace App\Models;
class RelatoriosModel extends CoreModel
{
    protected $table = 'GEENTREG';
    protected $primaryKey = 'Cd_empresa, Ordem, Cd_entrega, Sugestao';
    protected $allowedFields = ['Bairro','Campo16','Campo17','Campo18','Campo19','Campo20','Campo21','Campo22','Campo23','Campo24','Campo25','Campo26','Campo27','Campo28','Campo29','Campo30','Campo31','Campo32','Campo33','Campo34','Campo35','Campo36','Campo37','Campo38','Campo39','Campo40','Campo41','Campo42','Campo43','Cd_empresa','Cd_entrega','Cd_pais','Cep','Dt_modificacao','Endereco','Municipio','Observacao','Ordem','Sessao','Sugestao','Uf','Usuario_criacao','Usuario_modific'];
    protected $validationRules = [
        'PK' => 'required|is_unique[GEENTREG.Cd_empresa, GEENTREG.Ordem, GEENTREG.Cd_entrega, GEENTREG.Sugestao]'
    ];

    public function buscar_notas($start = null, $length = null, $campo = null, $direcao = null, $search = null, $empresa = null)
    {
        $where = "WHERE N.Cd_empresa = '".$empresa."'";

        if ($search != "") {
            $where = " AND
                D.Nome LIKE '%".$search."%' OR
                A.Nome  LIKE '%".$search."%' OR
                N.Nota LIKE '%".$search."%'
            ";
        }
        
        $query =$this->db->query("SELECT 
            D.Nome Disciplina, 
            A.Nome Avaliacao, 
            N.Nota 
        FROM TENOTAS N
        LEFT OUTER JOIN TEAVALIACOES A ON N.Cd_avaliacao = A.Cd_avaliacao
        LEFT OUTER JOIN TEDISCIPLINAS D ON D.Cd_disciplina = A.Cd_disciplina
        $where
        ORDER BY D.Nome asc, A.Data asc
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM TEDISCIPLINAS D $where");
        $countall = $countall->getRowArray();
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;
        
        return $response;
    }

    public function buscar_presencas($start = null, $length = null, $campo = null, $direcao = null, $search = null, $empresa = null)
    {
        $where = "WHERE P.Cd_empresa = '".$empresa."'";

        if ($search != "") {
            $where = " AND
                D.Nome LIKE '%".$search."%' OR
                A.Data  LIKE '%".$search."%' OR
                N.Presente LIKE '%".$search."%'
            ";
        }
        
        $query =$this->db->query("SELECT 
            D.Nome Disciplina
            ,A.Data
            ,P.Presente
        FROM TEPRESENCAS P
        LEFT OUTER JOIN TEAULAS A ON P.Cd_aula = A.Cd_aula
        LEFT OUTER JOIN TEDISCIPLINAS D ON D.Cd_disciplina = A.Cd_disciplina
        $where
        ORDER BY D.Nome asc, A.Data asc
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = $this->db->table('TEPRESENCAS P')->join('TEAULAS A','P.Cd_aula = A.Cd_aula','left')->join('TEDISCIPLINAS D','D.Cd_disciplina = A.Cd_disciplina','left')->where('P.Cd_empresa',$empresa)->countAllResults();
        $response['recordsFiltered'] = $countall;
        $response['recordsTotal'] = $countall;
        $response['where'] = $where;
        
        return $response;
    }

    public function buscar_atestados($start = null, $length = null, $campo = null, $direcao = null, $search = null, $empresa = null)
    {
        $where = "WHERE A.Cd_empresa = '".$empresa."'";

        if ($search != "") {
            $where = " AND
                E.Nome_completo LIKE '%".$search."%' OR
                A.Data  LIKE '%".$search."%' OR
                A.Duracao LIKE '%".$search."%'
            ";
        }
        
        $query =$this->db->query("SELECT 
            RTRIM(E.Nome_completo) Nome_completo
            ,A.Data
            ,A.Duracao
        FROM TEATESTADOS A
        LEFT OUTER JOIN GEEMPRES E ON E.Cd_empresa = A.Cd_empresa
        $where
        ORDER BY E.Nome_completo asc, A.Data asc
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = $this->db->table('TEATESTADOS A')->join('GEEMPRES E','E.Cd_empresa = A.Cd_empresa','left')->where('A.Cd_empresa',$empresa)->countAllResults();
        $response['recordsFiltered'] = $countall;
        $response['recordsTotal'] = $countall;
        $response['where'] = $where;
        
        return $response;
    }

    public function buscar_financeiro($start = null, $length = null, $campo = null, $direcao = null, $search = null, $empresa = null)
    {
        $where = "WHERE 1=1";
        
        if($empresa != null) {
            $where .= " AND C.Cd_empresa = ".$empresa;
        }
        
        
        if ($search != "") {
            $where = " AND
                P.Cd_contrato LIKE '%".$search."%' OR
                P.Cd_parcela LIKE '%".$search."%' OR
                P.Valor LIKE '%".$search."%' OR
                P.Tipo LIKE '%".$search."%' OR
                P.Data_pagamento LIKE '%".$search."%' OR
                K.Nome LIKE '%".$search."%' OR
                P.Validade LIKE '%".$search."%'
            ";
        }

        $query =$this->db->query("SELECT 
            P.Cd_contrato
            ,P.Cd_parcela
            ,P.Valor
            ,P.Tipo
            ,K.Nome
            ,FORMAT(P.Data_pagamento, 'dd/MM/yyyy') Data_pagamento
            ,FORMAT(P.Validade, 'dd/MM/yyyy') Validade
        FROM TEPARCELAS P
        LEFT OUTER JOIN TECONTRATOS C ON C.Cd_contrato = P.Cd_contrato
        LEFT OUTER JOIN TECURSOS K ON K.Cd_curso = C.Cd_curso
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        // debug($where);
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM TECONTRATOS C $where");
        $countall = $countall->getRowArray();
        // debug($countall['Resultados']);
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        
        return $response;
    }
}
