<?php

class __NEL__9939a58967b1437210ac1169e66e0620 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<header class="container page-header medium-text-center">
';
        $buffer .= $indent . '  <div class="row align-center">
';
        $buffer .= $indent . '    <div class="columns medium-text-center large-10 xlarge-8">
';
        // 'header_meta' section
        $value = $context->find('header_meta');
        $buffer .= $this->section32567a5e94a1d07b4f70f6a75479ae2a($context, $indent, $value);
        $buffer .= $indent . '      <h1 class="Article__title">';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= $value;
        $buffer .= '</h1>
';
        // 'intro' section
        $value = $context->find('intro');
        $buffer .= $this->section21a08c89c86abf39d41331afc4959291($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</header>';

        return $buffer;
    }

    private function section32567a5e94a1d07b4f70f6a75479ae2a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="page-header__meta meta">{{{header_meta}}}</div>
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
                
                $buffer .= $indent . '        <div class="page-header__meta meta">';
                $value = $this->resolveValue($context->find('header_meta'), $context);
                $buffer .= $value;
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section21a08c89c86abf39d41331afc4959291(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <div class="Article__intro">{{{intro}}}</div>
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
                
                $buffer .= $indent . '      <div class="Article__intro">';
                $value = $this->resolveValue($context->find('intro'), $context);
                $buffer .= $value;
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
