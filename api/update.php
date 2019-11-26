<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 18.06
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../model/Connection.php';
include_once '../model/Wishlist.php';

$connection = new Connection();
$conn = $connection->getConnection();

$whishlist = new Wishlist($conn);

$data = json_decode(file_get_contents("php://input"));

$whishlist->id = $data->id;

$whishlist->user_id = $data->user_id;
$whishlist->title_wishlist = $data->title_wishlist;
$whishlist->number_of_items = $data->number_of_items;

$response = array();

if($whishlist->update()){

    http_response_code(200);

    $response["status_code"] = 200;
    $response["status_text"] = "OK";
    $response["message"] = "Wish updated";

    echo json_encode($response);
}

else{

    http_response_code(503);

    $response["status_code"] = 503;
    $response["status_text"] = "K0";
    $response["message"] = "Unable to update wish";

    echo json_encode($response);
}