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

    /**
     * Get parameters for connect BlazingLayer API
     *
     * @param $token
     *
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->endpoint = 'eu';
        //$this->url = 'https://'.$this->endpoint.'api.blazinglayer.co.uk/v1/';
        $this->url = 'http://localhost/github/BlazingAPI/api.php';
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
        $salt = base64_encode(md5($token));
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
        $postData = '';
        foreach($variables as $k => $v)
        {
            $postData .= $k . '='.$v.'&';
        }
        $postData = rtrim($postData, '&');
        if($variables):
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, count($postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Token: '.$this->hash($this->token)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);
            return json_decode($data, true);
        else:
            return false;
        endif;
    }

    /**
     * Get servers with filter your chose type.
     *
     * @param $type('vps','dedicated','teamspeak')
     * @return array
     *
     */
    public function getMyServers($type)
    {
        $check = (in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
        if($check):
            $data = $this->connect(array('get' => 'myservers', 'type' => $type));
            return $data;
        else:
            return false;
        endif;
    }
}