<?php
namespace Ocarina;

use Ocarina\Http\HttpRequest;
use Ocarina\Http\HttpResponse;
use Ocarina\Template\TemplateEngine;

class Core {

    /**
     * Application modules
     * @var array
     */
    private $_modules;

    /**
     * @var HttpRequest
     */
    private $_request;
    /**
     * @var HttpResponse
     */
    private $_response;

    /**
     * @var TemplateEngine
     */
    private $_templateEngine;

    public function __construct(Bootstrap $bootstrap) {
        $this->_modules = $bootstrap::registerModules();
        $this->_templateEngine = $bootstrap::initTemplateEngine();
        $this->_request = new HttpRequest($this->_modules);
        $this->_response = new HttpResponse($this->_request->getRouting());
    }

    /**
     */
    public function dispatch() {
        $routing = $this->_request->getRouting();

        $controllerName = 'App\\'.$routing->getModule().'\Controller\\' . $routing->getController() . 'Controller';
        $res = call_user_func_array(
            array(
                new $controllerName(),
                $routing->getAction() . 'Action'
            ),
            array(
                $this->_request,
                $this->_response
            )
        );
        $this->_response->setBody($res);
    }

    /**
     * HttpResponse rendering method
     */
    public function render() {
        if($this->_response->hasNoLayout()) {
            echo $this->_response->render($this->_templateEngine);
            return;
        }

        $response = new HttpResponse($this->_request->getRouting());
        $response->setBody(array('content' => $this->_response->render($this->_templateEngine)));
        $response->setTemplate('layout.tpl');
        echo $response->render($this->_templateEngine);
    }

}