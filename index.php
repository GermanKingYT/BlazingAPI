<?php
/**
 * Created by PhpStorm.
 * User: XARON
 * Date: 24.11.2017
 * Time: 08:04
 */

require_once('src/BlazingLayer.php');

try {
    $api = new BlazingLayer('YOUR PRIVATE TOKEN');
    $my = $api->getMyServers('vps');
    echo $my;
} catch (Exception $e) {
    print_r($e->getMessage());
}