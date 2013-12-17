<?php

    namespace Fracture\Http;

    class FileBagBuilder
    {

        private $uploadedFileBuilder = null;


        public function __construct( $builder )
        {
            $this->uploadedFileBuilder = $builder;
        }


        public function create( $list )
        {
            $instance = new FileBag;

            foreach ( $list as $key => $value )
            {
                $item = $this->createItem( $value );
                $instance[ $key ] =  $item;
            }

            return $instance;
        }

        private function createItem( $params )
        {
            if ( isset( $params[ 'name' ] ) === true &&
                 is_array( $params[ 'name' ] ) === true )
            {
                return $this->createFromList( $params );
            }

            return $this->uploadedFileBuilder->create( $params );
        }


        private function createFromList( $list )
        {
            $instance = new FileBag;

            foreach ( array_keys( $list['name'] ) as $key )
            {
                $params = [
                    'name'      => $list['name'][$key],
                    'type'      => $list['type'][$key],
                    'tmp_name'  => $list['tmp_name'][$key],
                    'error'     => $list['error'][$key],
                    'size'      => $list['size'][$key],
                ];
                $file = $this->uploadedFileBuilder->create( $params );
                $instance[] = $file;
            }

            return $instance;
        }

    }