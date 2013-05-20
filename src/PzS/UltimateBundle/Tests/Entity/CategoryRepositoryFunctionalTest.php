<?php
namespace PzS\UltimateBundle\Tests\Entity;
use ultimate\data\category\CategoryAction;
use ultimate\data\category\CategoryEditor;
use ultimate\data\category\Category;
use PzS\UltimateBundle\Entity\Category as CategoryEntity;
use PzS\UltimateBundle\Entity\Layout as LayoutEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryRepositoryFunctionalTest extends WebTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * @var string
	 */	
	private $databaseTable = 'ultimate1_category';

	/**
	 * {@inheritDoc}
	 */
	public function setUp()
	{
		static::$kernel = static::createKernel();
		static::$kernel->boot();
		$this->em = static::$kernel->getContainer()
			->get('doctrine')
			->getManager()
		;
	}
	
	public function testCleanInstall()
	{
		$categories = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(1, $categories);
		$this->assertCount(5, $layouts);
		
		$id = 1;
		/* @var $defaultCategory \PzS\UltimateBundle\Entity\Category */
		$defaultCategory = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->find($id)
		;
		$expectedDefaultCategory = $this->getMock('\PzS\UltimateBundle\Entity\Category');
		
		$expectedDefaultCategory->expects($this->once())
			->method('getId')
			->will($this->returnValue(1))
		;
		$expectedDefaultCategory->expects($this->once())
			->method('getCategoryParent')
			->will($this->returnValue(0))
		;
		$expectedDefaultCategory->expects($this->once())
			->method('getCategoryTitle')
			->will($this->returnValue('ultimate.category.1.categoryTitle'))
		;
		$expectedDefaultCategory->expects($this->once())
			->method('getCategoryDescription')
			->will($this->returnValue(''))
		;
		$expectedDefaultCategory->expects($this->once())
			->method('getCategorySlug')
			->will($this->returnValue('uncategorized'))
		;
		$this->assertEquals($expectedDefaultCategory->getId(), $defaultCategory->getId(), 'The IDs are not equal.');
		$this->assertEquals($expectedDefaultCategory->getCategoryParent(), $defaultCategory->getCategoryParent(), 'The category parent is not equal.');
		$this->assertEquals($expectedDefaultCategory->getCategoryTitle(), $defaultCategory->getCategoryTitle(), 'The category title is not equal.');
		$this->assertEquals($expectedDefaultCategory->getCategoryDescription(), $defaultCategory->getCategoryDescription(), 'The category description is not equal.');
		$this->assertEquals($expectedDefaultCategory->getCategorySlug(), $defaultCategory->getCategorySlug(), 'The category slug is not equal.');
	}
	
	public function testCategory()
	{
		$id = 1;
		$actualCategory = new Category($id);
		$expectedCategory = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->find($id)
		;
	
		$this->assertEquals($expectedCategory->getId(), $actualCategory->__get('categoryID'), 'The IDs are not equal.');
		$this->assertEquals($expectedCategory->getCategoryParent(), $actualCategory->__get('categoryParent'), 'The category parent is not equal.');
		$this->assertEquals($expectedCategory->getCategoryTitle(), $actualCategory->__get('categoryTitle'), 'The category title is not equal.');
		$this->assertEquals($expectedCategory->getCategoryDescription(), $actualCategory->__get('categoryDescription'), 'The category description is not equal.');
		$this->assertEquals($expectedCategory->getCategorySlug(), $actualCategory->__get('categorySlug'), 'The category slug is not equal.');
	}
	
	public function testCreate()
	{
		// create category
		$parameters = array(
			'data' => array(
				'categoryTitle' => 'test',
				'categoryDescription' => 'testDescription',
				'categorySlug' => 'test'
			)
		);
		$categoryAction = new CategoryAction(array(), 'create', $parameters);
		$returnValues = $categoryAction->executeAction();
		$categoryWCF = $returnValues['returnValues'];
		$categoryID = $categoryWCF->__get('categoryID');
		
		// check if the category has been created
		$categories = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(2, $categories, 'The category hasn\'t been created.');
		$this->assertCount(6, $layouts, 'The layout hasn\'t been created.');
		
		// check if created category fits the expected outcome
		$actualCategory = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->find($categoryID)
		;
		$layoutID = 6;
		$actualLayout = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->find($layoutID)
		;
		
		$expectedCategory = $this->getMock('\PzS\UltimateBundle\Entity\Category');
		$expectedCategory->expects($this->once())
			->method('getId')
			->will($this->returnValue($categoryID))
		;
		$expectedCategory->expects($this->once())
			->method('getCategoryParent')
			->will($this->returnValue(0))
		;
		$expectedCategory->expects($this->once())
			->method('getCategoryTitle')
			->will($this->returnValue('test'))
		;
		$expectedCategory->expects($this->once())
			->method('getCategoryDescription')
			->will($this->returnValue('testDescription'))
		;
		$expectedCategory->expects($this->once())
			->method('getCategorySlug')
			->will($this->returnValue('test'))
		;
		$this->assertEquals($expectedCategory->getId(), $actualCategory->getId(), 'The IDs are not equal.');
		$this->assertEquals($expectedCategory->getCategoryParent(), $actualCategory->getCategoryParent(), 'The category parent is not equal.');
		$this->assertEquals($expectedCategory->getCategoryTitle(), $actualCategory->getCategoryTitle(), 'The category title is not equal.');
		$this->assertEquals($expectedCategory->getCategoryDescription(), $actualCategory->getCategoryDescription(), 'The category description is not equal.');
		$this->assertEquals($expectedCategory->getCategorySlug(), $actualCategory->getCategorySlug(), 'The category slug is not equal.');
	}
	
	public function testUpdate()
	{
		// first create category with Doctrine
		$actualCategory = new CategoryEntity();
		$actualCategory->setCategoryParent(0);
		$actualCategory->setCategoryTitle('test');
		$actualCategory->setCategorySlug('test');
		$actualCategory->setCategoryDescription('testDescription');
		$this->em->persist($actualCategory);
		$this->em->flush($actualCategory);
		$this->em->refresh($actualCategory);
		
		$layout = new LayoutEntity();
		$layout->setObjectID($actualCategory->getId());
		$layout->setObjectType('category');
		$this->em->persist($layout);
		$this->em->flush($layout);
		$this->em->refresh($layout);
		
		// reset WCF cache, possible since it is only WCF code
		CategoryEditor::resetCache();
		
		// test if category has been created
		$categories = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(2, $categories, 'The category hasn\'t been created.');
		$this->assertCount(6, $layouts, 'The layout hasn\'t been created.');
		
		// update created category
		$parameters = array(
			'data' => array(
				'categoryTitle' => 'HelloWorld',
				'categoryDescription' => 'SampleDesc'
			)
		);
		$categoryAction = new CategoryAction(array($actualCategory->getId()), 'update', $parameters);
		$categoryAction->executeAction();
		
		$this->em->refresh($actualCategory);
		$this->em->refresh($layout);
		
		// test if created category has been correctly updated
		$id = $actualCategory->getId();
		$expectedCategory = $this->getMock('\PzS\UltimateBundle\Entity\Category');
		$expectedCategory->expects($this->once())
			->method('getId')
			->will($this->returnValue($id))
		;
		$expectedCategory->expects($this->once())
			->method('getCategoryParent')
			->will($this->returnValue(0))
		;
		$expectedCategory->expects($this->once())
			->method('getCategoryTitle')
			->will($this->returnValue('HelloWorld'))
		;
		$expectedCategory->expects($this->once())
			->method('getCategoryDescription')
			->will($this->returnValue('SampleDesc'))
		;
		$expectedCategory->expects($this->once())
			->method('getCategorySlug')
			->will($this->returnValue('test'))
		;
		$this->assertEquals($expectedCategory->getId(), $actualCategory->getId(), 'The IDs are not equal.');
		$this->assertEquals($expectedCategory->getCategoryParent(), $actualCategory->getCategoryParent(), 'The category parent is not equal.');
		$this->assertEquals($expectedCategory->getCategoryTitle(), $actualCategory->getCategoryTitle(), 'The category title is not equal.');
		$this->assertEquals($expectedCategory->getCategoryDescription(), $actualCategory->getCategoryDescription(), 'The category description is not equal.');
		$this->assertEquals($expectedCategory->getCategorySlug(), $actualCategory->getCategorySlug(), 'The category slug is not equal.');
	}
	
	public function testDelete()
	{
		// first create category with Doctrine
		$category = new CategoryEntity();
		$category->setCategoryParent(0);
		$category->setCategoryTitle('test');
		$category->setCategorySlug('test');
		$category->setCategoryDescription('testDescription');
		$this->em->persist($category);
		$this->em->flush($category);
		$this->em->refresh($category);
		
		$layout = new LayoutEntity();
		$layout->setObjectID($category->getId());
		$layout->setObjectType('category');
		$this->em->persist($layout);
		$this->em->flush($layout);
		$this->em->refresh($layout);
		
		// reset WCF cache, possible since it is only WCF code
		CategoryEditor::resetCache();
		
		// delete created category
		$categoryAction = new CategoryAction(array($category->getId()), 'delete');
		$categoryAction->executeAction();
		
		// check if category has been removed
		$categories = $this->em
			->getRepository('PzSUltimateBundle:Category')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(1, $categories, 'The category hasn\'t been removed.');
		$this->assertCount(5, $layouts, 'The layout hasn\'t been removed.');
	}
	

	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		$sql = 'DELETE FROM `'.$this->databaseTable.'` WHERE categoryID > 1';
		$this->em->getConnection()->executeQuery($sql);
		$sql = 'DELETE FROM `ultimate1_layout` WHERE layoutID > 5';
		$this->em->getConnection()->executeQuery($sql);
		$sql = 'ALTER TABLE `'.$this->databaseTable.'` AUTO_INCREMENT = 2';
		$this->em->getConnection()->executeQuery($sql);
		$sql = 'ALTER TABLE `ultimate1_layout` AUTO_INCREMENT = 6';
		$this->em->getConnection()->executeQuery($sql);
		CategoryEditor::resetCache();
		parent::tearDown();
		$this->em->close();
	}
}