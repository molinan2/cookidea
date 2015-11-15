<?php

namespace AppBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as SonataUser;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Comment;

/**
 * User
 *
 * @ORM\Table("fos_user_user2")
 * @ORM\Entity
 */
class User extends SonataUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $pro
     * @ORM\Column(name="pro", type="boolean", length=255, nullable=true)
     */
    public $pro = false;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"all"})
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();

        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set pro
     *
     * @param boolean $pro
     *
     * @return User
     */
    public function setPro($pro)
    {
        $this->pro = $pro;

        return $this;
    }

    /**
     * Get pro
     *
     * @return boolean
     */
    public function getPro()
    {
        return $this->pro;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
