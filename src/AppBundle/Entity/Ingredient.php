<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\RecipeIngredient;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Ingredient
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ingredient
{
    const UNIT_GRAM = "gram";
    const UNIT_LITRE = "litre";
    const UNIT_PC = "pc";

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"ingredients"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"ingredients"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255)
     */
    private $unit;

    /**
     * @var \AppBundle\Entity\RecipeIngredient[]
     *
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="ingredient", cascade={"all"})
     */
    private $recipeIngredients;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipeIngredients = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Ingredient
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
     * Set unit
     *
     * @param string $unit
     *
     * @return Ingredient
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Add recipeIngredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $recipeIngredient
     *
     * @return Ingredient
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
