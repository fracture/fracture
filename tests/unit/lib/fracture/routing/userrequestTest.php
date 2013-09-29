<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class UserRequestTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Routing\UserRequest::setMethod
         * @covers Fracture\Routing\UserRequest::getMethod
         */
        public function test_getMethod_for_Unprepared_Request()
        {
            $request = new UserRequest;
            $request->setMethod( 'GET' );

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setMethod
         * @covers Fracture\Routing\UserRequest::getMethod
         * @covers Fracture\Routing\UserRequest::prepare
         *
         * @covers Fracture\Routing\UserRequest::getResolvedMethod
         *
         * @depends test_getMethod_for_Unprepared_Request
         */
        public function test_getMethod_for_Prepared_Request()
        {
            $request = new UserRequest;
            $request->setMethod( 'GET' );
            $request->prepare();

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::getMethod
         */
        public function test_getMethod_for_Unprepared_Request_with_Custom_Method()
        {
            $request = new UserRequest;
            $request->setParameters( ['_method' => 'PUT'] );

            $this->assertNull( $request->getMethod() );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::getMethod
         * @covers Fracture\Routing\UserRequest::prepare
         *
         * @covers Fracture\Routing\UserRequest::getResolvedMethod
         *
         * @depends test_getMethod_for_Unprepared_Request_with_Custom_Method
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_without_Override()
        {
            $request = new UserRequest;
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertNull( $request->getMethod() );
        }

        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::setMethod
         * @covers Fracture\Routing\UserRequest::getMethod
         * @covers Fracture\Routing\UserRequest::prepare
         *
         * @covers Fracture\Routing\UserRequest::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request
         * @depends test_getMethod_for_Prepared_Request_with_Custom_Method_without_Override
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
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::setMethod
         * @covers Fracture\Routing\UserRequest::getMethod
         * @covers Fracture\Routing\UserRequest::prepare
         *
         * @covers Fracture\Routing\UserRequest::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_with_Wrong_Override()
        {
            $request = new UserRequest;
            $request->setMethod( 'GET' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers Fracture\Routing\UserRequest::getParameter
         */
        public function test_getParameter_when_no_Value()
        {
            $request = new UserRequest;
            $this->assertNull( $request->getParameter('foobar') );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::getParameter
         */
        public function test_getParameter_when_set_Value()
        {
            $request = new UserRequest;
            $request->setParameters( ['param' => 'value'] );
            $this->assertEquals( 'value', $request->getParameter('param') );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::getParameter
         */
        public function test_getParameter_when_set_Different()
        {
            $request = new UserRequest;
            $request->setParameters( ['param' => 'value'] );
            $this->assertNull( $request->getParameter('different') );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         * @covers Fracture\Routing\UserRequest::setMethod
         * @covers Fracture\Routing\UserRequest::getMethod
         * @covers Fracture\Routing\UserRequest::prepare
         * @covers Fracture\Routing\UserRequest::getParameter
         *
         * @covers Fracture\Routing\UserRequest::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override
         */
        public function test_getMethod_for_Prepared_Request_Unsets_Custom_Method()
        {
            $request = new UserRequest;
            $request->setMethod( 'POST' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertNull( $request->getParameter('_method') );
        }


        /**
         * @covers Fracture\Routing\UserRequest::setParameters
         */
        public function test_Duplicate_Keys_Assigned_to_Parameters()
        {
            set_error_handler( [ $this, '_handleWarnedMethod' ], E_USER_WARNING );

            $request = new UserRequest;
            $request->setParameters( ['alpha' => 'foo'] );
            $request->setParameters( ['alpha' => 'foo'] );

            restore_error_handler();
        }

        public function _handleWarnedMethod( $errno, $errstr )
        {
             $this->assertEquals( E_USER_WARNING, $errno );
        }



        /**
         * @dataProvider clean_URI_Provider
         * @covers Fracture\Routing\UserRequest::setUri
         * @covers Fracture\Routing\UserRequest::getUri
         *
         * @covers Fracture\Routing\UserRequest::sanitizeUri
         * @covers Fracture\Routing\UserRequest::resolveUri
         * @covers Fracture\Routing\UserRequest::adjustUriSegments
         */
        public function test_Valid_Clean_Uri( $uri, $expected )
        {
            $request = new UserRequest;
            $request->setUri( $uri );

            $this->assertEquals( $expected, $request->getUri() );
        }


        public function  clean_URI_Provider()
        {
            return include FIXTURE_PATH . '/routing/uri-variations.php';
        }


        /**
         * @covers Fracture\Routing\UserRequest::setIp
         * @covers Fracture\Routing\UserRequest::getIp
         */
        public function test_Valid_IP()
        {
            $request = new UserRequest;
            $request->setIp( '127.0.0.1' );

            $this->assertEquals( '127.0.0.1', $request->getIp() );
        }

        /**
         * @covers Fracture\Routing\UserRequest::setIp
         * @covers Fracture\Routing\UserRequest::getIp
         */
        public function test_Invalid_IP()
        {
            $request = new UserRequest;
            $request->setIp( 'a.b.c.d.e' );

            $this->assertNull( $request->getIp() );
        }



    }