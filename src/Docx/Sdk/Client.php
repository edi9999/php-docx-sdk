<?php

namespace Docx\Sdk;
use GuzzleHttp;

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 21/05/14
 * Time: 18:42
 */



class Client {
    private $key="";
    private $endpoint="http://localhost:3000/api";

    function __construct()
    {
        $this->guzzleClient=new \GuzzleHttp\Client();
    }


    public function setKey($key)
    {
        $this->key=$key;
    }

    public function getTemplates()
    {
        return $this->guzzleClient->get($this->endpoint."/templates/?key=".$this->key)->json();
    }

    public function getTemplate($name)
    {
        return $this->guzzleClient->get($this->endpoint."/templates/".$name."?key=".$this->key);
    }


    public function addTemplate($name,$file)
    {
        return $this->guzzleClient->post($this->endpoint."/templates/".$name."?key=".$this->key);
    }

    public function generate($name,$data)
    {
        return $this->guzzleClient->post($this->endpoint."/generate/".$name."?key=".$this->key);
    }
}