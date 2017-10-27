<?php

namespace Docx\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class Client {

    public static $key="";
    public static $folder="";
    public static $endpoint="http://docxapi.beequick.fr/api/v1";
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

    public static function setUrl($endpoint)
    {
        self::$endpoint=$endpoint;
    }

    public function getTemplates()
    {
        $this->queryParams['key']=self::$key;
        $response = $this->guzzleClient->get(self::$endpoint."/templates",
            [
                "query"=>$this->queryParams
            ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getTemplate($name)
    {
        $this->queryParams['key']=self::$key;
        $this->queryParams['folder']=self::$folder;
        return $this->guzzleClient->get(self::$endpoint."/templates/".$name,
            [
                "query"=>$this->queryParams
            ])->getBody();
    }

    public function generate($name,$data,$pptx=false)
    {
        $this->queryParams['key']=self::$key;
        $this->queryParams['folder']=self::$folder;

        if ($pptx)
            $this->queryParams['pptx']='true';

        $this->queryParams['folder']=self::$folder;
        try{
            $postResponse=$this->guzzleClient->post(self::$endpoint."/generate/".$name,[
                "body"=>json_encode($data),
                "headers"=>["content-type"=>"application/json"],
                "query"=>$this->queryParams
            ]);
            return $postResponse->getBody();
        }
        catch (ClientException $exception) {
            $response=$exception->getResponse()->json();
            throw new InvalidTagsException($response["error_message"]);
        }
    }

    public function addTemplate($filename,$content)
    {
        $this->queryParams['key']=self::$key;
        $this->queryParams['folder']=self::$folder;
        $this->queryParams['filename']=$filename;
        $response = $this->guzzleClient->post(self::$endpoint."/templates",
            [
                "multipart"=> [
                    [
                        'name'=>'file',
                        'contents'=> $content,
                        'filename'=>'file'
                    ]
                ],
                "query"=>$this->queryParams
            ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
