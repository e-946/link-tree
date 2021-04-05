<?php
    class Header
    {
        const IMAGE_DEFAULT = "src". DIRECTORY_SEPARATOR."img". DIRECTORY_SEPARATOR."default-user.png";

        private $image;
        private $username;
        private $renderedHtml;

        function __construct($username, $image = self::IMAGE_DEFAULT)
        {
            $this->image = $image;
            $this->username = $username;
        }

        public function makeHeader(){
            $html = sprintf("<img src='%s' alt='imagem-perfil' class='profile-image'>\n<h1 class='profile-title'>%s</h1>",
                $this->image,
                $this->username
            );
            $this->renderedHtml = $html;
            return $this;
        }

        public function getHeaderHtml(){
            return $this->renderedHtml;
        }
    }