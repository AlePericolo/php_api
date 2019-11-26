<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 11.44
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../model/Connection.php';
include_once '../model/Wishlist.php';

$connection = new Connection();
$conn = $connection->getConnection();

$whishlist = new Wishlist($conn);

$data = $whishlist->read();

$response = array();

if($data->rowCount() > 0){

    $response["data"] = array();

    while ($row = $data->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        //error_log(json_encode($row));

        $element = array(
                    "id" => intval($id),
                    "name" => html_entity_decode($name),
                    "title_wishlist" => html_entity_decode($title_wishlist),
                    "number_of_items" => intval($number_of_items)
                );

        array_push($response["data"], $element);
    }


    http_response_code(200);

    $response["status_code"] = 200;
    $response["status_text"] = "OK";

    echo json_encode($response);
}
else{

    http_response_code(404);

    $response["status_code"] = 404;
    $response["status_text"] = "K0";
    $response["message"] = "No wish found";

    echo json_encode($response);
}