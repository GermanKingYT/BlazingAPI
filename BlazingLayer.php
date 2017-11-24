<?php
/**
 * Created by PhpStorm.
 * User: XARON
 * Date: 24.11.2017
 * Time: 08:07
 */

class BlazingLayer
{
    public $url;
    public $token;

    function __construct($token)
    {
        parent::__construct();
        $this->url = 'https://api.blazinglayer.co.uk/v2/';
        $this->token = $token;
    }

    public function hash($token)
    {
        $salt = base64_encode(crypt($token));
        return $salt;
    }

    public function connect($variables)
    {
        $variables = (is_array($variables)) ? true : false;
        if($variables):
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $variables);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Token:'.$this->token.''));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        else:
            return false;
        endif;
    }

    public function getMyServers($type)
    {
        $data = $this->connect(array('get' => 'myservers', 'type' => $type));
        $check = (in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
        if($check):
            return $data;
        else:
            return false;
        endif;
    }
}

//$api = new BlazingLayer('YOUR PRIVATE TOKEN');