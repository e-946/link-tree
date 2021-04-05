<?php

    class Button {

        const CSS_PATH = 'src' . DIRECTORY_SEPARATOR . 'button.css'; 

        private $renderedHtml;
        private $name;
        private $link;
        private $color;
        private $backgroundColor;
        private $css;

        public function __construct($name, $link, $color, $backgroundColor)
        {
            $this->name = $name;
            $this->link = $link;
            $this->color = $color;
            $this->backgroundColor = $backgroundColor;
        }
        
        public function verifyImg(){
            if(!file_exists('src/img/'.$this->name.'.png')){
                return false;
            }
                return true;
        }   
        
        public function makeButton()
        {
            /*if(!$this->verifyImg()){
                $html = sprintf(
                    '<a class="btn-no-image" type="button" target="__blank" href="%s" style="background-color:%s; color:%s"> %s</a>',
                    $this->link,
                    $this->backgroundColor,
                    $this->color,
                    $this->name
                );
                $this->renderedHtml = $html;
    
                return $this;
            }*/

            $html = sprintf('<a class="btn btn-%s" type="button" target="__blank" href="%s"> <i class="fab fa-%s img-btn"></i> %s</a>',
                $this->name,
                $this->link,
                strtolower($this->name),
                $this->name
                );
                $css = sprintf("
    .btn-%s {
        background:%s;
        color:%s;
    }
    .btn-%s:hover{
        background:%s;
        color:%s;
    }
    ",
                $this->name,
                $this->backgroundColor,
                $this->color,
                $this->name,
                $this->color,
                $this->backgroundColor
            );

            $this->renderedHtml = $html;
            $this->css = $css;

            return $this;
        }

        public function getButtonHtml(): string
        {
            return $this->renderedHtml;
        }

        public function getCss(): string
        {
            return $this->css;
        }
    }