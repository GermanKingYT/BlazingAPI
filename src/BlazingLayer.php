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
    public $endpoint;
    public $version;

    /**
     * Get variables for connect BlazingLayer API.
     *
     * @param $token
     *
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->endpoint = 'eu';
        $this->url = 'https://'.$this->endpoint.'api.blazinglayer.co.uk/v1/';
        $this->version = '2.0.3';
    }

    /**
     * Connect to BlazingLayer API with curl.
     *
     * @param $variables
     * @return $data
     *
     */
    public function connect($variables, $url = null)
    {
        $postData = '';
        foreach($variables as $k => $v)
        {
            $postData .= $k . '='.$v.'&';
        }
        $postData = rtrim($postData, '&');
        if($variables):
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Token: '.$this->token, 'Version: '.$this->version));
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
     * @param $type
     * @return array
     *
     */
    public function getMyServers($type)
    {
        $check = (ctype_alnum($type) && in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
        if($check):
            $data = $this->connect(array('type' => $type), $this->url.''.$type.'/myservers');
            return $data;
        else:
            return false;
        endif;
    }

    /**
     * Manage server power.
     *
     * @param $id, $type, $action
     * @return array
     *
     */
    public function power($id, $type, $action)
    {
        $check = (is_numeric($id) && ctype_alnum($action) && ctype_alnum($type) && in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
        if($check):
            $data = $this->connect(array('id' => $id, 'power' => $action), $this->url.''.$type.'/power');
            return $data;
        else:
            return false;
        endif;
    }

    /**
     * Get server status & information.
     *
     * @param $id, $type
     * @return array
     *
     */
    public function status($id, $type)
    {
        $check = (is_numeric($id) && ctype_alnum($type) && in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
        if($check):
            $data = $this->connect(array('id' => $id), $this->url.''.$type.'/status');
            return $data;
        else:
            return false;
        endif;
    }
}