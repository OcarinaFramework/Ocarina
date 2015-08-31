<?php
namespace Ocarina;

interface Bootstrap {

    static function registerModules();

    static function initTemplateEngine();

    function autoload();

}