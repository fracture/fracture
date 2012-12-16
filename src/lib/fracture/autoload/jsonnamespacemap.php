<?php

    namespace Fracture\Autoload;

    class JsonNamespaceMap extends NamespaceMap
    {

        use \Fracture\Transcription\JsonToArray;


        public function import( $filepath )
        {
            $config = $this->fetchConfig( $filepath );
            $this->applyValues( $config );
        }


        protected function applyValues( $config, $id = 0 )
        {
            foreach ( $config as $name => $data )
            {
                $this->growBranch( $name, $data, $id );
            }
        }


        protected function growBranch( $name, $data, $id )
        {
            $current =  $this->growNode( $name, $id );

            foreach( $data as $parameter )
            {
                $this->handleParameter( $parameter, $current );
            }
        }


        protected function handleParameter( $parameter, $id )
        {
            if ( is_array( $parameter ) )
            {
                $this->applyValues( $parameter, $id );
            }

            if ( is_string( $parameter ) )
            {
                $this->tree[ $id ][ 'paths' ][] = $parameter;
            }
        }


    }