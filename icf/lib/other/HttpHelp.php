<?php
/**
 *============================
 * author:Farmer
 * time:2018/1/7
 * blog:blog.icodef.com
 * function:HTTP协议
 *============================
 */


namespace icf\lib\other;


class HttpHelp {
    private static $httpVersion = "HTTP/1.1";

    public static function setStatusCode($statusCode) {
        $statusMessage = self::getHttpStatusMessage($statusCode);
        header(self::$httpVersion . " " . $statusCode . " " . $statusMessage);
    }

    private static $contentType = [
        'html' => 'text/html', 'json' => 'application/json', 'jpg' => 'image/jpeg',
        'png' => 'image/png', 'gif' => 'image/gif', 'xml' => 'text/xml'
    ];

    public static function setContentType($type = 'html') {
        header('Content-Type:' . self::$contentType[$type] . '; charset=utf-8');
    }

    public static function getHeaderVal($key) {
        if (isset($_SERVER['HTTP_' . strtoupper($key)])) {
            return $_SERVER['HTTP_' . strtoupper($key)];
        }
        return false;
    }

    public static function getHttpStatusMessage($statusCode) {
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }
}