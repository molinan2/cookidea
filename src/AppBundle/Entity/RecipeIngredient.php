<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Recipe;

/**
 * Ingredient
 *
 * @ORM\Table(name="RecipeIngredient", uniqueConstraints={@UniqueConstraint(name="urf_constraint", columns={"ingredient_id", "recipe_id"})})
 * @ORM\Entity
 */
class RecipeIngredient
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     **/
    private $recipe;

    /**
     * @var Ingredient $ingredient
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     **/
    private $ingredient;

    /**
     * @var integer $quantity
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->ingredient)
            return $this->ingredient->getName();
        else
            return $this->id;
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return RecipeIngredient
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return RecipeIngredient
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
     * Set ingredient
     *
     * @param \AppBundle\Entity\Ingredient $ingredient
     *
     * @return RecipeIngredient
     */
    public function setIngredient(\AppBundle\Entity\Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \AppBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
