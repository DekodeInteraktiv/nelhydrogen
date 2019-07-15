<?php

class __NEL__ee071f425fe85b4636efb122211f1a3c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'termNav.has_terms' section
        $value = $context->findDot('termNav.has_terms');
        $buffer .= $this->section461a4611a5376af0ec18f7f3513e45e4($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="row align-center">
';
        $buffer .= $indent . '  <div class="columns">
';
        $buffer .= $indent . '    <ul class="PostLoop row">
';
        // 'posts' section
        $value = $context->find('posts');
        $buffer .= $this->sectionA2cd12df63c40da21f3d05bf60836f69($context, $indent, $value);
        $buffer .= $indent . '    </ul>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        // 'pagination' section
        $value = $context->find('pagination');
        $buffer .= $this->section5c08b316923e31785d9a907c848bde4b($context, $indent, $value);

        return $buffer;
    }

    private function section461a4611a5376af0ec18f7f3513e45e4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<div class="row">
  <div class="columns">
    {{> TermNav}}
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
                
                $buffer .= $indent . '<div class="row">
';
                $buffer .= $indent . '  <div class="columns">
';
                if ($partial = $this->mustache->loadPartial('TermNav')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $buffer .= $indent . '  </div>
';
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5135de6955e3efd880c6daae7453de88(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <div role="img" class="lazyload bg-image" {{{featured_image.atts}}}></div>
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
                
                $buffer .= $indent . '              <div role="img" class="lazyload bg-image" ';
                $value = $this->resolveValue($context->findDot('featured_image.atts'), $context);
                $buffer .= $value;
                $buffer .= '></div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8d605d3bc02619b77fe0c00a14558741(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span class="Cover__terms">{{{term_links}}}</span>';
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
                
                $buffer .= '<span class="Cover__terms">';
                $value = $this->resolveValue($context->find('term_links'), $context);
                $buffer .= $value;
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1f6911c8ccef406de25d67dc18147f78(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <div class="Cover__excerpt">{{{excerpt}}}</div>
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
                
                $buffer .= $indent . '              <div class="Cover__excerpt">';
                $value = $this->resolveValue($context->find('excerpt'), $context);
                $buffer .= $value;
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA2cd12df63c40da21f3d05bf60836f69(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="PostLoop__item columns small-12 medium-6">
          <article class="Cover">
            <a href="{{permalink}}" class="Cover__image aspect small-aspect-widescreen">
              {{#featured_image.atts}}
              <div role="img" class="lazyload bg-image" {{{featured_image.atts}}}></div>
              {{/featured_image.atts}}
            </a>
            <div class="Cover__meta">
              {{#term_links}}<span class="Cover__terms">{{{term_links}}}</span>{{/term_links}}
              <time class="Cover__published meta" datetime="{{post_date_gmt}}">{{date}}</time>
            </div>
            <a class="Cover__text" href="{{permalink}}">
              <h3 class="Cover__title">{{{title}}}</h3>
              {{#excerpt}}
              <div class="Cover__excerpt">{{{excerpt}}}</div>
              {{/excerpt}}
              <span class="Cover__more">{{readmore}}</span>
            </a>
          </article>
        </li>
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
                
                $buffer .= $indent . '        <li class="PostLoop__item columns small-12 medium-6">
';
                $buffer .= $indent . '          <article class="Cover">
';
                $buffer .= $indent . '            <a href="';
                $value = $this->resolveValue($context->find('permalink'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '" class="Cover__image aspect small-aspect-widescreen">
';
                // 'featured_image.atts' section
                $value = $context->findDot('featured_image.atts');
                $buffer .= $this->section5135de6955e3efd880c6daae7453de88($context, $indent, $value);
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '            <div class="Cover__meta">
';
                $buffer .= $indent . '              ';
                // 'term_links' section
                $value = $context->find('term_links');
                $buffer .= $this->section8d605d3bc02619b77fe0c00a14558741($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '              <time class="Cover__published meta" datetime="';
                $value = $this->resolveValue($context->find('post_date_gmt'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->find('date'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</time>
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '            <a class="Cover__text" href="';
                $value = $this->resolveValue($context->find('permalink'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">
';
                $buffer .= $indent . '              <h3 class="Cover__title">';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= $value;
                $buffer .= '</h3>
';
                // 'excerpt' section
                $value = $context->find('excerpt');
                $buffer .= $this->section1f6911c8ccef406de25d67dc18147f78($context, $indent, $value);
                $buffer .= $indent . '              <span class="Cover__more">';
                $value = $this->resolveValue($context->find('readmore'), $context);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</span>
';
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '          </article>
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5c08b316923e31785d9a907c848bde4b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <div class="Pagination row align-center">
    <div class="columns">{{{pagination}}}</div>
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
                
                $buffer .= $indent . '  <div class="Pagination row align-center">
';
                $buffer .= $indent . '    <div class="columns">';
                $value = $this->resolveValue($context->find('pagination'), $context);
                $buffer .= $value;
                $buffer .= '</div>
';
                $buffer .= $indent . '  </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
