<?php

/**
 * 
 * @author      osmanonat
 * @version     0.1
 * @since       21.02.2022
 * 
 */

/**
 * 
 * Eğer \ işaretini kaldırırsan hata alırsın hata çözümü 
 * Link : https://stackoverflow.com/questions/34535866/undefined-property-pdo-exception-erros
 * 
 * Çözüm : 
 * Çünkü, SİZİN uygulama sınıfı ad alanında \böyle bir sınıf olmadığı için PDO'yu esas olarak a ile adreslemeniz gerekir PDO. 
 * Bunun yaptığı, bulunduğu PDOyer olan \ad alanındaki sınıfı aramaktır. Şimdi böyle bir şey yapmalısın:
 *  $stmt->bindParam(':username', $username, \PDO::PARAM_INT);
 *  Bunu tekrar tekrar yapmak zorunda kalmamak için şunları yapabilirsiniz:
 *  use PDO;anahtar kelimeyi tanımladıktan sonra namespaceve önce class.
 * 
 * / işareti ile global bir sınıf olduğunu ifade ettik .
 * 
 */


namespace DataBase;

require_once("message.class.php");

use Messages\Message;
use PDO;

class VeriTabani extends Message //başka sınıfı kullanmak için miras aldık. parent::  ile miras aldığımız sınıftan metot çekebiliriz.
{

    /**
     * 
     * @param private $HOST         Host girin
     * @param private $DB_NAME      Veritabanı İsmi Girin
     * @param private $DB_USER      Veritabanı kullanıcı ismi girin
     * @param private $DB_PASSWORD  Veritabanı şifresi girin
     * @param private $CONNECTION   Veritabanı bağlantı değişkeni 
     * 
     * @param private $islem        Fonksiyonlarda veritabanı işlemleri için özel değişken
     * @param private $sonuc        Fonksiyonlarda veritabanı işlemleri fetch işlemleri için özel değişken 
     * 
     */

    private $HOST = "localhost";
    private $DB_NAME = "classesDB"; // veri tabanı ismini gir!
    private $DB_USER = "root";
    private $DB_PASSWORD = "";
    private $CONNECTION;

    private $islem; //execute
    private $sonuc; //fetch(PDO::FETCH_ASSOC)

    private static $issetTable;

    /**
     * 
     * 
     * __CONCTRUCT METOTU OTOMATİK OLARAK VERİTABANIN BAĞLAR.
     * 
     * 
     */

    public function __construct()
    {


        try {
            $this->CONNECTION = new PDO(
                'mysql:host=' . $this->HOST . ';dbname=' . $this->DB_NAME . ';',
                $this->DB_USER,
                $this->DB_PASSWORD,
            );
            $this->CONNECTION->exec('set name utf8');
            $this->CONNECTION->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            /*if(isset($this->CONNECTION)){
                echo 'Bağlantı Sağlandı!';
            }*/
        } catch (\PDOException $e) {
            error_reporting(0);
            echo $this->pdo_database_connect_error($e->getMessage());
        }
    }


    public function queryRowList($query)
    {
        return $this->CONNECTION->query($query)->fetchAll(PDO::FETCH_ASSOC); // verileri getirmesi için return kullandık!
    }

    public function queryRow($query)
    {
        return $this->CONNECTION->query($query)->fetch(PDO::FETCH_ASSOC); // verileri getirmesi için return kullandık!
    }

    public function dataAdd($sql, $veri = null)
    {
        if (isset($veri)) {
            echo "Veri Eklendi!";
            $this->CONNECTION->prepare($sql)->execute($veri);
        } else {
            echo "Herhangi bir veri girmediniz!";
            exit();
        }
    }

    public function dataDelete($sql, $id = null)
    {

        if (isset($id)) {
            $this->CONNECTION->prepare($sql)->execute(array($id));
            echo $id . " değeri silindi!";
        } else {
            echo "Silme işlemi başarısız!";
            exit();
        }
    }

    public function methodControl($method)
    {

        switch ($method) {
            case 'POST':
                echo '$_POST geliyor';
                break;
            case 'GET':
                break;
            default:
                echo "Method Yok!";
                break;
        }

        /*$args = func_get_args();

        foreach($args as $a){
            if(isset($_GET)){
                echo 'Method GET';
            }
            elseif(isset($_POST)){
                echo 'Method Post';
            }
            else{
                echo 'Girilen değer bir method değil';
            }

           
        }*/
    }

    /*public function connect(){

        try{
            $this->CONNECTION = new PDO(
                'mysql:host='.$this->HOST.';dbname='.$this->DB_NAME.';',
                $this->DB_USER,
                $this->DB_PASSWORD,
            );
            $this->CONNECTION->exec('set name utf8');
            $this->CONNECTION->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }
        catch(\PDOException $e){
            echo 'VERİ TABANI BAĞLANTI HATASI <br />';
            echo $e->getMessage();
        }

    }*/
}
