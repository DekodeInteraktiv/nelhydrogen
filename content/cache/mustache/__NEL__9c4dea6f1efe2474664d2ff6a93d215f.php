<?php

class __NEL__9c4dea6f1efe2474664d2ff6a93d215f extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<li class="Sitemap__item">
';
        $buffer .= $indent . '  <div>
';
        $buffer .= $indent . '    <a class="Sitemap__link" href="';
        $value = $this->resolveValue($context->find('permalink'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">';
        $value = $this->resolveValue($context->find('post_title'), $context);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</a>
';
        $buffer .= $indent . '    ';
        // 'special_label' section
        $value = $context->find('special_label');
        $buffer .= $this->sectionCbc255c7be69cb3c9ea849d7ee45085a($context, $indent, $value);
        $buffer .= '
';
        // 'has_translations' section
        $value = $context->find('has_translations');
        $buffer .= $this->section9c9081af56473fe1d781ba2407d6df8f($context, $indent, $value);
        $buffer .= $indent . '  </div>
';
        // 'has_children' section
        $value = $context->find('has_children');
        $buffer .= $this->section021696de80e38b1f69553cdc84d5d753($context, $indent, $value);
        $buffer .= $indent . '</li>';

        return $buffer;
    }

    private function sectionCbc255c7be69cb3c9ea849d7ee45085a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<small>{{special_label}}</small>';
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
                
                $buffer .= '<small>';
                $value = $this->resolveValue($context->find('special_label'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</small>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section33833b7612ce698de813b3bc87b55081(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <a title="{{title}}" class="Sitemap__lang" href="{{permalink}}">({{lang}})</a>
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
                
                $buffer .= $indent . '        <a title="';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '" class="Sitemap__lang" href="';
                $value = $this->resolveValue($context->find('permalink'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">(';
                $value = $this->resolveValue($context->find('lang'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= ')</a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9c9081af56473fe1d781ba2407d6df8f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <small class="Sitemap__langs">
      {{#translations}}
        <a title="{{title}}" class="Sitemap__lang" href="{{permalink}}">({{lang}})</a>
      {{/translations}}
      </small>
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
                
                $buffer .= $indent . '      <small class="Sitemap__langs">
';
                // 'translations' section
                $value = $context->find('translations');
                $buffer .= $this->section33833b7612ce698de813b3bc87b55081($context, $indent, $value);
                $buffer .= $indent . '      </small>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section015995b14028dc3d030316dac0f5d4fc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> SitemapPost}}
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
                
                if ($partial = $this->mustache->loadPartial('SitemapPost')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section021696de80e38b1f69553cdc84d5d753(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <ul class="Sitemap__children">
    {{#children}}
      {{> SitemapPost}}
    {{/children}}
    </ul>
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
                
                $buffer .= $indent . '    <ul class="Sitemap__children">
';
                // 'children' section
                $value = $context->find('children');
                $buffer .= $this->section015995b14028dc3d030316dac0f5d4fc($context, $indent, $value);
                $buffer .= $indent . '    </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
