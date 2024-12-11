<?php
class ConnectDB{
    //ตัวแปรหลักที่จะใช้ติดต่อกับ DB
    public $connDB;
 
    //ตัวแปรที่ใช้เก็บข้อมูลของ DB ที่จะทำงานด้วย
    private $host = "localhost";    //ชื่อเครื่อง Server หรือ 127.0.0.1, IP Address, Domain Name
    private $username = "root";     //ชื่อผู้ใช้งานฐานข้อมูล
    private $password = "";         //รหัสผ่านผู้ใช้งานฐานข้อมูล
    private $dbname = "money_tracking_db";    //ชื่อฐานข้อมูล

    //ฟังก์ชันที่ใช้ติดต่อกับฐานข้อมูล
    public function getConnectionDB(){
        $this->connDB = null;

        try{
            $this->connDB = new PDO("mysql:host={$this->host};dbname={$this->dbname}",$this->username,$this->password);

            $this->connDB->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->connDB;
    }
}
?>