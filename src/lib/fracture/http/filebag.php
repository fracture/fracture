<?php

    namespace Fracture\Http;

    class FileBag implements \Iterator, \ArrayAccess
    {

        private $entries = [];

        private $current = 0;




        // implementing Iterator interface
        public function current()
        {
            return $this->entries[ $this->current ];
        }


        public function key()
        {
            return $this->current;
        }


        public function next()
        {
            $this->current += 1;
        }


        public function rewind()
        {
            $this->current = 0;
        }


        public function valid()
        {
            return isset( $this->entries[ $this->current ] );
        }


        // implementing ArrayAccess interface
        public function  offsetExists ( $offset )
        {
            return isset( $this->entries[ $offset ] );
        }


        public function offsetSet ( $offset, $value )
        {
            if ( $value->isValid() === false )
            {
                return;
            }

            if ( is_null( $offset ) === true )
            {
                $this->entries[] = $value;
            }
            else
            {
                $this->entries[ $offset ] = $value;
            }
        }


        public function offsetGet ( $offset )
        {
            if ( array_key_exists( $offset, $this->entries ) )
            {
                return $this->entries[ $offset ];
            }

            return null;
        }


        public function offsetUnset ( $offset )
        {
            unset( $this->entries[ $offset ] );
        }


    }