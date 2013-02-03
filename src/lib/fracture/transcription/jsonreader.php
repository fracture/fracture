<?php


    namespace Fracture\Transcription;

    class JsonReader
    {

        public function getAsArray( $filepath )
        {
            if ( file_exists( $filepath ) === false )
            {
                throw new \Exception( "File '$filepath' not found!" );
            }

            $json = file_get_contents( $filepath );
            $data = json_decode( $json, true );

            if ( is_array( $data ) === false )
            {
                throw new \Exception( "Not valid JSON from '$filepath' file!" );
            }

            return $data;
        }

    }