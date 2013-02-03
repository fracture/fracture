<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class requestBuilderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers \Fracture\Routing\RequestBuilder::create
         *
         * @covers \Fracture\Routing\RequestBuilder::getPostValues
         * @covers \Fracture\Routing\RequestBuilder::getServerValue
         */
        public function test_Create()
        {
            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Routing\UserRequest', $builder->create());
        }


        /**
         * @covers \Fracture\Routing\RequestBuilder::create
         *
         * @covers \Fracture\Routing\RequestBuilder::getPostValues
         * @covers \Fracture\Routing\RequestBuilder::getServerValue
         */
        public function test_Create_with_POST()
        {
            $_POST = [ 'test' => 'value' ];

            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Routing\UserRequest', $builder->create());
        }


        /**
         * @covers \Fracture\Routing\RequestBuilder::create
         *
         * @covers \Fracture\Routing\RequestBuilder::getPostValues
         * @covers \Fracture\Routing\RequestBuilder::getServerValue
         */
        public function test_Create_with_Request_Method()
        {
            $_SERVER['REQUEST_METHOD'] = 'POST';

            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Routing\UserRequest', $builder->create());
        }


    }