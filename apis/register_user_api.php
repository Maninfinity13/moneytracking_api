<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");  //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/user.php";

$connDB = new ConnectDB();
$user = new User($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$user->userFullname = $data->userFullname;
$user->userBirthDate = $data->userBirthDate;
$user->userName = $data->userName;
$user->userPassword = $data->userPassword;

//---------- จัดการเรื่องการ อัปโหลดรูป ในที่นี้เราใช้ Base64 --------------------------
//เอารูปที่ส่งมาซึ่งเป็น base64 เก็บไว้ในตัวแปรตัวหนึ่ง
$picture_temp = $data->userImage;
//ตั้งชื่อรูปใหม่เพื่อใช้กับรูปที่เป็น base64 ที่ส่งมา
$picture_filename = "user_" . uniqid() . "_" . round(microtime(true) * 1000) . ".jpg";
//เอารูปที่ส่งมาซึ่งเป็น base64 แปลงให้เป็นรูปภาพ แล้วเอาไปไว้ที่ picupload/userImage/
//file_put_contents( ที่อยู่ของไฟล์+ชื่อไฟล์ , ตัวไฟล์ที่จะอัปโหลดไปไว้)
file_put_contents("./../picupload/userImage/" . $picture_filename, base64_decode($picture_temp));
//เอาชื่อไฟล์ไปกำหนดให้กับตัวแปรที่จะเก็บลงตารางในฐานข้อมูล
$user->userImage = $picture_filename;
//---------------------------------------------------------------

$result = $user->registerUser();

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
