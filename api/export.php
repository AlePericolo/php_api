<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 27/11/19
 * Time: 10.55
 */

include_once '../model/Connection.php';
include_once '../model/Wishlist.php';

$connection = new Connection();
$conn = $connection->getConnection();

$whishlist = new Wishlist($conn);

$data = $whishlist->read();

$response = array();

if($data->rowCount() > 0) {

    download_headers();

    $rows = $data->fetchAll(PDO::FETCH_ASSOC);

    //Get the column names (csv header).
    $columnNames = array();
    if (!empty($rows)) {
        $firstRow = $rows[0];
        foreach ($firstRow as $colName => $val) {
            $columnNames[] = $colName;
        }
    }

    $fp = fopen('php://output', 'w');

    fputcsv($fp, $columnNames);

    foreach ($rows as $row) {
        fputcsv($fp, $row);
    }

    fclose($fp);

    http_response_code(200);

}
else{
    
    http_response_code(404);

    $response["status_code"] = 404;
    $response["status_text"] = "K0";
    $response["message"] = "No wish found";

    echo json_encode($response);
}


function download_headers()
{
    $now = gmdate("D, d M Y H:i:s");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    $filename = "export_" . date("Y-m-d") . ".csv";
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}