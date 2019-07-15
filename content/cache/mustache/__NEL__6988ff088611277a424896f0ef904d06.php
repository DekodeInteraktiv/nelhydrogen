<?php

class __NEL__6988ff088611277a424896f0ef904d06 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="Sitemap">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  <div class="row">
';
        $buffer .= $indent . '
';
        // 'post_hierarchy' section
        $value = $context->find('post_hierarchy');
        $buffer .= $this->section4644e70e2043a9cc65cd9bb20c68d5eb($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'taxonomies' section
        $value = $context->find('taxonomies');
        $buffer .= $this->sectionA6a019a8443db7dfef45f849de43cd4d($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function section16c27b1997999bf48f65a7aacc1d24be(Mustache_Context $context, $indent, $value)
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
                    $buffer .= $partial->renderInternal($context, $indent . '              ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4644e70e2043a9cc65cd9bb20c68d5eb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <div class="Sitemap__group column small-12 medium-6 large-4">
        <div class="Sitemap__card">
          <h4 class="Sitemap__title">{{type}}</h4>
          <ul class="Sitemap__list">
            {{#posts}}
              {{> SitemapPost}}
            {{/posts}}
          </ul>
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
                
                $buffer .= $indent . '      <div class="Sitemap__group column small-12 medium-6 large-4">
';
                $buffer .= $indent . '        <div class="Sitemap__card">
';
                $buffer .= $indent . '          <h4 class="Sitemap__title">';
                $value = $this->resolveValue($context->find('type'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</h4>
';
                $buffer .= $indent . '          <ul class="Sitemap__list">
';
                // 'posts' section
                $value = $context->find('posts');
                $buffer .= $this->section16c27b1997999bf48f65a7aacc1d24be($context, $indent, $value);
                $buffer .= $indent . '          </ul>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2a2ce802b3962d94f390a6711dda3739(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{wpml.docs.taxonomy_translation.url}}
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
                
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->findDot('wpml.docs.taxonomy_translation.url'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC015279490ecf8070f7cb6474894b548(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              {{> SitemapTerm}}
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
                
                if ($partial = $this->mustache->loadPartial('SitemapTerm')) {
                    $buffer .= $partial->renderInternal($context, $indent . '              ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA6a019a8443db7dfef45f849de43cd4d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <div class="Sitemap__group column small-12 medium-6 large-4">
        <div class="Sitemap__card">
          <h4 class="Sitemap__title">{{type}}</h4>
          {{#wpml}}
            {{wpml.docs.taxonomy_translation.url}}
          {{/wpml}}
          <ul class="Sitemap__list">
            {{#terms}}
              {{> SitemapTerm}}
            {{/terms}}
          </ul>
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
                
                $buffer .= $indent . '      <div class="Sitemap__group column small-12 medium-6 large-4">
';
                $buffer .= $indent . '        <div class="Sitemap__card">
';
                $buffer .= $indent . '          <h4 class="Sitemap__title">';
                $value = $this->resolveValue($context->find('type'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</h4>
';
                // 'wpml' section
                $value = $context->find('wpml');
                $buffer .= $this->section2a2ce802b3962d94f390a6711dda3739($context, $indent, $value);
                $buffer .= $indent . '          <ul class="Sitemap__list">
';
                // 'terms' section
                $value = $context->find('terms');
                $buffer .= $this->sectionC015279490ecf8070f7cb6474894b548($context, $indent, $value);
                $buffer .= $indent . '          </ul>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
