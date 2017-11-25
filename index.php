<?php
/**
 * Created by PhpStorm.
 * User: XARON
 * Date: 24.11.2017
 * Time: 08:04
 */

require_once('src/BlazingLayer.php');

try {
    $api = new BlazingLayer('TEST');
    $my = $api->getMyServers('vps');
    echo $my['data']['token'];
} catch (Exception $e) {
    print_r($e->getMessage());
}


public function power($id, $action)
{
    $check = (in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
    if($check):
        $data = $this->connect(array('get' => 'myservers', 'type' => $type), $this->url.$id.'/'.$action);
        return $data;
    else:
        return false;
    endif;
}