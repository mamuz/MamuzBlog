<?php

namespace MamuzBlog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="MamuzBlogPost")
 * @Annotation\Name("blogPost")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Annotation\Exclude()
     * @var int|null
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"Alnum", "options": {"allowWhiteSpace":"false"}})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"1", "max":"255"}})
     * @Annotation\Options({"label":"Title"})
     * @var string
     */
    private $title = '';

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"3", "max":"65535"}})
     * @Annotation\Options({"label":"Content"})
     * @var string
     */
    private $content = '';

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"3", "max":"1000"}})
     * @Annotation\Options({"label":"Description"})
     * @var string
     */
    private $description = '';

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Annotation\Filter({"name":"Boolean"})
     * @Annotation\Options({"label":"Active"})
     * @var bool
     */
    private $active = false;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="posts")
     * @ORM\JoinTable(name="MamuzBlogPostsTags")
     * @var Collection
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var \DateTime
     */
    private $modifiedAt;

    /**
     * init datetime objects
     */
    public function __construct($id = null, \DateTime $createdAt = null, \DateTime $modifiedAt = null)
    {
        $this->id = $id;
        $this->createdAt = $this->determineDate($createdAt);
        $this->modifiedAt = $this->determineDate($modifiedAt);
        $this->tags = new ArrayCollection();
    }

    /**
     * @param null|\DateTime $value
     * @return \DateTime
     */
    private function determineDate($value)
    {
        return $value ? : new \DateTime;
    }

    /**
     * Provide deep clone,
     * destroy identity and init datetime objects
     */
    public function __clone()
    {
        $this->id = null;
        $this->active = false;
        $this->createdAt = new \DateTime;
        $this->modifiedAt = new \DateTime;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param boolean $active
     * @return Post
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param Collection $tags
     * @return Post
     */
    public function setTags(Collection $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }
}
