<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)) {
    $APPLICATION->SetTitle("Конструктор");
    $APPLICATION->SetPageProperty('description', 'Конструктор комплекта для ведра в колодец');  
}
?>

    <div class="page-top">
        <div class="container">
            <div class="page-top__inner">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                );
                ?>
                <h1><?= !empty($metaTags['TITLE']) ? $metaTags['TITLE'] : 'Конструктор комплекта для ведра в колодец' ?></h1>
            </div>
        </div>
    </div>

    <div class="quiz">
        <div class="container">
            <div class="row">
                <form action="">
                    <div class="col-12">
                        <div class="quiz__question">
                            <div class="quiz__question-title">Вопрос 1</div>
                            <div class="quiz__question-fields">
                                <div class="quiz__question-fields-title">Выберите вес ведра с водой</div>
                                <div class="quiz__question-label">
                                    <label for="qq1">
                                        <input type="radio" name="qqg1" id="qq1">
                                        <span>До 10 л</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq2">
                                        <input type="radio" name="qqg1" id="qq2">
                                        <span>От 10-15 л</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq3">
                                        <input type="radio" name="qqg1" id="qq3">
                                        <span>От 15-25 л</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq4">
                                        <input type="radio" name="qqg1" id="qq4">
                                        <span>От 25-50 л</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq5">
                                        <input type="radio" name="qqg1" id="qq5">
                                        <span>От 50+ л</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="quiz__question">
                            <div class="quiz__question-title">Вопрос 2</div>
                            <div class="quiz__question-fields">
                                <div class="quiz__question-fields-title">Укажите глубину колодца</div>
                                <div class="quiz__question-label">
                                    <label for="qq6">
                                        <input type="radio" name="qqg2" id="qq6">
                                        <span>До 5 м.</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq7">
                                        <input type="radio" name="qqg2" id="qq7">
                                        <span>До 10 м.</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq8">
                                        <input type="radio" name="qqg2" id="qq8">
                                        <span>До 15 м.</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq9">
                                        <input type="radio" name="qqg2" id="qq9">
                                        <span>До 20 м.</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq10">
                                        <input type="radio" name="qqg2" id="qq10">
                                        <span>25 м.</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq11">
                                        <input type="radio" name="qqg2" id="qq11">
                                        <span>30 м.</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="quiz__question">
                            <div class="quiz__question-title">Вопрос 3</div>
                            <div class="quiz__question-fields">
                                <div class="quiz__question-fields-title">Укажите материал, в который будет крепиться трос</div>
                                <div class="quiz__question-label">
                                    <label for="qq12">
                                        <input type="radio" name="qqg3" id="qq12">
                                        <span>Крепление в дерево</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq13">
                                        <input type="radio" name="qqg3" id="qq13">
                                        <span>Крепление в бетон</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq14">
                                        <input type="radio" name="qqg3" id="qq14">
                                        <span>Сквозное крепление или отверстие с резьбой М8</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="quiz__question">
                            <div class="quiz__question-title">Вопрос 4</div>
                            <div class="quiz__question-fields">
                                <div class="quiz__question-fields-title">Понадобится ли Вам оснастка для сверления отверстия?</div>
                                <div class="quiz__question-label">
                                    <label for="qq15">
                                        <input type="radio" name="qqg4" id="qq15">
                                        <span>Да</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                                <div class="quiz__question-label">
                                    <label for="qq16">
                                        <input type="radio" name="qqg4" id="qq16">
                                        <span>Нет</span>
                                        <div class="quiz__question-label-list">
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">АРТ 8379 А2 Трос средней мягкости 3 мм</span>
                                            </a>
                                            <a href="#" class="quiz__question-card">
                                                <span class="quiz__question-card-image">
                                                    <img src="https://krepfield.ru/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="">
                                                </span>
                                                <span class="quiz__question-card-text">ART 8281 А4 Петля (обух) для обжима на трос 3 мм</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="quiz__result">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="quiz__result-wrapper">
                        <div class="quiz__result-title">
                            <strong>Выбранные товары</strong>
                            <div class="quiz__result-navigation">
                                <div class="quiz__result-prev">
                                    <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.801617 6.53033C0.508723 6.23744 0.508723 5.76256 0.801617 5.46967L5.57459 0.696699C5.86748 0.403806 6.34235 0.403806 6.63525 0.696699C6.92814 0.989593 6.92814 1.46447 6.63525 1.75736L2.39261 6L6.63525 10.2426C6.92814 10.5355 6.92814 11.0104 6.63525 11.3033C6.34235 11.5962 5.86748 11.5962 5.57459 11.3033L0.801617 6.53033ZM11 6.75L1.33195 6.75V5.25L11 5.25V6.75Z"/>
                                    </svg>
                                </div>
                                <div class="quiz__result-next">
                                    <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.1984 6.53033C10.4913 6.23744 10.4913 5.76256 10.1984 5.46967L5.42541 0.696699C5.13252 0.403806 4.65765 0.403806 4.36475 0.696699C4.07186 0.989593 4.07186 1.46447 4.36475 1.75736L8.60739 6L4.36475 10.2426C4.07186 10.5355 4.07186 11.0104 4.36475 11.3033C4.65765 11.5962 5.13252 11.5962 5.42541 11.3033L10.1984 6.53033ZM0 6.75L9.66805 6.75V5.25L0 5.25L0 6.75Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="slick-quiz">
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                            <div class="catalog__item">
                                <div class="catalog__item-fav">
                                    <svg>
                                        <use xlink:href="#like"></use>
                                    </svg>
                                </div>
                                <a class="catalog__item-img" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <img src="/upload/resize_cache/af_webp/iblock/d6b/327_332_1/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3.webp" alt="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3" title="DIN 933 БОЛТ С шестигранной головкой Полная резьба M8х100 А2-8-К3 в интернет-магазине Krepfield">
                                </a>
                                <a class="catalog__item-title" title="Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба" href="/product/din_933_bolt_s_shestigrannoy_golovkoy_polnaya_rezba_m8kh100_a2_8_k3/">
                                    <span>Болт Нержавеющий M8х100 мм DIN 933 А2 с шестигранной головкой полная резьба</span>
                                </a>
                                <div class="catalog__item-bottom">
                                    <div class="catalog__item-price">
                                        <div class="catalog__item-price-old" style="display: none;">581</div>
                                        <div class="catalog__item-price-now">581</div>
                                    </div>
                                    <div class="catalog__item-nb">за 1 уп</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="button button-black">ПЕРЕЙТИ В КОРЗИНУ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");