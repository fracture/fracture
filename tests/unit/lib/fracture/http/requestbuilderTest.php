<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class RequestBuilderTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @covers Fracture\Http\RequestBuilder::create
         */
        public function test_Internal_Manipulations_of_Instance()
        {
            $request = new Request(
                new FileBagBuilder (
                    new UploadedFileBuilder
                )
            );

            $params = [
                'get'    => [],
                'post'   => [],
                'server' => [],
                'files'  => [],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'buildInstance', 'applyParams' ] );

            $builder->expects( $this->once() )
                    ->method( 'buildInstance' )
                    ->will( $this->returnValue( $request ) );

            $builder->expects( $this->once() )
                    ->method( 'applyParams' )
                    ->with( $this->equalTo( $request ), $this->equalTo( $params ) );


            $instance = $builder->create( [] );
            $this->assertInstanceOf( 'Fracture\Http\Request', $instance );
        }


        /**
         * @dataProvider provide_Test_Shared_Setup
         * @covers Fracture\Http\RequestBuilder::create
         * @covers Fracture\Http\RequestBuilder::applyParams
         */
        public function test_Method_Calls_on_Instance( $request, $builder )
        {

            $request->expects( $this->once() )->method( 'setUploadedFiles' );
            $request->expects( $this->once() )->method( 'setAddress' );

            $builder->expects( $this->once() )
                    ->method( 'isCLI' )
                    ->will( $this->returnValue( false ) );

            $instance = $builder->create( [
                'get'    => [],
                'post'   => [],
                'server' => [
                    'REQUEST_METHOD' => 'post',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                ],
                'files'  => [],
            ] );
            $this->assertInstanceOf( 'Fracture\Http\Request', $instance );
        }


        /**
         * @dataProvider provide_Test_Shared_Setup
         * @covers Fracture\Http\RequestBuilder::create
         * @covers Fracture\Http\RequestBuilder::applyParams
         */
        public function test_Method_Calls_on_Instance_for_CLI( $request, $builder )
        {


            $builder->expects( $this->once() )
                    ->method( 'isCLI' )
                    ->will( $this->returnValue( true ) );


            $instance = $builder->create( [
                'get'    => [],
                'post'   => [],
                'files'  => [],
            ] );
            $this->assertInstanceOf( 'Fracture\Http\Request', $instance );
        }



        public function provide_Test_Shared_Setup()
        {
            $request = $this->getMock(
                'Fracture\Http\Request',
                [
                    'setParameters',
                    'setMethod',
                    'setUploadedFiles',
                    'setAddress',
                    'prepare',
                ]
            );

            $request->expects( $this->exactly(2) )->method( 'setParameters' );
            $request->expects( $this->once() )->method( 'setMethod' );
            $request->expects( $this->once() )->method( 'prepare' );



            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'buildInstance', 'isCLI' ] );

            $builder->expects( $this->once() )
                    ->method( 'buildInstance' )
                    ->will( $this->returnValue( $request ) );

            return [[
                'request' => $request,
                'builder' => $builder
            ]];
        }


        /**
         * @covers Fracture\Http\RequestBuilder::create
         * @covers Fracture\Http\RequestBuilder::buildInstance
         */
        public function test_Unaltered_Instance()
        {
            $input = [
                'get'    => [],
                'post'   => [],
                'server' => [
                    'REQUEST_METHOD' => 'post',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                ],
                'files'  => [],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'applyParams' ] );

            $builder->expects( $this->once() )
                    ->method( 'applyParams' )
                    ->with( $this->isInstanceOf( '\Fracture\Http\Request' ) , $this->equalTo( $input ) );

            $instance = $builder->create( $input );
        }

        /**
         * @covers Fracture\Http\RequestBuilder::create
         */
        public function test_When_Content_Parsers_Applied()
        {
            $input = [
                'get'    => [],
                'server' => [
                    'REQUEST_METHOD' => 'put',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                ],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'applyContentParsers', 'isCLI' ] );

            $builder->expects( $this->once() )
                    ->method( 'isCLI' )
                    ->will( $this->returnValue( false ) );

            $builder->expects( $this->once() )
                    ->method( 'applyContentParsers' )
                    ->with( $this->isInstanceOf( '\Fracture\Http\Request' ));

            $instance = $builder->create( $input );
        }


        /**
         * @covers Fracture\Http\RequestBuilder::create
         */
        public function test_When_Content_Parsers_Ignored()
        {
            $input = [
                'get'    => [],
                'server' => [
                    'REQUEST_METHOD' => 'get',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                ],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'applyContentParsers', 'isCLI' ] );

            $builder->expects( $this->once() )
                    ->method( 'isCLI' )
                    ->will( $this->returnValue( false ) );

            $builder->expects( $this->never() )
                    ->method( 'applyContentParsers' );

            $instance = $builder->create( $input );
        }



        /**
         * @covers Fracture\Http\RequestBuilder::create
         * @covers Fracture\Http\RequestBuilder::applyContentParsers
         * @covers Fracture\Http\RequestBuilder::addContentParser
         */
        public function test_Applied_Content_Parsers()
        {
            $input = [
                'get'    => [],
                'server' => [
                    'REQUEST_METHOD' => 'delete',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                    'CONTENT_TYPE'   => 'application/json',
                ],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'isCLI' ] );

            $builder->expects( $this->once() )
                    ->method( 'isCLI' )
                    ->will( $this->returnValue( false ) );


            $builder->addContentParser( 'application/json', function() {
                return ['foo' => 'bar'];
            });

            $instance = $builder->create( $input );
            $this->assertEquals('bar', $instance->getParameter('foo'));

        }


        /**
         * @covers Fracture\Http\RequestBuilder::create
         * @covers Fracture\Http\RequestBuilder::applyContentParsers
         * @covers Fracture\Http\RequestBuilder::addContentParser
         */
        public function test_Applied_Content_Parsers_with_Missing_Header()
        {
            $input = [
                'get'    => [],
                'server' => [
                    'REQUEST_METHOD' => 'delete',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                ],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'isCLI' ] );

            $builder->expects( $this->once() )
                    ->method( 'isCLI' )
                    ->will( $this->returnValue( false ) );


            $builder->addContentParser( 'application/json', function() {
                return ['foo' => 'bar'];
            });

            $instance = $builder->create( $input );
            $this->assertEquals(null, $instance->getParameter('foo'));

        }

        /*
         * @covers Fracture\Http\RequestBuilder::create
         * @covers Fracture\Http\RequestBuilder::applyContentParsers
         * @covers Fracture\Http\RequestBuilder::applyHeaders
         */
        public function test_If_Header_Abstractions_Applied()
        {
            $request = $this->getMock('Fracture\Http\Request', ['setAcceptHeader', 'setContentTypeHeader']);

            $request->expects($this->once())
                    ->method('setAcceptHeader')
                    ->with($this->isInstanceOf('Fracture\Http\AcceptHeader'));

            $request->expects($this->once())
                    ->method('setContentTypeHeader')
                    ->with($this->isInstanceOf('Fracture\Http\ContentTypeHeader'));

            $input = [
                'get'    => [],
                'server' => [
                    'REQUEST_METHOD' => 'post',
                    'REMOTE_ADDR'    => '0.0.0.0',
                    'HTTP_ACCEPT'    => 'text/html',
                    'CONTENT_TYPE'   => 'application/json',
                ],
            ];

            $builder = $this->getMock('Fracture\Http\RequestBuilder', ['buildInstance', 'isCLI']);

            $builder->expects($this->once())
                    ->method('isCLI')
                    ->will($this->returnValue(false));

            $builder->expects($this->once())
                    ->method('buildInstance')
                    ->will($this->returnValue($request));

            $instance = $builder->create($input);


        }


    }