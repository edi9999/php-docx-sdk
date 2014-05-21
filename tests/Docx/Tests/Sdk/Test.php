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
        var_dump($this->client->getTemplates());

    }

}
 