<?php

namespace KhidirDotID\Nicepay;

use KhidirDotID\Nicepay\NicepayConfig;

class NicepayRequestor
{
    public $sock = 0;
    public $port = 443;
    public $status;
    public $headers = '';
    public $body = '';
    public $errorcode;
    public $errormsg;

    public function openSocket($apiUrl)
    {
        $host = parse_url($apiUrl, PHP_URL_HOST);
        $tryCount = 0;
        if (!$this->sock = @fsockopen('ssl://' . $host, $this->port, $errno, $errstr, NicepayConfig::NICEPAY_TIMEOUT_CONNECT)) {
            while ($tryCount < 5) {
                if ($this->sock = @fsockopen('ssl://' . $host, $this->port, $errno, $errstr, NicepayConfig::NICEPAY_TIMEOUT_CONNECT)) {
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

    public function apiRequest($apiUrl, $data)
    {
        $this->openSocket($apiUrl);

        $host = parse_url($apiUrl, PHP_URL_HOST);
        $uri = parse_url($apiUrl, PHP_URL_PATH);
        $this->headers = '';
        $this->body = '';
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
        if ($this->sock) {
            fwrite($this->sock, $request);

            /* Read */
            stream_set_blocking($this->sock, FALSE);

            $atStart = true;
            $IsHeader = true;
            $timeout = false;
            $start_time = time();
            while (!feof($this->sock) && !$timeout) {
                $line = fgets($this->sock, 4096);
                $diff = time() - $start_time;
                if ($diff >= NicepayConfig::NICEPAY_TIMEOUT_READ) {
                    $timeout = true;
                }
                if ($IsHeader) {
                    if ($line == '') // for stream_set_blocking
                    {
                        continue;
                    }
                    if (substr($line, 0, 2) == "\r\n") // end of header
                    {
                        $IsHeader = false;
                        continue;
                    }
                    $this->headers .= $line;
                    if ($atStart) {
                        $atStart = false;
                        if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
                            $this->errormsg = 'Status code line invalid: ' . htmlentities($line);
                            fclose($this->sock);
                            return false;
                        }
                        $http_version = $m[1];
                        $this->status = $m[2];
                        $status_string = $m[3];
                        continue;
                    }
                } else {
                    $this->body .= $line;
                }
            }
            fclose($this->sock);

            if ($timeout) {
                $this->errorcode = NicepayConfig::NICEPAY_READ_TIMEOUT_ERR;
                $this->errormsg = 'Socket Timeout (' . $diff . ' sec)';
                return false;
            }

            if (!$this->parseResult($this->body)) {
                $this->body = substr($this->body, 4);

                return $this->parseResult($this->body);
            }
            return $this->parseResult($this->body);
        } else {
            // echo 'Connection Timeout. Please retry.;
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
