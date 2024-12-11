<?php
class Money
{
    //ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $moneyId;
    public $moneyDetail;
    public $moneyDate;
    public $moneyInOut;
    public $moneyType;
    public $userId;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //คอนสตรักเตอร์
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //--------------------------------------
    //ฟังก์ชันการทำงานที่ล้อกับส่วนของ apis

    //ฟังก์ชันดึงข้อมูลตาม userId
    public function getMoneyDetailList()
    {
        $strSQL = "SELECT * FROM money_tb WHERE userId = :userId";

        $this->userId = intval(htmlspecialchars(strip_tags($this->userId)));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":userId", $this->userId);

        $stmt->execute();

        return $stmt;
    }

    //ฟังก์ชันเพิ่มรายงานเงินเข้า-ออก
    public function insertMoneyInOut()
    {
        $strSQL = "INSERT INTO  money_tb 
                    (`moneyDetail`, `moneyDate`,`moneyInOut`,`moneyType`,`userId`)
                VALUES
                    (:moneyDetail,:moneyDate,:moneyInOut,:moneyType, :userId)";

        $this->moneyDetail = htmlspecialchars(strip_tags($this->moneyDetail));
        $this->moneyDate = htmlspecialchars(strip_tags($this->moneyDate));
        $this->moneyInOut = doubleval(htmlspecialchars(strip_tags($this->moneyInOut)));
        $this->moneyType = intval(htmlspecialchars(strip_tags($this->moneyType)));
        $this->userId = intval(htmlspecialchars(strip_tags($this->userId)));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":moneyDetail", $this->moneyDetail);
        $stmt->bindParam(":moneyDate", $this->moneyDate);
        $stmt->bindParam(":moneyInOut", $this->moneyInOut);
        $stmt->bindParam(":moneyType", $this->moneyType);
        $stmt->bindParam(":userId", $this->userId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
