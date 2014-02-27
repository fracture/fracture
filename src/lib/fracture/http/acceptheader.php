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
            $this->list = [];

            if ( strlen( $this->headerValue ) > 0 )
            {
                $this->list = $this->getParsedList( $this->headerValue );
            }
        }

        public function getParsedList( $header )
        {
            $elements = preg_split( '#,\s?#', $header, -1, PREG_SPLIT_NO_EMPTY );
            $elements = $this->obtainGroupedElements( $elements );
            $keys = $this->obtainSortedQualityList( $elements );
            return $this->obtainSortedElements( $elements, $keys );
        }



        public function getPrioritizedList()
        {
            return  $this->list;
        }



        private function obtainGroupedElements( $elements )
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


        private function obtainAssessedItem( $item )
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


        private function obtainSortedQualityList( $elements )
        {
            $keys = array_keys( $elements );
            $keys = array_map( function($value){ return (float)$value; } , $keys );
            rsort($keys);
            return array_map( function($value){ return (string)$value; }, $keys );
        }


        private function obtainSortedElements( $elements, $keys )
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
                if ( $this->isMatch( $expected, $item ) )
                {
                    return true;
                }
            }

            return false;
        }


        public function getPreferred( $options )
        {
            $options = $this->getParsedList( $options );

            foreach ( $this->list as $item )
            {
                $entry = $this->obtainEntryFromList( $item, $options );

                if ( $entry !== null)
                {
                    return $entry['value'];
                }
            }

            return null;
        }


        private function obtainEntryFromList( array $needle, $haystack )
        {
            foreach ( $haystack as $item )
            {
                if ( $this->isMatch( $item, $needle ) )
                {
                    return $item;
                }
            }

            return null;
        }

        private function isMatch( array $left, array $right )
        {
            if ( $left == $right )
            {
                return true;
            }

            $left['value'] = $this->replaceStars( $left['value'], $right['value'] );
            $right['value'] = $this->replaceStars( $right['value'], $left['value'] );

            return $left == $right;
        }

        private function replaceStars( $target, $pattern )
        {
            $target = explode( '/', $target . '/*' );
            $pattern = explode( '/', $pattern . '/*' );

            if ( $pattern[0] === '*' )
            {
                $target[0] = '*';
            }

            if ( $pattern[1] === '*' )
            {
                $target[1] = '*';
            }

            return $target[0] . '/' . $target[1];
        }

    }