<?php

namespace Fc\Utils\Small;

class UR
{
    public static function success($content = '', $message = '请求成功')
    {
        $data = array();

        $data['code'] = 0;
        $data['message'] = $message;
        $data['content'] = $content;

        return $data;
    }

    public static function fail($message = '请求失败', $code = null, $content = '')
    {
        $error = array();

        if ($code != null) {
            $error['code'] = $code;
        } else {
            $error['code'] = -1;
        }

        $error['message'] = $message;
        $error['content'] = $content;

        return $error;
    }

}