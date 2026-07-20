<form id="form_<?= $arParams["TOKEN"] ?>">
	<div class="masters-form__fr-inner">
		<div class="masters-form__fr-row">
			<input type="text" placeholder="Ваше имя" id="name_<?= $arParams["TOKEN"] ?>" required>
			<input type="text" placeholder="Телефон" id="phone_<?= $arParams["TOKEN"] ?>" required>
		</div>
		<div class="masters-form__fr-row">
			<input type="text" placeholder="Направление деятельности" id="conditions_<?= $arParams["TOKEN"] ?>">
			<input type="text" placeholder="E-mail" id="email_<?= $arParams["TOKEN"] ?>" required>
		</div>
		<div class="masters-form__fr-row-bottom">
			<div class="masters-form__fr-row-tx">Нажимая на кнопку «Отправить» вы соглашаетесь<br>
				с <a href="<?= SITE_DIR ?>policy/" target="_blank">Политикой конфиденциальности</a></div>
			<button class="button button-black" type="submit" id="submit_<?= $arParams["TOKEN"] ?>">
				Отправить
				<svg>
					<use xlink:href="#arrow" class="icon"></use>
				</svg>
			</button>
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
				data.append("EMAIL", $("#email_<?=$arParams['TOKEN']?>").val());
				data.append("NAME", $("#name_<?=$arParams['TOKEN']?>").val());
                data.append("FORM_NAME", "<?=$arParams['FORM_NAME']?>");
                data.append("URL", "<?=$APPLICATION->GetCurDir()?>");
				data.append("PHONE", $("#phone_<?=$arParams['TOKEN']?>").val());
				data.append("DIRECTION", $("#conditions_<?=$arParams['TOKEN']?>").val());
				$.ajax({
					method: "post",
					url: "<?=$APPLICATION->GetCurDir()?>",
					data: data,
					contentType: false,
					processData: false,
					success: (data) => {
						data = JSON.parse(data);
						if (data.status == true) {
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