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
        $info = @file_get_contents("http://$ip/Myth/GetConnectionInfo?Pin=");
        if (!$info)
            return false;

		if (class_exists('SimpleXMLElement')) {
			$data = new SimpleXMLElement($info);
			return array(
				'host' => (string)$data->Database->Host[0],
				'port' => (string)$data->Database->Port[0],
				'user' => (string)$data->Database->UserName[0],
				'pass' => (string)$data->Database->Password[0],
				'name' => (string)$data->Database->Name[0]);
		}

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

        // Try ipv6
        if (!is_array($devices) || count($devices) == 0) {
            $devices = self::discoverRaw($schema, $ipCount, 'ipv6');
        }

        // Fail :(
        if (!is_array($devices) || count($devices) == 0) {
            return false;
        }

        foreach ($devices as $device) {
            preg_match('/LOCATION: http:\/\/(.*):([0-9]+).*/', $device, $matches);
			$ips[] = [$matches[1], $matches[2]];
        }

		if (count($ips) == 0)
			return false;

        if ($ipCount == 1) {
            $ip = $ips[0][0];
            $port = $ips[0][1];
            return "$ip:$port";
        }

        $ret = array();
        foreach ($ips as $ip) {
            $ret[] = "{$ip[0]}:{$ip[1]}";
            $ipCount--;
            if ($ipCount == 0)
                break;
        }
        return $ret;
    }

    static function discoverRaw ($schema = null, $count = 9999, $type = 'ipv4') {
        if (!function_exists('socket_create'))
            return false;

        $port = self::$minPort;

        switch ($type) {
            case 'ipv4':
                $domain = AF_INET;
                $type = SOCK_DGRAM;
                $protocol = SOL_UDP;
                $address = '0.0.0.0';
                $upnp_address = '239.255.255.250';
                $upnp_port = 1900;
                break;
            case 'ipv6':
                $domain = AF_INET6;
                $type = SOCK_DGRAM;
                $protocol = SOL_UDP;
                $address = '::';
                $upnp_address = 'FF08::C';
                $upnp_port = 1900;
                break;
			default:
				return false;
        }

    // Prep to receive UPnP data
        while ($port < self::$maxPort) {
            $valid = true;
            $socket = socket_create($domain, $type, $protocol);
            $valid = @socket_bind($socket, $address, $port);
            if ($valid)
                break;
            socket_close($socket);
            $port++;
        }
        if (!$valid) {
            return false;
        }

    // Send a discovery
        $out  = "M-SEARCH * HTTP/1.1\r\n";
        $out .= "HOST: {$upnp_address}:{$port}\r\n";
        $out .= "MAN: \"ssdp:discover\"\r\n";
        $out .= "MX: ".self::$timeout."\r\n";
        $out .= "ST: $schema\r\n";
        $out .= "USER-AGENT: MythWEB\r\n";
        $out .= "\r\n";
        $res = @socket_sendto($socket, $out, strlen($out), 0, $upnp_address, $upnp_port);

    // Await replies
        $devices = array();

		if ($res === false)
			return $devices;

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
