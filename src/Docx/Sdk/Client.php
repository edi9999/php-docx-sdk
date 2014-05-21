<?php

namespace Docx\Sdk;

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 21/05/14
 * Time: 18:42
 */


use GuzzleHttp\Client as GuzzleClient;

class Client {
    private $key="";
    private $endpoint="http://localhost:3000/api";

    function __construct()
    {
        $this->guzzleClient=new GuzzleClient();
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
        return $this->guzzleClient->get($this->endpoint."/templates/".$name."?key=".$this->key)->getBody()->__toString();
    }

    public function generate($name,$data)
    {
        return $this->guzzleClient->post($this->endpoint."/generate/".$name."?key=".$this->key)->getBody()->__toString();
    }

    public function addTemplate($name,$file)
    {
        return $this->guzzleClient->post($this->endpoint."/templates/".$name."?key=".$this->key)->getJson();
    }

}