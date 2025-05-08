<?php

class Grocery_list {
    //Properties
    private $connection;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
    }

    // Ondersteunende functie ingrediënten
    function selectIngredienten($dish_id) {
        return [
            // ['artikel_id' => 1],
            // ['artikel_id' => 2],
            // ['artikel_id' => 3],
        ];
    }

    // Ondersteunende functie boodschappenlijst
    function ophalenBoodschappen($user_id) {
        return [
            // (object)['artikel_id' => 2],
            // (object)['artikel_id' => 4],
        ];
    }

    // functie: boodschappenToevoegen(gerecht_id, user_id)
    function boodschappenToevoegen($gerecht_id, $user_id) {
        $ingredienten = $this->ophalenIngredienten($gerecht_id); 

        foreach ($ingredienten as $ingredient) {
            $artikel_id = $ingredient['artikel_id'];

            if ($this->ArtikelOpLijst($artikel_id, $user_id)) {
                // Artikel bijwerken
                $this->ArtikelBijwerken($artikel_id, $user_id);
            } else {
                // Artikel toevoegen
                $this->ArtikelToevoegen($artikel_id, $user_id);
            }
        }
    }

    // functie: ArtikelOpLijst(artikel_id, user_id)
    function ArtikelOpLijst($artikel_id, $user_id) {
        $boodschappen = $this->ophalenBoodschappen($user_id);

        foreach ($boodschappen as $boodschap) {
            if ($boodschap->artikel_id == $artikel_id) {
                // Artikel is op de lijst
                return $boodschap;
            }
        }

        // Artikel is niet op de lijst
        return false;
    }

    // Simuleert toevoegen van artikel aan boodschappenlijst
    function ArtikelToevoegen($artikel_id, $user_id) {
        echo "Artikel $artikel_id toegevoegd voor gebruiker $user_id\n";
    }

    // Simuleert bijwerken van bestaand artikel op boodschappenlijst
    function ArtikelBijwerken($artikel_id, $user_id) {
        echo "Artikel $artikel_id bijgewerkt voor gebruiker $user_id\n";
    }
}
