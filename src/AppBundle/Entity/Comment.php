<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;


/**
 * Comment
 *
 * @ORM\Table(name="Comment", uniqueConstraints={@UniqueConstraint(name="urf_constraint", columns={"user_id", "recipe_id"})} )
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"recipes"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     * @Groups({"recipes"})
     */
    private $comment;

    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="comments")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     **/
    private $recipe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     * @Type("DateTime<'Y-m-d, H:i'>")
     * @Groups({"recipes"})
     */
    private $creationDate;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime('NOW');
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Comment
     */
    public function setRecipe(\AppBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \AppBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Comment
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @VirtualProperty
     * @SerializedName("username")
     * @Groups({"recipes"})
     *
     * @return string
     */
    public function getUsernameMethod()
    {
        return $this->user->getUsername();
    }
}
