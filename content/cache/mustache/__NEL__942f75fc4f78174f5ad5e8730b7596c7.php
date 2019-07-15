<?php

class __NEL__942f75fc4f78174f5ad5e8730b7596c7 extends Mustache_Template
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
        $buffer .= $this->sectionA0a9ede6f2e466b49b041000ded450bd($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'taxonomies' section
        $value = $context->find('taxonomies');
        $buffer .= $this->section3f2a911589e15501eceb2d89dd98cef1($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function section4aaa15f72995354eed71b9562b94ed35(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <a target="_blank" rel="noopener noreferrer" href="{{wpml.docs.post_translation.url}}">{{wpml.docs.post_translation.title}}</a>
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
                
                $buffer .= $indent . '              <a target="_blank" rel="noopener noreferrer" href="';
                $value = $this->resolveValue($context->findDot('wpml.docs.post_translation.url'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->findDot('wpml.docs.post_translation.title'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a>
';
                $context->pop();
            }
        }
    
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

    private function sectionA0a9ede6f2e466b49b041000ded450bd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <div class="Sitemap__group column small-12 medium-6 large-4">
        <div class="Sitemap__card">
          <div class="Sitemap__header">
            <h4 class="Sitemap__title">{{type}}</h4>
            {{#wpml}}
              <a target="_blank" rel="noopener noreferrer" href="{{wpml.docs.post_translation.url}}">{{wpml.docs.post_translation.title}}</a>
            {{/wpml}}
          </div>
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
                $buffer .= $indent . '          <div class="Sitemap__header">
';
                $buffer .= $indent . '            <h4 class="Sitemap__title">';
                $value = $this->resolveValue($context->find('type'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</h4>
';
                // 'wpml' section
                $value = $context->find('wpml');
                $buffer .= $this->section4aaa15f72995354eed71b9562b94ed35($context, $indent, $value);
                $buffer .= $indent . '          </div>
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

    private function section6db626fc61950e1fe362d9430eaaba3d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <a target="_blank" rel="noopener noreferrer" href="{{wpml.docs.taxonomy_translation.url}}">{{wpml.docs.taxonomy_translation.title}}</a>
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
                
                $buffer .= $indent . '              <a target="_blank" rel="noopener noreferrer" href="';
                $value = $this->resolveValue($context->findDot('wpml.docs.taxonomy_translation.url'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->findDot('wpml.docs.taxonomy_translation.title'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a>
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

    private function section3f2a911589e15501eceb2d89dd98cef1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <div class="Sitemap__group column small-12 medium-6 large-4">
        <div class="Sitemap__card">
          <div class="Sitemap__header">
            <h4 class="Sitemap__title">{{type}}</h4>
            {{#wpml}}
              <a target="_blank" rel="noopener noreferrer" href="{{wpml.docs.taxonomy_translation.url}}">{{wpml.docs.taxonomy_translation.title}}</a>
            {{/wpml}}
          </div>
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
                $buffer .= $indent . '          <div class="Sitemap__header">
';
                $buffer .= $indent . '            <h4 class="Sitemap__title">';
                $value = $this->resolveValue($context->find('type'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</h4>
';
                // 'wpml' section
                $value = $context->find('wpml');
                $buffer .= $this->section6db626fc61950e1fe362d9430eaaba3d($context, $indent, $value);
                $buffer .= $indent . '          </div>
';
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
