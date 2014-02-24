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
                ],
                'files'  => [],
            ];

            $builder = $this->getMock( 'Fracture\Http\RequestBuilder', [ 'applyParams' ] );

            $builder->expects( $this->once() )
                    ->method( 'applyParams' )
                    ->with( $this->isInstanceOf( '\Fracture\Http\Request' ) , $this->equalTo( $input ) );

            $instance = $builder->create( $input );
        }

    }