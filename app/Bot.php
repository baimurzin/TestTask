<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 06.10.2016
 * Time: 1:21
 */

namespace App;


class Bot
{
    public $token;
    private $url = 'https://api.telegram.org/bot';
    public $username;


    function __construct($token) {
        $this->token = $token;
    }

    function executeMethod($method_name, $post_data = false) {
        $ch = curl_init($this->url . $this->token . '/' . $method_name);
        if ($post_data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $exec = curl_exec($ch);
        curl_close($ch);
        return json_decode($exec, true);
    }
}