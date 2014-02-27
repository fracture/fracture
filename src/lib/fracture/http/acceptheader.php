<?php

    namespace Fracture\Http;

    class AcceptHeader implements AbstractedHeader{


        private $headerValue = '';

        private $list = [];

        public function __construct( $headerValue = '' )
        {
            $this->headerValue = $headerValue;
        }


        public function setAlternativeValue( $headerValue )
        {
            $this->headerValue = $headerValue;
        }


        public function prepare()
        {
            $elements = preg_split( '#,\s?#', $this->headerValue, -1, PREG_SPLIT_NO_EMPTY );
            $elements = $this->obtainGroupedElements( $elements );

            $keys = $this->obtainSortedQualityList( $elements );

            $this->list = $this->obtainSortedElements( $elements, $keys );
        }



        public function getPrioritizedList()
        {
            return  $this->list;
        }



        protected function obtainGroupedElements( $elements )
        {
            $result = [];

            foreach ( $elements as $item )
            {
                $item = $this->obtainAssessedItem( $item );
                $quality = $item[ 'q' ];

                if ( array_key_exists( $quality, $result) === false )
                {
                    $result[ $quality ] = [];
                }

                $result[ $quality ][] = $item;
            }

            return $result;
        }


        protected function obtainAssessedItem( $item )
        {
            $result = [];
            $parts = preg_split( '#;\s?#', $item, -1, PREG_SPLIT_NO_EMPTY );
            $result['value'] = array_shift( $parts );

            foreach ( $parts as $item )
            {
                list( $key, $value ) = explode( '=', $item . '=' );
                $result[ $key ] = $value;
            }

            $result = $result + [ 'q' => '1' ];

            return $result;
        }


        protected function obtainSortedQualityList( $elements )
        {
            $keys = array_keys( $elements );
            $keys = array_map( function($value){ return (float)$value; } , $keys );
            rsort($keys);
            return array_map( function($value){ return (string)$value; }, $keys );
        }


        protected function obtainSortedElements( $elements, $keys )
        {
            $list = [];

            foreach ( $keys as $key )
            {
                foreach ( $elements[ $key ] as $item )
                {
                    unset( $item['q'] );
                    $list[] = $item;
                }
            }

            return $list;
        }


        public function contains( $type )
        {
            $expected = $this->obtainAssessedItem( $type );
            unset( $expected['q'] );


            foreach( $this->list as $item )
            {
                if ( $expected == $item )
                {
                    return true;
                }
            }

            return false;
        }

    }