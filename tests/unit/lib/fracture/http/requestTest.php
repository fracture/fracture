<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class RequestTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Http\Request::setMethod
         * @covers Fracture\Http\Request::getMethod
         */
        public function test_getMethod_for_Unprepared_Request()
        {
            $request = new Request;
            $request->setMethod( 'GET' );

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers Fracture\Http\Request::setMethod
         * @covers Fracture\Http\Request::getMethod
         * @covers Fracture\Http\Request::prepare
         *
         * @covers Fracture\Http\Request::getResolvedMethod
         *
         * @depends test_getMethod_for_Unprepared_Request
         */
        public function test_getMethod_for_Prepared_Request()
        {
            $request = new Request;
            $request->setMethod( 'GET' );
            $request->prepare();

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::getMethod
         */
        public function test_getMethod_for_Unprepared_Request_with_Custom_Method()
        {
            $request = new Request;
            $request->setParameters( ['_method' => 'PUT'] );

            $this->assertNull( $request->getMethod() );
        }


        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::getMethod
         * @covers Fracture\Http\Request::prepare
         *
         * @covers Fracture\Http\Request::getResolvedMethod
         *
         * @depends test_getMethod_for_Unprepared_Request_with_Custom_Method
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_without_Override()
        {
            $request = new Request;
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertNull( $request->getMethod() );
        }

        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::setMethod
         * @covers Fracture\Http\Request::getMethod
         * @covers Fracture\Http\Request::prepare
         *
         * @covers Fracture\Http\Request::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request
         * @depends test_getMethod_for_Prepared_Request_with_Custom_Method_without_Override
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override()
        {
            $request = new Request;
            $request->setMethod( 'POST' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertEquals( 'put', $request->getMethod() );
        }

        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::setMethod
         * @covers Fracture\Http\Request::getMethod
         * @covers Fracture\Http\Request::prepare
         *
         * @covers Fracture\Http\Request::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_with_Wrong_Override()
        {
            $request = new Request;
            $request->setMethod( 'GET' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertEquals( 'get', $request->getMethod() );
        }


        /**
         * @covers Fracture\Http\Request::getParameter
         */
        public function test_getParameter_when_no_Value()
        {
            $request = new Request;
            $this->assertNull( $request->getParameter('foobar') );
        }


        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::getParameter
         */
        public function test_getParameter_when_set_Value()
        {
            $request = new Request;
            $request->setParameters( ['param' => 'value'] );
            $this->assertEquals( 'value', $request->getParameter('param') );
        }


        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::getParameter
         */
        public function test_getParameter_when_set_Different()
        {
            $request = new Request;
            $request->setParameters( ['param' => 'value'] );
            $this->assertNull( $request->getParameter('different') );
        }


        /**
         * @covers Fracture\Http\Request::setParameters
         * @covers Fracture\Http\Request::setMethod
         * @covers Fracture\Http\Request::getMethod
         * @covers Fracture\Http\Request::prepare
         * @covers Fracture\Http\Request::getParameter
         *
         * @covers Fracture\Http\Request::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override
         */
        public function test_getMethod_for_Prepared_Request_Unsets_Custom_Method()
        {
            $request = new Request;
            $request->setMethod( 'POST' );
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertNull( $request->getParameter('_method') );
        }


        /**
         * @covers Fracture\Http\Request::setParameters
         */
        public function test_Duplicate_Keys_Assigned_to_Parameters()
        {
            set_error_handler( [ $this, '_handleWarnedMethod' ], E_USER_WARNING );

            $request = new Request;
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
         * @covers Fracture\Http\Request::setUri
         * @covers Fracture\Http\Request::getUri
         *
         * @covers Fracture\Http\Request::sanitizeUri
         * @covers Fracture\Http\Request::resolveUri
         * @covers Fracture\Http\Request::adjustUriSegments
         */
        public function test_Valid_Clean_Uri( $uri, $expected )
        {
            $request = new Request;
            $request->setUri( $uri );

            $this->assertEquals( $expected, $request->getUri() );
        }


        public function  clean_URI_Provider()
        {
            return include FIXTURE_PATH . '/http/uri-variations.php';
        }


        /**
         * @covers Fracture\Http\Request::setIp
         * @covers Fracture\Http\Request::getIp
         */
        public function test_Valid_IP()
        {
            $request = new Request;
            $request->setIp( '127.0.0.1' );

            $this->assertEquals( '127.0.0.1', $request->getIp() );
        }

        /**
         * @covers Fracture\Http\Request::setIp
         * @covers Fracture\Http\Request::getIp
         */
        public function test_Invalid_IP()
        {
            $request = new Request;
            $request->setIp( 'a.b.c.d.e' );

            $this->assertNull( $request->getIp() );
        }



    }