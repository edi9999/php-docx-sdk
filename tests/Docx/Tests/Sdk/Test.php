<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 21/05/14
 * Time: 18:52
 */


namespace Docx\Tests\Sdk;

use Docx\Sdk;

class Test extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->client=new \Docx\Sdk\Client();
        $this->client->setKey("a457f87f54a654a87fd89aeff");
    }

    public function testGetTemplates()
    {
        $expected= ["Size"=>19424,"Name"=>"sample.docx"];
        $result=$this->client->getTemplates();
        $this->assertEquals($expected["Size"],$result[0]["Size"]);
        $this->assertEquals($expected["Name"],$result[0]["Name"]);
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

        file_put_contents("generated.docx",$this->client->generate("sample.docx",$tagData));
    }

    public function testAddTemplate()
    {
        $expected= ["Size"=>19424,"Name"=>"sample.docx"];
        $result=$this->client->addTemplate("sample.docx",file_get_contents("sample.docx"));
        $this->assertEquals($expected["Size"],$result["Size"]);
        $this->assertEquals($expected["Name"],$result["Name"]);

    }

}
 