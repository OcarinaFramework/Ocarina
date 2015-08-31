<?php
namespace Ocarina\Http;

use Ocarina\Http\HttpRequestRouting;
use Ocarina\Http\HttpRequestParam;

/**
 * Class HttpRequest
 *
 * Defines an Http request
 *
 * @package Framework\Http
 */
class HttpRequest {

    /**
     * @var array
     */
    private $_modules;

    /**
     * @var array
     */
    private $_uriParams;

    /**
     * Http uri
     * @var HttpRequestRouting
     */
    private $_routing;
    /**
     * Http method name
     * POST, GET
     * @var string
     */
    private $_method;
    /**
     * Http sent params
     * from $_GET and $_POST
     * @var HttpRequestParam[]
     */
    private $_params;


    public function __construct($modules = array()) {
        $this->_modules = $modules;
        $this->_uriParams = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
        $this->_method = $_SERVER['REQUEST_METHOD'];

        $this->buildRouting();
        $this->buildParams();
    }

    /**
     * @return String
     */
    public function getMethod()
    {
        return $this->_method;
    }


    protected function buildRouting() {
        // get application module
        $module = $this->getApplicationModule();
        // build a new routing
        $this->_routing = new HttpRequestRouting($module);
        if(empty($this->_uriParams)) {
            return;
        }
        $this->_routing->setController($this->_uriParams[0]);
        unset($this->_uriParams[0]);
        if(array_key_exists(1, $this->_uriParams)) {
            $this->_routing->setAction($this->_uriParams[1]);
            unset($this->_uriParams[1]);
        }
        array_values($this->_uriParams);
    }

    protected function getApplicationModule() {
        $module = null;
        if(!empty($this->_uriParams)) {
            $hasModule = array_key_exists($this->_uriParams[0], $this->_modules);
            if($hasModule) {
                $module = $this->_uriParams[0];
                // remove module from uri params
                // and re-index array
                unset($this->_uriParams[0]);
                $this->_uriParams = array_values($this->_uriParams);
            }
        }
        if(!isset($module)) {
            $module = array_search('/', $this->_modules);
        }

        return ucfirst(strtolower($module));
    }



    protected function buildParams() {
        $params = array();
        foreach($_GET as $paramName => $paramValue) {
            $params[] = new HttpRequestParam($paramName, $paramValue);
        }
        for($i = 0; $i < count($this->_uriParams); $i+=2) {
            $params[] = new HttpRequestParam($this->_uriParams[$i], $this->_uriParams[$i+1]);
        }

        foreach($_POST as $paramName => $paramValue) {
            $params[] = new HttpRequestParam($paramName, $paramValue);
        }

        foreach($_FILES as $paramName => $file) {
            $param = new HttpRequestParam($paramName, $file);
            $param->setMultipart(true);
            $params[] = $param;
        }

        $this->_params = $params;
    }

    /**
     * @return HttpRequestRouting
     */
    public function getRouting()
    {
        return $this->_routing;
    }

    public function getParams() {
        return $this->_params;
    }

    public function getParam($name, $isMultipart = false) {
        $p = null;
        foreach($this->_params as $param) {
            if($param->getName() === $name && $param->isMultipart() === $isMultipart) {
                $p = $param;
                break;
            }
        }
        return $p;
    }

}