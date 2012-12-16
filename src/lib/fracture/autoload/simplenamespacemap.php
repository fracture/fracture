<?php

    namespace Fracture\Autoload;

    class SimpleNamespaceMap extends NamespaceMap
    {


        public function addNamespacePath( $namespace, $path )
        {
            $segments = explode( '\\', $namespace );
            $id = $this->growBranch( $segments );
            $this->tree[ $id ][ 'paths' ][] = $path;
        }


        protected function growBranch( array $segments )
        {
            $total = count( $segments );
            $current = 0;

            for ( $i = 0; $i < $total; $i++ )
            {
                $name = $segments[ $i ];
                $current = $this->growNode( $name, $current );
            }

            return $current;
        }

    }