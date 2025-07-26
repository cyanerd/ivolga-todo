<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$amount_per_collumn = ceil(count($arResult['SECTIONS']) / 2);
$total_amount = count($arResult['SECTIONS']);
?>
<ul class="mobile-header__list second">
  <li>
    <a
      href=""
      class="nav-link nav-link-close"
    >
      <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_2451_4901)">
          <line x1="11" y1="5.71741" x2="1" y2="5.71741" stroke="#1B1A19"/>
          <path d="M5.24264 1.21695L1 5.45959L5.24264 9.70224" stroke="#1B1A19"/>
        </g>
        <defs>
          <clipPath id="clip0_2451_4901">
            <rect width="11" height="10" fill="white" transform="translate(0 0.217407)"/>
          </clipPath>
        </defs>
      </svg>

    </a
    >
  </li>
  <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
    <li>
      <a
        href="<?= $arSection['SECTION_PAGE_URL'] ?>"
        class="nav-link"
      ><?= $arSection['NAME'] ?></a>
    </li>
  <? } ?>
</ul>
