<main class="profile">
    <?require "left-menu.php";?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="address-add-container"><a class="back-button" href="/personal/addresses/"><img
                        src="/assets/img/icons/arrow-left.svg" alt="">
                    <p>Назад</p>
                </a>
                <form class="form form--gap" action="/personal/" method="post">
                    <h1 class="common-profile-title">Новый адрес</h1>
                    <div class="input-container"><label class="input-label" for="title">Название</label>
                        <input required class="input text-field" placeholder="Офис на Остоженке" id="title" name="title">
                    </div>
                    <?/*
                    <div class="input-container"><label class="input-label" for="city">Город</label>
                        <select name="city" id="city" class="select-input ">
                            <option value="Москва">Москва</option>
                            <option value="Санкт-Петербург">Санкт-Петербург</option>
                            <option value="Казань">Казань</option>
                        </select></div>
                    */?>
                    <div class="input-container"><label class="input-label" for="address">Адрес</label><input required
                            class="input text-field" placeholder="г. Москва, улица Большая Никитская, 2, кв. 21" id="address" name="address"></div>
                    <div class="input-container"><label class="input-label" for="comment">Комментарий для
                            курьера</label><textarea class="textarea-input text-field" id="comment"
                                                     placeholder="Позвоните за 2 часа, этаж 2, домофон 54667457" name="comment"></textarea></div>
                    <button class="primary-button" type="submit" >Сохранить</button>
                    <input type="hidden" name="action" value="add_address" />
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#address").suggestions({
            token: "4e33ae3ce19ae013e93d53f621c5fb365b72479d",
            type: "ADDRESS",
            geoLocation: [],
            onSelect: function(suggestion) {
                //console.log(suggestion);
            }
        });
    </script>
</main>