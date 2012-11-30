<?php

    namespace Fracture\Autoload;


    class ClassLoader
    {

        protected $maps = [];

        protected $silent;

        protected $basePath = DIRECTORY_SEPARATOR;

        
        public function __construct( $silent = FALSE )
        {
            $this->silent = $silent;
        }
        

        public function addMap( Searchable $map, $basePath )
        {
            $item = [ 'map'  => $map, 
                      'path' => $basePath ];

            $this->maps[] = $item;
        }


        public function register()
        {
            spl_autoload_register( array( $this, 'load' ) );
        }



        protected function load( $className )
        {

            foreach ( $this->maps as $item )
            {


                $locations = $item['map']->getLocations( $className );

                foreach ( $locations as $filepath )
                {
                    $filepath = $item['path'] . $filepath;
                    if ( file_exists( $filepath ) )
                    {
                        require $filepath;
                        return;
                    }
                }

            }

            if ( $this->silent === FALSE )
            {
                throw new ClassNotFoundException( "Class '$className' not found!" );
            }
        }


    }

?>