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

require_once("front_functions/message.class.php");

use Messages\Message;
use PDO;

class VeriTabani //parent::  ile miras aldığımız sınıftan metot çekebiliriz.
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
            Message::pdo_database_connect_error($e->getMessage());
        }
    }


    
    /**
     * 
     * BURADA VERİTABANINDA VAR OLAN TABLOLARI KONTROL ETMEK İÇİN YAZILMIŞTIR
     * 
     * @param string $table     Varolan bir tablo ismi giriniz
     * 
     */

    public function pdo_table_control(string $table){

        $s = $this->CONNECTION->query('SHOW TABLES');
        $t = $s->fetchAll();

        foreach($t as $tt){
            //echo $tt['Tables_in_classesdb']; //veritabanında olan tabloları yazdırdık.

            if($tt['Tables_in_'.mb_strtolower($this->DB_NAME).''] == $table){
                //echo 'tablo bulundu!';
                return true;
            }else{
                //echo 'tablo bulunamadı!';
                //Message::pdo_table_error_message(); //diğer fonksiyonlarda else bloğuna bunu yazınca iki defa yazıyor o yüzden yorum satırında
            }
        }
        
    }

    /**
     * 
     * TABLODA VAR OLAN ID SÜTUNUNU KONTROL ETMEK İÇİN YAZILMIŞTIR.
     * 
     * @param string $table     Varolan bir tablo ismi giriniz
     * @param string $column    ID ismini girin (id) (ZORUNLU)
     * @param int    $id        Var olan bir ID değeri girin
     * 
     */

    public function IDControl(string $table, string $column = 'id', int $id){
        
        if($column != 'id'){
            echo '
            <p class="text-center" style="background-color:beige;padding:5px;color:red;font-size:25px;font-weight:700;">
                Sütun ismi id olmak zorunda
            </p>
            ';
            Message::pdo_wrong_column_name($column);
        }else{

            //echo 'id isminde sütun ismi bulundu!';

            $id_control = $this->CONNECTION->prepare(
                'SELECT '.$column.' FROM '.$table.''
            );
            $id_control->execute();
    
            $sonuc = $id_control->fetchAll(PDO::FETCH_COLUMN);
    
            $yenidizi = [];
    
            for($i = 0; $i < count($sonuc); $i++){
                $donustur = intval($sonuc[$i]);
                array_push($yenidizi,$donustur);
            }
    
            if(in_array($id,$yenidizi)){
                //echo $table . ' tablosunda '.$id.' id değeri var';
                return true;
            }else{
                Message::pdo_id_not_found($id,$table);
            }

        }

        

        /*for($i = 0;$i<count($sonuc);$i++){
            echo $sonuc[0][$i];
        }*/

    }


    public function arraydeneme($dizi = [])
    {

        $dizi2 = array(
            'osman', 'onat', '1234'
        );

        $artiklar = [];

        echo 'Dizi 1 değeri  -  Dizi 2 değeri <br />';
        for ($i = 0; $i < count($dizi); $i++) {
            for ($j = 0; $j < count($dizi2); $j++) {
                if ($dizi[$i] == $dizi2[$j]) {
                    echo '' . $dizi[$i] . ' = ' . $dizi2[$j] . '<br />';
                    array_push($artiklar, array($dizi[$i], $dizi2[$j]));
                }
            }
        }

        var_dump($artiklar);


        /*foreach($dizi as $dk => $dv){
            echo '
                <p>
                    '.$dk.'  -  '.$dv.'
                </p>
            ';
        }*/
    }


    /**
     * 
     * BİR TABLODA VAR OLAN TOPLAM SATIR SAYISINI BULMAK İÇİN YAZILDI.
     * 
     * @param string $table     Varolan bir tablo ismi giriniz
     * 
     */

    public function getWithTableTotalRow(string $table = '')
    {

        if($this->pdo_table_control($table)){
            $this->islem = $this->CONNECTION->prepare(
                'SELECT COUNT(*) FROM ' . $table . ''
            );
            $this->islem->execute();
            $this->sonuc = $this->islem->fetchColumn();
    
            if (isset($this->sonuc)) {
                echo $table . ' tablosundaki satır sayısı = ' . $this->sonuc;
            } else {
                echo 'hata var getwithtabletotalrow function';
                die();
            }
        }
        else{
            Message::pdo_table_error_message();
        }

        
    }

    /**
     * 
     * 
     * BİR TABLODA BELİRLİ BİR ID GİREREK O ID'YE BAĞLI VERİLERİ GETİRMEK İÇİN YAZILDI
     * 
     * @param string $table     Varolan bir tablo ismi giriniz
     * @param int  $id          Varolan bir id değeri girin
     * 
     */

    public function getWithIDValues(string $table = '', int $id = 1)
    {

        if ($this->pdo_table_control($table) == TRUE) {

            if($this->IDControl($table,"id",$id) == true){

                $this->islem = $this->CONNECTION->prepare(
                    'SELECT * FROM ' . $table . ' WHERE id = :id '
                );
                $this->islem->bindParam(
                    ':id',$id , PDO::PARAM_INT
                );
                $this->islem->execute();
                $this->sonuc = $this->islem->fetchAll(PDO::FETCH_ASSOC);
    
                $data = json_encode($this->sonuc,JSON_PRETTY_PRINT);
                
                echo '<pre>';
                print $data;
    
                /*echo '<pre>';
                var_dump($data);*/
            }
            else{
                return false;
            }

        } else {
            //error_reporting(0); // kendi yazıdığım hata mesajını göstermek için php hata mesajlarını kapattım. .
            Message::pdo_table_error_message(); //miras aldığımız için diğer sınıftaki metodu extends ile çağırdık.
        }
    }

    /**
     * 
     * 
     * BİR TABLODA BELİRLİ BİR ID'YE BAĞLI OLAN VERİYİ SİLMEK İÇİN YAZILDI
     * 
     * @param string $table     Varolan bir tablo ismi giriniz
     * @param int $id           Varolan bir id değeri giriniz
     * 
     */

    public function deleteWithID(string $table , int $id = 0){
        if($this->pdo_table_control($table) == true){

            if($this->IDControl($table,'id',$id)){
                $this->islem = $this->CONNECTION->prepare(
                    'DELETE FROM '.$table.' WHERE id = :id'
                );
                $this->islem->bindParam(
                    ':id',$id , PDO::PARAM_INT
                );
                $this->islem->execute();
    
                if($this->islem){
                    echo $table.' tablosundaki '.$id.' değeri silindi!'; 
    
                    //var_dump($this->islem);
                }
            }else{
                Message::pdo_id_not_found($id,$table);
            }

        }else{
            Message::pdo_table_error_message();
        }
    }

    /**
     * 
     * 
     * BİR TABLODAN BELİRLİ BİR SÜTUN İSMİ GİRİLEREK SADECE O SÜTUNA AİT VERİLERİ SIRALAR.
     * 
     * @param string $table         Varolan bir tablo ismi giriniz
     * @param string $columnName    Tabloda varolan bir sütun ismi giriniz
     * 
     */

    public function getWithTableSingleColumnValue(string $table = '', string $columnName = '')
    {

        if($this->pdo_table_control($table)){
            $this->islem = $this->CONNECTION->prepare(
                'SELECT * FROM ' . $table . ' '
            );
            $this->islem->execute();
            $this->sonuc = $this->islem->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($this->sonuc as $sonucValue) {
                echo '
                    <p>
                        ' . $sonucValue[''.$columnName.''] . '
                    </p>
                ';
            }
        }
        else{
            //echo 'tablo bulunamadı!';
            Message::pdo_table_error_message();
        }
        
    }

    /**
     * 
     * 
     * BİR TABLODAN BELİRLİ BİR ID'YE AİT OLAN SÜTUN İSMİ , LİMİT , ASC VEYA DESC GİRİLEREK O İD'YE BAĞLI VERİLERİ LİMİTLİ OLARAK EKRANA BASAR.
     * 
     * @param string $table         Varolan bir tablo ismi giriniz
     * @param string $column        ID ismini girin (id) (ZORUNLU)
     * @param string $limit         Limit sayıyı girin
     * @param string $keyword       ASC veya DESC anahtar kelimesini girin
     * @param string $dataColumn    Tabloda varolan bir sütun ismi girin
     * 
     */

    public function getWithTableFetchLimitedValue(string $table = '', string $column = 'id' ,string $limit = '5', string $keyword = 'DESC' , string $dataColumn)
    {
        if ($this->pdo_table_control($table) == TRUE) {
            if ($keyword == 'DESC' or $keyword == 'ASC') {
                $this->islem = $this->CONNECTION->prepare(
                    'SELECT * FROM  ' . $table . ' ORDER BY '.$column.' ' . $keyword . ' LIMIT ' . $limit . ''
                );
                //print_r($this->islem);
                $this->islem->execute();
                $this->sonuc = $this->islem->fetchAll(PDO::FETCH_ASSOC);

                foreach ($this->sonuc as $sonucValue) {
                    echo'
                      <p>
                        ' . $sonucValue[''.$dataColumn.''] . '
                      </p> 
                    ';
                }
            }
            else{
                echo 'asc veya desc kullan';
            }
        } else {
            Message::pdo_table_error_message();
        }
    }

    /**
     * 
     * TABLODA BELİRTİLEN BİR ID İLE BELİRTİLEN BİR SÜTUN İSMİ GİRİLEREK O ID VE SÜTUNA AİT VERİYİ GÜNCELLER
     * 
     * @param string $table         Varolan bir tablo ismi giriniz
     * @param int $id               Bir ID değeri giriniz
     * @param string $column        Tabloda varolan bir sütun ismi gir
     * @param $text                 Güncellemek istediğiniz bir değer girin (string veya int)
     * 
     */

    public function updateWithTableSingleColumnRow(string $table,int $id , string $column , $text){

        if($this->pdo_table_control($table)){

            if($this->IDControl($table,'id',$id)){

                $this->islem = $this->CONNECTION->prepare(
                    'UPDATE '.$table.' SET '.$column.' = :text WHERE id = :id '
                );
                $this->islem->bindParam(':id',$id , PDO::PARAM_INT);
                $this->islem->bindParam(':text',$text);

                $this->islem->execute();

                if($this->islem){
                    //echo 'işlem tamam!'; 

                }else{
                    //echo 'update error';

                }

            }else{
                Message::pdo_id_not_found($id,$table);
            }

        }else{
            Message::pdo_table_error_message();
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
