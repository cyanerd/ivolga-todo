<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="lk-main">
  <form id="profile-form" method="post" action="" enctype="multipart/form-data">
    <?= bitrix_sessid_post() ?>

    <div class="lk-main__row">
      <div class="lk-main__col">
        <div class="inputel">
          <input
            type="text"
            name="NAME"
            value="<?= htmlspecialcharsbx($arResult["arUser"]["NAME"]) ?>"
            id="name"
            <?= ($arResult["bVarsFromForm"] ? "" : "placeholder=\"1\"") ?>
          >
          <label for="name">Имя</label>
        </div>
      </div>
      <div class="lk-main__col">
        <div class="inputel">
          <input
            type="text"
            name="LAST_NAME"
            value="<?= htmlspecialcharsbx($arResult["arUser"]["LAST_NAME"]) ?>"
            id="name2"
            <?= ($arResult["bVarsFromForm"] ? "" : "placeholder=\"1\"") ?>
          >
          <label for="name2">Фамилия</label>
        </div>
      </div>
      <div class="lk-main__col">
        <?
        $date = $arResult["arUser"]["PERSONAL_BIRTHDAY"];
        if ($date && preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $date, $matches)) {
            $date = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
        }
        ?>
        <div class="inputel">
          <input
            type="date"
            name="PERSONAL_BIRTHDAY"
            value="<?= $date ?>"
            id="date"
            <?= ($arResult["bVarsFromForm"] ? "" : "placeholder=\"1\"") ?>
            max="<?= date('Y-m-d') ?>"
            required
          >
          <label for="date">Дата рождения</label>
        </div>
      </div>
      <div class="lk-main__col">
        <div class="inputel">
          <input
            type="tel"
            name="PERSONAL_PHONE"
            value="<?= htmlspecialcharsbx($arResult["arUser"]["PERSONAL_PHONE"]) ?>"
            id="tel"
            <?= ($arResult["bVarsFromForm"] ? "" : "placeholder=\"1\"") ?>
          >
          <label for="tel">Телефон</label>
        </div>
      </div>
      <div class="lk-main__col lk-main__col_12">
        <div class="inputel">
          <input
            type="email"
            name="EMAIL"
            value="<?= htmlspecialcharsbx($arResult["arUser"]["EMAIL"]) ?>"
            id="email"
            <?= ($arResult["bVarsFromForm"] ? "" : "placeholder=\"1\"") ?>
          >
          <label for="email">Email для подписки</label>
        </div>
      </div>
      <div class="lk-main__col lk-main__col_12">
        <div class="wantget">
          <input
            type="checkbox"
            name="UF_NOT_SUBSCRIBED"
            value="Y"
            id="want"
            <?= ($arResult["arUser"]["UF_NOT_SUBSCRIBED"] == "0" ? "checked" : "") ?>
          >
          <label for="want">
            Я хочу получать новости от Ivolga на свой Email
          </label>
        </div>
      </div>
      <div class="lk-main__col lk-main__col_12">
        <button type="submit" name="save" value="Y" class="lk-main__submit">
          Сохранить
        </button>
      </div>
    </div>

    <div class="lk-main__password">
      <p class="lk-main__password-txt">
        Пароль
      </p>
      <button type="button" class="lk-main__password-change js--modal" data-modal="changepass">
        Изменить
      </button>
    </div>
  </form>
</div>
