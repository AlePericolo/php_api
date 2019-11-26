<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 17.06
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../model/Connection.php';
include_once '../model/Wishlist.php';

$connection = new Connection();
$conn = $connection->getConnection();

$whishlist = new Wishlist($conn);

//set id from url
$whishlist->id = isset($_GET['id']) ? $_GET['id'] : die();

$whishlist->readOne();

$response = array();

if($whishlist->name!=null){

    $response["data"] = array();

    $element = array(
        "id" => $whishlist->id,
        "name" => $whishlist->name,
        "title_wishlist" => $whishlist->title_wishlist,
        "number_of_items" => $whishlist->number_of_items
    );

    array_push($response["data"], $element);

    http_response_code(200);

    $response["status_code"] = 200;
    $response["status_text"] = "OK";

    echo json_encode($response);
}

else{

    http_response_code(404);

    $response["status_code"] = 404;
    $response["status_text"] = "K0";
    $response["message"] = "Wish does not exist";

    echo json_encode($response);
}