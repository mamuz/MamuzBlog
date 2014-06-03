<?php

namespace MamuzBlog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="MamuzBlogTag")
 * @Annotation\Name("blogTag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Annotation\Exclude()
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"Alnum", "options": {"allowWhiteSpace":"false"}})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"1", "max":"255"}})
     * @Annotation\Options({"label":"Name"})
     * @Annotation\Required()
     * @var string
     */
    private $name = '';

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     * @var Collection
     */
    private $posts;

    /**
     * init posts collection
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * provide deep clone and destroy identity
     */
    public function __clone()
    {
        $this->id = null;
        if ($this->posts) {
            $this->posts = clone $this->posts;
        }
    }

    /**
     * @param int $id
     * @return Tag
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Collection $posts
     * @return Tag
     */
    public function setPosts(Collection $posts)
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
