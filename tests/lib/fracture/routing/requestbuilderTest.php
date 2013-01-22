<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class requestBuilderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers \Fracture\Routing\RequestBuilder::create
         */
        public function testCreate()
        {
            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Routing\UserRequest', $builder->create());
        }


    }