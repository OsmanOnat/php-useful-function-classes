<?php

/**
 * 
 * @author      osmanonat
 * @version     0.1
 * @since       21.02.2022
 * 
 * BURASI KENDİ YAZDIĞIM HATA MESAJLARI KISMIDIR.
 * 
 */

namespace Messages;

require_once('front.class.php');

use Front_Functions\FrontFunctions;

class Message
{

    public function __construct()
    {
    }

    public static function pdo_table_error_message()
    {

        FrontFunctions::div_start('container mt-4');

        FrontFunctions::div_start('row', '', 'center');

        FrontFunctions::div_start('col-md-12 text-center', '', '', 'background-color:beige;padding:5px;');

        FrontFunctions::p_start('', '', '( ! ) HATA', 'color:red;font-size:20px;font-weight:600;');

        FrontFunctions::p_end();

        FrontFunctions::p_start('', '', 'Böyle Bir Tablo Yok veya Tablo İsmi Hatalı', 'color:red;font-size:20px;font-weight:600;');

        FrontFunctions::p_end();

        FrontFunctions::div_end();

        FrontFunctions::div_end();

        FrontFunctions::div_end();
    }

    /**
     * 
     * @param string $method        POST veya GET methodları girilmeli
     * 
     */

    public static function method_name_error(string $method = ''){
        FrontFunctions::div_start('container mt-4');

        FrontFunctions::div_start('row', '', 'center');

        FrontFunctions::div_start('col-md-12 text-center', '', '', 'background-color:beige;padding:5px;');

        FrontFunctions::p_start('', '', '( ! ) HATA', 'color:red;font-size:20px;font-weight:600;');

        FrontFunctions::p_end();

        FrontFunctions::p_start('', '', 'Method İsmi Hatalı Girdiğiniz değer : '.$method.'', 'color:red;font-size:20px;font-weight:600;');

        FrontFunctions::p_end();

        FrontFunctions::div_end();

        FrontFunctions::div_end();

        FrontFunctions::div_end();
    }

    /**
     * 
     * @param string $column    Tabloda var olan sütun ismi girin
     * 
     */

    public static function pdo_wrong_column_name(string $table,string $column)
    {
        echo '
        <div class="container mt-4">
        <div class="row" align="center">
            <div class="col-md-12 text-center" style="background-color:beige;padding:5px;">
                <p style="color:red;font-size:25px;font-weight:700;">
                ( ! ) VeriTabanı Tablo Sütun İsmi Hatası
                </p>
                <p style=
                "   color: red ;
                    font-size:20px;
                    font-weight:600;
                ">
                <span style="color:darkred;font-weight:800;"> ' . $table . ' </span> Tablosunda 
                <span style="color:darkred;font-weight:800;"> ' . $column . ' </span> adında bir sütun ismi yok!
                <br />
                Lütfen sütun ismini kontrol ediniz!
                </p>
            </div>
        </div>
    </div>
        ';
    }

    /**
     * 
     *  @param string $value    Bir değer girilebilir (kullanımına göre değişkenlik gösterebilir)
     *  @param string $table    Veritabanında varolan bir tablo ismi girin
     * 
     */

    public static function pdo_id_not_found(string $value, string $table)
    {
        echo '
        <div class="container mt-4">
        <div class="row" align="center">
            <div class="col-md-12 text-center" style="background-color:beige;padding:5px;">
                <p style="color:red;font-size:25px;font-weight:700;">
                ( ! ) Uyarı
                </p>
                <p style=
                "   color: red ;
                    font-size:20px;
                    font-weight:600;
                ">
                <span style="color:darkred;font-weight:800;">' . $table . ' </span>
                tablosunda ID = 
                <span style="color:darkred;font-weight:800;"> ' . $value . ' </span> değeri bulunmuyor !
                <br />
                Lütfen <span style="color:darkred;font-weight:800;">ID  , Tablo İsmi VE Sütun Ismini</span> kontrol ediniz!
                </p>
            </div>
        </div>
    </div>
        ';
    }

    /**
     * 
     * 
     * 
     */

    public static function pdo_empty_or_false_value()
    {
        echo '
        <div class="container mt-4">
        <div class="row" align="center">
            <div class="col-md-12 text-center" style="background-color:beige;padding:5px;">
                <p style="color:red;font-size:25px;font-weight:700;">
                ( ! ) UYARI
                </p>
                <p style=
                "   color: red ;
                    font-size:20px;
                    font-weight:600;
                ">
                Boş Değer veya False Dönüyor !
                <br />
                Lütfen <span style="color:darkred;font-weight:800;"> var_dump() </span> fonksiyonu ile kontrol ediniz!
                </p>
            </div>
        </div>
    </div>
        ';
    }

    /**
     * 
     * @param string $errorMessage      Bir hata mesajı girin
     * 
     */

    public static function pdo_database_connect_error(string $errorMessage = '')
    {
        echo '
        <div class="container mt-4">
        <div class="row" align="center">
            <div class="col-md-12 text-center" style="background-color:beige;padding:5px;">
                <p style="color:red;font-size:25px;font-weight:700;">
                ( ! ) HATA
                </p>
                <p style=
                "   color: red ;
                    font-size:20px;
                    font-weight:600;
                ">
                Veri Tabanı Bağlantısı Yok !
                </p>
                <br />
                <p class="text-center">
                    <span style="color:darkred;font-size:18px;font-weight:700;">
                    Hata Mesajı
                    </span>
                    <br />
                    ' . $errorMessage . '
                </p>
            </div>
        </div>
    </div>
        ';
    }

    /**
     * 
     * 
     * 
     */

    

}
