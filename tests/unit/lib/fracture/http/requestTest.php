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
         * @covers Fracture\Http\Request::setMethod
         * @covers Fracture\Http\Request::getMethod
         * @covers Fracture\Http\Request::prepare
         *
         * @covers Fracture\Http\Request::getResolvedMethod
         *
         * @depends test_getMethod_for_Prepared_Request
         */
        public function test_getMethod_for_Prepared_Request_with_Custom_Method_with_Override()
        {
            $request = new Request;
            $request->setParameters( ['_method' => 'PUT'] );
            $request->prepare();

            $this->assertEquals( 'put', $request->getMethod() );
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
         * @covers Fracture\Http\Request::setAddress
         * @covers Fracture\Http\Request::getAddress
         */
        public function test_Valid_Address()
        {
            $request = new Request;
            $request->setAddress( '127.0.0.1' );

            $this->assertEquals( '127.0.0.1', $request->getAddress() );
        }

        /**
         * @covers Fracture\Http\Request::setAddress
         * @covers Fracture\Http\Request::getAddress
         */
        public function test_Invalid_Address()
        {
            $request = new Request;
            $request->setAddress( 'a.b.c.d.e' );

            $this->assertNull( $request->getAddress() );
        }


        /**
         * @covers Fracture\Http\Request::__construct
         * @covers Fracture\Http\Request::getUpload
         */
        public function test_Gathering_Uploads_without_Files()
        {
            $instance = new Request;
            $this->assertNull( $instance->getUpload( 'foobar' ) );
        }


        /**
         * @covers Fracture\Http\Request::__construct
         * @covers Fracture\Http\Request::setUploadedFiles
         * @covers Fracture\Http\Request::getUpload
         */
        public function test_Addition_of_Uploads_without_Builder()
        {
            $input = [
                'alpha' => [
                    'name'      => 'simple.png',
                    'type'      => 'image/png',
                    'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                    'error'     => 0,
                    'size'      => 74,
                ],
            ];

            $instance = new Request;
            $instance->setUploadedFiles( $input );

            $this->assertEquals( $input[ 'alpha' ], $instance->getUpload('alpha')
            );
        }


        /**
         * @covers Fracture\Http\Request::__construct
         * @covers Fracture\Http\Request::setUploadedFiles
         */
        public function test_Call_on_FileBagBuilder_when_Setting_Uploads()
        {
            $input = [
                'alpha' => [
                    'name'      => 'simple.png',
                    'type'      => 'image/png',
                    'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                    'error'     => 0,
                    'size'      => 74,
                ],
            ];

            $builder = $this->getMock( 'FileBagBuilder', ['create'] );
            $builder->expects( $this->once() )
                    ->method( 'create' )
                    ->with( $this->equalTo( $input ) );

            $instance = new Request( $builder );
            $instance->setUploadedFiles( $input );
        }


    }