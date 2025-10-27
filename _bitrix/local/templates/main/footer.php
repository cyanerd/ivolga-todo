<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

</main>
<footer class="footer">
  <div class="footer__container">
    <div class="footer__top">
      <div class="footer__contact">
        <div class="footer__contact-title">Связаться с нами</div>
        <div class="footer__contact-links">
          <? if ($siteSettings['phone']) { ?>
            <a href="tel:<?= clearPhoneString($siteSettings['phone']) ?>" class="footer__link"><?= $siteSettings['phone'] ?>
              <i>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11 6.74951L12 6.74951C13.7949 6.74951 15.25 5.29444 15.25 3.49951L16.75 3.49951C16.75 6.12286 14.6234 8.24951 12 8.24951L11 8.24951L11 6.74951Z"
                        fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 3.49951C16.75 5.29444 18.2051 6.74951 20 6.74951L21 6.74951L21 8.24951L20 8.24951C17.3766 8.24951 15.25 6.12286 15.25 3.49951L16.75 3.49951Z"
                        fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 21.2495L3 21.2495L3 19.7495L15.25 19.7495L15.25 3.49951L16.75 3.49951L16.75 21.2495Z"
                        fill="#232229"/>
                </svg>
              </i>
            </a>
          <? } ?>
          <? if ($siteSettings['email']) { ?>
            <a href="mailto:<?= $siteSettings['email'] ?>" class="footer__link"><?= $siteSettings['email'] ?>
              <i>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11 6.74951L12 6.74951C13.7949 6.74951 15.25 5.29444 15.25 3.49951L16.75 3.49951C16.75 6.12286 14.6234 8.24951 12 8.24951L11 8.24951L11 6.74951Z"
                        fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 3.49951C16.75 5.29444 18.2051 6.74951 20 6.74951L21 6.74951L21 8.24951L20 8.24951C17.3766 8.24951 15.25 6.12286 15.25 3.49951L16.75 3.49951Z"
                        fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 21.2495L3 21.2495L3 19.7495L15.25 19.7495L15.25 3.49951L16.75 3.49951L16.75 21.2495Z"
                        fill="#232229"/>
                </svg>
              </i>
            </a>
          <? } ?>
        </div>
        <div class="footer__bottomgroup">
          <div class="footer__social">
            <? if ($siteSettings['tg']) { ?>
              <a href="<?= $siteSettings['tg'] ?>" target="_blank" class="footer__social-link">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M19.7769 4.92948C20.024 4.82547 20.2945 4.7896 20.5602 4.82559C20.8259 4.86159 21.0771 4.96815 21.2876 5.13416C21.4981 5.30018 21.6603 5.51959 21.7573 5.76956C21.8542 6.01953 21.8824 6.29092 21.8389 6.55548L19.5709 20.3125C19.3509 21.6395 17.8949 22.4005 16.6779 21.7395C15.6599 21.1865 14.1479 20.3345 12.7879 19.4455C12.1079 19.0005 10.0249 17.5755 10.2809 16.5615C10.5009 15.6945 14.0009 12.4365 16.0009 10.4995C16.7859 9.73848 16.4279 9.29948 15.5009 9.99948C13.1989 11.7375 9.5029 14.3805 8.2809 15.1245C7.2029 15.7805 6.6409 15.8925 5.9689 15.7805C4.7429 15.5765 3.6059 15.2605 2.6779 14.8755C1.4239 14.3555 1.4849 12.6315 2.6769 12.1295L19.7769 4.92948Z"
                        fill="#232229"/>
                </svg>
              </a>
            <? } ?>
            <? if ($siteSettings['vk']) { ?>
              <a href="<?= $siteSettings['vk'] ?>" target="_blank" class="footer__social-link">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M4.26 4.75951C3 6.03151 3 8.06551 3 12.1395V12.8595C3 16.9275 3 18.9615 4.26 20.2395C5.532 21.4995 7.566 21.4995 11.64 21.4995H12.36C16.428 21.4995 18.462 21.4995 19.74 20.2395C21 18.9675 21 16.9335 21 12.8595V12.1395C21 8.07151 21 6.03751 19.74 4.75951C18.468 3.49951 16.434 3.49951 12.36 3.49951H11.64C7.572 3.49951 5.538 3.49951 4.26 4.75951ZM6.036 8.97751H8.1C8.166 12.4095 9.678 13.8615 10.878 14.1615V8.97751H12.816V11.9355C13.998 11.8095 15.246 10.4595 15.666 8.97151H17.598C17.4404 9.74173 17.1256 10.4712 16.6735 11.1143C16.2213 11.7575 15.6414 12.3005 14.97 12.7095C15.7194 13.0824 16.3813 13.6099 16.9118 14.2574C17.4424 14.9048 17.8297 15.6574 18.048 16.4655H15.918C15.462 15.0435 14.322 13.9395 12.816 13.7895V16.4655H12.576C8.472 16.4655 6.132 13.6575 6.036 8.97751Z"
                    fill="#232229"/>
                </svg>
              </a>
            <? } ?>
          </div>
          <div class="footer__legal">
            <? if ($siteSettings['ogrn']) { ?>
              <span>ОГРН <?= $siteSettings['ogrn'] ?></span>
            <? } ?>
            <span class="footer__legal-dot"></span>
            <? if ($siteSettings['inn']) { ?>
              <span>ИНН <?= $siteSettings['inn'] ?></span>
            <? } ?>
          </div>
        </div>
      </div>
      <div class="footer__nav">
        <div class="footer__nav-col">
          <div class="footer__nav-title">О нас</div>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "footer-menu",
            [
              "ROOT_MENU_TYPE" => "about",
              "MAX_LEVEL" => "3",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "Y",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "Y",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => [],
              "COMPONENT_TEMPLATE" => "footer-menu"
            ],
            false
          );
          ?>
        </div>
        <div class="footer__nav-col">
          <div class="footer__nav-title">Покупателям</div>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "footer-menu",
            [
              "ROOT_MENU_TYPE" => "customers",
              "MAX_LEVEL" => "3",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "Y",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "Y",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => [],
              "COMPONENT_TEMPLATE" => "footer-menu"
            ],
            false
          );
          ?>
        </div>
      </div>
    </div>

    <div class="footer__newsletter">
      <div class="footer__newsletter-title">Будьте в курсе новостей</div>
      <form class="footer__newsletter-form" id="newsletter-form">
        <div class="footer__newsletter-inputWrapper">
          <input type="email" class="footer__newsletter-input" id="newsInput" placeholder="" required>
          <label for="newsInput"><span>Email</span></label>
        </div>
        <button type="submit" class="footer__newsletter-button">Подписаться</button>
      </form>
    </div>

    <div class="footer__bottom">
      <div class="footer__logo">
        <img
          src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgzNiIgaGVpZ2h0PSI2NTMiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTE4LjU4NiAxOTEuNjA2aDU1LjA5N3YzMTkuODI3SDE4LjU4NlYxOTEuNjA2Wk03Ni4zNCA1NC4wNzRoNjkuMDM1bC03Ni4zNCA4My42ODdIMjEuMjRsNTUuMS04My42ODdaTTE1Ny4yMjIgMTkxLjYwNmg1Ny4wOTJsMTAyLjIyOSAyNjcuMjc5IDk5LjU3NS0yNjcuMjc5aDUzLjc3M0wzNDcuMDgzIDUxMS40MzRoLTY1LjA2MWwtMTI0LjgtMzE5LjgyOFpNNTEzLjA0NCAzNTEuMTk2YzAtMTAwLjU1NSA3My4wMjQtMTY5LjMyMSAxNzEuMjctMTY5LjMyMSA5OC4yNDUgMCAxNzAuNjA4IDY4Ljc2NiAxNzAuNjA4IDE2OS4zMjEgMCAxMDAuNTU1LTcyLjM2IDE2OS45NzYtMTcwLjYwOCAxNjkuOTc2LTk4LjI0OSAwLTE3MS4yNy02OS40MjMtMTcxLjI3LTE2OS45NzZabTE3MS4yNzkgMTI1LjIwNWM2OC4zNzcgMCAxMTQuMTgyLTUyLjU0NiAxMTQuMTgyLTEyNS44NTUgMC03My4zMDgtNDUuMTQyLTEyMy45MDctMTE0LjE4Mi0xMjMuOTA3LTY5LjcwMSAwLTExNC44MzUgNDkuMzAzLTExNC44MzUgMTIzLjkwNyAwIDc0LjYwNiA0NS43ODggMTI1Ljg1NSAxMTQuODM1IDEyNS44NTVaTTkzMS44OTIgNDQ3Ljg2N1Y1NC4wNzRoNTUuMDk5djM5MC41NGMwIDI0LjAwMiAxMS45NSAzMS43ODcgMzEuMTk5IDMxLjc4N2gxNS4xNHY0NC43NjRoLTI1Ljc2Yy01MC40NTggMC03NS42NzgtMjYuNTk3LTc1LjY3OC03My4yOThaTTE0ODIuMTcgMzUxLjE5NmMwLTk5LjI1NiA2NC40LTE2OS4zMjEgMTU5Ljk5LTE2OS4zMjEgNjUuNzIgMCAxMDUuNTUgMzIuNDM3IDEyMS40OCA1OC4zODZ2LTQ4LjY1NWg1My43N3YzMTkuODI4aC01My43N3YtNTIuNTQ5Yy04LjYzIDE2Ljg2OC00Ny43OSA2Mi4yOC0xMjAuODIgNjIuMjgtOTUuNTkgMC0xNjAuNjUtNjguMTE4LTE2MC42NS0xNjkuOTY5Wm0xNjcuMjkgMTI1LjIwNWM2Ny4wNSAwIDExNC4xOC00OS45NTEgMTE0LjE4LTEyNS4yMDUgMC03My45NTYtNDcuMTMtMTIzLjkwOS0xMTQuMTgtMTIzLjkwOS02OC4zNyAwLTExMy41MiA0Ny4zNjYtMTEzLjUyIDEyMy45MDkgMCA3Ni41NDQgNDUuMTUgMTI1LjIwNSAxMTMuNTIgMTI1LjIwNVpNMTEwNi43OSA1MjEuMTc5aDU1Ljc2YzIgMzUuNjggMjcuMjIgNjkuNDExIDk2LjI2IDY5LjQxMSA2NS4wNiAwIDEwNC44OS0zNy42NDEgMTA0Ljg5LTEwNi40MDdWNDQ0LjI0Yy0yOS45NiAzNC43NTgtNjkuMjIgNTAuNDQ3LTExNi45NiA1MC40NDctODYuNiAwLTE0Ny4yNS02MS4wNDEtMTQ3LjI1LTE1My44NjIgMC05OS41NDcgNTUuNzYtMTU4Ljk0MSAxNDguMDQtMTU4Ljk0MSA2NS44NSAwIDk4LjkxIDM0LjM3MiAxMTYuODMgNTguMzc0di00OC42NGg1My43N3YyODguMDI4YzAgOTkuOTA1LTY0LjM5IDE1NC40MTQtMTU5LjMyIDE1NC40MTQtOTcuNTgtLjAwNS0xNDYuNzEtNDMuNDY1LTE1Mi4wMi0xMTIuODgxWm0xNTEuNDQtNzEuMjk3YzY1LjI3IDAgMTA1LjQ4LTQ4LjE0NyAxMDUuNDgtMTEwLjM2NSAwLTY3Ljg3Mi00MC4yMS0xMTIuODc5LTEwNS40OC0xMTIuODc5LTY1LjkzIDAtMTA0LjgyIDQ0LjM3OC0xMDQuODIgMTEyLjg3OSAwIDYyLjg0NSAzOC44OSAxMTAuMzY1IDEwNC44MiAxMTAuMzY1WiIgZmlsbD0iIzIzMjIyOSIvPjwvc3ZnPg=="
          alt="">
      </div>
      <div class="footer__bottom-info">
        <div class="footer__copyright">© <?= $siteSettings['copyright'] ?></div>
        <? /*
        <div class="footer__creator">
          <span>Сайт создан</span>
          <a href="<?= $siteSettings['madebylink'] ?>" target="_blank"
             class="footer__creator-link">© <?= $siteSettings['madeby'] ?></a>
        </div>*/ ?>
        <div class="footer__payment">
          <img
            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODYiIGhlaWdodD0iMjUiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3QgeT0iLjUiIHdpZHRoPSI4NiIgaGVpZ2h0PSIyNCIgcng9IjEiIGZpbGw9IiMyMzIyMjkiLz48cGF0aCBkPSJNMjAuNDI0IDcuNWgtMS42Njh2OC40NjFoMS42NjhWNy41Wk0xNi44MzkgNy45NzNIMTUuMTd2OC40NjFoMS42Njl2LTguNDZaTTEzLjI1NCA4LjUwMmgtMS42Njl2OC40NjNoMS42NjlWOC41MDJaTTkuNjY5IDkuMDM2SDhWMTcuNWgxLjY2OVY5LjAzNlpNNjQuNDkzIDEyLjAwOCA2MS44MDYgOS4wMmgtMS41N3Y2LjkxNmgxLjY0di00LjQxMmwyLjQ1MiAyLjYxNGguMzAzbDIuNDEtMi42MTR2NC40MTJoMS42NFY5LjAyaC0xLjU3bC0yLjYxOCAyLjk4OFpNNzYuNDk0IDkuMDJsLTQuMDY0IDQuNDk2VjkuMDJoLTEuNjR2Ni45MTZoMS41MDJsNC4wNjUtNC40OTV2NC40OTVoMS42NFY5LjAyaC0xLjUwM1pNNTEuNDAzIDExLjU1MWMwIDEuMTAxLjYwMiAxLjk2OSAxLjUyNiAyLjMzMmwtMS43MzMgMi4wNTNoMi4wMDdsMS41NzctMS44NjdoMS43MDZ2MS44NjdoMS42NFY5LjAySDUzLjk1Yy0xLjU1NiAwLTIuNTQ4IDEuMDY1LTIuNTQ4IDIuNTMxWm01LjA4NC0xLjAwN3YyLjA0NWgtMi4yMzJjLS43NDUgMC0xLjE0NC0uNDE1LTEuMTQ0LTEuMDI0IDAtLjYwOC40MTQtMS4wMjMgMS4xNDQtMS4wMjNsMi4yMzIuMDAyWk00My43ODMgMTAuNDA0Yy0uMSAyLjM3OC0uNjAyIDMuOTE0LTEuNTg1IDMuOTE0aC0uMjQ2djEuNjZsLjI2Mi4wMTRjMS45Ny4xMSAzLjA2LTEuNjIgMy4yMzgtNS4zOTVoMi41OXY1LjM0aDEuNjM4VjkuMDJoLTUuODQybC0uMDU1IDEuMzg0Wk0zNy42MSA4LjkyNGMtMi4yMTggMC0zLjgxNCAxLjUzNS0zLjgxNCAzLjU1NCAwIDIuMDg4IDEuNzM2IDMuNTcgMy44MTQgMy41NyAyLjE2NCAwIDMuODQ1LTEuNTY0IDMuODQ1LTMuNTdzLTEuNjgxLTMuNTU0LTMuODQ1LTMuNTU0Wm0wIDUuNDYzYy0xLjI1NCAwLTIuMTA4LS44MTYtMi4xMDgtMS45MDkgMC0xLjEyLjg1NS0xLjkxNCAyLjEwOC0xLjkxNCAxLjI1MiAwIDIuMTM2LjgzIDIuMTM2IDEuOTE0cy0uODk2IDEuOTEtMi4xMzYgMS45MVpNMzIuMDU3IDkuMDM0SDI2LjI3bC0uMDU2IDEuMzgzYy0uMDgyIDEuOTkyLS42MDIgMy44ODctMS41ODQgMy45MTVsLS40NTUuMDE0VjE3LjVsMS42NTQtLjAwNHYtMS41NTloNS43NDV2MS41NmgxLjY2OHYtMy4xNjVoLTEuMTg1VjkuMDMyWm0tMS42NCA1LjI5N2gtMy41Yy41OTMtLjg5OC45MS0yLjE5OS45NjUtMy43MmgyLjUzNXYzLjcyWiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg=="
            alt="Долями" class="footer__payment-img">
          <img
            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDEiIGhlaWdodD0iMzMiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgY2xpcC1wYXRoPSJ1cmwoI2EpIj48cGF0aCBkPSJNNy40MzEgMzIuNDN2LTIuMTI0YzAtLjgxMi0uNDkyLTEuMzQ0LTEuMzM4LTEuMzQ0LS40MjIgMC0uODgyLjE0LTEuMTk4LjYwMi0uMjQ2LS4zODgtLjU5OS0uNjAyLTEuMTI4LS42MDItLjM1MyAwLS43MDYuMTA3LS45ODUuNDk1di0uNDI1aC0uNzM5djMuMzk4aC43Mzl2LTEuODc3YzAtLjYwMi4zMTYtLjg4Ni44MDgtLjg4Ni40OTMgMCAuNzM5LjMxNy43MzkuODg2djEuODc3aC43Mzl2LTEuODc3YzAtLjYwMi4zNTItLjg4Ni44MDgtLjg4Ni40OTIgMCAuNzM5LjMxNy43MzkuODg2djEuODc3aC44MTZabTEwLjk1Ni0zLjM5OGgtMS4xOTh2LTEuMDI3aC0uNzM5djEuMDI3aC0uNjY5di42NzJoLjY3djEuNTU5YzAgLjc4LjMxNSAxLjIzNyAxLjE2IDEuMjM3LjMxNiAwIC42Ny0uMTA3LjkxNS0uMjQ4bC0uMjEzLS42MzljLS4yMTMuMTQtLjQ2LjE3OC0uNjM2LjE3OC0uMzUzIDAtLjQ5Mi0uMjE1LS40OTItLjU2NXYtMS41MjJoMS4xOTh2LS42NzJoLjAwNFptNi4yNy0uMDc0YTEgMSAwIDAgMC0uODgzLjQ5NHYtLjQyNGgtLjczOHYzLjM5OGguNzM4di0xLjkxNGMwLS41NjUuMjQ3LS44ODYuNzA2LS44ODYuMTQgMCAuMzE2LjAzNy40Ni4wN2wuMjEzLS43MWMtLjE0OC0uMDI4LS4zNTctLjAyOC0uNDk2LS4wMjhabS05LjQ3NS4zNTRjLS4zNTMtLjI0Ny0uODQ1LS4zNTQtMS4zNzQtLjM1NC0uODQ2IDAtMS40MDguNDI0LTEuNDA4IDEuMDk3IDAgLjU2NC40MjMuODg2IDEuMTYxLjk5bC4zNTMuMDM2Yy4zODYuMDcuNi4xNzguNi4zNTUgMCAuMjQ3LS4yODQuNDI1LS43NzYuNDI1YTEuOTQgMS45NCAwIDAgMS0xLjEyOS0uMzU1bC0uMzUyLjU2NWMuMzg1LjI4NS45MTUuNDI1IDEuNDQ0LjQyNS45ODUgMCAxLjU1LS40NjIgMS41NS0xLjA5NyAwLS42MDItLjQ1OS0uOTItMS4xNi0xLjAyN2wtLjM1My0uMDM3Yy0uMzE2LS4wMzctLjU2Mi0uMTA3LS41NjItLjMxOCAwLS4yNDcuMjQ2LS4zODcuNjM2LS4zODcuNDIyIDAgLjg0NS4xNzcgMS4wNTguMjg0bC4zMTItLjYwMlptMTkuNjUtLjM1NGExIDEgMCAwIDAtLjg4MS40OTR2LS40MjRoLS43Mzl2My4zOThoLjczOXYtMS45MTRjMC0uNTY1LjI0Ni0uODg2LjcwNS0uODg2LjE0IDAgLjMxNi4wMzcuNDYuMDdsLjIxMy0uNzAxYy0uMTQzLS4wMzctLjM1My0uMDM3LS40OTYtLjAzN1ptLTkuNDM3IDEuNzczYzAgMS4wMjcuNzA2IDEuNzY5IDEuNzk3IDEuNzY5LjQ5MyAwIC44NDYtLjEwNyAxLjE5OS0uMzg4bC0uMzUzLS42MDJjLS4yODMuMjE1LS41NjIuMzE4LS44ODMuMzE4LS41OTkgMC0xLjAyMS0uNDI1LTEuMDIxLTEuMDk3IDAtLjY0LjQyMi0xLjA2NCAxLjAyMS0xLjA5Ny4zMTYgMCAuNi4xMDcuODgzLjMxN2wuMzUzLS42MDJjLS4zNTMtLjI4NC0uNzA2LS4zODctMS4xOTgtLjM4Ny0xLjA5Mi0uMDA0LTEuNzk4Ljc0Mi0xLjc5OCAxLjc2OVptNi44MzIgMHYtMS43aC0uNzM4di40MjZjLS4yNDctLjMxOC0uNi0uNDk1LTEuMDU5LS40OTUtLjk1MiAwLTEuNjkuNzQyLTEuNjkgMS43NjlzLjczOCAxLjc2OSAxLjY5IDEuNzY5Yy40OTIgMCAuODQ1LS4xNzcgMS4wNTktLjQ5NXYuNDI1aC43Mzh2LTEuN1ptLTIuNzEyIDBjMC0uNjAyLjM4Ni0xLjA5NyAxLjAyMi0xLjA5Ny41OTkgMCAxLjAyMS40NjIgMS4wMjEgMS4wOTcgMCAuNjAyLS40MjIgMS4wOTctMS4wMjEgMS4wOTctLjYzMi0uMDM3LTEuMDIyLS41LTEuMDIyLTEuMDk3Wm0tOC44MzgtMS43NzNjLS45ODUgMC0xLjY5MS43MDktMS42OTEgMS43NjkgMCAxLjA2NC43MDYgMS43NjkgMS43MjcgMS43NjkuNDkzIDAgLjk4NS0uMTQgMS4zNzUtLjQ2MmwtLjM1My0uNTMyYTEuNjcyIDEuNjcyIDAgMCAxLS45ODUuMzU1Yy0uNDYgMC0uOTE1LS4yMTUtMS4wMjEtLjgxM2gyLjQ5OHYtLjI4NGMuMDMzLTEuMDkzLS42MDMtMS44MDItMS41NS0xLjgwMlptMCAuNjM5Yy40NTkgMCAuNzc1LjI4NC44NDUuODEyaC0xLjc2Yy4wNy0uNDU4LjM4NS0uODEyLjkxNS0uODEyWm0xOC4zNSAxLjEzNHYtMy4wNDRoLS43NHYxLjc3Yy0uMjQ1LS4zMTgtLjU5OC0uNDk1LTEuMDU4LS40OTUtLjk1MiAwLTEuNjkuNzQyLTEuNjkgMS43NjlzLjczOCAxLjc2OSAxLjY5IDEuNzY5Yy40OTIgMCAuODQ1LS4xNzcgMS4wNTktLjQ5NXYuNDI1aC43Mzh2LTEuN1ptLTIuNzEzIDBjMC0uNjAyLjM4Ni0xLjA5NyAxLjAyMi0xLjA5Ny41OTkgMCAxLjAyMi40NjIgMS4wMjIgMS4wOTcgMCAuNjAyLS40MjMgMS4wOTctMS4wMjIgMS4wOTctLjYzNi0uMDM3LTEuMDIyLS41LTEuMDIyLTEuMDk3Wm0tMjQuNzI2IDB2LTEuN2gtLjczOXYuNDI2Yy0uMjQ2LS4zMTgtLjU5OS0uNDk1LTEuMDU5LS40OTUtLjk1MiAwLTEuNjkuNzQyLTEuNjkgMS43NjlTOC44MzggMzIuNSA5Ljc5IDMyLjVjLjQ5MyAwIC44NDYtLjE3NyAxLjA2LS40OTV2LjQyNWguNzM4di0xLjdabS0yLjc0NSAwYzAtLjYwMi4zODUtMS4wOTcgMS4wMjEtMS4wOTcuNiAwIDEuMDIyLjQ2MiAxLjAyMiAxLjA5NyAwIC42MDItLjQyMyAxLjA5Ny0xLjAyMiAxLjA5Ny0uNjM2LS4wMzctMS4wMjEtLjUtMS4wMjEtMS4wOTdaIiBmaWxsPSIjMjMyMjI5Ii8+PHBhdGggZD0iTTI2LjAzMSAzLjIyNkgxNC45MzZ2MjAuMDMzSDI2LjAzVjMuMjI2WiIgZmlsbD0iI0ZGNUEwMCIvPjxwYXRoIGQ9Ik0xNS42NzUgMTMuMjQyYzAtNC4wNyAxLjkwMy03LjY4MiA0LjgyNS0xMC4wMTZBMTIuNTcyIDEyLjU3MiAwIDAgMCAxMi42OC41QzUuNjcuNSAwIDYuMTk5IDAgMTMuMjQyYzAgNy4wNDQgNS42NyAxMi43NDIgMTIuNjggMTIuNzQyIDIuOTU4IDAgNS42Ny0xLjAyNiA3LjgyLTIuNzI1LTIuOTI2LTIuMzAxLTQuODI1LTUuOTQ3LTQuODI1LTEwLjAxN1oiIGZpbGw9IiNFQjAwMUIiLz48cGF0aCBkPSJNNDEgMTMuMjQyYzAgNy4wNDQtNS42NyAxMi43NDItMTIuNjggMTIuNzQyLTIuOTU4IDAtNS42Ny0xLjAyNi03LjgyLTIuNzI1IDIuOTU5LTIuMzM4IDQuODI2LTUuOTQ3IDQuODI2LTEwLjAxNyAwLTQuMDctMS45MDQtNy42ODItNC44MjYtMTAuMDE2QTEyLjU1MSAxMi41NTEgMCAwIDEgMjguMzE3LjVDMzUuMzI5LjUgNDEgNi4yMzYgNDEgMTMuMjQyWiIgZmlsbD0iI0Y3OUUxQiIvPjwvZz48ZGVmcz48Y2xpcFBhdGggaWQ9ImEiPjxwYXRoIGZpbGw9IiNmZmYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgLjUpIiBkPSJNMCAwaDQxdjMySDB6Ii8+PC9jbGlwUGF0aD48L2RlZnM+PC9zdmc+"
            alt="Mastercard" class="footer__payment-img">
          <img
            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iMTkiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgY2xpcC1wYXRoPSJ1cmwoI2EpIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCI+PHBhdGggZD0iTTE3LjI0Ni41di4wMDhjLS4wMDggMC0yLjUtLjAwOC0zLjE2NCAyLjM1OC0uNjEgMi4xNy0yLjMyNiA4LjE1OS0yLjM3NCA4LjMyNGgtLjQ3NFM5LjQ3NyA1LjA2NyA4Ljg2IDIuODU4QzguMTk2LjQ5MiA1LjY5Ni41IDUuNjk2LjVIMHYxOGg1LjY5NlY3LjgxaC40NzVMOS40OTMgMTguNWgzLjk1NkwxNi43NyA3LjgxOGguNDc1VjE4LjVoNS42OTZWLjVoLTUuNjk2Wk0zOC4wNTIuNXMtMS42Ny4xNS0yLjQ1MyAxLjg4NmwtNC4wMzQgOC44MDRoLS40NzVWLjVoLTUuNjk2djE4aDUuMzhzMS43NDgtLjE1NyAyLjUzMS0xLjg4N2wzLjk1Ni04LjgwM2guNDc0VjE4LjVoNS42OTZWLjVoLTUuMzhaTTQ1Ljk2MyA4LjY3NVYxOC41aDUuNjk2di01LjczOGg2LjE3YTYuMTYgNi4xNiAwIDAgMCA1LjgxNS00LjA4N0g0NS45NjNaIiBmaWxsPSIjNERCNDVFIi8+PHBhdGggZD0iTTU3LjgzLjVINDUuMTYzYy42MzMgMy40MjcgMy4yMiA2LjE3OCA2LjU2NiA3LjA3NC43Ni4yMDUgMS41NTkuMzE1IDIuMzgxLjMxNWg5Ljc2M2MuMDg3LS40MS4xMjYtLjgyNi4xMjYtMS4yNThDNjQgMy4yNDMgNjEuMjQuNSA1Ny44My41WiIgZmlsbD0idXJsKCNiKSIvPjwvZz48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9ImIiIHgxPSI0NS4xNjYiIHkxPSI0LjE5NCIgeDI9IjY0IiB5Mj0iNC4xOTQiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9Ii4zIiBzdG9wLWNvbG9yPSIjMDBCNEU2Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjMDg4Q0NCIi8+PC9saW5lYXJHcmFkaWVudD48Y2xpcFBhdGggaWQ9ImEiPjxwYXRoIGZpbGw9IiNmZmYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgLjUpIiBkPSJNMCAwaDY0djE4SDB6Ii8+PC9jbGlwUGF0aD48L2RlZnM+PC9zdmc+"
            alt="МИР" class="footer__payment-img">
        </div>
      </div>
    </div>
  </div>
</footer>

<div class="backdrop js--close"></div>

<div class="modalcart" id="cart">
  <div class="modalcart__header">
    <p class="modalcart__title">
      Корзина
    </p>
    <button class="modalcart__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div id="cart-content">
    <div class="cart-loading">
      <p>Загрузка корзины...</p>
    </div>
  </div>
</div>


<div class="modalguide" id="modalguide">
  <div class="modalguide__header">
    <p class="modalguide__title">
      Гайд по размерам
    </p>
    <button class="modalguide__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <?= $siteSettings['UF_SIZE_TABLE'] ?>

  <div class="modalguide-how">
    <p class="modalguide-how__title">
      Как измерить?
    </p>
    <? foreach ($siteSettings['UF_SIZE_TABS'] as $i => $tabTitle) { ?>
      <div class="modalguide-how__block">
        <button class="modalguide-how__header">
          <p>
            <?= $tabTitle ?>
          </p>
          <i>
            <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 5.25V0H8.25V5.25H0V6.75H8.25V12H9.75V6.75H18V5.25H9.75Z"
                    fill="#232229"/>
            </svg>
          </i>
        </button>
        <div class="modalguide-how__body-wrap">
          <div class="modalguide-how__body">
            <?= $siteSettings['UF_SIZE_TABS_CONTENT'][$i] ?>
          </div>
        </div>
      </div>
    <? } ?>
  </div>
</div>

<div class="lkmodal" id="logout-modal">
  <div class="lkmodal__header">
    <p class="lkmodal__title">Вы уверены, что хотите выйти?</p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div style="margin-bottom: 10px;">
      <button id="logout-yes" class="modalcart__button" style="min-width:90px;">Да</button>
    </div>
    <button id="logout-no" class="modalcart__button" style="background:#eee; color:#232229; min-width:90px;">Нет</button>
  </div>
</div>

<div class="lkmodal" id="changepass">
  <div class="lkmodal__header">
    <p class="lkmodal__title">Изменение пароля</p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <form class="lkmodal__form" id="changePassForm">
      <div class="lkmodal__form-el">
        <div class="inputel inputel_pas">
          <input type="password" name="current" placeholder="1" id="password" required>
          <label for="password">Введите текущий пароль</label>
        </div>
      </div>
      <div class="lkmodal__form-el">
        <div class="inputel inputel_pas">
          <input type="password" name="new" placeholder="1" id="password2" required>
          <label for="password2">Введите новый пароль</label>
        </div>
      </div>
      <div class="lkmodal__form-el">
        <div class="inputel inputel_pas">
          <input type="password" name="repeat" placeholder="1" id="password3" required>
          <label for="password3">Повторите пароль</label>
        </div>
      </div>
      <div class="lkmodal__form-el">
        <div class="lkmodal__form-error" id="changePassError" style="color:red;display:none;"></div>
      </div>
      <button type="submit" class="lkmodal__form-submit">Изменить</button>
    </form>
  </div>
</div>
<div class="lkmodal" id="changepass_ok">
  <div class="lkmodal__header">
    <p class="lkmodal__title">Изменение пароля</p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">Готово!</p>
      <p class="lkmodal__done-txt">Пароль успешно изменён</p>
      <a href="#" class="lkmodal__form-submit js--close">Закрыть</a>
    </div>
  </div>
</div>
<div class="lkmodal" id="updateprofile">
  <div class="lkmodal__header">
    <p class="lkmodal__title">Обновление данных</p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">Готово!</p>
      <p class="lkmodal__done-txt">Профиль успешно обновлен</p>
      <a href="#" class="lkmodal__form-submit js--close">Закрыть</a>
    </div>
  </div>
</div>
<div class="lkmodal" id="newadress"></div>


<div class="lkmodal" id="resetpass">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Восстановление пароля
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__form">
      <p class="lkmodal__form-descr">
        Введите email, на который отправим код авторизации
      </p>
      <div class="lkmodal__form-el">
        <div class="inputel">
          <input type="email" placeholder="1" id="changemail">
          <label for="changemail">E-mail</label>
        </div>
      </div>
      <button class="lkmodal__form-submit js--modal" data-modal="resetpass_code">
        Отправить
      </button>
    </div>
  </div>
</div>


<div class="lkmodal" id="resetpass_code">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Восстановление пароля
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__form">
      <p class="lkmodal__form-descr">
        Введите код подтверждения из письма
      </p>
      <div class="lkmodal__form-el">
        <div class="inputel">
          <input placeholder="1" id="code">
          <label for="code">Код</label>
        </div>
      </div>
      <button class="lkmodal__form-submit js--modal" data-modal="resetpass_code">
        Отправить
      </button>
    </div>
  </div>
</div>


<div class="lkmodal" id="resetpass_new">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Восстановление пароля
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__form">
      <p class="lkmodal__form-descr">
        Введите новый пароль для своего аккаунта
      </p>
      <div class="lkmodal__form-el">
        <div class="inputel">
          <input placeholder="1" id="changeoldpass">
          <label for="changeoldpass">Введите новый пароль</label>
        </div>
      </div>
      <div class="lkmodal__form-el">
        <div class="inputel">
          <input placeholder="1" id="changeoldpassrep">
          <label for="changeoldpassrep">Повторите пароль</label>
        </div>
      </div>
      <button class="lkmodal__form-submit js--modal" data-modal="resetpass_code">
        Отправить
      </button>
    </div>
  </div>
</div>


<div class="lkmodal" id="resetpass_ok">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Восстановление пароля
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">
        Готово!
      </p>
      <p class="lkmodal__done-txt">
        Пароль успешно сброшен
      </p>
      <a href="#" class="lkmodal__form-submit">
        Перейти в профиль
      </a>
    </div>
  </div>
</div>

<div class="lkmodal" id="newadress_ok">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Добавить новый адрес
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">
        Готово!
      </p>
      <p class="lkmodal__done-txt">
        Адрес успешно добавлен
      </p>
      <a href="#" class="lkmodal__form-submit">
        Перейти в профиль
      </a>
    </div>
  </div>
</div>

<!-- Универсальная модалка для добавления и редактирования адреса -->
<div class="lkmodal" id="editadress">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      <span id="editadress-title">Добавить новый адрес</span>
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__form">
      <div class="lkmodal__form-el lkmodal__form-el_6">
        <div class="inputel">
          <input placeholder="1" id="city">
          <label for="street">Город</label>
        </div>
      </div>
      <div class="lkmodal__form-el lkmodal__form-el_6">
        <div class="inputel">
          <input placeholder="1" id="street">
          <label for="street">Улица</label>
        </div>
      </div>
      <div class="lkmodal__form-el lkmodal__form-el_6">
        <div class="inputel">
          <input placeholder="1" id="home">
          <label for="home">Дом</label>
        </div>
      </div>
      <div class="lkmodal__form-el lkmodal__form-el_6">
        <div class="inputel">
          <input placeholder="1" id="podesz">
          <label for="podesz">Подъезд</label>
        </div>
      </div>
      <div class="lkmodal__form-el lkmodal__form-el_6">
        <div class="inputel">
          <input placeholder="1" id="room">
          <label for="room">Квартира</label>
        </div>
      </div>
      <div class="lkmodal__form-el lkmodal__form-el_6">
        <div class="inputel">
          <input placeholder="1" id="floor">
          <label for="floor">Этаж</label>
        </div>
      </div>
      <div class="lkmodal__form-el">
        <div class="inputel">
          <input placeholder="1" id="comment">
          <label for="comment">Комментарий</label>
        </div>
      </div>
      <button class="lkmodal__form-submit" id="editadress-submit">Добавить</button>
    </div>
  </div>
</div>

<!-- Модалка подтверждения -->
<div class="lkmodal" id="editadress_ok">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      <span id="editadress-ok-title">Готово!</span>
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">
        Готово!
      </p>
      <p class="lkmodal__done-txt" id="editadress-ok-msg">
        Адрес успешно сохранён
      </p>
      <a href="#" class="lkmodal__form-submit js--close">Закрыть</a>
    </div>
  </div>
</div>

<div class="lkmodal" id="deleteadress">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Удалить адрес
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">
        Подтверждение
      </p>
      <p class="lkmodal__done-txt">
        Вы уверены, что хотите удалить этот адрес?
      </p>
      <a href="#" class="lkmodal__form-submit">
        Удалить
      </a>
    </div>
  </div>
</div>

<div class="lkmodal" id="deleteadress_ok">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Удалить адрес
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">
        Готово!
      </p>
      <p class="lkmodal__done-txt">
        Адрес успешно удалён
      </p>
      <a href="#" class="lkmodal__form-submit">
        Перейти в профиль
      </a>
    </div>
  </div>
</div>

<div class="lkmodal" id="cancel">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Отмена заказа
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__cancel">
      <p class="lkmodal__cancel-title">
        Укажите причину отмены заказа
      </p>
      <div class="lkmodal__cancel-list">
        <div class="lkmodal__cancel-item">
          <input type="radio" name="rulesofcanceled" id="rulesofcanceled-1">
          <label for="rulesofcanceled-1">
            Товар больше не нужен
          </label>
        </div>
        <div class="lkmodal__cancel-item">
          <input type="radio" name="rulesofcanceled" id="rulesofcanceled-2">
          <label for="rulesofcanceled-2">
            скидка не применяется к заказу
          </label>
        </div>
        <div class="lkmodal__cancel-item">
          <input type="radio" name="rulesofcanceled" id="rulesofcanceled-3">
          <label for="rulesofcanceled-3">
            не подходят способы доставки
          </label>
        </div>
        <div class="lkmodal__cancel-item">
          <input type="radio" name="rulesofcanceled" id="rulesofcanceled-4">
          <label for="rulesofcanceled-4">
            заказ создан по ошибке
          </label>
        </div>
        <div class="lkmodal__cancel-item">
          <input type="radio" name="rulesofcanceled" id="rulesofcanceled-5">
          <label for="rulesofcanceled-5">
            другая причина
          </label>
        </div>
      </div>
      <a href="#" class="lkmodal__form-submit">
        Отменить
      </a>
    </div>
  </div>
</div>

<div class="lkmodal" id="cancel_ok">
  <div class="lkmodal__header">
    <p class="lkmodal__title">
      Отмена заказа
    </p>
    <button class="lkmodal__close js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
      </svg>
    </button>
  </div>
  <div class="lkmodal__body">
    <div class="lkmodal__done">
      <p class="lkmodal__done-title">
        Готово!
      </p>
      <p class="lkmodal__done-txt">
        Заказ отменён. Деньги вернуться на ваш счёт
      </p>
      <a href="#" class="lkmodal__form-submit">
        Перейти в профиль
      </a>
    </div>
  </div>
</div>


<div class="cartaler">
  <div class="cartaler__header">
    <p class="cartaler__header-title">
      Товар добавлен в корзину
    </p>
    <button class="cartaler__close js--close">
      <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15 17.3331L10 10.6664M5 3.99976L10 10.6664M10 10.6664L15 3.99976M10 10.6664L5 17.3331" stroke="#232229"
              stroke-width="1.5"/>
      </svg>

    </button>
  </div>
  <div class="cartaler__main">
    <div class="cartaler__img">
      <img src="/html/assets/img/modal-prod.c2771fc9b14c1d861b3d.jpg" alt="Название товара">
    </div>
    <div class="cartaler__content">
      <p class="cartaler__title">
        Сарафан молочный с цветочным принтом
      </p>
      <div class="cartaler__footer">
        <div class="cartaler__price">
          <p class="cartaler__price-old">
            16 000₽
          </p>
          <p class="cartaler__price-current">
            12 000₽
            <span>-25%</span>
          </p>
        </div>
        <p class="cartaler__info">
          Цвет:
          Розовый <br>
          Размер:
          М
        </p>
      </div>
    </div>
  </div>
</div>

</body>

</html>
