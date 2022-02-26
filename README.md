# PHP KULLANIŞLI FONKSİYON SINIFI (PHP USEFUL FUNCTION CLASS)
 * Kendimce yazmış olduğum içerisinde pdo , türkçe hata mesajları barındıran bir fonksiyon sınıfı.
 * Amacımız sadece fonksiyon girilerek birşeyler üretmek .  
 * İçerisinde Hem Front-End ve Hem Back-End fonksiyonlar bulunuyor .

# SINIFLAR (CLASSES)
 <ul>
  <li>
    <strong> db.class.php -> </strong> Veritabanı sınıfı (PDO)
  </li>
  <li>
    <strong> front.class.php -> </strong> HTML Etiketleri sınıfı 
  </li>
  <li>
    <strong> message.class.php -> </strong> Hata Mesajları sınıfı
  </li>
 </ul>
 
# FONKSİYONLAR (FUNCTIONS)

<h2>
  db.class.php
</h2>

<ul>
  <li>
    <strong> pdo_table_control() -> </strong> 
    Veritabanında varolan tabloları kontrol etmek 
  </li>
  <li>
    <strong> IDControl() -> </strong> 
    Girilen tabloda id sütununu kontrol etmek 
  </li>
  <li>
    <strong> columnControl() -> </strong> 
    Girilen tabloda sütun isimlerini kontrol etmek 
  </li>
  <li>
    <strong> getWithTableTotalRow() -> </strong> 
    Tabloda varolan toplam satır sayısını bulmak
  </li>
  <li>
    <strong> getWithIDValues() -> </strong> 
    Tabloda belirli bir id girerek o id'ye bağlı verileri json formatında getirmek 
  </li>
  <li>
    <strong> deleteWithID() -> </strong> 
    Tabloda belirli bir id'ye bağlı olan veriyi silmek 
  </li>
  <li>
    <strong> etWithTableSingleColumnValue() -> </strong> 
    Tablodan belirli bir sütun ismi girilerek sadece o sütuna ait verileri sıralamak 
  </li>
  <li>
    <strong> getWithTableFetchLimitedValue() -> </strong> 
    Bir tablodan belirli bir id'ye ait olan sütun ismi , limit , ASC veya DESC anahtar kelimeleri girilerek o id'ye bağlı verileri limitli olarak ekrana basar
  </li>
  <li>
    <strong> updateWithTableSingleColumnRow() -> </strong> 
    Tabloda belirtilen bir id ile belirtilen bir sütun ismi girilerek o id ve sütuna ait veriyi güncelle 
  </li>
</ul>

<h2>
message.class.php
</h2>

<strong>
NOT : 
</strong>

* Burada MainErrorFunction fonksiyonunda html kullanmadan sadece fonksiyon girerek denedim . İki şekildede kullanabilirsin.
* İster html yaz ister fonksiyon yaz

<ul>
  <li>
    <strong> pdo_database_connect_error() -> </strong> 
    Veritabanı bağlantı hatası 
  </li>
  <li>
    <strong> pdo_table_error_message() -> </strong> 
    Hatalı Tablo ismi
  </li>
  <li>
    <strong> pdo_wrong_column_name() -> </strong> 
    Hatalı Sütun ismi 
  </li>
  <li>
    <strong> pdo_id_not_found() -> </strong> 
    Tabloda belirtilen bir id değeri bulunamadı .
  </li>
  <li>
    <strong> method_name_error() -> </strong> 
    Method değeri hatası (POST veya GET)
  </li>
</ul>

<h2>
  front.class.php
</h2>

<strong>
  Bu sınıfı neden yazdığımı söylememe gerek yok :)
</strong>
