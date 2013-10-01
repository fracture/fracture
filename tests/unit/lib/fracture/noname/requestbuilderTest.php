<?php


    namespace Fracture\NoName;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class requestBuilderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers \Fracture\Noname\RequestBuilder::create
         *
         * @covers \Fracture\Noname\RequestBuilder::getPostValues
         * @covers \Fracture\Noname\RequestBuilder::getServerValue
         */
        public function test_Create()
        {
            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Noname\UserRequest', $builder->create());
        }


        /**
         * @covers \Fracture\Noname\RequestBuilder::create
         *
         * @covers \Fracture\Noname\RequestBuilder::getPostValues
         * @covers \Fracture\Noname\RequestBuilder::getServerValue
         */
        public function test_Create_with_POST()
        {
            $_POST = [ 'test' => 'value' ];

            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Noname\UserRequest', $builder->create());
        }


        /**
         * @covers \Fracture\Noname\RequestBuilder::create
         *
         * @covers \Fracture\Noname\RequestBuilder::getPostValues
         * @covers \Fracture\Noname\RequestBuilder::getServerValue
         */
        public function test_Create_with_Request_Method()
        {
            $_SERVER['REQUEST_METHOD'] = 'POST';

            $builder = new RequestBuilder;
            $this->assertInstanceOf('\Fracture\Noname\UserRequest', $builder->create());
        }


    }