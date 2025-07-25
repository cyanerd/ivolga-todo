<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Коллекции");
?>

<section class="pagecollect">
  <div class="pagecollect__wrap">
    <div class="container">
      <h1 class="pagecollect__title">
        <?$APPLICATION->ShowTitle();?>
      </h1>
    </div>
    <?$APPLICATION->IncludeComponent(
      "bitrix:news.list",
      "collections",
      array(
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => "21",
        "NEWS_COUNT" => "4",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_BY2" => "ID",
        "SORT_ORDER2" => "DESC",
        "FIELD_CODE" => array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE"),
        "PROPERTY_CODE" => array("SUBTITLE", "URL", "PICTURE", "ITEMS"),
        "DISPLAY_PANEL" => "N",
        "SET_TITLE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_LAST_MODIFIED" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => "",
      ),
      false
    );?>
  </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
