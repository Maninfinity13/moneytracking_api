<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");  //GET, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/money.php";

$connDB = new ConnectDB();
$money = new Money($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

//นำข้อมูลที่ส่งมาจากฝั่ง Client/User กำหนดให้กับตัวแปรที่จะเก็บลงตารางในฐานข้อมูล
$money->moneyDetail = $data->moneyDetail;
$money->moneyDate = $data->moneyDate;
$money->moneyInOut = $data->moneyInOut;
$money->moneyType = $data->moneyType;
$money->userId = $data->userId;

$result = $money->insertMoneyInOut();

if ($result == true) {
    //insert-update-delete สําเร็จ
    $resultArray = array(
        "message" => "1"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    //insert-update-delete ไม่สําเร็จ
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
