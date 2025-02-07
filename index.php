<?php
require_once("Config/Config.php");
require_once("Helpers/Helpers.php");

$url = !empty($_GET['url']) ? $_GET['url'] : "home/home";
// separa un strim cuando encuentre el caracter, en este caso el /
$arrUrl = explode("/", $url);
// asignar controlador
$controller = $arrUrl[0];
// asignar metodo
$method = $arrUrl[0];
//definir parametros
$params = "";

if (!empty($arrUrl[1])) {
    if ($arrUrl[1] != "") {
        $method = $arrUrl[1];
    }
}

if (!empty($arrUrl[2])) {
    if ($arrUrl[2] != "") {
        for ($i = 2; $i < count($arrUrl); $i++) {
            // asignar parametros y concatenar la ,
            $params .= $arrUrl[$i] . ',';
        }
        // eliminar ultima ,
        $params = trim($params, ',');
    }
}

require_once("Libraries/Core/Autoload.php");
require_once("Libraries/Core/Load.php");
