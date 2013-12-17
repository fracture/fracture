<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class FileBagBuilderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::create
         * @covers Fracture\Http\FileBagBuilder::createItem
         */
        public function test_Created_Dummy_Element()
        {
            $instance = new FileBagBuilder( null );
            $object = $instance->create( [] );

            $this->assertInstanceOf( 'Fracture\Http\FileBag', $object );
        }


        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::create
         * @covers Fracture\Http\FileBagBuilder::createItem
         */
        public function test_With_Invalid_Input()
        {
            $input = [ 'foo' => 'bar' ];

            $response  = $this->getMock( 'UploadedFile', ['isValid'] );
            $response->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( false ) );


            $builder = $this->getMock( 'UploadedFileBuilder', ['create'] );
            $builder->expects( $this->once() )
                    ->method( 'create' )
                    ->will( $this->returnValue( $response ) );


            $instance = new FileBagBuilder( $builder );

            $object = $instance->create( $input );
            $this->assertInstanceOf( 'Fracture\Http\FileBag', $object );
        }


        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::create
         * @covers Fracture\Http\FileBagBuilder::createItem
         */
        public function test_With_Invalid_Malformed_Upload()
        {
            $input = [ 'foo' => ['bar'] ];

            $response  = $this->getMock( 'UploadedFile', ['isValid'] );
            $response->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( false ) );


            $builder = $this->getMock( 'UploadedFileBuilder', ['create'] );
            $builder->expects( $this->once() )
                    ->method( 'create' )
                    ->with( $this->equalTo( $input['foo'] ) )
                    ->will( $this->returnValue( $response ) );

            $instance = new FileBagBuilder( $builder );

            $object = $instance->create( $input );
            $this->assertInstanceOf( 'Fracture\Http\FileBag', $object );
        }

        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::create
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

            $response  = $this->getMock( 'UploadedFile', ['isValid'] );
            $response->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );


            $builder = $this->getMock( 'UploadedFileBuilder', ['create'] );
            $builder->expects( $this->once() )
                    ->method( 'create' )
                    ->with( $this->equalTo( $input['alpha'] ) )
                    ->will( $this->returnValue( $response ) );

            $instance = new FileBagBuilder( $builder );
            $object = $instance->create( $input );

            $this->assertInstanceOf( 'Fracture\Http\FileBag', $object );
        }


        /**
         * @covers Fracture\Http\FileBagBuilder::__construct
         * @covers Fracture\Http\FileBagBuilder::create
         * @covers Fracture\Http\FileBagBuilder::createFromList
         */
        public function test_Two_Files_Uploaded_from_Diffrent_Inputs()
        {
            $input = [
                'alpha' => [
                    'name'      => 'simple.png',
                    'type'      => 'image/png',
                    'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                    'error'     => 0,
                    'size'      => 74,
                ],
                'beta' => [
                    'name'      => 'no-extension',
                    'type'      => 'application/octet-stream',
                    'tmp_name'  => FIXTURE_PATH . '/files/tempname',
                    'error'     => 0,
                    'size'      => 75,
                ],
            ];

            $response  = $this->getMock( 'UploadedFile', ['isValid'] );
            $response->expects( $this->exactly(2) )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );


            $builder = $this->getMock( 'UploadedFileBuilder', ['create'] );
            $builder->expects( $this->exactly(2) )
                    ->method( 'create' )
                    ->will( $this->returnValue( $response ) );

            $instance = new FileBagBuilder( $builder );
            $object = $instance->create( $input );

            $this->assertInstanceOf( 'Fracture\Http\FileBag', $object );
        }


    }