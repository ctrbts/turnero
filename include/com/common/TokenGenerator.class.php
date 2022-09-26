<?php

    class TokenGenerator{

        public function Generate(){
            return bin2hex(random_bytes(16));
        }
    }

?>