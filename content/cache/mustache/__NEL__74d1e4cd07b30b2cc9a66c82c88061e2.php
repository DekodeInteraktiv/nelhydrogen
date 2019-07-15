<?php

class __NEL__74d1e4cd07b30b2cc9a66c82c88061e2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'next_post' section
        $value = $context->find('next_post');
        $buffer .= $this->sectionBdab2ee57211a30013a23f278018e11f($context, $indent, $value);

        return $buffer;
    }

    private function section0e125e6211c904b32fe59925dd786485(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="NextPost__image columns small-12 medium-8 large-6">
      <div role="img" class="aspect small-aspect-widescreen lazyload bg-image" {{{featured_image.atts}}}></div>
    </div>
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
                
                $buffer .= $indent . '    <div class="NextPost__image columns small-12 medium-8 large-6">
';
                $buffer .= $indent . '      <div role="img" class="aspect small-aspect-widescreen lazyload bg-image" ';
                $value = $this->resolveValue($context->findDot('featured_image.atts'), $context);
                $buffer .= $value;
                $buffer .= '></div>
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD4eabbd79a82d61a6e22a251e017c472(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="NextPost__excerpt">{{{excerpt}}}</div>
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
                
                $buffer .= $indent . '        <div class="NextPost__excerpt">';
                $value = $this->resolveValue($context->find('excerpt'), $context);
                $buffer .= $value;
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBdab2ee57211a30013a23f278018e11f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<hr class="section-divider">
<div class="NextPost section">
  <div class="row align-center align-middle section__content">
    {{#featured_image.atts}}
    <div class="NextPost__image columns small-12 medium-8 large-6">
      <div role="img" class="aspect small-aspect-widescreen lazyload bg-image" {{{featured_image.atts}}}></div>
    </div>
    {{/featured_image.atts}}
    <div class="NextPost__text columns small-12 medium-8 large-6">
      <a class="NextPost__link" href="{{permalink}}">
        <span class="NextPost__label">{{label}}</span>
        <h2 class="NextPost__title">{{{title}}}</h2>
        {{#excerpt}}
        <div class="NextPost__excerpt">{{{excerpt}}}</div>
        {{/excerpt}}
      </a>
    </div>
  </div>
</div>
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
                $buffer .= $indent . '<div class="NextPost section">
';
                $buffer .= $indent . '  <div class="row align-center align-middle section__content">
';
                // 'featured_image.atts' section
                $value = $context->findDot('featured_image.atts');
                $buffer .= $this->section0e125e6211c904b32fe59925dd786485($context, $indent, $value);
                $buffer .= $indent . '    <div class="NextPost__text columns small-12 medium-8 large-6">
';
                $buffer .= $indent . '      <a class="NextPost__link" href="';
                $value = $this->resolveValue($context->find('permalink'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">
';
                $buffer .= $indent . '        <span class="NextPost__label">';
                $value = $this->resolveValue($context->find('label'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</span>
';
                $buffer .= $indent . '        <h2 class="NextPost__title">';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= $value;
                $buffer .= '</h2>
';
                // 'excerpt' section
                $value = $context->find('excerpt');
                $buffer .= $this->sectionD4eabbd79a82d61a6e22a251e017c472($context, $indent, $value);
                $buffer .= $indent . '      </a>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '  </div>
';
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
