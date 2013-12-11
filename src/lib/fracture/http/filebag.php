<?php

    namespace Http;

    class FileBag
    {

        private $rawParams = [];


        public function __construct( $list )
        {
            $this->rawParams = $list;
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

    }