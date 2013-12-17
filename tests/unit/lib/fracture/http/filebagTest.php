<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class FileBagTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Http\FileBag::offsetExists
         * @covers Fracture\Http\FileBag::offsetSet
         * @covers Fracture\Http\FileBag::offsetGet
         * @covers Fracture\Http\FileBag::offsetUnset
         */
        public function test_ArrayAccess_for_One_Valid_Item()
        {
            $instance = new FileBag;


            $item  = $this->getMock( 'Fracture\Http\UploadedFile', ['isValid'], [ 'foo' => 'bar'] );
            $item->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );

            $this->assertFalse( isset( $instance[ 'foo' ] ) );
            $instance[ 'foo' ] = $item;
            $this->assertTrue( isset( $instance[ 'foo' ] ) );
            $this->assertEquals( $item, $instance[ 'foo' ] );
            unset( $instance[ 'foo' ] );
            $this->assertFalse( isset( $instance[ 'foo' ] ) );
        }


        /**
         * @covers Fracture\Http\FileBag::offsetExists
         * @covers Fracture\Http\FileBag::offsetSet
         * @covers Fracture\Http\FileBag::offsetGet
         * @covers Fracture\Http\FileBag::offsetUnset
         */
        public function test_ArrayAccess_for_One_Inalid_Item()
        {
            $instance = new FileBag;


            $item  = $this->getMock( 'Fracture\Http\UploadedFile', ['isValid'], [ 'foo' => 'bar' ] );
            $item->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( false ) );

            $this->assertFalse( isset( $instance[ 'foo' ] ) );
            $instance[ 'foo' ] = $item;
            $this->assertFalse( isset( $instance[ 'foo' ] ) );
            $this->assertNull( $instance[ 'foo' ] );
            unset( $instance[ 'foo' ] );
            $this->assertFalse( isset( $instance[ 'foo' ] ) );
        }

    }