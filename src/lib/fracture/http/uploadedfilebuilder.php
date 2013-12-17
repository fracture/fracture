<?php

    namespace Fracture\Http;

    class UploadedFileBuilder
    {

        public function create( $params )
        {
            $instance = $this->buildInstance( $params )
            $instance->prepare();


            if ( $instance->isValid() === false )
            {
                $instance = null;
            }

            return $instance;
        }


        protected function buildInstance( $params )
        {
            return new UploadedFile( $params );
        }

    }


