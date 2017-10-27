<?php

namespace Docx\Tests\Sdk;

use Docx\Sdk\Client;

class Test extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        Client::setKey("a457f87f54a654a87fd89aeff");
        $this->client=new Client();
    }

    public function testGetTemplates()
    {
        $expected= [[
            "Size"=>19424,"Name"=>"acme/sample.docx"
        ],[
            "Size"=>4193,"Name"=>"error.docx"
        ],[
            "Size"=>4193,"Name"=>"error.docx"
        ]];
        $result=$this->client->getTemplates();
        $this->assertEquals(3,count($result));

        $this->assertEquals(19424,$result[0]["Size"]);
        $this->assertEquals("acme/sample.docx",$result[0]["Name"]);

        $this->assertEquals(4193,$result[1]["Size"]);
        $this->assertEquals("error.docx",$result[1]["Name"]);

        $this->assertEquals(19424,$result[2]["Size"]);
        $this->assertEquals("sample.docx",$result[2]["Name"]);
    }

    public function testGetTemplate()
    {
        $content=$this->client->getTemplate("sample.docx");
        file_put_contents("copy.docx",$content);
        $expectedContent=file_get_contents("sample.docx");
        $this->assertEquals($expectedContent,$content);
    }

    public function testGenerateFromTemplate()
    {
        $tagData=[
            "first_name"  => "Gla",
            "last_name"   => "Edgar",
            "phone"       => "0652455478",
            "description" => "New Website"
        ];

        $generatedContent=$this->client->generate("sample.docx",$tagData);
        file_put_contents("generated.docx",$generatedContent);
        $this->assertEquals(strlen($generatedContent),17283);
    }

    public function testGenerateError()
    {
        $tagData=[
        ];

        $result=$this->client->addTemplate("error.docx",file_get_contents("error.docx"));
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Scope parser execution');
        $generatedContent=$this->client->generate("error.docx",$tagData);
    }

    public function testAddTemplate()
    {
        $expected= ["Size"=>19424,"Name"=>"sample.docx"];
        $result=$this->client->addTemplate("sample.docx",file_get_contents("sample.docx"));
        $this->assertEquals($expected["Size"],$result["Size"]);
        $this->assertEquals($expected["Name"],$result["Name"]);
    }

    public function testAddTemplateWithFolder()
    {
        $expected= ["Size"=>19424,"Name"=>"sample.docx","Folder"=>"acme"];
        Client::setFolder("acme");
        $result=$this->client->addTemplate("sample.docx",file_get_contents("sample.docx"));
        $this->assertEquals($expected["Size"],$result["Size"]);
        $this->assertEquals($expected["Name"],$result["Name"]);
        $this->assertEquals($expected["Folder"],$result["Folder"]);
        Client::setFolder("");
    }
}
