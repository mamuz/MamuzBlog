<?php

namespace MamuzBlog\View\Renderer;

use Zend\View\Renderer\PhpRenderer as ZendPhpRenderer;

/**
 * @method string markdown($text)
 * @method string anchor($href, $title, $content)
 * @method string hashId($id)
 * @method string panel($header, $content, $footer)
 * @method string postMeta(\MamuzBlog\Entity\Post $entity)
 * @method string badge($message = null, array $attributes = null)
 * @method string glyphicon($name, array $attributes = null)
 * @method string dateFormat(\DateTime $date, $dateType = null, $timeType = null, $locale = null, $pattern = null)
 * @method string translate($message, $textDomain = null, $locale = null)
 */
class PhpRenderer extends ZendPhpRenderer
{
}
