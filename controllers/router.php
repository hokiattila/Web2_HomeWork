<?php
session_start();
if (!isset($_SESSION['username'])) $_SESSION['username'] = "unknown";
if (!isset($_SESSION['userfirstname'])) $_SESSION['userfirstname'] = "";
if (!isset($_SESSION['userlastname'])) $_SESSION['userlastname'] = "";
if (!isset($_SESSION['userlevel'])) $_SESSION['userlevel'] = "1__";

include(SERVER_ROOT.'includes/database.inc.php');
Database::dbInit();

include(SERVER_ROOT.'includes/nav.inc.php');

$page = "home";
$subpage = "";
$vars = array();

$request = $_SERVER['QUERY_STRING'];

if($request != "")
{
    $params = explode('/', $request);
    $page = array_shift($params); // a kért oldal neve

    if(array_key_exists($page, Menu::$menu) && count($params)>0) // Az oldal egy menüpont oldala és van még adat az url-ben
    {
        $subpage = array_shift($params); // a kért aloldal
        if(! (array_key_exists($subpage, Menu::$menu) && Menu::$menu[$subpage][1] == $page)) // ha nem egy alolal
        {
            $vars[] = $subpage; // akkor ez egy parameter
            $subpage = ""; // és nincs aloldal
        }

    }

    foreach($params as $p) // a paraméterek tömbje feltöltése
    {
        $vars[] = $p;
    }

    $vars += $_POST;
}

// Meghatározzuk a kért oldalhoz tartozó vezérlõt. Ha megtaláltuk
// a fájlt és a hozzá tartozó vezérlõ oldalt is, akkor betöltjük az
// elõbbiekben lekérdezett paramétereket továbbadva.

$controllerfile = $page.($subpage != "" ? "_".$subpage : "");
$target = SERVER_ROOT.'controllers/'.$controllerfile.'.php';

if(! file_exists($target))
{
    $target = SERVER_ROOT.'controllers/error.php';
    $vars[0] = "A vezérlő nem található";
    $vars[1] = "Hiányzó oldal <strong>".$controllerfile."</strong>";
    $controllerfile = "error";
}

include_once($target);
$class = ucfirst($controllerfile).'_Controller';

if(! class_exists($class))
{
    include_once(SERVER_ROOT.'controllers/error.php');
    $vars[0] = "A vezérlő főosztálya nem található";
    $vars[1] = "Hiányos oldal megadása <strong>".$controllerfile."</strong>";
    $class = 'Error_Controller';
}


include_once(SERVER_ROOT.'models/view_loader.php');

$controller = new $class;
$controller->main($vars);
