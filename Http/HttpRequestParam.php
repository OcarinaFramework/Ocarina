<?php
namespace Ocarina\Http;


class HttpRequestParam {

    /**
     * Request parameter name
     * @var string
     */
    private $_name;

    /**
     * Request parameter type
     * true if file upload
     * @var boolean
     */
    private $_multipart;

    /**
     * Request parameter value
     * @var mixed
     */
    private $_value;


    public function __construct($name = null, $value = null, $multipart = false) {
        $this->_name = $name;
        $this->_value = $value;
        $this->_multipart = $multipart;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return boolean
     */
    public function isMultipart()
    {
        return $this->_multipart;
    }

    /**
     * @param boolean $multipart
     */
    public function setMultipart($multipart)
    {
        $this->_multipart = $multipart;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }

}