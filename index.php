<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerechten_info.php");

/// INIT / objects
$db = new database();
$art = new artikel($db->getConnection());
$user = new user($db->getConnection());
$keuken_type = new keuken_type($db->getConnection());
$ingredient_return= new ingredient($db->getConnection());
$gerecht_info = new gerecht_info($db->getConnection());

/// VERWERK 
$artikel = $art->selecteerArtikel(1);
$user = $user->selecteerUser(1);
$keuken_type = $keuken_type->selecteerKeuken_type(5);
$ingredient_return = $ingredient_return->selecteerIngredient(1);
$gerecht_info = $gerecht_info->selecteerGerecht_info(1);

/// RETURN
echo "<pre>";
var_dump($artikel, $user, $keuken_type, $ingredient_return, $gerecht_info);


