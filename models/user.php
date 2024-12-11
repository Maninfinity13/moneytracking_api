<?php
class User
{
    //ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $userId;
    public $userFullname;
    public $userBirthDate;
    public $userName;
    public $userPassword;
    public $userImage;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //คอนสตรักเตอร์ คือ เมธอดที่มีชื่อเดียวกับชื่อคลาส
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //--------------------------------------
    //ฟังก์ชันการทำงานที่ล้อกับส่วนของ apis

    //ฟังก์ชันตรวจสอบชื่อผู้ใช้รหัสผ่าน
    public function checkLogin()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM user_tb WHERE userName = :userName AND userPassword = :userPassword";

        //ตรวจสอบค่าที่ส่งมาจาก Client/User ก่อนที่จะกำหนดให้กับ parameter (:???????)
        $this->userName = htmlspecialchars(strip_tags($this->userName));
        $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter
        $stmt->bindParam(":userName", $this->userName);
        $stmt->bindParam(":userPassword", $this->userPassword);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลผู้ใช้ใหม่
    public function registerUser()
    {
        $strSQL = "INSERT INTO   user_tb 
            (`userFullname`, `userBirthDate`, `userName`, `userPassword`, `userImage`)
            VALUES
            (:userFullname, :userBirthDate, :userName, :userPassword, :userImage)";

        $this->userFullname = htmlspecialchars(strip_tags($this->userFullname));
        $this->userBirthDate = htmlspecialchars(strip_tags($this->userBirthDate));
        $this->userName = htmlspecialchars(strip_tags($this->userName));
        $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));
        $this->userImage = htmlspecialchars(strip_tags($this->userImage));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":userFullname", $this->userFullname);
        $stmt->bindParam(":userBirthDate", $this->userBirthDate);
        $stmt->bindParam(":userName", $this->userName);
        $stmt->bindParam(":userPassword", $this->userPassword);
        $stmt->bindParam(":userImage", $this->userImage);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
