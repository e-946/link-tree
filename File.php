<?php
    class File 
    {
        private $path;
        private $cacheIsValid;

        public function __construct ($path, $cacheIsValid = false){
            $this->path = __DIR__ . DIRECTORY_SEPARATOR . $path;
            $this->cacheIsValid = $cacheIsValid;
        }

        public function makeCssFile($content)
        {
            if(!file_exists($this->path)){
                file_put_contents($this->path, $content);
                return $this->path;     
            }                 
            
            if(!$this->cacheIsValid){
                file_put_contents($this->path, $content);
                return $this->path;     
            }

            return $this->path;
        }

    }