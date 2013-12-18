<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class UploadedFileBuilderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @dataProvider provide_Input
         *
         * @covers Fracture\Http\UploadedFileBuilder::create
         */
        public function test_Initialization_of_Instance( $input )
        {


            $builder = $this->getMock( 'Fracture\Http\UploadedFileBuilder', ['buildInstance'] );
            $builder->expects( $this->once() )
                    ->method( 'buildInstance' )
                    ->with( $this->equalTo( $input ) )
                    ->will( $this->returnValue( new UploadedFile( $input ) ) );


            $builder->create( $input );
        }



        /**
         * @dataProvider provide_Input
         *
         * @covers Fracture\Http\UploadedFileBuilder::create
         */
        public function test_Preparation_of_Instance( $input )
        {

            $response  = $this->getMock( 'Fracture\Http\UploadedFile', ['prepare'], [ 'params' => $input ] );
            $response->expects( $this->once() )
                     ->method( 'prepare' );

            $builder = $this->getMock( 'Fracture\Http\UploadedFileBuilder', ['buildInstance'] );
            $builder->expects( $this->once() )
                    ->method( 'buildInstance' )
                    ->with( $this->equalTo( $input ) )
                    ->will( $this->returnValue( $response ) );

            $instance = $builder->create( $input );

            $this->assertInstanceOf( 'Fracture\Http\UploadedFile', $instance );
            $this->assertEquals( $response, $instance );
        }


        /**
         * @dataProvider provide_Input
         *
         * @covers Fracture\Http\UploadedFileBuilder::create
         * @covers Fracture\Http\UploadedFileBuilder::createInstance
         */
        public function test_Unaltered_Builder( $input )
        {
            $builder = new UploadedFileBuilder;
            $instance = $builder->create($input);

            $this->assertInstanceOf( 'Fracture\Http\UploadedFile', $instance );
        }


        public function provide_Input()
        {
            return [
                [
                    'input' =>  [
                        'name'      => 'simple.png',
                        'type'      => 'image/png',
                        'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                        'error'     => 0,
                        'size'      => 74,
                    ],
                ],
            ];
        }

    }
