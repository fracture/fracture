<?php

    namespace Http;

    class FileBag implements \Iterator
    {

        private $params = [];

        private $entries = [];

        private $current = 0;


        public function __construct( $params )
        {
            $this->params = $params;
        }


        public function prepare()
        {

        }


        public function hasItem( $name )
        {

        }


        public function fetchItem( $name )
        {

        }


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




    }