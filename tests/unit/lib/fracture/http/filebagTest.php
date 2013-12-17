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
         */
        public function test_ArrayAccess_for_One_Valid_Item_without_Key()
        {
            $instance = new FileBag;


            $item  = $this->getMock( 'Fracture\Http\UploadedFile', ['isValid'], [ 'foo' => 'bar'] );
            $item->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );

            $this->assertFalse( isset( $instance[ 0 ] ) );
            $instance[] = $item;
            $this->assertTrue( isset( $instance[ 0 ] ) );
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


        /**
         * @dataProvider provide_List_of_UploadedFile_Instances
         *
         * @covers Fracture\Http\FileBag::current
         * @covers Fracture\Http\FileBag::key
         * @covers Fracture\Http\FileBag::next
         * @covers Fracture\Http\FileBag::rewind
         * @covers Fracture\Http\FileBag::valid
         */
        public function test_Iterator_with_Foreach_Loop( $first, $second, $third )
        {
            $instance = new FileBag;

            $instance['a'] = $first;
            $instance['b'] = $second;
            $instance['c'] = $third;


            $expected = [ 'a' =>  $first, 'b' => $second, 'c' => $third ];
            $keys = ['a', 'b', 'c'];

            foreach ( $instance as $key => $value )
            {
                $this->assertEquals( array_shift( $keys ), $key );
                $this->assertEquals( $expected[$key], $value );
            }
        }


        /**
         * @dataProvider provide_List_of_UploadedFile_Instances
         *
         * @covers Fracture\Http\FileBag::current
         * @covers Fracture\Http\FileBag::key
         * @covers Fracture\Http\FileBag::next
         * @covers Fracture\Http\FileBag::rewind
         * @covers Fracture\Http\FileBag::valid
         */
        public function test_Iterator_Directly_with_Numeric_Keys( $first, $second, $third )
        {
            $instance = new FileBag;

            $instance[] = $first;
            $instance[] = $second;
            $instance[] = $third;

            $this->assertEquals( $first, $instance->current() );
            $instance->next();
            $this->assertEquals( 1, $instance->key() );
            $instance->next();
            $instance->next();
            $this->assertFalse( $instance->valid() );
            $this->assertEquals( 3, $instance->key() );
            $instance->rewind();
            $this->assertEquals( 0, $instance->key() );
            $instance->next();
            $this->assertEquals( $second, $instance->current() );

        }


        public function provide_List_of_UploadedFile_Instances()
        {
            $first  = $this->getMock( 'Fracture\Http\UploadedFile', ['isValid'], [ 'foo' => 'bar' ] );
            $first->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );

            $second  = $this->getMock( 'Fracture\Http\UploadedFile', ['isValid'], [ 'foo' => 'bar' ] );
            $second->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );

            $third  = $this->getMock( 'Fracture\Http\UploadedFile', ['isValid'], [ 'foo' => 'bar' ] );
            $third->expects( $this->once() )
                     ->method( 'isValid' )
                     ->will( $this->returnValue( true ) );

            return [[
                'first'  => $first,
                'second' => $second,
                'third'  => $third,
            ]];
        }

    }