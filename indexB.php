<?php

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/User.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/dish_info.php");
require_once("lib/dishes.php");
require_once("lib/groceries_article.php");

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
$groceryListObj = new Grocery_list($connection);

// === VERWERK ===
$dish_ids = [1, 2]; // Example dish IDs
$dish_id = 1; // Example dish ID
$user_id = 1; // Example user ID

// Fetch data
$articleData = $articleObj->selectArticle(1);
$userData = $userObj->selectUser(1);
$kitchenTypeData = $kitchenTypeObj->selectKitchenType(5);
$ingredientData = $ingredientObj->selectIngredient(1);
$dishInfoData = $dishInfoObj->selectDishInfo(1, 2);
$addFavoriteResult = $dishInfoObj->AddFavoriteIfNotExists(1, 2, 3);
$deleteFavoriteResult = $dishInfoObj->deleteFavorite(1, 2, 3);

$selectRecipes = $dishesObj->selectRecipeOrMore($dish_id);

$articleList = $groceryListObj->articleOnList($user_id, 1);
$groceryList = $groceryListObj->addGroceries($dish_id, $user_id);

// === OUTPUT ===
// Display the fetched data
echo "<pre>";
// var_dump(
//     $articleData, 
//      $userData, 
//     $kitchenTypeData,
//     $ingredientData, 
//    $dishInfoData);
//     $addFavoriteResult, 
//     $deleteFavoriteResult,
//     $groceryList,
//     $articleList);
print_r($selectRecipes);
echo "</pre>";

