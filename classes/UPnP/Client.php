<?php

class UPnP_Client {
    static $ip = '239.255.255.250';
    static $minPort = '1900';
    static $maxPort = '1910';
    static $timeout = 1;
    static $maxPacketSize = 10240;

    static function discover($schema = null) {
    }

    static function discoverDatabase() {
        $ip = UPnP_Client::discoverIps('urn:schemas-mythtv-org:device:MasterMediaServer:1', 1);
        $info = file_get_contents("http://$ip/Myth/GetConnectionInfo?Pin=");
        preg_match('/<Database><Host>(.*)<\/Host><Port>(.*)<\/Port><UserName>(.*)<\/UserName><Password>(.*)<\/Password><Name>(.*)<\/Name><Type>.*<\/Type><\/Database>/', $info, $matches);
        return array(
            'host' => $matches[1],
            'port' => $matches[2],
            'user' => $matches[3],
            'pass' => $matches[4],
            'name' => $matches[5]);
    }

    static function discoverIps($schema = null, $ipCount = 1) {
        $devices = self::discoverRaw($schema, $ipCount);

        foreach ($devices as $device) {
            preg_match('/LOCATION: http:\/\/(.*):([0-9]+).*/', $device, $matches);
            $ips[$matches[1]] = $matches[2];
        }

        if ($ipCount == 1) {
            reset($ips);
            $ip = key($ips);
            $port = current($ips);
            return "$ip:$port";
        }

        $ret = array();
        foreach ($ips as $ip => $port) {
            $ret[] = "$ip:$port";
            $ipCount--;
            if ($ipCount == 0)
                break;
        }
        return $ret;
    }

    static function discoverRaw ($schema = null, $count = 9999) {
        if (!function_exists('socket_create'))
            return false;

        $port = self::$minPort;

    // Prep to receive UPnP data
        while ($port < self::$maxPort) {
            $valid = true;
            $socket = socket_create(AF_INET,SOCK_DGRAM,SOL_UDP);
            socket_bind($socket,'0.0.0.0', $port) or $valid = false;
            if ($valid)
                break;
            socket_close($socket);
            $port++;
        }

    // Send a discovery
        $out  = "M-SEARCH * HTTP/1.1\r\n";
        $out .= "HOST: 239.255.255.250:$port\r\n";
        $out .= "MAN: \"ssdp:discover\"\r\n";
        $out .= "MX: ".self::$timeout."\r\n";
        $out .= "ST: $schema\r\n";
        $out .= "USER-AGENT: MythWEB\r\n";
        $out .= "\r\n";
        socket_sendto($socket, $out, strlen($out), 0, '239.255.255.250', 1900);

    // Await replies
        $devices = array();
        $startTime = time();
        while (time() - $startTime < self::$timeout) {
            $read = array($socket);
            $write = array();
            $except = array();
            @socket_recv($socket, $data, 1024, MSG_DONTWAIT);
            $data = trim($data);
            if (is_null($data) || strlen($data) == 0)
                usleep(10000);
            else
                $devices[] = $data;
            if (count($devices) >= $count)
                break;
        }
        socket_close($socket);
        return $devices;
    }
}
