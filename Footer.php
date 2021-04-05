<?php
class Footer
{

    private $opacity;
    private $align;
    private $color;
    private $renderedHtml;

    function __construct($opacity, $color, $align = "center")
    {
        $this->opacity = $opacity;
        $this->color = $color;
        $this->align = $align;
    }
    public function makeFooter()
    {
        $html = sprintf("<footer style='display:flex; justify-content: %s; text-align: %s; color:%s; opacity:%f'> Desenvolvido por E-946&copy </footer>",
            $this->align,
            $this->align,
            $this->color,
            (string)$this->opacity
        );

        $this->renderedHtml = $html;
        return $this;   
    }

    public function getFooterHtml()
    {
        return $this->renderedHtml;
    }

}