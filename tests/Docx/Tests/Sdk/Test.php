<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 21/05/14
 * Time: 18:52
 */


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
            "Size"=>19424,"Name"=>"sample.docx"
        ]
        ];
        $result=$this->client->getTemplates();
        $this->assertEquals(2,count($result));

        $this->assertEquals($expected[0]["Size"],$result[0]["Size"]);
        $this->assertEquals($expected[0]["Name"],$result[0]["Name"]);

        $this->assertEquals($expected[1]["Size"],$result[1]["Size"]);
        $this->assertEquals($expected[1]["Name"],$result[1]["Name"]);
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
				"first_name"  => "Glou",
				"last_name"   => "Edgar",
				"phone"       => "0652455478",
				"description" => "New Website"
			];

        $generatedContent=$this->client->generate("sample.docx",$tagData);
        file_put_contents("generated.docx",$generatedContent);
        $this->assertEquals(strlen($generatedContent),68345);
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
