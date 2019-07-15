<?php

class __NEL__2a49ac91415f1d67d6074a95aa84ebac extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<header class="Article__header container">
';
        $buffer .= $indent . '  <div class="row columns">
';
        $buffer .= $indent . '    <h1 class="Article__title">';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</h1>
';
        // 'excerpt' section
        $value = $context->find('excerpt');
        $buffer .= $this->section8abd0db159e5502a1d8fa04fc6bb21f6($context, $indent, $value);
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</header>';

        return $buffer;
    }

    private function section8abd0db159e5502a1d8fa04fc6bb21f6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="Article__intro">{{{excerpt}}}</div>
    ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="Article__intro">';
                $value = $this->resolveValue($context->find('excerpt'), $context);
                $buffer .= $value;
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
