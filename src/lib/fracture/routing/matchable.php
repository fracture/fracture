<?php

    namespace Fracture\Routing;

    interface Matchable
    {
        public function getMatch( $uri );
    }
