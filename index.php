<?php

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php"); 
require_once("lib/kitchen_type.php"); 
require_once("lib/ingredient.php"); 
require_once("lib/dish_info.php");

// INIT
//objectnaam (nu aangemaakt) + classnaam (zoals in '...'.php script)
// roep hier de verschillende classes aan die je wilt gebruiken.
$db = new database();
$articleObj = new Article($db->getConnection()); 
$userObj = new User($db->getConnection());
$kitchenTypeObj = new KitchenType($db->getConnection());
$ingredientObj = new Ingredient($db->getConnection());
$dishInfoObj = new DishInfo($db->getConnection());

// VERWERK
// datanaam (nu aangemaakt) + objectnaam (zoals hierboven genoemd).
// roep hier de verschillende functies aan die je wilt gebruiken.
$articleData = $articleObj->selectArticle(1); 
$userData = $userObj->selectUser(1);
$kitchenTypeData = $kitchenTypeObj->selectKitchenType(5); 
$ingredientData = $ingredientObj->selectIngredient(1); 
$dishInfoData = $dishInfoObj->selectDishInfo(1);
$usersCData = $dishInfoObj->selectUsersC();
$addFavoriteResult = $dishInfoObj->selectAddFavoriteIfNotExists(1, 2, 3);
$deleteFavoriteResult = $dishInfoObj->selectdeleteFavorite(1, 2, 3);

// RETURN
// roept datanaam aan (zoals hierboven genoemd) en geeft deze weer in een array.
echo "<pre>";
var_dump($articleData, $userData, $kitchenTypeData, $ingredientData, $dishInfoData, $usersCData, $addFavoriteResult, $deleteFavoriteResult);
