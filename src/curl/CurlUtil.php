<?php

namespace Fc\Utils\Curl;

class CurlUtil
{
    public static function normalPost($url, $data = null, $headers = null)
    {
        return self::curl($url, $headers, 'POST', $data);
    }

    public static function normalGet($url, $headers = null)
    {
        return self::curl($url, $headers);
    }

    public static function normalProxyGet($url, $headers = null)
    {
        return self::proxyCurl($url, $headers, 'GET');
    }

    public static function normalProxyPost($url, $data, $headers = null)
    {
        return self::proxyCurl($url, $headers, 'POST', $data);
    }

    public static function post($url, $data = null, $headers = null)
    {
        return json_decode(self::curl($url, $headers, 'POST', $data));
    }

    public static function get($url, $headers = null)
    {
        return json_decode(self::curl($url, $headers));
    }

    public static function proxyGet($url, $headers = null)
    {
        return json_decode(self::proxyCurl($url, $headers, 'GET'));
    }

    public static function proxyPost($url, $data, $headers = null)
    {
        return json_decode(self::proxyCurl($url, $headers, 'POST', $data));
    }

    private static function curl($url, $headers = null, $method = 'GET', $data = null)
    {
        // 1. 初始化
        $ch = curl_init();
        // 2. 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 30);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36");

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        if ($output === FALSE) {
            echo "CURL Error:" . curl_error($ch);
        }

        // 4. 释放curl句柄
        curl_close($ch);

        return $output;
    }

    private static function proxyCurl($url, $headers = null, $method = 'GET', $data = null)
    {
        $host = env('PROXY_HOST');
        $port = env('PROXY_PORT');
        $user = env('PROXY_USER');
        $password = env('PROXY_PASSWORD');
        $usernameAndPassword = $user . ":" . $password;

        // 1. 初始化
        $ch = curl_init();
        // 2. 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 30);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36");

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $usernameAndPassword);
        curl_setopt($ch, CURLOPT_PROXY, $host);     //代理服务器地址
        curl_setopt($ch, CURLOPT_PROXYPORT, $port); //代理服务器端口

        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        if ($output === FALSE) {
            echo "CURL Error:" . curl_error($ch);
        }

        // 4. 释放curl句柄
        curl_close($ch);

        return $output;

    }
}