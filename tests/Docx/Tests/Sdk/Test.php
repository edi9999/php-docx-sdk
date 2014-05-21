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
        $expected= ["LastModified"=>"2014-05-21T15:52:48.000Z","Size"=>19424,"Name"=>"sample.docx"];
        $this->assertEquals($expected,$this->client->getTemplates()[0]);
    }

    public function testGetTemplate()
    {
        file_put_contents("copy.docx",$this->client->getTemplate("sample.docx"));
    }

    public function testGenerateFromTemplate()
    {
        file_put_contents("generated.docx",$this->client->generate("sample.docx",[]));
    }

}
 