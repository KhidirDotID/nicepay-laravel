<?php

namespace KhidirDotID\Nicepay;

use KhidirDotID\Nicepay\NicepayConfig;

class NicepayRequestor
{
    public $sock = 0;
    public $port = 443;
    public $status;
    public $headers = "";
    public $body = "";
    public $errorcode;
    public $errormsg;

    public function openSocket($apiUrl)
    {
        $host = parse_url($apiUrl, PHP_URL_HOST);
        $tryCount = 0;
        if (!$this->sock = @fsockopen("ssl://" . $host, $this->port, $errno, $errstr, NicepayConfig::NICEPAY_TIMEOUT_CONNECT)) {
            while ($tryCount < 5) {
                if ($this->sock = @fsockopen("ssl://" . $host, $this->port, $errno, $errstr, NicepayConfig::NICEPAY_TIMEOUT_CONNECT)) {
                    return true;
                }
                sleep(2);
                $tryCount++;
            }
            $this->errorcode = $errno;
            switch ($errno) {
                case -3:
                    $this->errormsg = 'Socket creation failed (-3)';
                case -4:
                    $this->errormsg = 'DNS lookup failure (-4)';
                case -5:
                    $this->errormsg = 'Connection refused or timed out (-5)';
                default:
                    $this->errormsg = 'Connection failed (' . $errno . ')';
                    $this->errormsg .= ' ' . $errstr;
            }
            return false;
        }
        return true;
    }

    public static function apiRequest($apiUrl, $data)
    {
        self::openSocket($apiUrl);

        $host = parse_url($apiUrl, PHP_URL_HOST);
        $uri = parse_url($apiUrl, PHP_URL_PATH);
        self::$headers = "";
        self::$body = "";
        $postdata = json_encode($data);

        /* Write */
        $request = "POST " . $uri . " HTTP/1.0\r\n";
        $request .= "Connection: close\r\n";
        $request .= "Host: " . $host . "\r\n";
        $request .= "Content-type: application/json\r\n";
        $request .= "Content-length: " . strlen($postdata) . "\r\n";
        $request .= "Accept: */*\r\n";
        $request .= "\r\n";
        $request .= $postdata . "\r\n";
        $request .= "\r\n";
        if (self::$sock) {
            fwrite(self::$sock, $request);

            /* Read */
            stream_set_blocking(self::$sock, FALSE);

            $atStart = true;
            $IsHeader = true;
            $timeout = false;
            $start_time = time();
            while (!feof(self::$sock) && !$timeout) {
                $line = fgets(self::$sock, 4096);
                $diff = time() - $start_time;
                if ($diff >= NicepayConfig::NICEPAY_TIMEOUT_READ) {
                    $timeout = true;
                }
                if ($IsHeader) {
                    if ($line == "") // for stream_set_blocking
                    {
                        continue;
                    }
                    if (substr($line, 0, 2) == "\r\n") // end of header
                    {
                        $IsHeader = false;
                        continue;
                    }
                    self::$headers .= $line;
                    if ($atStart) {
                        $atStart = false;
                        if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
                            self::$errormsg = "Status code line invalid: " . htmlentities($line);
                            fclose(self::$sock);
                            return false;
                        }
                        $http_version = $m[1];
                        self::$status = $m[2];
                        $status_string = $m[3];
                        continue;
                    }
                } else {
                    self::$body .= $line;
                }
            }
            fclose(self::$sock);

            if ($timeout) {
                self::$errorcode = NicepayConfig::NICEPAY_READ_TIMEOUT_ERR;
                self::$errormsg = "Socket Timeout(" . $diff . "SEC)";
                return false;
            }

            if (!self::parseResult(self::$body)) {
                self::$body =   substr(self::$body, 4);

                return self::parseResult(self::$body);
            }
            return self::parseResult(self::$body);
        } else {
            // echo "Connection Timeout. Please retry.";
            return false;
        }
    }

    public function netCancel()
    {
        return true;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getErrorMsg()
    {
        return $this->errormsg;
    }

    public function getErrorCode()
    {
        return $this->errorcode;
    }

    public function parseResult($result)
    {
        return json_decode($result);
    }
}
