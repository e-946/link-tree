<?php
require_once('Header.php');
require_once('Footer.php');
require_once('Button.php');
require_once('File.php');

class Builder
{
    const CACHE_PATH = 'src' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'config-cached';
    const CSS = 'css';
    const BUTTONS = 'buttons';

    private $config;

    private $renderedHtmlButton;
    private $renderedHtmlFooter;
    private $renderedHtmlHeader;

    private $cacheIsValid;
    private array $paths;   
    

    public function __construct(string $pathToConfig)
    {
        $json = file_get_contents($pathToConfig);
        $this->cacheIsValid = $this->checkCache($json);
        $this->config = json_decode($json, true);
        $successButton = $this->renderizeButton();
        $sucessFooter = $this->renderizeFooter();
        $sucessHeader = $this->renderizeHeader();
        if (!$successButton || $sucessFooter || $sucessHeader) {
            throw new Exception('Não foi possível renderizar');
        }
    }

    private function checkCache(string $toCache)
    {
        if(!file_exists(self::CACHE_PATH)) {
            $isSuccess = $this->saveCache($toCache);
            return !$isSuccess;
        }

        $cached = file_get_contents(self::CACHE_PATH);
        $toCacheTrimmed = $this->trimm($toCache);

        if($cached !== $toCacheTrimmed) {
            $isSuccess = $this->saveCache($toCache);

            return !$isSuccess;
        }

        return true;
    }

    private function trimm(string $toTrim)
    {
        return preg_replace('/\s*/', "", $toTrim);
    }

    private function saveCache(string $toCache)
    {
        $cache = $this->trimm($toCache);
        $bytes = file_put_contents(self::CACHE_PATH, $cache);

        if (!$bytes) {
            return false;
        }

        return true;
    }

    public function getConfig(): array 
    {
        return $this->config;
    }

    public function cacheIsValid()
    {
        return $this->cacheIsValid;
    }

    public function renderizeButton()
    {
        $buttons = $this->createButtons();
        if (!$buttons) {
            return false;
        }

        $html = '';
        $css = '';

        foreach($buttons as $button) {
            $html .= $button->makeButton()->getButtonHtml();
            $css .= $button->getCss();
        }

        $this->renderedHtmlButton = $html;
        $file = new File(Button::CSS_PATH, $this->cacheIsValid);
        $path = $file->makeCssFile($css);
        $this->paths[self::CSS][self::BUTTONS] = $path;

        return true;
    }

    private function createButtons()
    {
        if (!$this->config['buttons']) {
            return false;
        }

        $buttons = $this->getButtonsByPriority($this->config['buttons']);
        $buttonsElements = [];

        foreach ($buttons as $button) {
            $buttonsElements[] = new Button(
                $button['name'],
                $button['link'],
                $button['color'],
                $button['background-color']
            );
        }

        return $buttonsElements;
    }
    public function renderizeFooter()
    {
        $footer = $this->createFooter();
        if(!$footer){
            return false;
        }
        $html = $footer->makeFooter()->getFooterHtml();
        $this->renderedHtmlFooter = $html;
        
    }

    private function createFooter()
    {
        if(!$this->config['footer']){
            return false;
        }
        $footer = $this->config['footer'];
        $footer = new Footer($footer['opacity'],$footer['color'],$footer['align']);
        return $footer;
    }
    public function renderizeHeader()
    {
        $header = $this->createHeader();
        if(!$header){
            return false;
        }
        $html = $header->makeHeader()->getHeaderHtml();
        $this->renderedHtmlHeader = $html;
    }
    private function createHeader()
    {
        if(!$this->config['header']){
            return false;
        }
        $header = $this->config['header'];
        $header = new Header($header['username'], $header['image']);
        return $header;
    }

    public function getButtonsByPriority(array $buttons)
    {
        $buttons = $this->orderCrescentedArray($buttons, 'name');

        foreach ($buttons as $key => $button) {
            $buttons[$key]['priority'] = $button['priority'] ?? 99;
        }

        $buttons = $this->orderCrescentedArray($buttons, 'priority');

        return $buttons;    
    }   

    public function orderCrescentedArray(array $array, string $index)
    {
        uasort($array, function($item1, $item2) use ($index) {
            return $item1[$index] > $item2[$index];
        });

        return $array;
    }

    public function renderHtmlFooter()
    {
        echo $this->renderedHtmlFooter;
    }

    public function renderHtmlButton()
    {
        echo $this->renderedHtmlButton;
    }
    public function renderHtmlHeader()
    {
        echo $this->renderedHtmlHeader;
    }

    public function pathToButtonCss(): string
    {
        return $this->paths[self::CSS][self::BUTTONS];
    }
}
