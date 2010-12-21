<?php

class UPnP_Client {
    static $ip = '239.255.255.250';
    static $port = '1900';
    static $timeout = 3;
    static $maxPacketSize = 10240;

    static function discover($schema = null) {
    }

    static function discoverIps($schema = null, $ipCount = 1) {
        $ips = self::discoverRaw($schema, $ipCount);
        var_dump($ips);
        if ($ipCount == 1)
            return substr($ips[0]['peer'], 0, strpos($ips[0]['peer'], ':'));
        $ret = array();
        return $ret;
    }

    static function discoverRaw ($schema = null, $count = null) {
    // Prep to receive UPnP data
        $socket = stream_socket_server('udp://0.0.0.0:1900', $errno, $errstr, STREAM_SERVER_BIND);
        if (!$socket) die("$errstr ($errno)");
        $write = stream_socket_client('udp://239.255.255.250:1900', $errno, $errstr);
        if (!$write) die("$errstr ($errno)");

    // Send a discovery
        $out = "M-SEARCH * HTTP/1.1\r\n";
        $out .= "Host: 239.255.255.250:1900\r\n";
        $out .= "ST:$schema\r\n";
        $out .= "Man:\"ssdp:discover\"\r\n";
        $out .= "MX:".self::$timeout."\r\n";
        $out .= "\r\n";
        fwrite($write, $out);

    // Await replies
        $devices = array();
        $startTime = time();
        while (time() - $startTime < self::$timeout) {
            $read = array($socket);
            $write = array();
            $except = array();
            $pending = stream_select($read, $write, $except, 0, 0);
            if ( $pending > 0 ) {
                $pkt = stream_socket_recvfrom($socket, self::$maxPacketSize, 0, $peer);
                if ($pkt !== false) {
                    $devices[] = array('peer' => $peer, 'pkt' => $pkt);
                    if (!is_null($count) && $count >= count($devices))
                        break;
                }
            }
            usleep(100000);
        }
        stream_socket_shutdown($socket, STREAM_SHUT_RDWR);
        return $devices;
    }
}
