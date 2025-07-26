<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");
?>
<section class="infopage infopage--contacts">
  <div class="infopage__wrap">
    <div class="container">
      <div class="infopage__main">
        <h1 class="infopage__title">Страница не найдена</h1>
        <div><a class="_link" href="/">Вернуться на главную</a></div>
      </div>
    </div>
  </div>
</section>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
