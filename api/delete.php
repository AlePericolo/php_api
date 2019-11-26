<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 18.22
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

if($whishlist->delete()){

    http_response_code(200);

    $response["status_code"] = 200;
    $response["status_text"] = "OK";
    $response["message"] = "Wish deleted";

    echo json_encode($response);
}
else{

    $response["status_code"] = 503;
    $response["status_text"] = "K0";
    $response["message"] = "Unable to delete wish";

    echo json_encode($response);
}