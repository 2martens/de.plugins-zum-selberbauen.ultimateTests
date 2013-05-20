<?php
namespace PzS\UltimateBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Layout
 *
 * @ORM\Table(name="ultimate1_layout")
 * @ORM\Entity
 */
class Layout
{
    /**
     * @var integer
     *
     * @ORM\Column(name="layoutID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="objectID", type="integer", scale=10)
     */
    private $objectID;

    /**
     * @var string
     *
     * @ORM\Column(name="objectType", type="string")
     */
    private $objectType;

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
     * @param $objectID
     * @return Category
     */
    public function setObjectID($objectID)
    {
        $this->objectID = $objectID;
    
        return $this;
    }

    /**
     * Get objectID
     *
     * @return integer
     */
    public function getObjectID()
    {
        return $this->objectID;
    }

    /**
     * Set objectType
     *
     * @param string $objectType
     * @return Category
     */
    public function setObjectType($objectType)
    {
    	$allowedTypes = array(
    		'content',
    		'category',
    		'index',
    		'page'
    	);
    	if (in_array($objectType, $allowedTypes)) {
    		$this->objectType = $objectType;
    	}
    
        return $this;
    }
}
