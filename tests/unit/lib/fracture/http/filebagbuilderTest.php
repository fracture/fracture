<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class FileBagBuilderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::createItem
         */
        public function test_Created_Instance()
        {
            $instance = new FileBagBuilder( null );
            $object = $instance->create( [] );

            $this->assertInstanceOf( 'Fracture\Http\FileBag', $object );
        }


        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::createItem
         */
        public function test_Single_File_Upload()
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

            $builder = $this->getMock( 'UploadedFileBuilder', ['create'] );
            $builder->expects( $this->once() )
                    ->method( 'create' )
                    ->with( $this->equalTo( $input['alpha'] ) )
                    ->will( $this->returnValue( new UploadedFile( $input['alpha'] ) ) );

            $instance = new FileBagBuilder( $builder );
            $object = $instance->create( $input );
        }

    }