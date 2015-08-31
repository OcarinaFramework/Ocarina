<?php
namespace Ocarina\Http;

use Ocarina\Template\TemplateEngine;

/**
 * Class HttpResponse
 *
 * Defines an Http response
 *
 * @package Framework\Http
 */
class HttpResponse {

    public static $contentTypes = array(
        'JSON' => 'application/json',
        'HTML' => 'text/html'
    );

    /**
     * @var String
     */
    private $_templatePath;

    /**
     * Custom template name
     * full path from /view folder
     * @var string
     */
    private $_template;

    /**
     * @var bool
     */
    private $_noLayout;

    private $_body;

    private $_contentType;

    /**
     * @var HttpRequestRouting
     */
    private $_routing;


    public function __construct(HttpRequestRouting $routing) {
        $this->_routing = $routing;
        $this->_templatePath = dirname(__FILE__).'/../../../../app/'.strtolower($routing->getModule()).'/view/';
        $this->_noLayout = false;
        $this->_contentType = self::$contentTypes['HTML'];
    }

    public function redirect($url) {
        header('Location: ' . $url);
    }

    public function download($file) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$file\"");
    }

    public function render(TemplateEngine $templateEngine) {
        $rendering  = null;
        switch(array_search($this->_contentType, self::$contentTypes)) {
            case 'JSON':
                $rendering = $this->renderAsJson();
                break;
            case 'HTML':
            default:
                $rendering = $this->renderAsHtml($templateEngine);
                break;
        }

        return $rendering;
    }

    public function renderAsHtml(TemplateEngine $templateEngine) {
        $tpl = null;
        if(isset($this->_template)) {
            $tpl = $this->_templatePath . $this->_template;
        } else {
            $tpl = $this->_templatePath . strtolower($this->_routing->getController()) . '/' . strtolower($this->_routing->getAction()) . '.tpl';
        }

        header('Content-Type: text/html');
        $templateEngine->setTemplatePath($this->_templatePath);
        return $templateEngine->render($this->_body, $tpl);
    }

    public function renderAsJson() {
        header('Content-Type: application/json');
        return json_encode($this->_body);
    }

    /**
     * @param bool $noLayout
     */
    public function setNoLayout($noLayout) {
        $this->_noLayout = $noLayout;
    }

    /**
     * @return bool
     */
    public function hasNoLayout() {
        return $this->_noLayout;
    }

    public function setBody($body) {
        $this->_body = $body;
    }

    public function setContentType($contentType) {
        if(in_array($contentType, self::$contentTypes)) {
            $this->_contentType = $contentType;
        }
    }

    public function setTemplate($template) {
        $this->_template = $template;
    }

}