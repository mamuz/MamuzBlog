<?php

namespace MamuzBlog\View\Renderer;

use Zend\View\Renderer\PhpRenderer as ZendPhpRenderer;

/**
 * @method string markdown($text)
 * @method string anchor($href, $title, $content, $class = null)
 * @method string anchorBookmark($href, $title, $content, $class = null)
 * @method string hashId($id)
 * @method string slugify($value)
 * @method string panel($header, $content, $footer)
 * @method string postMeta(\MamuzBlog\Entity\Post $entity)
 * @method string permaLinkPost(\MamuzBlog\Entity\Post $entity)
 * @method string permaLinkTag($tagName)
 * @method string tag(\MamuzBlog\Entity\Tag $entity)
 * @method string tagList()
 * @method string tagAnchor($tagName, $content)
 * @method string badge($message = null, array $attributes = null)
 * @method string glyphicon($name, array $attributes = null)
 * @method string dateFormat(\DateTime $date, $dateType = null, $timeType = null, $locale = null, $pattern = null)
 * @method string translate($message, $textDomain = null, $locale = null)
 */
class PhpRenderer extends ZendPhpRenderer
{
}
