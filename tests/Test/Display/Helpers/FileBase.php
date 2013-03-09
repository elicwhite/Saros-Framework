<?php
namespace Test\Display\Helpers;

class FileBase extends \PHPUnit_Framework_TestCase
{
    protected $object;
    public function setUp()
    {
        $this->object = new \Fixture\Display\Helpers\FileHelper(\Saros\Display::getInstance(new \Saros\Core\Registry()));
    }

    public function testAppendAppends()
    {
        $f1 = "foo";
        $f2 = "bar";

        $this->object->appendFile($f1);
        $this->object->appendFile($f2);

        $this->assertEquals(array($f1, $f2), $this->object->getFiles());
    }

    public function testPrependPrepends()
    {
        $f1 = "foo";
        $f2 = "bar";

        $this->object->prependFile($f2);
        $this->object->prependFile($f1);

        $this->assertEquals(array($f1, $f2), $this->object->getFiles());
    }

    public function testPrependPrependsWAppend()
    {
        $f1 = "foo";
        $f2 = "bar";
        $f3 = "baz";

        $this->object->prependFile($f2);
        $this->object->appendFile($f3);
        $this->object->prependFile($f1);

        $this->assertEquals(array($f1, $f2, $f3), $this->object->getFiles());
    }

    public function testAppendPageAppends()
    {
        $f1 = "foo";
        $f2 = "bar";

        $this->object->appendPageFile($f2);
        $this->object->appendFile($f1);

        $this->assertEquals(array($f1, $f2), $this->object->getFiles());
    }

    public function testPrependPageAppends()
    {
        $f1 = "foo";
        $f2 = "bar";
        $f3 = "baz";
        $f4 = "dog";

        $this->object->appendPageFile($f4);
        $this->object->appendFile($f1);
        $this->object->prependPageFile($f3);
        $this->object->prependPageFile($f2);

        $this->assertEquals(array($f1, $f2, $f3, $f4), $this->object->getFiles());
    }

    public function testDisplay() {
        $f1 = "foo";
        $f2 = "bar";

        $array = array_map(
            function ($item) { return "-".$item."-"; },
            array($f1, $f2)
        );

        $this->assertEquals(array("-foo-", "-bar-"), $array);
    }
}


