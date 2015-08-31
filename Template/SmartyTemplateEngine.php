<?php
namespace Ocarina\Template;

class SmartyTemplateEngine implements TemplateEngine {

    /**
     * @var \Smarty
     */
    private $_engine;


    public function __construct() {
        $this->_engine = new \Smarty();
        $this->_engine->setCompileDir(dirname(__FILE__).'/../../../../cache');
    }

    public function render(array $data, $template) {
        foreach($data as $name => $param) {
            $this->_engine->assign($name, $param);
        }

        return $this->_engine->fetch($template);
    }

    public function setTemplatePath($templatePath)
    {
        $this->_engine->setTemplateDir($templatePath);
    }
}