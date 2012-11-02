<?php

    namespace Fracture\Autoload;


    class ClassLoader
    {

        protected $map;

        protected $basePath = DIRECTORY_SEPARATOR;

        
        public function __construct( Searchable $map )
        {
            $this->map = $map;
        }
        

        public function setBasePath( $basePath )
        {
            $this->basePath = $basePath;
        }


        public function register()
        {
            spl_autoload_register( array( $this, 'load' ) );
        }



        protected function load( $className )
        {

            $locations = $this->map->getLocations( $className );

            foreach ( $locations as $filepath )
            {
                $filepath = $this->basePath . $filepath;
                if ( file_exists( $filepath ) )
                {
                    require $filepath;
                    return;
                }
            }

            throw new ClassNotFoundException( "Class '$className' not found!" );
        }


    }

?>