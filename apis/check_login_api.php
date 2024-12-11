<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/user.php";

//สร้าง instance (object/ตัวแทน) 
$connDB = new ConnectDB();
$user = new User($connDB->getConnectionDB());

//รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มาทำการ Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

//เอาค่าในตัวแปรกำหนดให้กับ ตัวแปรของ Model ที่สร้างไว้
$user->userName = $data->userName;
$user->userPassword = $data->userPassword;

//เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $user->checkLogin();

//ตรวจสอบข้อมูลจาการการเรียกฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result->rowCount() > 0) {
    //แตกข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);

    //สร้างตัวแปรเป็นอาเรย์เก็บข้อมูล 
    $resultArray = array(
        "message" => "1",
        "userId" => strval($userId),
        "userFullname" => $userFullname,
        "userBirthDate" => $userBirthDate,
        "userName" => $userName,
        "userPassword" => $userPassword,
        "userImage" => $userImage
    );

    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
