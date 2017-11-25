<?php

/**
 * Class BlazingLayer
 *
 * @author Uğur Pekesen
 *         @web https://www.blazinglayer.co.uk/
 *         @date 24 November 2017
 * @author Ege Yıldız
 *         @web https://www.blazinglayer.co.uk/
 *         @update 25 November 2017
 */

class BlazingLayer
{
    /**
     * API Url
     *
     * @var
     *
     */
    public $url;

    /**
     * Authentication Token
     *
     * @var
     *
     */
    public $token;

    /**
     * API Endpoint
     *
     * @var
     *
     */
    public $endpoint;

    /**
     * API Version
     *
     * @var
     *
     */
    public $version;

    /**
     * BlazingLayer Constructor
     *
     * @param $token
     * @param $endpoint
     *
     */
    public function __construct($token, $endpoint = 'eu')
    {
        $this->token = $token;
        $this->endpoint = $endpoint;
        $this->version = '2.0.3';
        $this->url = 'https://'.$this->endpoint.'api.blazinglayer.co.uk/v'.substr($this->version, 0, 1).'/';
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
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authentication: '.$this->token, 'Version: '.$this->version));
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
    public function myservers($type)
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
        $check = (is_numeric($id) && ctype_alnum($type) && ctype_alnum($action) && in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
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
     * @param $id, $type, $graph
     * @return array
     *
     */
    public function status($id, $type, $graph = null)
    {
        $check = (is_numeric($id) && ctype_alnum($type) && in_array($type, array('vps', 'dedicated', 'teamspeak'))) ? true : false;
        if($check):
            $data = $this->connect(array('id' => $id, 'graph' => $graph), $this->url.''.$type.'/status');
            return $data;
        else:
            return false;
        endif;
    }
}