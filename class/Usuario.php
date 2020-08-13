<?php

class Usuario
{

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

   


    // Getter e Setters
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    public function setIdusuario($value)
    {
        $this->idusuario = $value;
    }

    public function getDeslogin()
    {
        return $this->deslogin;
    }

    public function setDeslogin($value)
    {
        $this->deslogin = $value;
    }

    public function getDessenha()
    {
        return $this->dessenha;
    }

    public function setDessenha($value)
    {
        $this->dessenha = $value;
    }

    public function getDtcadastro()
    {
        return $this->dtcadastro;
    }

    public function setDtcadastro($value)
    {
        $this->dtcadastro = $value;
    }

    public function setData($data)
    {
        $this->setIdusuario($data['id_usuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro($data['dtcadastro']);
    }

    public function __construct($login = "", $pass = "")
    {
        $this->setDeslogin($login);
        $this->setDessenha($pass);
    }

    public function update($login, $pass)
    {
        $this->setDeslogin($login);
        $this->setDessenha($pass);

        $sql = new Sql();

        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASS WHERE id_usuario = :ID", array(
            ':LOGIN' => $this->getDeslogin(),
            ':PASS' => $this->getDessenha(),
            ':ID' => $this->getIdusuario()
        ));
    }

    public function loadById($id)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE id_usuario = :ID", array(
            ":ID"=>$id
        ));
       

        if(count($results) > 0)
        {
            $this->setData($results[0]);
        }
    }

    public function login($login, $pass)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASS", array(
            ":LOGIN"=>$login,
            ":PASS" => $pass
        ));
       

        if(count($results) > 0)
        {
            $this->setData($results[0]);
        }
        else
        {
            throw new Exception("Login e/ou Senha invalidos");
        }
    }

    public function insert()
    {
        $sql = new Sql();

        $results = $sql->select("CALL sp_usuario_insert(:LOGIN, :PASS)",  array(
            ":LOGIN" => $this->getDeslogin(),
            ":PASS" => $this->getDessenha()
        ));

        if(count($results) > 0)
        {
            $this->setData($results[0]);
        }
        
    }

    public static function search($login)
    {
        
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH' => "%" . $login . "%"
        ));
    }

    public static function getList()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
    }

    public function delete()
    {
        $sql = new Sql();

        $sql->query("DELETE FROM tb_usuarios WHERE id_usuario = :ID", array(
            ":ID" => $this->getIdusuario()
        ));

        $this->setDeslogin("");
        $this->setIdusuario(0);
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());
    }

 

    public function __toString()
    {
        return json_encode(array(
            "idusuario" => $this->getIdusuario(),
            "deslogin" => $this->getDeslogin(),
            "dessenha" => $this->getDessenha(),
            "dtcadastro" => $this->getDtcadastro()

        ));
    }

}

?>