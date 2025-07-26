<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (empty($arResult)) return;
?>
<p class="infopage__aside-title"><?= $arParams["TITLE"] ?? 'Покупателям' ?></p>
<ul class="infopage__aside-list">
  <? foreach ($arResult as $arItem): ?>
    <?
    $active = $arItem["SELECTED"] ? 'active' : '';
    ?>
    <li>
      <a href="<?= $arItem["LINK"] ?>" class="<?= $active ?>">
        <?= $arItem["TEXT"] ?>
      </a>
    </li>
  <? endforeach; ?>
</ul>
