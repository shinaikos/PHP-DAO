<?php


class Sql extends PDO 
{

    private $conn;

    // metodo construtor | cria a conexão com o database quando chamado
    public function __construct()
    {

        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7","root","");

    } 

    private function setParams($statemente, $parameters = array())
    {

        foreach($parameters as $key => $value)
        {
            $this->setParam($statemente, $key, $value);
        }

    }

    // setParam 
    private function setParam($statemente,$key, $value)
    {
        $statemente->bindParam($key, $value);
    }

    public function query($rawquery , $params = array())
    {
        $stmt = $this->conn->prepare($rawquery);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
        
    }

    public function select($rawquery, $params = array()):array
    {
        $stmt = $this->query($rawquery, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>