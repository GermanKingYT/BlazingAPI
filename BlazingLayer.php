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

    function __construct()
    {
        parent::__construct();
        $this->url = 'https://api.blazinglayer.co.uk/v2/';
        $this->token = 'YOUR PRIVATE TOKEN';
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
            curl_setopt($ch, CURLOPT_POSTFIELDS,$variables);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        else:
            return false;
        endif;
    }
}