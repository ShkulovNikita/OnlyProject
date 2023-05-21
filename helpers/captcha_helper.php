<?php
/* Код для проверки капчи из документации Яндекса (отредактирован)
https://cloud.yandex.ru/docs/smartcaptcha/quickstart */

define('SMARTCAPTCHA_SERVER_KEY', '<ключ_сервера>');

// выполнение запроса к Яндексу
function check_captcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP-адрес пользователя.
                                         // Способ получения IP-адреса пользователя зависит от вашего прокси.
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}

// проверка капчи
function check_captcha_passed() {
    // проверка поля токена на пустоту (пользователь не нажал на капчу)
    if (!isset($_POST['smart-token']))
        return "Пройдите капчу";
    if (empty($_POST['smart-token']))
        return 'Пройдите капчу';

    $token = $_POST['smart-token'];
    if (check_captcha($token)) {
        return "Passed";
    } else {
        return "Не удалочь пройти капчу";
    }
}
?>