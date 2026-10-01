<?php
// Fonction pour valider une URL. Fonctionne avec les URL contenant des caractères spéciaux comme les accents.
function validerUrl(string $url) {
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}