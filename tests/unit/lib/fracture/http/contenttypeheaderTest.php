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
            $this->assertEquals( [ 'application/json' ], $instance->getParsedList( 'application/json' ) );
            $this->assertEquals( [ 'application/json', 'application/json;version=1' ], $instance->getParsedList( 'application/json, application/json;version=1' ) );
            $this->assertEquals( [ 'text/html', '*/*' ], $instance->getParsedList( 'text/html,*/*' ) );
        }


        /**
         * @covers Fracture\Http\ContentTypeHeader::__construct
         * @covers Fracture\Http\ContentTypeHeader::prepare
         * @covers Fracture\Http\ContentTypeHeader::contains
         */
        public function test_Prepared_Result()
        {
            $instance = new ContentTypeHeader('application/json, text/html, text/plain');
            $instance->prepare();

            $this->assertTrue($instance->contains('text/html'));
            $this->assertFalse($instance->contains('image/png'));
        }


        /**
         * @covers Fracture\Http\ContentTypeHeader::__construct
         * @covers Fracture\Http\ContentTypeHeader::prepare
         * @covers Fracture\Http\ContentTypeHeader::contains
         * @covers Fracture\Http\ContentTypeHeader::setALternativeValue
         */
        public function test_Prepared_Result_Ater_Manual_Alteration()
        {
            $instance = new ContentTypeHeader('application/json, text/html, text/plain');
            $instance->setALternativeValue('image/jpeg, image/png');
            $instance->prepare();


            $this->assertTrue($instance->contains('image/png'));
            $this->assertFalse($instance->contains('text/html'));
        }


    }