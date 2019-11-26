<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 11.41
 */

class Wishlist
{
// database connection and table name
    private $conn;
    private $table_name = "wishlist";

    public $id;
    public $user_id;
    public $title_wishlist;
    public $number_of_items;

    public function __construct($conn){
        $this->conn = $conn;
    }

    function read(){

        error_log("Read");

        $query = 'SELECT wishlist.id, users.name, wishlist.title_wishlist, wishlist.number_of_items ' .
                 'FROM ' . $this->table_name . ' ' .
                 'INNER JOIN users on wishlist.user_id = users.id';

        //error_log($query);

        $result = $this->conn->prepare($query);
        $result->execute();

        return $result;
    }

    function readOne(){

        error_log("ReadOne");

        $query = 'SELECT wishlist.id, users.name, wishlist.title_wishlist, wishlist.number_of_items ' .
                 'FROM ' . $this->table_name . ' ' .
                 'INNER JOIN users on wishlist.user_id = users.id ' .
                 'WHERE wishlist.id = ?';

        //error_log($query);

        $result = $this->conn->prepare($query);

        $result->bindParam(1, $this->id);

        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->title_wishlist = $row['title_wishlist'];
        $this->number_of_items = $row['number_of_items'];
    }

    function create(){

        error_log("Create");

        $query = 'INSERT INTO ' . $this->table_name . ' ' .
                 'SET user_id =:user_id, title_wishlist=:title_wishlist, number_of_items=:number_of_items';

        //error_log($query);

        $result = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->title_wishlist=htmlspecialchars(strip_tags($this->title_wishlist));
        $this->number_of_items=htmlspecialchars(strip_tags($this->number_of_items));

        $result->bindParam(":user_id", $this->user_id);
        $result->bindParam(":title_wishlist", $this->title_wishlist);
        $result->bindParam(":number_of_items", $this->number_of_items);

        if($result->execute()){
            return true;
        }
        return false;
    }

    function update(){

        error_log("Update");

        $query = 'UPDATE ' . $this->table_name . ' ' .
                 'SET user_id = :user_id, title_wishlist=:title_wishlist, number_of_items=:number_of_items '.
                 'WHERE id = :id';

        //error_log($query);

        $result = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->title_wishlist=htmlspecialchars(strip_tags($this->title_wishlist));
        $this->number_of_items=htmlspecialchars(strip_tags($this->number_of_items));
        $this->id=htmlspecialchars(strip_tags($this->id));


        $result->bindParam(":user_id", $this->user_id);
        $result->bindParam(":title_wishlist", $this->title_wishlist);
        $result->bindParam(":number_of_items", $this->number_of_items);
        $result->bindParam(':id', $this->id);


        if($result->execute()){
            return true;
        }
        return false;
    }

    function delete(){

        error_log("Delete");

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        //error_log($query);

        $result = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $result->bindParam(1, $this->id);

        // execute query
        if($result->execute()){
            return true;
        }
        return false;
    }

}