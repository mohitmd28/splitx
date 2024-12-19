<?php

namespace Core;

class View
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $data;

    /**
     * @param string $file
     * @param array $data
     */
    public function __construct(string $file, array $data = [])
    {
        $this->file = $file;
        $this->data = $data;
    }

    /**
     * Render the give view
     * 
     * @return void
     */
    public function render(): void
    {
        $content    = $this->getContent();
        $layout     = $this->determineLayout($content);

        // if we don't need to use any layout then
        // render the content
        if (empty($layout)) {
            echo $content;
            return;
        }

        echo $this->renderLayout($layout, $content);
    }

    /**
     * Get the view content
     * 
     * @return string
     */
    protected function getContent(): string
    {
        ob_start();

        extract($this->data);

        require "../view/{$this->file}.view.php";

        return ob_get_clean();
    }

    protected function determineLayout(string $content): string
    {
        preg_match('/@layout\(\'(.*)\'\)/', $content, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

    protected function renderLayout(string $layout, string $content): string
    {
        $layoutContent = $this->getLayoutContent($layout);

        $content = $this->stripLayoutTag($content);

        return str_replace('%content%', $content, $layoutContent);
    }

    protected function getLayoutContent(string $layout): string
    {
        ob_start();

        require "../view/layouts/{$layout}.view.php";

        return ob_get_clean();
    }

    protected function stripLayoutTag(string $content): string
    {
        return preg_replace('/@layout\(.*\)/', '', $content);
    }
}
