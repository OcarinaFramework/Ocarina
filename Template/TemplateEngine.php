<?php
namespace Ocarina\Template;

interface TemplateEngine {

    function render(array $data, $template);

    function setTemplatePath($templatePath);

}