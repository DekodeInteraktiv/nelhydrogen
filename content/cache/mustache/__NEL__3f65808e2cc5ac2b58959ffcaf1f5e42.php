<?php

class __NEL__3f65808e2cc5ac2b58959ffcaf1f5e42 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<article class="page">
';
        if ($partial = $this->mustache->loadPartial('PostHeader')) {
            $buffer .= $partial->renderInternal($context, $indent . '  ');
        }
        if ($partial = $this->mustache->loadPartial('Blocks')) {
            $buffer .= $partial->renderInternal($context, $indent . '  ');
        }
        if ($partial = $this->mustache->loadPartial('NextPost')) {
            $buffer .= $partial->renderInternal($context, $indent . '  ');
        }
        $buffer .= $indent . '</article>';

        return $buffer;
    }
}
