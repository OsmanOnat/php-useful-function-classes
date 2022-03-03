<?php

/**
 * 
 * @author      osmanonat
 * @version     0.1
 * @since       21.02.2022
 * 
 */

include("header.php");

require_once("classes/db.class.php");
require_once("classes/front_functions/message.class.php");
require_once("classes/front_functions/front.class.php");

use DataBase\VeriTabani;
use Front_Functions\FrontFunctions;

$VeriTabani = new VeriTabani();


/**
 * 
 *                      MYSQL
 * 
 * table = deneme1
 * columns = id , isim , soyisim 
 * 
 * 
 * 
 */



/*$VeriTabani->insertIntoGetColumns('deneme1');

$VeriTabani->insert_into_deneme('deneme1',array(NULL,'İsim','Soyisim'));*/


/**
 * ü
 * orada aslında var ama yorum satırı yapmışsın. Ayrıca 
 * php default notificationları yerine
 * özelleştirilmiş hata sayfanı kodlayıp onu kullansan
 * daha anlamlı mesajlar yazsan
 * bu mesajları çok dilli yapıya uygun yapsan, sadece ingilizcesini
 * sen yazsan, insanlar da ilerde kendi dillerinde katkıda bulunurlar
 * laravelde olduğu gibi.
 *  mesela biraz önce hata kodu bastırımını pdo class ının kendi getirdiği şekilde
 * yaptırmışsın. Oysa onun yerine kendi hata bastırma fonksiyonunu yazsan
 * örneğin
 *  print_error('DB Table not found!', '404');
 * gibi bir fonksiyon yasan, header bilgisi olarak http status code 404 
 * gönderse harika olur. işin standardı da bu zaten.
 * 
 * Şöyle göstereyim.
 * 
*/


//print_r($VeriTabani->arrayEcho(array('osman','onat','1234')));

//$VeriTabani->pdo_table_control('denem');

//$VeriTabani->getWithIDValues('deneme1',100);

//$VeriTabani->getWithTableSingleColumnValue('deneme1','isim');

//$VeriTabani->getWithTableTotalRow('deneme1');

//$VeriTabani->arraydeneme(array('osman','onat','1234'));

//$VeriTabani->getWithTableFetchLimitedValue('deneme1','id',2,'DESC','isim');

//$VeriTabani->deleteWithID('deneme1',48);

//$VeriTabani->IDControl('deneme1','id',50);

//$VeriTabani->updateWithTableSingleColumnRow('deneme1',49,'isim','denemesdadsad1');

//$VeriTabani->columnControl('deneme1','isim');

//$VeriTabani->insert_into_deneme('deneme1',array('isim','soyisim'));

//$VeriTabani->getColumns('deneme1',array('id','isim'));

//$VeriTabani->insert_into_deneme('deneme1',array('isim','soyisim'),array('Ekle deneme 2 isim','ekle deneme 2 soyisim'));

//$VeriTabani->arrayEcho(array('osman','onat','omu'));

/*

// Front Class Deneme 

FrontFunctions::div_start('container mt-4');

FrontFunctions::div_start('row','','center');

FrontFunctions::div_start('col-md-12 text-center','','','background-color:beige;padding:5px;');

FrontFunctions::p_start('','','( ! ) UYARI','color:red;font-size:20px;font-weight:600;');

FrontFunctions::p_end();

FrontFunctions::p_start('','','FRONT CLASS DENEMESİ','color:red;font-size:20px;font-weight:600;');

FrontFunctions::p_end();

FrontFunctions::div_end();

FrontFunctions::div_end();

FrontFunctions::div_end();

FrontFunctions::br(1);

FrontFunctions::form_start('','','',$_SERVER['PHP_SELF'],'POST');
*/





include("footer.php");
?>