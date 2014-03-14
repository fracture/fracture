<?php

    namespace Fracture\Http;

    class ContentTypeHeader implements AbstractedHeader{


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
            return $elements;
        }

        public function contains( $type )
        {
            return in_array( $type, $this->list );
        }
    }
