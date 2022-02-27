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


    public function arrayEcho(array $value){
        foreach($value as $v){
            return $v; //SORGU İÇİNE YAZMASI İÇİN return KULLANDIK.
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
            Message::pdo_wrong_column_name($table,$column);
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

    /**
     * Varolan bir tabloda sütun ismini kontrol eder . 
     * 
     * @param string $table         Varolan bir tablo ismi girin
     * @param string $columnName    Tablodan var olan bir sütun ismi girin.
     * 
     */

    public function columnControl(string $table , string $columnName){
        
        trim($table);
        trim($columnName);

        $this->islem = $this->CONNECTION->prepare(
            'DESCRIBE '.$table.''
        );
        $this->islem->execute();
        $this->sonuc = $this->islem->fetchAll();

        foreach($this->sonuc as $s){
            $yenidizi[] = $s['Field'];
        }

        if(in_array($columnName,$yenidizi)){
            //echo $columnName .' değeri var';
            return true;
        }
        else{
            //echo 'değer yok';
            Message::pdo_wrong_column_name($table,$columnName);
        }

        /*echo '<br />';
        echo '<pre>';
        print_r($this->sonuc);
        */
    }

    /**
     * Tabloda olan sütun isimlerini arasına virgül koyarak yazar . 
     * Amacı : INSERT INTO işlemlerinde kullanmak için .
     * 
     * @param string $table         Varolan bir tablo ismi gir.
     * @param array $columns        Tabloda varolan array olarak gir.
     */

    public function insertIntoGetColumns(string $table , array $columns){


            $this->islem = $this->CONNECTION->prepare(
                'DESCRIBE '.$table.''
            );
            $this->islem->execute();
            $this->sonuc = $this->islem->fetchAll(PDO::FETCH_COLUMN);

            $newArray = [];

            for ($i = 0; $i < count($this->sonuc); $i++) {

                for ($j = 0; $j < count($columns); $j++) {

                    if ($this->sonuc[$i] == $columns[$j]) {
                        //echo '' . $this->sonuc[$i] . ' = ' . $columns[$j] . '<br />';
                        array_push($newArray,$this->sonuc[$i]); //burada zaten ikiside birbirine eşitse herhangi bir tanesini yeni diziye aktar.
                    }
                    
                }

            }

            
            $sondizi = [];

            for($i = 0; $i<count($newArray); $i++){
                if($i == count($newArray) - 1) {
                    array_push($sondizi,''.$newArray[$i].' = ? '); //SORGU İÇİNE YAZMASI İÇİN return KULLANDIK.
                }
                else{
                   array_push($sondizi,''.$newArray[$i].' = ? , '); //SORGU İÇİNE YAZMASI İÇİN return KULLANDIK.
                }
                
            }

            var_dump($sondizi);

            foreach($sondizi as $s){
                echo $s;
            }
            
            echo '<br /><br />';
            echo '
                <strong>
                    $sondizi dizisindeki son elemanı sql sorgusunda return yapmıyor . 
                </strong>
            ';
            echo '<br /><br />';

            foreach($sondizi as $s){
                return $s;
            }
            


            /*for($i = 0; $i<$column_count; $i++){
                if($i == $column_count - 1){ //sona virgül koymasın .
                    return $newArray[$i]; //SORGU İÇİNE YAZMASI İÇİN return KULLANDIK.
                }else{
                    return ' '.$newArray[$i].' , '; //SORGU İÇİNE YAZMASI İÇİN return KULLANDIK.
                }
            }*/

            /*for($i = 0; $i<$column_count; $i++){
                if($i == $column_count - 1){ //son sütuna virgül koymasın .
                    $yenidizi[] = $this->sonuc[$i];
                }else{
                    $yenidizi[] =  $this->sonuc[$i].' ,';
                }
            }*/

        
    }

    

    public function insert_into_deneme(string $table, array $columns , array $values){


        if($this->pdo_table_control($table) == true){

            $this->islem = $this->CONNECTION->prepare(
                'INSERT INTO '.$table.' SET '.$this->insertIntoGetColumns($table,$columns).''
            );
            /*$this->islem->execute(
                array(
                    $this->arrayEcho($values)
                ),
            );

            if($this->islem){
                echo 'işlem tamam';
            }
            else{
                echo 'bir hata var';
            }*/
            
            var_dump($this->islem);
        }
        else{
            Message::pdo_table_error_message($table);
        }

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
            Message::pdo_table_error_message($table);
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
            Message::pdo_table_error_message($table); 
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
            Message::pdo_table_error_message($table);
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
            Message::pdo_table_error_message($table);
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
            Message::pdo_table_error_message($table);
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
            Message::pdo_table_error_message($table);
        }

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
