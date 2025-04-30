<?php

class ingredient {
    //properties
    private $connection;
    private $artikel;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
        $this->artikel = new artikel($connection);
    }
  
    private function selecteerArtikel($artikel_id) {
        $artikel = $this->artikel->selecteerArtikel($artikel_id);
        return($artikel);
    }

    public function selecteerIngredient($gerecht_id) {
        //selecteer alle ingredientvelden die behoren tot een specifiek gerecht.
        $sql = "select * from ingredient where id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        // lege aray voor tegen foutmelding null waarden.
        $ingredient_return=[];

        // Gecreeërde array verplaatsen in "$row". 
        // Loops erdoor en maakt nieuwe array aan (loops door zolang mysqli_fetch_array kan worden uitgevoerd,
        // (e.g. select * from ingredient waar gerecht_id = $gerecht_id)). 
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            // Nieuw property: artikel_id en stop die in "$row".
            $artikel_id = $row["artikel_id"];

            // Nieuw property_2: art_ing.
            // maak nieuwe array aan, via de selecteerArtikel functie, voor elke artikel_id.
            $art_ing = $this->selecteerArtikel($artikel_id);
        
            // maak nieuwe array aan en specificeer de velden.
            $ingredient_return[] = [
                "id" => $row["id"],
                "gerecht_id" => $row["gerecht_id"],
                "artikel_id" => $artikel_id,
                "naam" => $artikel_id["naam"],
                "omschrijving" => $artikel_id["omschrijving"]
            ];
        }
        return($ingredient_return);
    }
    
}

