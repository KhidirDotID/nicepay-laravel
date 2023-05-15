<?php

namespace KhidirDotID\Nicepay;

use KhidirDotID\Nicepay\NicepayConfig;

class NicepayLogger
{
    public $handle;
    public $type;
    public $log;
    public $debug_mode;
    public $array_key;
    public $debug_msg;
    public $starttime;

    function NicepayLog($log, $mode)
    {
        $this->debug_msg = array('', 'CRITICAL', 'ERROR', 'NOTICE', '4', 'INFO', '6', 'DEBUG', '8');
        $this->debug_mode = $mode;
        $this->log = $log;
        $this->starttime = $this->GetMicroTime();
    }

    function StartLog($dir, $mid)
    {
        if ($this->log == 'false') return true;

        $logfile = $dir . '/logs/' . NicepayConfig::NICEPAY_PROGRAM . '_' . $this->type . '_' . $mid . '_' . date('ymd') . '.log';
        $this->handle = fopen($logfile, 'a+');
        if (!$this->handle) {
            return false;
        }

        $this->WriteLog('START ' . NicepayConfig::NICEPAY_PROGRAM . ' ' . $this->type . ' (V' . NicepayConfig::NICEPAY_VERSION . 'B' . NicepayConfig::NICEPAY_BUILDDATE . '(OS:' . php_uname('s') . php_uname('r') . ',PHP:' . phpversion() . '))');
        return true;
    }

    function CloseNicepayLog($msg)
    {
        $laptime = $this->GetMicroTime() - $this->starttime;
        $this->WriteLog('END ' . $this->type . ' ' . $msg . ' Laptime:[' . round($laptime, 3) . 'sec]');
        $this->WriteLog('===============================================================');
        fclose($this->handle);
    }

    function WriteLog($data)
    {
        if (!$this->handle || $this->log == 'false') return;
        $pfx = ' [' . date('Y-m-d H:i:s') . '] <' . getmypid() . '> ';
        fwrite($this->handle, $pfx . $data . "\r\n");
    }

    function GetMicroTime()
    {
        list($usec, $sec) = explode(' ', microtime(true));
        return (float)$usec + (float)$sec;
    }

    function SetTimestamp()
    {
        $m = explode(' ', microtime());
        list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0] * 1000, 3));
        return date('Y-m-d H:i:s', $totalSeconds) . ':$extraMilliseconds';
    }

    function SetTimestamp1()
    {
        $m = explode(' ', microtime());
        list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0] * 10000, 4));
        return date('ymdHis', $totalSeconds) . '$extraMilliseconds';
    }
}
