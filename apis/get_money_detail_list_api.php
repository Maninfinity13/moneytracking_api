<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");  //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/money.php";

$connDB = new ConnectDB();
$money = new Money($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$money->userId = $data->userId;

$result = $money->getMoneyDetailList();

if ($result->rowCount() > 0) {
    //มี
    $resultInfo = array();

    //แตกข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);

        //สร้างตัวแปรเป็นอาเรย์เก็บข้อมูล 
        $resultArray = array(
            "message" => "1",
            "moneyId" => strval($moneyId),
            "moneyDetail" => $moneyDetail,
            "moneyDate" => $moneyDate,
            "moneyInOut" => strval($moneyInOut),
            "moneyType" => strval($moneyType),
            "userId" => strval($userId)
        );

        array_push($resultInfo, $resultArray);
    }

    echo json_encode($resultInfo, JSON_UNESCAPED_UNICODE);
} else {
    //ไม่มี
    $resultInfo = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultInfo, $resultArray);
    echo json_encode($resultInfo);
}
