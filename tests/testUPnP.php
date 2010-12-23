<?php

include('classes/UPnP/Client.php');

var_dump(UPnP_Client::discoverDatabase('urn:schemas-mythtv-org:device:MasterMediaServer:1'));
