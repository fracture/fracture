<?php


    namespace Fracture\Autoload;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class NodeTest extends PHPUnit_Framework_TestCase
    {

        public function test_Setting_of_Namespace()
        {
            $instance = new Node;
            $instance->setNamespace('foobar');
            $this->assertEquals('foobar', $instance->getNamespace());
        }

    }