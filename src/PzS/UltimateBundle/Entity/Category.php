<?php
namespace PzS\UltimateBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="ultimate1_category")
 * @ORM\Entity
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="categoryID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="categoryParent", type="integer", scale=10)
     */
    private $categoryParent;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryTitle", type="string", length=255)
     */
    private $categoryTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryDescription", type="string", length=255)
     */
    private $categoryDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="categorySlug", type="string", length=255)
     */
    private $categorySlug;


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
     * Set categoryParent
     *
     * @param $categoryParent
     * @return Category
     */
    public function setCategoryParent($categoryParent)
    {
        $this->categoryParent = $categoryParent;
    
        return $this;
    }

    /**
     * Get categoryParent
     *
     * @return integer
     */
    public function getCategoryParent()
    {
        return $this->categoryParent;
    }

    /**
     * Set categoryTitle
     *
     * @param string $categoryTitle
     * @return Category
     */
    public function setCategoryTitle($categoryTitle)
    {
        $this->categoryTitle = $categoryTitle;
    
        return $this;
    }

    /**
     * Get categoryTitle
     *
     * @return string 
     */
    public function getCategoryTitle()
    {
        return $this->categoryTitle;
    }

    /**
     * Set categoryDescription
     *
     * @param string $categoryDescription
     * @return Category
     */
    public function setCategoryDescription($categoryDescription)
    {
        $this->categoryDescription = $categoryDescription;
    
        return $this;
    }

    /**
     * Get categoryDescription
     *
     * @return string 
     */
    public function getCategoryDescription()
    {
        return $this->categoryDescription;
    }

    /**
     * Set categorySlug
     *
     * @param string $categorySlug
     * @return Category
     */
    public function setCategorySlug($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    
        return $this;
    }

    /**
     * Get categorySlug
     *
     * @return string 
     */
    public function getCategorySlug()
    {
        return $this->categorySlug;
    }
}
