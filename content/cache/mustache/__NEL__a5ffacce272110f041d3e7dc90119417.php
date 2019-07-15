<?php

class __NEL__a5ffacce272110f041d3e7dc90119417 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'section_divider' section
        $value = $context->find('section_divider');
        $buffer .= $this->section9de08eabe193dadcd9b3c75b630144be($context, $indent, $value);
        $buffer .= $indent . '<div data-magellan-target="';
        $value = $this->resolveValue($context->find('slug'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '" id="';
        $value = $this->resolveValue($context->find('slug'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '"></div>
';
        $buffer .= $indent . '<section id="section-';
        $value = $this->resolveValue($context->find('slug'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '" data-nav-title="';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '" class="section ';
        $value = $this->resolveValue($context->find('section_classes'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">
';
        // 'bgset' section
        $value = $context->find('bgset');
        $buffer .= $this->sectionD9d5f9a36df8d3f602b88e2c9964201c($context, $indent, $value);
        $buffer .= $indent . '  <div class="';
        $value = $this->resolveValue($context->find('aspect_inner'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">
';
        $buffer .= $indent . '    <div class="row section__content align-center ';
        $value = $this->resolveValue($context->find('row_classes'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">
';
        $buffer .= $indent . '      <div class="';
        $value = $this->resolveValue($context->find('column_classes'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">
';
        $buffer .= $indent . '        <div class="wysiwyg">';
        $value = $this->resolveValue($context->find('content'), $context);
        $buffer .= $value;
        $buffer .= '</div>
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</section>';

        return $buffer;
    }

    private function section9de08eabe193dadcd9b3c75b630144be(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<hr class="section-divider">
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
                
                $buffer .= $indent . '<hr class="section-divider">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD9d5f9a36df8d3f602b88e2c9964201c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="section__bg-image lazyload" {{{bgset}}}></div>
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
                
                $buffer .= $indent . '    <div class="section__bg-image lazyload" ';
                $value = $this->resolveValue($context->find('bgset'), $context);
                $buffer .= $value;
                $buffer .= '></div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
