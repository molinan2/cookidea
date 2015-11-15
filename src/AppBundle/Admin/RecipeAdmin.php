<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RecipeAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('image')
            ->add('pro')
            ->add('cuisineMicrowave')
            ->add('cuisineRaw')
            ->add('cuisineBoiled')
            ->add('cuisineGrilled')
            ->add('mealLunch')
            ->add('mealDinner')
            ->add('mealBreakfast')
            ->add('creationDate')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('pro', null, array('editable' => true))
            ->add('cuisineMicrowave', null, array('editable' => true))
            ->add('cuisineRaw', null, array('editable' => true))
            ->add('cuisineBoiled', null, array('editable' => true))
            ->add('cuisineGrilled', null, array('editable' => true))
            ->add('mealLunch', null, array('editable' => true))
            ->add('mealDinner', null, array('editable' => true))
            ->add('mealBreakfast', null, array('editable' => true))
            ->add('creationDate')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description')
            ->add('image', null, array('required' => false))
            ->add('pro', null, array('required' => false))
            ->add('cuisineMicrowave', null, array('required' => false))
            ->add('cuisineRaw', null, array('required' => false))
            ->add('cuisineBoiled', null, array('required' => false))
            ->add('cuisineGrilled', null, array('required' => false))
            ->add('mealLunch', null, array('required' => false))
            ->add('mealDinner', null, array('required' => false))
            ->add('mealBreakfast', null, array('required' => false))
            ->add('comments')
            ->add('recipeIngredients')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('image')
            ->add('pro')
            ->add('cuisineMicrowave')
            ->add('cuisineRaw')
            ->add('cuisineBoiled')
            ->add('cuisineGrilled')
            ->add('mealLunch')
            ->add('mealDinner')
            ->add('mealBreakfast')
            ->add('creationDate')
        ;
    }
}
