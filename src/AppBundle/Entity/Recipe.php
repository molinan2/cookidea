<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Comment;
use AppBundle\Entity\RecipeIngredient;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;

# TODO: user_fav
# TODO: favs

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recipe
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"recipes"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Groups({"recipes"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Groups({"recipes"})
     */
    private $image;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pro", type="boolean")
     * @Groups({"recipes"})
     */
    private $pro;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cuisine_microwave", type="boolean")
     * @Groups({"recipes"})
     */
    private $cuisineMicrowave;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cuisine_raw", type="boolean")
     * @Groups({"recipes"})
     */
    private $cuisineRaw;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cuisine_boiled", type="boolean")
     * @Groups({"recipes"})
     */
    private $cuisineBoiled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cuisine_grilled", type="boolean")
     * @Groups({"recipes"})
     */
    private $cuisineGrilled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="meal_lunch", type="boolean")
     * @Groups({"recipes"})
     */
    private $mealLunch;

    /**
     * @var boolean
     *
     * @ORM\Column(name="meal_dinner", type="boolean")
     * @Groups({"recipes"})
     */
    private $mealDinner;

    /**
     * @var boolean
     *
     * @ORM\Column(name="meal_breakfast", type="boolean")
     * @Groups({"recipes"})
     */
    private $mealBreakfast;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     * @Type("DateTime<'Y-m-d, H:i'>")
     * @Groups({"recipes"})
     */
    private $creationDate;

    /**
     * @var \AppBundle\Entity\Comment[]
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="recipe", cascade={"all"})
     * @Groups({"recipes"})
     */
    private $comments;

    /**
     * @var \AppBundle\Entity\RecipeIngredient[]
     *
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="recipe", cascade={"all"})
     */
    private $recipeIngredients;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recipeIngredients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creationDate = new \DateTime('NOW');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Recipe
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set pro
     *
     * @param boolean $pro
     *
     * @return Recipe
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
     * Set cuisineMicrowave
     *
     * @param boolean $cuisineMicrowave
     *
     * @return Recipe
     */
    public function setCuisineMicrowave($cuisineMicrowave)
    {
        $this->cuisineMicrowave = $cuisineMicrowave;

        return $this;
    }

    /**
     * Get cuisineMicrowave
     *
     * @return boolean
     */
    public function getCuisineMicrowave()
    {
        return $this->cuisineMicrowave;
    }

    /**
     * Set cuisineRaw
     *
     * @param boolean $cuisineRaw
     *
     * @return Recipe
     */
    public function setCuisineRaw($cuisineRaw)
    {
        $this->cuisineRaw = $cuisineRaw;

        return $this;
    }

    /**
     * Get cuisineRaw
     *
     * @return boolean
     */
    public function getCuisineRaw()
    {
        return $this->cuisineRaw;
    }

    /**
     * Set cuisineBoiled
     *
     * @param boolean $cuisineBoiled
     *
     * @return Recipe
     */
    public function setCuisineBoiled($cuisineBoiled)
    {
        $this->cuisineBoiled = $cuisineBoiled;

        return $this;
    }

    /**
     * Get cuisineBoiled
     *
     * @return boolean
     */
    public function getCuisineBoiled()
    {
        return $this->cuisineBoiled;
    }

    /**
     * Set cuisineGrilled
     *
     * @param boolean $cuisineGrilled
     *
     * @return Recipe
     */
    public function setCuisineGrilled($cuisineGrilled)
    {
        $this->cuisineGrilled = $cuisineGrilled;

        return $this;
    }

    /**
     * Get cuisineGrilled
     *
     * @return boolean
     */
    public function getCuisineGrilled()
    {
        return $this->cuisineGrilled;
    }

    /**
     * Set mealLunch
     *
     * @param boolean $mealLunch
     *
     * @return Recipe
     */
    public function setMealLunch($mealLunch)
    {
        $this->mealLunch = $mealLunch;

        return $this;
    }

    /**
     * Get mealLunch
     *
     * @return boolean
     */
    public function getMealLunch()
    {
        return $this->mealLunch;
    }

    /**
     * Set mealDinner
     *
     * @param boolean $mealDinner
     *
     * @return Recipe
     */
    public function setMealDinner($mealDinner)
    {
        $this->mealDinner = $mealDinner;

        return $this;
    }

    /**
     * Get mealDinner
     *
     * @return boolean
     */
    public function getMealDinner()
    {
        return $this->mealDinner;
    }

    /**
     * Set mealBreakfast
     *
     * @param boolean $mealBreakfast
     *
     * @return Recipe
     */
    public function setMealBreakfast($mealBreakfast)
    {
        $this->mealBreakfast = $mealBreakfast;

        return $this;
    }

    /**
     * Get mealBreakfast
     *
     * @return boolean
     */
    public function getMealBreakfast()
    {
        return $this->mealBreakfast;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Recipe
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
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Recipe
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

    /**
     * Add recipeIngredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $recipeIngredient
     *
     * @return Recipe
     */
    public function addRecipeIngredient(\AppBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredients[] = $recipeIngredient;

        return $this;
    }

    /**
     * Remove recipeIngredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $recipeIngredient
     */
    public function removeRecipeIngredient(\AppBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredients->removeElement($recipeIngredient);
    }

    /**
     * Get recipeIngredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipeIngredients()
    {
        return $this->recipeIngredients;
    }
}
