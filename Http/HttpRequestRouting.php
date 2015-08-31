<?php
namespace Ocarina\Http;

/**
 * Class HttpRouting
 *
 * Defines an Http routing class
 * containing controller and action to request
 *
 * @package Framework\Http
 */
class HttpRequestRouting {

    /**
     * Module name
     * @var string
     */
    private $_module;

    /**
     * Controller name
     * @var string
     */
    private $_controller;

    /**
     * Action name
     * @var string
     */
    private $_action;


    public function __construct($module) {
        $this->_module = $module;
        $this->_controller = 'Index';
        $this->_action = 'index';
    }


    /**
     * @return String
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @param String $controller
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    /**
     * @return String
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @param String $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->_module;
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->_module = $module;
    }

}