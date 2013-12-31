<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;

    use \Mock\UploadedFile as ExposedUploadedFile;


    class UploadedFileTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @dataProvider simple_Type_Provider
         *
         * @covers Fracture\Http\UploadedFile::__construct
         * @covers Fracture\Http\UploadedFile::getMimeType
         * @covers Fracture\Http\UploadedFile::prepare
         * @covers Fracture\Http\UploadedFile::hasProperExtension
         * @covers Fracture\Http\UploadedFile::isDubious
         * @covers Fracture\Http\UploadedFile::getPath
         */
        public function test_Upload_Types( $params, $type, $validity )
        {

            $instance = $this->getMock( 'Fracture\Http\UploadedFile', [ 'seemsTampered' ], [ $params ] );
            $instance->expects( $this->once() )
                     ->method( 'seemsTampered' )
                     ->will( $this->returnValue( false ) );

            $instance->prepare();
            $this->assertEquals( $type, $instance->getMimeType() );
            $this->assertEquals( $validity, $instance->hasProperExtension() );
        }

        public function simple_Type_Provider()
        {
            return include FIXTURE_PATH . '/http/uploads-type.php';
        }

        /**
         * @dataProvider simple_Validity_provider
         *
         * @covers Fracture\Http\UploadedFile::__construct
         * @covers Fracture\Http\UploadedFile::isValid
         * @covers Fracture\Http\UploadedFile::prepare
         * @covers Fracture\Http\UploadedFile::isDubious
         * @covers Fracture\Http\UploadedFile::getPath
         */
        public function test_Upload_Validity( $params, $result )
        {
            $instance = $this->getMock( 'Fracture\Http\UploadedFile', [ 'seemsTampered' ], [ $params ] );
            $instance->method( 'seemsTampered' )
                     ->will( $this->returnValue( false ) );


            $instance->prepare();
            $this->assertEquals( $result, $instance->isValid() );
        }


        public function simple_Validity_provider()
        {
            return include FIXTURE_PATH . '/http/uploads-validity.php';
        }


        /**
         * @covers Fracture\Http\UploadedFile::__construct
         * @covers Fracture\Http\UploadedFile::getName
         * @covers Fracture\Http\UploadedFile::getMimeType
         * @covers Fracture\Http\UploadedFile::getSize
         */
        public function test_Simple_Getters()
        {
            $params = [
                'name'      => 'simple.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                'error'     => UPLOAD_ERR_OK,
                'size'      => 74,
            ];

            $instance = new UploadedFile( $params );

            $this->assertEquals( $params['name'], $instance->getName() );
            $this->assertEquals( $params['type'], $instance->getMimeType() );
            $this->assertEquals( $params['size'], $instance->getSize() );
        }


    }