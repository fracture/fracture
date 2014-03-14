<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class ContentTypeHeaderTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @covers Fracture\Http\ContentTypeHeader::__construct
         * @covers Fracture\Http\ContentTypeHeader::getParsedList
         */
        public function test_Empty_Instance()
        {
            $instance = new ContentTypeHeader;
            $this->assertEquals( [], $instance->getParsedList( '' ) );
        }

    }