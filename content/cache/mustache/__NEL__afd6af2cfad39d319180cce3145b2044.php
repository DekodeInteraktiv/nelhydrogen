<?php

class __NEL__afd6af2cfad39d319180cce3145b2044 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $value = $this->resolveValue($context->find('blocks'), $context);
        $buffer .= $indent . $value;

        return $buffer;
    }
}
