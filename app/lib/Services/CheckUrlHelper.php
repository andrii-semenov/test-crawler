<?php namespace Fizik\Services;

/**
* Хэлпер для парсинга и проверки url-ов.
*
* @param array $allowed_url_schemes содержит список дозволеных протоколов для проверки.
*/
class CheckUrlHelper
{
    protected $allowed_url_schemes = ['http','https', null];

    /**
    * Проверяет валидный ли url и начинается ли он http или https или вообще
    * не содержит указание протокола.
    *
    * @param string $url url для проверки
    * @return bool true если url правильно оформлен и имеет подходящие протоколы
    */
    public function checkUrl(string $url): bool
    {
        $url_parts = parse_url($url);
        return (
            filter_var($url, FILTER_VALIDATE_URL) &&
            (in_array($url_parts['scheme'], $this->allowed_url_schemes) ) //|| ($url_parts['scheme'] == null)
        );
    }


    /**
    * Проверяет валидный ли $url и начинается ли он с $start.
    *
    * @param string $url целевой адрес для проверки
    * @param string $start начало адреса
    * @return bool true если $start в начале $url
    */
    public function checkUrlStartsWith(string $url, string $start): bool
    {
        return (strpos($url, $start) === 0);
    }


    /**
    * Проверяет указывает ли $url на локальное место или является внешним адресом.
    *
    * @param string $url
    * @return bool false если внешний адрес
    */
    public function checkUrlIsLocal(string $url): bool
    {
        $parsed = parse_url($url);
        return (!isset($parsed['host']) &&
                !isset($parsed['scheme']) &&
                isset($parsed['path']) &&
                !preg_match('/mailto:/', $parsed['path']));
    }


    /**
    * Проверяет указывает ли $url на html страницу и не на 404.
    *
    * @param string $url
    * @return bool
    *
    * @todo добавить дополнительные исключения и проверки
    */
    public function checkUrlIsHTML($url): bool
    {
        $headers = @get_headers($url);
        if($headers) {
            foreach($headers as $header) {
                if(strpos($header, 'Content-Type: text/html') !== false) {
                    return true;
                }
                if(strpos($header, '404 Not Found') == true) {
                    return false;
                }
            }
        }
        return false;
    }


    /**
    * Проверяет указывает ли полный $url на локальную html страницу и начинается с $init_url.
    *
    * @param string $url адрес для проверки
    * @param string $init_url адрес домена
    * @return bool
    */
    public function checkLocalUrl(string $url, string $init_url): bool
    {
        return ($this->checkUrl($url) &&
                $this->checkUrlStartsWith($url, $init_url));
    }


    /**
    * Строит адрес, который начинается с $init_url и заканчивается $url.
    *
    * @param string $url адрес-путь
    * @param string $init_url адрес-домен
    * @return string полученный адрес
    *
    * @todo использовать http_build_url
    */
    public function makeFullUrl(string $url, string $init_url): string
    {
        if(strpos($url,'/') === 0) {
            $path = ($url === '/') ? '' : '/'.trim($url, '/');
            $parsed_init = parse_url($init_url);
            $full_url = $parsed_init['scheme'].'://'.$parsed_init['host'].$path;
        }
        else {
            $full_url = $init_url.'/'.trim($url, '/');
        }

        return $full_url;
    }


    /**
    * Проверяет и строит адрес, который начинается с $init_url и заканчивается $url.
    *
    * @param string $url адрес-путь
    * @param string $init_url адрес-домен
    * @return string полученный адрес
    */
    public function makeValidUrl(string $url, string $init_url): string
    {
        if($this->checkUrlIsLocal($url)) {
            return $this->makeFullUrl($url, $init_url);
        }
        return $url;
    }
}
