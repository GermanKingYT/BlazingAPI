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
    $my = $api->myservers('vps');
    echo $my['data']['token'];
} catch (Exception $e) {
    print_r($e->getMessage());
}