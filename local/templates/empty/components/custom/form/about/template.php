<div class="fr">
    <form id="form_<?= $arParams["TOKEN"] ?>">
        <div class="fr__title">Остались вопросы?</div>
        <div class="fr__tx">Напишите нам, мы всегда рады помочь!</div>
        <input type="text" id="name_<?= $arParams["TOKEN"] ?>" placeholder="Имя" required>
        <input class="phone-mask" id="phone_<?= $arParams["TOKEN"] ?>" type="text" placeholder="+7(___) --- -- --"
               required>
        <textarea id="question_<?= $arParams["TOKEN"] ?>" placeholder="Вопрос" required></textarea>
        <button class="button button-black" id="submit_<?= $arParams["TOKEN"] ?>" type="submit">Задать вопрос</button>
        <div class="fr__inf">Нажимая кнопку, я даю согласие на обработку своих персональных данных в
            соответствии с <a href="<?= SITE_DIR ?>policy/" target="_blank">Политикой конфиденциальности</a></div>
    </form>
</div>

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
                data.append("PHONE", $("#phone_<?=$arParams['TOKEN']?>").val());
                data.append("NAME", $("#name_<?=$arParams['TOKEN']?>").val());
                data.append("FORM_NAME", "<?=$arParams['FORM_NAME']?>");
                data.append("URL", "<?=$APPLICATION->GetCurDir()?>");
                data.append("QUESTION", $("#question_<?=$arParams['TOKEN']?>").val());
                $.ajax({
                    method: "post",
                    url: "<?=$APPLICATION->GetCurDir()?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        data = JSON.parse(data);
                        if (data.status == true) {
                            ym(90913671,'reachGoal','ostalis-voprosu')
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