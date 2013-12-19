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




    }