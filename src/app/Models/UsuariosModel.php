<?php 
namespace App\Models;
class UsuariosModel extends CoreModel
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Id', 'Usuario','Senha','Admin'];
    protected $validationRules = [
        'Id' => 'required|is_unique[Usuarios.Id]'
    ];

    public function login($usuario,$senha){
        $query = $this->db->table("Usuarios U")
            ->select("U.Id, RTRIM(U.Usuario) Nome")
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
                (U.Id LIKE '%".$search."%' OR
                U.Usuario LIKE '%".$search."%' OR
                U.Admin LIKE '%".$search."%' OR
            ";
        }

        $query =$this->db->query("SELECT 
            U.Id,
            U.Admin, 
            RTRIM(U.Usuario) Usuario, 
        FROM Usuarios U
        $where
        ORDER BY $campo $direcao
        OFFSET $start ROWS
        FETCH NEXT $length ROWS ONLY");

        $response['data'] = $query->getResultArray();
        $response['lastQuery'] = $this->db->getLastQuery()->getQuery();
        $countall = $this->db->query("SELECT COUNT(*) Resultados FROM Usuarios")->getRowArray();
        // debug($countall->getRowArray());
        $response['recordsFiltered'] = $countall['Resultados'];
        $response['recordsTotal'] = $countall['Resultados'];
        $response['where'] = $where;

        return $response;
    }

    public function inserir($data)
    {
        return $this->db->table('Usuarios')->insert($data);
    }

    public function editar($id, $data)
    {
        return $this->db->table('Usuarios')->where('Id',$id)->update($data);
    }

    public function excluir($id)
    {
        return $this->db->table('Usuarios')->where('Id',$id)->delete();
    }

    public function getUsuario($nome)
    {
        return $this->db->query("SELECT * FROM Usuarios WHERE Usuario = $nome")->getRowArray();
    }
}