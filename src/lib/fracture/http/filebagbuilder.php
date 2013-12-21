<?php

    namespace Fracture\Http;

    class FileBagBuilder
    {

        private $uploadedFileBuilder = null;


        public function __construct( $builder )
        {
            $this->uploadedFileBuilder = $builder;
        }


        /**
         * Used for producinf a FileBag instance from standard $_FILES values
         *
         * @param array $list
         */
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
            // when using multiple "array inputs", the data ends up formated
            // as 'name' => [first, second, ..]
            if ( isset( $params[ 'name' ] ) === true &&
                 is_array( $params[ 'name' ] ) === true )
            {
                return $this->createFromList( $params );
            }

            return $this->uploadedFileBuilder->create( $params );
        }


        /**
         * When using <input type="file" name="foobar[]"> type of definitions,
         * this method is repsonsible for re-packeging the inputs into a sub-filebag
         */
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