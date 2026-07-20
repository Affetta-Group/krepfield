<form id="form_<?= $arParams["TOKEN"] ?>">
    <div class="form">
        <div class="form-row">
            <div class="form-cell">
                <label for="name-call">Имя</label>
                <input id="name-call" placeholder="Имя" required>
            </div>
            <div class="form-cell">
                <label for="tel-call">Телефон</label>
                <input class="phone-mask" id="tel-call" placeholder="+7(___) --- -- --" required>
            </div>
            <div class="form-cell">
                <button class="button button-primary" id="submit_<?= $arParams["TOKEN"] ?>" type="submit">ОТПРАВИТЬ
                    ЗАЯВКУ
                </button>
                <div class="form-cell-tx">Нажимая кнопку «Отправить заявку», я даю согласие
                    на обработку своих персональных данных в соответствии с <a href="<?= SITE_DIR ?>policy/"
                                                                               target="_blank">Политикой
                        конфиденциальности</a></div>
            </div>
        </div>
    </div>
</form>

<script type="application/javascript">
    "use strict";
    $(() => {
        $("#submit_<?=$arParams['TOKEN']?>").click(e => {
            e.preventDefault();
            let status = true;
            $("#form_<?=$arParams['TOKEN']?>").find("*[required]").each((index, el) => {
                if ($(el).val() === "") {
                    $(el).css({"border": "1px solid red"})
                    status = false
                } else {
                    $(el).css({"border": "unset"})
                }
            });
            if (status) {
                let data = new FormData;
                data.append("TOKEN", "<?=$arParams['TOKEN']?>");
                data.append("PHONE", $("#tel-call").val());
                data.append("FORM_NAME", "<?=$arParams['FORM_NAME']?>");
                data.append("URL", "<?=$APPLICATION->GetCurDir()?>");
                data.append("NAME", $("#name-call").val());
                $.ajax({
                    method: "post",
                    url: "<?=$APPLICATION->GetCurDir()?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        data = JSON.parse(data);
                        if (data.status === true) {
                            ym(90913671,'reachGoal','zakazat-zvonok')
                            $('#modalCall').modal('hide');
                            $('#modalZv').modal('show').on('hidden.bs.modal', () => {
                                location.reload();
                            });
                        }
                    }
                });
            }
        });
    });
</script>