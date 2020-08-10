<?php

    require_once("config.php");

    // $sql = new Sql();

    // $usuarios = $sql->select("SELECT * FROM tb_usuarios");

    // echo json_encode($usuarios);


    // $root = new Usuario();

    // $root->loadById(2);

    // echo $root;

    // $usuarios = Usuario::getList();

    // echo json_encode($usuarios);

    // $busca = Usuario::search("Gu");

    // echo json_encode($busca);


    $login = new Usuario;

    $login->login("Gui", "poiuytre");

    echo $login;
?>