<?php

    namespace Fracture\Transcription;

    trait JsonToArray{

        protected function fetchConfig( $filepath )
        {
            if ( !file_exists( $filepath ) )
            {
                throw new \Exception( "File '$filepath' not found!" );
            }
    
            $json = file_get_contents( $filepath );
            $data = json_decode( $json, TRUE );
    
            if ( ! is_array( $data ) )
            {
                throw new \Exception( "Not valid JSON from '$filepath' file!" );
            }
    
            return $data;
        }
       
    }


?>