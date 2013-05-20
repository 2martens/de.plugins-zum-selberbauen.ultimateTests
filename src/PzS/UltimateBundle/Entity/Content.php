<?php

namespace PzS\UltimateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="ultimate1_content")
 * @ORM\Entity
 */
class Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="contentID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $contentID;

    /**
     * @var integer
     *
     * @ORM\Column(name="authorID", type="integer")
     */
    private $authorID;

    /**
     * @var string
     *
     * @ORM\Column(name="contentTitle", type="string", length=255)
     */
    private $contentTitle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="contentDescription", type="string", length=255)
     */
    private $contentDescription = '';

    /**
     * @var string
     *
     * @ORM\Column(name="contentSlug", type="string", length=255)
     */
    private $contentSlug = '';

    /**
     * @var string
     *
     * @ORM\Column(name="contentText", type="string")
     */
    private $contentText = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="enableBBCodes", type="boolean")
     */
    private $enableBBCodes = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enableHtml", type="boolean")
     */
    private $enableHtml = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enableSmilies", type="boolean")
     */
    private $enableSmilies = true;

    /**
     * @var integer
     *
     * @ORM\Column(name="publishDate", type="integer")
     */
    private $publishDate = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastModified", type="integer")
     */
    private $lastModified = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="visibility", type="string")
     */
    private $visibility = 'public';


    /**
     * Get contentID
     *
     * @return integer 
     */
    public function getContentID()
    {
        return $this->contentID;
    }

    /**
     * Set authorID
     *
     * @param integer $authorID
     * @return Content
     */
    public function setAuthorID($authorID)
    {
        $this->authorID = $authorID;
    
        return $this;
    }

    /**
     * Get authorID
     *
     * @return integer 
     */
    public function getAuthorID()
    {
        return $this->authorID;
    }

    /**
     * Set contentTitle
     *
     * @param string $contentTitle
     * @return Content
     */
    public function setContentTitle($contentTitle)
    {
        $this->contentTitle = $contentTitle;
    
        return $this;
    }

    /**
     * Get contentTitle
     *
     * @return string 
     */
    public function getContentTitle()
    {
        return $this->contentTitle;
    }

    /**
     * Set contentDescription
     *
     * @param string $contentDescription
     * @return Content
     */
    public function setContentDescription($contentDescription)
    {
        $this->contentDescription = $contentDescription;
    
        return $this;
    }

    /**
     * Get contentDescription
     *
     * @return string 
     */
    public function getContentDescription()
    {
        return $this->contentDescription;
    }

    /**
     * Set contentSlug
     *
     * @param string $contentSlug
     * @return Content
     */
    public function setContentSlug($contentSlug)
    {
        $this->contentSlug = $contentSlug;
    
        return $this;
    }

    /**
     * Get contentSlug
     *
     * @return string 
     */
    public function getContentSlug()
    {
        return $this->contentSlug;
    }

    /**
     * Set contentText
     *
     * @param string $contentText
     * @return Content
     */
    public function setContentText($contentText)
    {
        $this->contentText = $contentText;
    
        return $this;
    }

    /**
     * Get contentText
     *
     * @return string 
     */
    public function getContentText()
    {
        return $this->contentText;
    }

    /**
     * Set enableBBCodes
     *
     * @param boolean $enableBBCodes
     * @return Content
     */
    public function setEnableBBCodes($enableBBCodes)
    {
        $this->enableBBCodes = $enableBBCodes;
    
        return $this;
    }

    /**
     * Get enableBBCodes
     *
     * @return boolean 
     */
    public function getEnableBBCodes()
    {
        return $this->enableBBCodes;
    }

    /**
     * Set enableHtml
     *
     * @param boolean $enableHtml
     * @return Content
     */
    public function setEnableHtml($enableHtml)
    {
        $this->enableHtml = $enableHtml;
    
        return $this;
    }

    /**
     * Get enableHtml
     *
     * @return boolean 
     */
    public function getEnableHtml()
    {
        return $this->enableHtml;
    }

    /**
     * Set enableSmilies
     *
     * @param boolean $enableSmilies
     * @return Content
     */
    public function setEnableSmilies($enableSmilies)
    {
        $this->enableSmilies = $enableSmilies;
    
        return $this;
    }

    /**
     * Get enableSmilies
     *
     * @return boolean 
     */
    public function getEnableSmilies()
    {
        return $this->enableSmilies;
    }

    /**
     * Set publishDate
     *
     * @param integer $publishDate
     * @return Content
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;
    
        return $this;
    }

    /**
     * Get publishDate
     *
     * @return integer 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return Content
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return integer 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Content
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set visibility
     *
     * @param string $visibility
     * @return Content
     */
    public function setVisibility($visibility)
    {
        $allowedValues = array(
        	'public', 
        	'protected', 
        	'private'
        );
    	if (in_array($visibility, $allowedValues)) {
    		$this->visibility = $visibility;
    	}
    
        return $this;
    }

    /**
     * Get visibility
     *
     * @return string 
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}
