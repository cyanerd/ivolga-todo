<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = array(
    "NAME" => "Блог - слайдер",
    "DESCRIPTION" => "Выводит последние записи блога в виде слайдера",
    "ICON" => "/images/news_list.gif",
    "CACHE_PATH" => "Y",
    "SORT" => 10,
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "news",
            "NAME" => "Новости",
            "SORT" => 10,
        ),
    ),
);
?> 