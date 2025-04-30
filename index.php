<?php

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php"); 
require_once("lib/kitchen_type.php"); 
require_once("lib/ingredient.php"); 
require_once("lib/dish_info.php");

// INIT: The following lines create objects for each class and pass the database connection to their constructors.
$db = new database();
$Article = new article($db->getConnection()); 
$User = new user($db->getConnection());
$KitchenType = new KitchenType($db->getConnection());
$Ingredient_return = new ingredient($db->getConnection());
$DishInfo = new DishInfo($db->getConnection());

// VERWERK: The following lines call the `select` methods on the respective objects to fetch data from the database.
$Article = $Article->selectArticle(1); 
$User = $User->selectUser(1);
$KitchenType = $KitchenType->selectKitchenType(5); 
$Ingredient_return = $Ingredient_return->selectIngredient(1); 
$DishInfo = $DishInfo->selectDishinfo(1); 

// RETURN: Displays the data fetched from the database.
echo "<pre>";
var_dump($Article, $User, $KitchenType, $Ingredient_return, $DishInfo); 


