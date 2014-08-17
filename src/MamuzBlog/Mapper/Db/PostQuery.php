<?php

namespace MamuzBlog\Mapper\Db;

use MamuzBlog\Entity\Post;
use MamuzBlog\EventManager\Event;
use MamuzBlog\Feature\PostQueryInterface;
use MamuzBlog\Options\Constraint;
use MamuzBlog\Options\ConstraintInterface;

class PostQuery extends AbstractQuery implements PostQueryInterface
{
    const REPOSITORY = 'MamuzBlog\Entity\Post';

    /** @var ConstraintInterface */
    private $constraint;

    public function findPublishedPostById($id)
    {
        $results = $this->trigger(
            Event::PRE_FIND_PUBLISHED_POST,
            array('id' => $id),
            function ($result) {
                return ($result instanceof Post);
            }
        );
        if ($results->stopped()) {
            return $results->last();
        }

        $post = $this->getEntityManager()->find(self::REPOSITORY, $id);

        $this->trigger(Event::POST_FIND_PUBLISHED_POST, array('id' => $id, 'post' => $post));

        return $post;
    }

    public function findPublishedPosts()
    {
        $this->constraint = new Constraint;
        $this->constraint->add('published', 'p.published = :published', true);

        return $this->createPaginator();
    }

    public function findPublishedPostsByTag($tag)
    {
        $this->constraint = new Constraint;
        $this->constraint->add('published', 'p.published = :published', 1);
        $this->constraint->add('tag', 'AND t.name = :tag', $tag);

        return $this->createPaginator();
    }

    protected function getQuery()
    {
        $dql = 'SELECT p, t FROM ' . self::REPOSITORY . ' p LEFT JOIN p.tags t '
            . 'WHERE ' . $this->constraint->toString() . ' '
            . 'ORDER BY p.createdAt DESC';

        /** @var \Doctrine\DBAL\Query\QueryBuilder $query */
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters($this->constraint->toArray());

        return $query;
    }
}
