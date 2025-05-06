<?php

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/dish_info.php");
require_once("lib/dishes_V2.php");

// === INIT ===
// Initialize the database connection
$db = new database();
$connection = $db->getConnection();

// Initialize objects for the required classes
$articleObj = new Article($connection);
$userObj = new User($connection);
$kitchenTypeObj = new KitchenType($connection);
$ingredientObj = new Ingredient($connection);
$dishInfoObj = new DishInfo($connection);
$dishesObj = new Dishes($connection);

// === VERWERK ===
$dish_id = 1; // Example dish ID

// Fetch data
$selectRecipe = $dishesObj->selectRecipe($dish_id);

$articleData = $articleObj->selectArticle(1);
$userData = $userObj->selectUser(1);
$kitchenTypeData = $kitchenTypeObj->selectKitchenType(5);
$ingredientData = $ingredientObj->selectIngredient(1);
$dishInfoData = $dishInfoObj->selectDishInfo(1, 2);
$addFavoriteResult = $dishInfoObj->AddFavoriteIfNotExists(1, 2, 3);
$deleteFavoriteResult = $dishInfoObj->deleteFavorite(1, 2, 3);

// === OUTPUT ===
// Display the fetched data
echo "<pre>";
// var_dump(
//         $articleData, 
//         $userData, 
//         $kitchenTypeData,
//         $ingredientData, 
//         $dishInfoData, 
//         $addFavoriteResult, 
//         $deleteFavoriteResult);
print_r($selectRecipe);
echo "</pre>";



