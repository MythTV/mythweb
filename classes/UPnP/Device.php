<?php

class UPnP_Device {
    private $data = '';


    function __construct($connection) {
        while (!feof($connection))
            $this->data .= fgets($connection);
        fclose($connection);
    }

    function getData() {
        return $this->data;
    }
}
