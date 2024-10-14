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
        // debug($data);
        date_default_timezone_set('America/Campo_Grande');
        $movimentacao['data'] = date('Y/m/d', time());
        // debug($movimentacao);
        switch ($data['Tipo']) {
            case 0:
                $this->inserir_entrada($data);
                break;
            case 1:
                $this->inserir_saida($data);
                break;
            case 2:
                // montando insercao movimento de transferencia
                $movimentacao['Entrada'] = $data['Tipo'];
                $movimentacao['Quantidade'] = $data['Quantidade'];
                $movimentacao['Ca_transferencia'] = $data['Id_Ca'];
                $movimentacao['Id_estoque'] = $data['Id_recebe'];

                // motando insercao movimento de saida 
                
                //  motando insercao movimento de entrada


                // montando a insercao/edicao do novo estoque
                $novoEstoque['Quantidade'] = $data['Quantidade'];
                $novoEstoque['Id_material'] = $data['Id_material'];
                $novoEstoque['Id_ca'] = $data['Id_recebe'];
                // debug($novoEstoque);
                $estoque = isset($this->db->query("SELECT Id FROM Estoque WHERE Id_ca = ".$novoEstoque['Id_ca']." AND Id_material = ". $novoEstoque['Id_material'])->getRow()->Id) ? $this->db->query("SELECT Id FROM Estoque WHERE Id_ca = ".$novoEstoque['Id_ca']." AND Id_material = ". $novoEstoque['Id_material'])->getRow()->Id : 0;
                if($estoque == 0){
                    $this->db->table('Estoque')->insert($novoEstoque);
                    $movimentacao['Id_estoque'] = $this->db->query("SELECT IDENT_CURRENT('Estoque') Id_estoque")->getRow()->Id_estoque;
                }else{
                    $novoEstoque['Quantidade'] += $this->db->query("SELECT Quantidade FROM Estoque WHERE Id =".$estoque)->getRow()->Quantidade;
                    // debug($data['Quantidade']);
                    $movimentacao['Id_estoque'] = $estoque;
                    $this->db->table('Estoque')->where('Id',$estoque)->set($novoEstoque)->update();
                }
                // atualizando quantidade do estoque que esta sendo transferido
                $data['Quantidade'] = $data['Estoque'] - $data['Quantidade'];
                unset($data['Estoque']);
                unset($data['Tipo']);
                unset($data['Id_recebe']);
                $ca_transferencia = $this->db->query("SELECT Id FROM Estoque WHERE Id_ca = ".$data['Id_Ca']." AND Id_material = ". $data['Id_material'])->getRow()->Id;
                $this->db->table('Estoque')->where('Id',$ca_transferencia)->set($data)->update();
                // debug($estoque);
                

                $this->db->table('Movimentacoes')->insert($movimentacao);
                break;
        }
    }

    public function editar($id, $data)
    {
        // debug($data);
        date_default_timezone_set('America/Campo_Grande');
        $movimentacao['data'] = date('Y/m/d', time());
        $movimentacao['Entrada'] = $data['Tipo'];
        $movimentacao['Quantidade'] = $data['Quantidade'];
        unset($data['Tipo']);
        
        return $this->db->table('Movimentacoes')->where('Id',$id)->set($movimentacao)->update();
    }

    public function excluir($id)
    {
        // debug($id);
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

    public function inserir_entrada($data)
    {
        // debug($data);
        date_default_timezone_set('America/Campo_Grande');
        $movimentacao['data'] = date('Y/m/d', time());
        $movimentacao['Entrada'] = $data['Tipo'];
        $movimentacao['Quantidade'] = $data['Quantidade'];
        unset($data['Tipo']);
        $estoque = isset($this->db->query("SELECT Id FROM Estoque WHERE Id_ca = ".$data['Id_Ca']." AND Id_material = ". $data['Id_material'])->getRow()->Id) ? $this->db->query("SELECT Id FROM Estoque WHERE Id_ca = ".$data['Id_Ca']." AND Id_material = ". $data['Id_material'])->getRow()->Id : 0;
        if($estoque == 0){
            $this->db->table('Estoque')->insert($data);
            $movimentacao['Id_estoque'] = $this->db->query("SELECT IDENT_CURRENT('Estoque') Id_estoque")->getRow()->Id_estoque;
        }else{
            $data['Quantidade'] += $this->db->query("SELECT Quantidade FROM Estoque WHERE Id =".$estoque)->getRow()->Quantidade;
            // debug($data['Quantidade']);
            $movimentacao['Id_estoque'] = $estoque;
            $this->db->table('Estoque')->where('Id',$estoque)->set($data)->update();
        }
        // debug($estoque);
        $this->db->table('Movimentacoes')->insert($movimentacao);
    }

    public function inserir_saida($data)
    {
        // debug($data);
        date_default_timezone_set('America/Campo_Grande');
        $movimentacao['data'] = date('Y/m/d', time());
        $movimentacao['Entrada'] = $data['Tipo'];
        $movimentacao['Quantidade'] = $data['Quantidade'];
        $data['Quantidade'] = $data['Estoque'] - $data['Quantidade'];
        unset($data['Estoque']);
        unset($data['Tipo']);
        $estoque = $this->db->query("SELECT Id FROM Estoque WHERE Id_ca = ".$data['Id_Ca']." AND Id_material = ". $data['Id_material'])->getRow()->Id;
        $this->db->table('Estoque')->where('Id',$estoque)->set($data)->update();
        $movimentacao['Id_estoque'] = $estoque;
        // debug($estoque);
        $this->db->table('Movimentacoes')->insert($movimentacao);
    }

    public function registro($id)
    {
        return $this->db->query("SELECT 
            M.Id,
            M.Id_estoque,
            M.Quantidade,
            M.Entrada,
            RTRIM(A.Descricao) Descricao_material,
            RTRIM(C.Descricao) Descricao_ca,
            A.Unidade_de_medida,
            A.Id Id_material,
            E.Id Id_estoque,
            C.Id Id_Ca
        FROM Movimentacoes M
        LEFT OUTER JOIN Estoque E ON M.Id_estoque = E.Id
        LEFT OUTER JOIN Materiais A ON A.Id = E.Id_material
        LEFT OUTER JOIN CAs C ON C.Id = E.Id_ca
        WHERE M.Id = $id")->getRowArray();
    }

    public function atualiza_estoque($tipo, $estoque, $data)
    {
        switch ($tipo) {
            case 0:
                # code...
                break;
            
            case 1:
                # code...
                break;

            case 2:
                # code...
                break;
        }
    }
}