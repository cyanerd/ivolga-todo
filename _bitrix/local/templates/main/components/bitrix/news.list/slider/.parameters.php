<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arTemplateParameters = [
  "DISPLAY_DATE" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
  ],
  "DISPLAY_NAME" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
  ],
  "DISPLAY_PICTURE" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
  ],
  "DISPLAY_PREVIEW_TEXT" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
  ],
  "USE_SHARE" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "VALUE" => "Y",
    "DEFAULT" => "N",
  ],
  "SHARE_HIDE" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
    "TYPE" => "CHECKBOX",
    "VALUE" => "Y",
    "DEFAULT" => "N",
  ],
  "SHARE_TEMPLATE" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
    "DEFAULT" => "",
    "TYPE" => "STRING",
    "MULTIPLE" => "N",
  ],
  "SHARE_HANDLERS" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
    "TYPE" => "LIST",
    "MULTIPLE" => "Y",
    "DEFAULT" => ["delicious", "facebook", "linkedin", "reddit", "twitter", "vkontakte"],
    "VALUES" => [
      "delicious" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_DELICIOUS"),
      "digg" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_DIGG"),
      "facebook" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_FACEBOOK"),
      "google" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_GOOGLE"),
      "linkedin" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_LINKEDIN"),
      "lj" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_LJ"),
      "reddit" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_REDDIT"),
      "twitter" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_TWITTER"),
      "vkontakte" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM_VKONTAKTE"),
    ],
  ],
  "SHARE_SHORTEN_URL_LOGIN" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
    "TYPE" => "STRING",
    "DEFAULT" => "",
  ],
  "SHARE_SHORTEN_URL_KEY" => [
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
    "TYPE" => "STRING",
    "DEFAULT" => "",
  ],
];
?>
