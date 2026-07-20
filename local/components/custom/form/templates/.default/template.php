<?
/**
 * @var $APPLICATION
 * @var $templateFolder
 * @var $arParams
 * @var $arResult
 */

$asset = \Bitrix\Main\Page\Asset::getInstance();
$asset->addCss($templateFolder. '/css/bootstrap.min.css');
$asset->addJs($templateFolder. '/js/bootstrap.min.css');
$asset->addJs($templateFolder. '/js/jquery-3.4.1.min.js');
$asset->addCss($templateFolder. '/css/datepicker/bootstrap-datepicker.standalone.min.css');
$asset->addJs($templateFolder. '/js/datepicker/bootstrap-datepicker.min.js');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <form id="form_<?=$arParams['TOKEN']?>"  enctype="multipart/form-data" type="post">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="name_<?=$arParams['TOKEN']?>">First name</label>
                            <input class="form-control" type="text" placeholder="First name" id="name_<?=$arParams['TOKEN']?>" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid name.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone_<?=$arParams['TOKEN']?>">Phone</label>
                            <input class="form-control" type="tel" placeholder="Phone" id="phone_<?=$arParams['TOKEN']?>" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid phone.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email_<?=$arParams['TOKEN']?>">E-mail</label>
                            <input class="form-control" type="email" placeholder="E-mail" id="email_<?=$arParams['TOKEN']?>" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid e-mail.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="message_<?=$arParams['TOKEN']?>">Message</label>
                            <textarea class="form-control" placeholder="Message" name="" rows="5" id="message_<?=$arParams['TOKEN']?>" required></textarea>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid message.
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 custom-file">
                        <input type="file" class="custom-file-input" id="file_<?=$arParams['TOKEN']?>" required>
                        <label class="custom-file-label" for="file_<?=$arParams['TOKEN']?>">Choose file...</label>
                    </div>
                    <div class="form-row align-items-center">
                        <div class="col-md-4 mb-3 date">
                            <label class="sr-only" for="date_<?=$arParams['TOKEN']?>">Date</label>
                            <input type="text" class="form-control" placeholder="Date" id="date_<?=$arParams['TOKEN']?>" required>
                            <span class="input-group-addon"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="sr-only" for="select_<?=$arParams['TOKEN']?>">Preference</label>
                            <select class="custom-select" id="select_<?=$arParams['TOKEN']?>"  required>
                                <? foreach($arResult["PROPERTY_SELECT"] as $id => $value): ?>
                                    <option value="<?= $id ?>"><?= $value ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkbox_<?=$arParams['TOKEN']?>" required>
                                <label class="custom-control-label" for="checkbox_<?=$arParams['TOKEN']?>">Check</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" id="button_<?=$arParams['TOKEN']?>" >Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="application/javascript">
    `use strict`;

    $(() => {
        $(`#date_<?=$arParams['TOKEN']?>`).closest(`.date`).datepicker({
            format: `dd.mm.yyyy`,
        });

        $(`#file_<?=$arParams['TOKEN']?>`).change(e => {
            $(e.currentTarget).next(`label`).html(e.currentTarget.files[0].name);
        });

        $(`#button_<?=$arParams['TOKEN']?>`).click(e => {
            e.preventDefault();
            let status = true;
            $(`#form_<?=$arParams['TOKEN']?>`).find(`*[required]`).each((index, el) => {
                if ($(el).val() === `` || ($(el).is(`:not(:checked)`) && $(el).is(`:checkbox`))) {
                    $(el).removeClass(`is-valid`);
                    $(el).addClass(`is-invalid`);
                    status = false
                } else {
                    $(el).addClass(`is-valid`);
                    $(el).removeClass(`is-invalid`);
                }
            });
            if (status) {
                let file_input = $(`#file_<?=$arParams['TOKEN']?>`);
                let data = new FormData;
                data.append(`DOCUMENT`, file_input.prop(`files`)[0]);
                data.append(`TOKEN`, `<?=$arParams['TOKEN']?>`);
                data.append(`EMAIL`, $(`#email_<?=$arParams['TOKEN']?>`).val());
                data.append(`NAME`, $(`#name_<?=$arParams['TOKEN']?>`).val());
                data.append(`PHONE`, $(`#phone_<?=$arParams['TOKEN']?>`).val());
                data.append(`MESSAGE`, $(`#message_<?=$arParams['TOKEN']?>`).val());
                data.append(`SELECT`, $(`#select_<?=$arParams['TOKEN']?>`).val());
                data.append(`DATE`, $(`#date_<?=$arParams['TOKEN']?>`).val());
                data.append(`CHECKBOX`, $(`#checkbox_<?=$arParams['TOKEN']?>`).prop(`checked`));
                data.append(`DETAIL_URL`, `<?=$APPLICATION->GetCurDir()?>`);
                $.ajax({
                    method: `post`,
                    url: `<?=$APPLICATION->GetCurDir()?>`,
                    data: data,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        data = JSON.parse(data);
                        if (data.status == true) {
                            alert(`Success!`);
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>