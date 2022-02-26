<?php

/**
 * @author      osmanonat
 * @version     0.1
 * @since       21.02.2022
 * 
 * 
 * Burası javascript ile entegre edilip bir editör yardımıyla sadece butonlara tıklanarak,
 *  burada yazılan fonksiyonlar çalıştırılıp güzel bir proje yapılabilir.
 * 
 */


namespace Front_Functions;

use Messages\Message;

require_once('message.class.php');

class FrontFunctions{


    /**
     *      PARAMS  
     * @param string $className         HTML div için bir sınıf ismi gir
     * @param $id                       HTML id için bir id ismi veya integer bir değer gir
     * @param string $align             Pozisyon belirle (center)
     * @param string $style             CSS özellik ekle
     * @param int $counter              Artış miktarı
     */

    public static function br(int $counter = 1){
        if($counter <= 0){
            echo __FUNCTION__ .'() fonksiyonundaki counter değeri 0 ve negatif girilemez';
        }else{
            for($i = 0; $i < $counter; $i++){
                echo '
                    <br />
                ';
            }
        }
    }

    public static function div_start(string $className = '',$id = '',string $align = '',string $style = ''){
        echo '
        <div class="'.$className.'" id="'.$id.'" align="'.$align.' "style="'.$style.'">
        ';
    }

    public static function div_end(){
        echo '
            </div>
        ';
    }

    public static function header_start(){
        echo '
            <header>
        ';
    }

    public static function header_end(){
        echo '
            </header>
        ';
    }

    public static function footer_start(){
        echo '
            <footer>
        ';
    }

    public static function footer_end(){
        echo '
            </footer>
        ';
    }

    public static function p_start(string $className = '',$id = '' , string $text , string $style = ''){
        echo '
            <p class="'.$className.'" id="'.$id.' "style="'.$style.'">

            '.$text.'

        ';
    }

    public static function p_end(){
        echo '
            </p>
        ';
    }

    public static function section_start(string $className = '',$id = '' , string $text , string $style = ''){
        echo '
            <section class="'.$className.'" id="'.$id.' "style="'.$style.'">
        ';
    }

    public static function section_end(){
        echo '
            </section>
        ';
    }

    public static function form_start(string $className = '',$id = '' , string $style = '' ,string $action = '' , string  $method = ''){

        switch(mb_strtolower($method)){
            case 'post':
                //echo 'post geliyor';
                echo '
                    <form action="'.$action.'" method="'.$method.'"  class="'.$className.'" id="'.$id.' "style="'.$style.'">
                ';
                break;
            case 'get':
                //echo 'get geliyor';

                echo '
                    <form action="'.$action.'" method="'.$method.'"  class="'.$className.'" id="'.$id.' "style="'.$style.'">
                ';
                break;
            default:
                Message::method_name_error($method);
                break;
        }
        
    }

    public static function form_end(){
        echo '
            </form>
        ';
    }
    
}



?>
