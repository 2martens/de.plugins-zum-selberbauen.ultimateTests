<?php
namespace PzS\UltimateBundle\Tests\Entity;
use ultimate\data\content\ContentAction;
use ultimate\data\content\ContentEditor;
use ultimate\data\content\Content;
use PzS\UltimateBundle\Entity\Content as ContentEntity;
use PzS\UltimateBundle\Entity\Layout as LayoutEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContentRepositoryFunctionalTest extends WebTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * @var string
	 */	
	private $databaseTable = 'ultimate1_content';

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
		$contents = $this->em
			->getRepository('PzSUltimateBundle:Content')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(0, $contents);
		$this->assertCount(5, $layouts);
	}
	
	public function testContent()
	{
		// first create content with Doctrine
		$actualContent = new ContentEntity();
		$actualContent->setAuthorID(1);
		$actualContent->setContentTitle('TestContent');
		$actualContent->setContentSlug('testSlug');
		$actualContent->setContentDescription('TestDescription');
		$actualContent->setContentText('Hallo you foo');
		$this->em->persist($actualContent);
		$this->em->flush($actualContent);
		$this->em->refresh($actualContent);
		
		$layout = new LayoutEntity();
		$layout->setObjectID($actualContent->getContentID());
		$layout->setObjectType('content');
		$this->em->persist($layout);
		$this->em->flush($layout);
		$this->em->refresh($layout);
		
		// reset WCF cache, possible since it is only WCF code
		ContentEditor::resetCache();
		
		$id = 1;
		$actualContent = new Content($id);
		$expectedContent = $this->em
			->getRepository('PzSUltimateBundle:Content')
			->find($id)
		;
	
		$this->assertEquals($expectedContent->getContentID(), $actualContent->__get('contentID'), 'The IDs are not equal.');
		$this->assertEquals($expectedContent->getAuthorID(), $actualContent->__get('authorID'), 'The authorID is not equal.');
		$this->assertEquals($expectedContent->getContentTitle(), $actualContent->__get('contentTitle'), 'The content title is not equal.');
		$this->assertEquals($expectedContent->getContentDescription(), $actualContent->__get('contentDescription'), 'The content description is not equal.');
		$this->assertEquals($expectedContent->getContentSlug(), $actualContent->__get('contentSlug'), 'The content slug is not equal.');
		$this->assertEquals($expectedContent->getContentText(), $actualContent->__get('contentText'), 'The content text is not equal.');
	}
	
	public function testCreate()
	{
		// create content
		$parameters = array(
			'data' => array(
				'authorID' => 1,
				'contentTitle' => 'TestContent',
				'contentDescription' => 'TestDescription',
				'contentSlug' => 'testSlug',
				'contentText' => 'Hallo you foo'
			)
		);
		$contentAction = new ContentAction(array(), 'create', $parameters);
		$returnValues = $contentAction->executeAction();
		$contentWCF = $returnValues['returnValues'];
		$contentID = $contentWCF->__get('contentID');
		
		// check if the content has been created
		$contents = $this->em
			->getRepository('PzSUltimateBundle:Content')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(1, $contents, 'The content hasn\'t been created.');
		$this->assertCount(6, $layouts, 'The layout hasn\'t been created.');
		
		// check if created content fits the expected outcome
		$actualContent = $this->em
			->getRepository('PzSUltimateBundle:Content')
			->find($contentID)
		;
		$layoutID = 6;
		$actualLayout = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->find($layoutID)
		;
		
		$expectedContent = $this->getMock('\PzS\UltimateBundle\Entity\Content');
		$expectedContent->expects($this->once())
			->method('getContentID')
			->will($this->returnValue($contentID))
		;
		$expectedContent->expects($this->once())
			->method('getAuthorID')
			->will($this->returnValue(1))
		;
		$expectedContent->expects($this->once())
			->method('getContentTitle')
			->will($this->returnValue('TestContent'))
		;
		$expectedContent->expects($this->once())
			->method('getContentDescription')
			->will($this->returnValue('TestDescription'))
		;
		$expectedContent->expects($this->once())
			->method('getContentSlug')
			->will($this->returnValue('testSlug'))
		;
		$expectedContent->expects($this->once())
			->method('getContentText')
			->will($this->returnValue('Hallo you foo'))
		;
		
		$this->assertEquals($expectedContent->getContentID(), $actualContent->getContentID(), 'The IDs are not equal.');
		$this->assertEquals($expectedContent->getAuthorID(), $actualContent->getAuthorID(), 'The author ID is not equal.');
		$this->assertEquals($expectedContent->getContentTitle(), $actualContent->getContentTitle(), 'The content title is not equal.');
		$this->assertEquals($expectedContent->getContentDescription(), $actualContent->getContentDescription(), 'The content description is not equal.');
		$this->assertEquals($expectedContent->getContentSlug(), $actualContent->getContentSlug(), 'The content slug is not equal.');
		$this->assertEquals($expectedContent->getContentText(), $actualContent->getContentText(), 'The content text is not equal.');
	}
	
	public function testUpdate()
	{
		// first create content with Doctrine
		$actualContent = new ContentEntity();
		$actualContent->setAuthorID(1);
		$actualContent->setContentTitle('TestContent');
		$actualContent->setContentSlug('testSlug');
		$actualContent->setContentDescription('TestDescription');
		$actualContent->setContentText('Hallo you foo');
		$this->em->persist($actualContent);
		$this->em->flush($actualContent);
		$this->em->refresh($actualContent);
		
		$layout = new LayoutEntity();
		$layout->setObjectID($actualContent->getContentID());
		$layout->setObjectType('content');
		$this->em->persist($layout);
		$this->em->flush($layout);
		$this->em->refresh($layout);
		
		// reset WCF cache, possible since it is only WCF code
		ContentEditor::resetCache();
		
		// test if content has been created
		$contents = $this->em
			->getRepository('PzSUltimateBundle:Content')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(1, $contents, 'The content hasn\'t been created.');
		$this->assertCount(6, $layouts, 'The layout hasn\'t been created.');
		
		// update created content
		$parameters = array(
			'data' => array(
				'contentTitle' => 'HelloWorld',
				'contentDescription' => 'SampleDesc'
			)
		);
		$contentAction = new ContentAction(array($actualContent->getContentID()), 'update', $parameters);
		$contentAction->executeAction();
		
		$this->em->refresh($actualContent);
		$this->em->refresh($layout);
		
		// test if created content has been correctly updated
		$contentID = $actualContent->getContentID();
		$expectedContent = $this->getMock('\PzS\UltimateBundle\Entity\Content');
		$expectedContent->expects($this->once())
			->method('getContentID')
			->will($this->returnValue($contentID))
		;
		$expectedContent->expects($this->once())
			->method('getAuthorID')
			->will($this->returnValue(1))
		;
		$expectedContent->expects($this->once())
			->method('getContentTitle')
			->will($this->returnValue('HelloWorld'))
		;
		$expectedContent->expects($this->once())
			->method('getContentDescription')
			->will($this->returnValue('SampleDesc'))
		;
		$expectedContent->expects($this->once())
			->method('getContentSlug')
			->will($this->returnValue('testSlug'))
		;
		$expectedContent->expects($this->once())
			->method('getContentText')
			->will($this->returnValue('Hallo you foo'))
		;
		$this->assertEquals($expectedContent->getContentID(), $actualContent->getContentID(), 'The IDs are not equal.');
		$this->assertEquals($expectedContent->getAuthorID(), $actualContent->getAuthorID(), 'The author ID is not equal.');
		$this->assertEquals($expectedContent->getContentTitle(), $actualContent->getContentTitle(), 'The content title is not equal.');
		$this->assertEquals($expectedContent->getContentDescription(), $actualContent->getContentDescription(), 'The content description is not equal.');
		$this->assertEquals($expectedContent->getContentSlug(), $actualContent->getContentSlug(), 'The content slug is not equal.');
		$this->assertEquals($expectedContent->getContentText(), $actualContent->getContentText(), 'The content text is not equal.');
	}
	
	public function testDelete()
	{
		// first create content with Doctrine
		$actualContent = new ContentEntity();
		$actualContent->setAuthorID(1);
		$actualContent->setContentTitle('TestContent');
		$actualContent->setContentSlug('testSlug');
		$actualContent->setContentDescription('TestDescription');
		$actualContent->setContentText('Hallo you foo');
		$this->em->persist($actualContent);
		$this->em->flush($actualContent);
		$this->em->refresh($actualContent);
		
		$layout = new LayoutEntity();
		$layout->setObjectID($actualContent->getContentID());
		$layout->setObjectType('content');
		$this->em->persist($layout);
		$this->em->flush($layout);
		$this->em->refresh($layout);
		
		// reset WCF cache, possible since it is only WCF code
		ContentEditor::resetCache();
		
		// delete created content
		$contentAction = new ContentAction(array($actualContent->getContentID()), 'delete', array());
		$contentAction->executeAction();
		
		// check if content has been removed
		$contents = $this->em
			->getRepository('PzSUltimateBundle:Content')
			->findAll()
		;
		$layouts = $this->em
			->getRepository('PzSUltimateBundle:Layout')
			->findAll()
		;
		$this->assertCount(0, $contents, 'The content hasn\'t been removed.');
		$this->assertCount(5, $layouts, 'The layout hasn\'t been removed.');
	}
	

	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		$sql = 'DELETE FROM `'.$this->databaseTable.'` WHERE contentID > 0';
		$this->em->getConnection()->executeQuery($sql);
		$sql = 'DELETE FROM `ultimate1_layout` WHERE layoutID > 5';
		$this->em->getConnection()->executeQuery($sql);
		$sql = 'ALTER TABLE `'.$this->databaseTable.'` AUTO_INCREMENT = 1';
		$this->em->getConnection()->executeQuery($sql);
		$sql = 'ALTER TABLE `ultimate1_layout` AUTO_INCREMENT = 6';
		$this->em->getConnection()->executeQuery($sql);
		ContentEditor::resetCache();
		parent::tearDown();
		$this->em->close();
	}
}