<?php
    
class KitchenType {
    //properties
    private $connection;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function selectKitchenType($kitchen_type_id) {
        $sql = "SELECT * FROM kitchen_type WHERE id = $kitchen_type_id";
        $result = mysqli_query($this->connection, $sql);
        $kitchen_type = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($kitchen_type);
    }

}

