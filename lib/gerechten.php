<?php

class gerechten {
    //properties
    
    private $connection;
    //keuken en type apart?
    private $ingredient;
    private $prijs;
    private $calorieen;
    private $bereidingswijze;
    private $opmerkingen;
    private $waardering;
    private $favorieten;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        //keuken_type
        $this->ingredient = new ingredient($connection);
        $this ->prijs = new prijs($connection);
        $this ->calorieen = new calorieen($connection);
        $this ->bereidingswijze = new bereidingswijze($connection);
        $this ->opmerkingen = new opmerkingen($connection);
        $this ->waardering = new waardering($connection);
        $this ->favorieten = new favorieten($connection);
    }
  
    //private functie
    private function selecteerIngredient($ingredient_id) {
        $ingredient = $this->ingredient->selecteerIngredient($ingredient_id);
        return($ingredient);
    }
    //private functies etc...
    
    public function selecteerGerechten ($Gerechten_id) {
        $sql = "select * from gerechten where gerechten_id = gerechten_id";
        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return[];
    }
    
    // methode selectUser toevoegen
    // methode selectKitchen toevoegen
    // methode selectType toevoegen
    // methode calcCalories toevoegen
    // methode calcPrice toevoegen
    // methode selectRating toevoegen
    // methode selectSteps toevoegen
    // methode selectRemarks toevoegen
    // methode detemineFavorite toevoegen

}

