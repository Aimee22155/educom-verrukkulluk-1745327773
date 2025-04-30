<?php
    
class keuken_type {
    //properties
    private $connection;

    //methods
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function selecteerKeuken_type($keuken_type_id) {
        $sql = "select * from keuken_type where id = $keuken_type_id";
        $result = mysqli_query($this->connection, $sql);
        $keuken_type = mysqli_fetch_array($result, MYSQLI_ASSOC); //mysqli_assoc --> kolomnamen

        return($keuken_type);
    }

}

