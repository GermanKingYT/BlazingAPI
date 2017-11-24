<?php
/**
 * Created by PhpStorm.
 * User: XARON
 * Date: 24.11.2017
 * Time: 08:07
 */


// UNDER DEVELOPMENT! //
// UNDER DEVELOPMENT! //
// UNDER DEVELOPMENT! //


class BlazingLayer
{
    public $url;
    public $token;
    public $endpoint;

    public function __construct($token)
    {
        $this->url = 'https://'.$this->endpoint.'api.blazinglayer.co.uk/v1/';
        $this->token = $token;
        $this->endpoint = 'eu';
    }

    /**
     * Token sends to the server with encrypting.
     *
     * @param $token
     * @return $salt
     *
     */
    public function hash($token)
    {
        $salt = base64_encode(crypt($token, CRYPT_MD5));
        return $salt;
    }

    /**
     * Connect to BlazingLayer API with curl.
     *
     * @param $variables
     * @return $data
     *
     */
    public function connect($variables)
    {
        $variables = (is_array($variables)) ? true : false;
        if($variables):
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $variables);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Token:'.$this->hash($this->token).''));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        else:
            return false;
        endif;
    }

    /**
     * Get servers with filter your chose type.
     *
     * @param $type
     * @return $data
     *
     */
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