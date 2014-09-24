<?php

namespace Docx\Sdk;

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 21/05/14
 * Time: 18:42
 */


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Post\PostFile;
use GuzzleHttp\Exception\ClientException;

class Client {

    public static $key="";
    public static $folder="";
    private $endpoint="http://docxgenapi.herokuapp.com/api/v1";
    private $queryParams=[];

    function __construct()
    {
        $this->guzzleClient=new GuzzleClient();
    }

    public static function setKey($key)
    {
        self::$key=$key;
    }

    public static function setFolder($folder)
    {
        self::$folder=$folder;
    }

    public function getTemplates()
    {
        $this->queryParams['key']=self::$key;
        return $this->guzzleClient->get($this->endpoint."/templates",
            [
                "query"=>$this->queryParams
            ])->json();
    }

    public function getTemplate($name)
    {
        $this->queryParams['key']=self::$key;
        $this->queryParams['folder']=self::$folder;
        return $this->guzzleClient->get($this->endpoint."/templates/".$name,
            [
                "query"=>$this->queryParams
            ])->getBody()->__toString();
    }

    public function generate($name,$data)
    {
        $this->queryParams['key']=self::$key;
        $this->queryParams['folder']=self::$folder;
        try{
            return $this->guzzleClient->post($this->endpoint."/generate/".$name,[
                "body"=>json_encode($data),
                "headers"=>["content-type"=>"application/json"],
                "query"=>$this->queryParams
            ]);
        }
        catch (ClientException $exception) {
            $response=$exception->getResponse()->json();
            throw new Exception($response);
        }
    }

    public function addTemplate($filename,$content)
    {
        $this->queryParams['key']=self::$key;
        $this->queryParams['folder']=self::$folder;
        $this->queryParams['filename']=$filename;
        return $this->guzzleClient->post($this->endpoint."/templates",
            [
                "body"=> ['file'=>new PostFile('file',$content)],
                "query"=>$this->queryParams
            ])->json();
    }
}
