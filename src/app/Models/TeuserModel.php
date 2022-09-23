<?php 
namespace App\Models;
class TeuserModel extends CoreModel
{
    protected $table = 'TEUSER';
    protected $primaryKey = 'Cd_USUARIO';
    protected $allowedFields = ['Cd_USUARIO', 'Usuario','Cd_empresa','Cd_unidade_n','Email','Senha','Versao_atual','Data_atuli','Contato'];
    protected $validationRules = [
        'Cd_USUARIO' => 'required|is_unique[TEUSER.Cd_USUARIO]'
    ];

    public function login($usuario,$senha){
        $query = $this->db->table("TEUSER U")
            ->select("U.Cd_USUARIO, ISNULL(UGD.Cd_gdirei,0) Cd_gdirei, RTRIM(U.Usuario) Nome")
            ->join("TEUSXGDIR UGD", "U.Cd_USUARIO = UGD.Cd_USUARIO", 'left')
            ->join("TEGDIREI GD", "GD.Cd_gdirei = UGD.Cd_gdirei", 'left')
            ->where("U.Usuario = '".$usuario."'");

        if ($senha != '') {
            $query->where("U.Senha",$senha);
        }
        return $query->get()->getRow();
    }

    public function listagem_usuarios($start = null, $length = null, $campo = null, $direcao = null, $search = null)
    {
        $where = "WHERE 1=1";

        if ($search != "") {
            $where .= " AND
                (U.Cd_USUARIO LIKE '%".$search."%' OR
                U.Usuario LIKE '%".$search."%' OR
                U.Cd_empresa LIKE '%".$search."%' OR
                U.Cd_unidade_n LIKE '%".$search."%' OR
                U.Email LIKE '%".$search."%')
            ";
        }

        $query =$this->db->query("SELECT 
            U.Cd_USUARIO,
            U.Cd_empresa, 
            RTRIM(U.Usuario) Usuario, 
            RTRIM(G.Nome_completo) Nome_completo,
            RTRIM(U.Email) Email, 
            U.Cd_unidade_n
        FROM TEUSER U
        LEFT OUTER JOIN GEEMPRES G ON U.Cd_empresa = G.Cd_empresa
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM TEUSER")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;

        return $response;
    }

    public function proximo_usuario()
    {
        $alfabeto = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $proximo_usuario = '001';
        // $proximo_usuario = '00Z';
        while ($this->db->table("TEUSER")->where('Cd_USUARIO',$proximo_usuario)->countAllResults() > 0) {
            $char3 = array_search(substr($proximo_usuario,2,1),$alfabeto);
            // debug(count($alfabeto));
            if($char3+1 == count($alfabeto)) {
                $proximo_usuario = substr_replace($proximo_usuario,0,2,1);
                $char2 = array_search(substr($proximo_usuario,1,1),$alfabeto);
                if($char2+1 == count($alfabeto)) {
                    $proximo_usuario = substr_replace($proximo_usuario,0,1,1);
                    $char1 = array_search(substr($proximo_usuario,0,1),$alfabeto);
                    if($char1+1 == count($alfabeto)) {
                        debug('ZZZ+1');
                    } else {
                        $proximo_usuario = substr_replace($proximo_usuario,$alfabeto[$char1+1],0,1); 
                    }
                } else {
                    $proximo_usuario = substr_replace($proximo_usuario,$alfabeto[$char2+1],1,1); 
                }
            } else {
                $proximo_usuario = substr_replace($proximo_usuario,$alfabeto[$char3+1],2,1);
            }
        }
        return $proximo_usuario;
    }

    public function inserir($data)
    {
        return $this->db->table('TEUSER')->insert($data);
    }

    public function editar($id, $data)
    {
        return $this->db->table('TEUSER')->where('Cd_USUARIO',$id)->update($data);
    }

    public function excluir($id)
    {
        return $this->db->table('TEUSER')->where('Cd_USUARIO',$id)->delete();
    }

    public function getUsuario($nome)
    {
        return $this->db->query("SELECT * FROM TEUSER WHERE Usuario = $nome")->getRowArray();
    }
}