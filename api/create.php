<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 12.44
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

$response = array();

if(
    !empty($data->user_id) &&
    !empty($data->title_wishlist) &&
    !empty($data->number_of_items)
){

    $whishlist->user_id = $data->user_id;
    $whishlist->title_wishlist = $data->title_wishlist;
    $whishlist->number_of_items = $data->number_of_items;


    // create the product
    if($whishlist->create()){

        http_response_code(201);

        $response["status_code"] = 201;
        $response["status_text"] = "OK";
        $response["message"] = "Wish created";

        echo json_encode($response);
    }

    else{

        http_response_code(503);

        $response["status_code"] = 503;
        $response["status_text"] = "K0";
        $response["message"] = "Unable to create wish";

        echo json_encode($response);
    }
}

else{

    http_response_code(400);

    $response["status_code"] = 404;
    $response["status_text"] = "K0";
    $response["message"] = "Data not complete";

    echo json_encode($response);
}