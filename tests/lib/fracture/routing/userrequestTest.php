<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class UserRequestTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers UserRequest::setMethod
         * @covers UserRequest::getMethod
         */
        public function test_getMethod_for_Unprepared_Request()
        {
            $request = new UserRequest;
            $request->setMethod( 'GET' );

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers UserRequest::setMethod
         * @covers UserRequest::getMethod
         * @covers UserRequest::prepare
         */
        public function test_getMethod_for_Prepared_Request()
        {
            $request = new UserRequest;
            $request->setMethod( 'GET' );
            $request->prepare();

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers UserRequest::setParameters
         * @covers UserRequest::getMethod
         */
        public function test_getMethod_for_Unprepared_Request_with_Custom_Method()
        {
            $request = new UserRequest;
            $request->setParameters( ['_method' => 'PUT'] );

            $this->assertNull( $request->getMethod() );
        }


        /**
         * @covers UserRequest::setParameters
         * @covers UserRequest::getMethod
         * @covers UserRequest::prepare
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_without_Override()
        {
            $request = new UserRequest;
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertNull( $request->getMethod() );
        }

        /**
         * @covers UserRequest::setParameters
         * @covers UserRequest::setMethod
         * @covers UserRequest::getMethod
         * @covers UserRequest::prepare
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override()
        {
            $request = new UserRequest;
            $request->setMethod( 'POST' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertEquals( 'put', $request->getMethod() );
        }

        /**
         * @covers UserRequest::setParameters
         * @covers UserRequest::setMethod
         * @covers UserRequest::getMethod
         * @covers UserRequest::prepare
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_with_Wrong_Override()
        {
            $request = new UserRequest;
            $request->setMethod( 'GET' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertEquals( 'get', $request->getMethod() );
        }


    }