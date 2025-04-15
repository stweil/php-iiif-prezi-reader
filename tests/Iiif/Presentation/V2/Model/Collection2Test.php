<?php
use Ubl\Iiif\AbstractIiifTest;
use Ubl\Iiif\Presentation\V2\Model\Resources\Collection2;
use Ubl\Iiif\Tools\IiifHelper;
use Ubl\Iiif\Presentation\V2\Model\Resources\Manifest2;

/**
 * Collection2 test case.
 */
class Collection2Test extends AbstractIiifTest {

    /**
     * @var Collection2
     */
    private $collection1;
    /**
     * @var Collection2
     */
    private $collection2;
    /**
     * @var Collection2
     */
    private $collection3;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        $this->collection1 = IiifHelper::loadIiifResource(self::getFile("v2/collection1.json"));
        $this->collection2 = IiifHelper::loadIiifResource(self::getFile("v2/collection2.json"));
        $this->collection3 = IiifHelper::loadIiifResource(self::getFile("v2/collection3.json"));
    }

    /**
     * Tests Collection2->getContainedCollections()
     */
    public function testGetContainedCollections() {
        self::assertNotNull($this->collection1);
        self::assertInstanceOf(Collection2::class, $this->collection1);
        self::assertEquals("http://example.org/collection/collection1", $this->collection1->getId());
        self::assertEmpty($this->collection1->getContainedCollections());
        
        self::assertNotNull($this->collection2);
        self::assertInstanceOf(Collection2::class, $this->collection2);
        self::assertEquals("http://example.org/collection/collection2", $this->collection2->getId());
        self::assertEmpty($this->collection2->getContainedCollections());
        
        self::assertNotNull($this->collection3);
        self::assertInstanceOf(Collection2::class, $this->collection3);
        self::assertEquals("http://example.org/collection/collection3", $this->collection3->getId());
        self::assertNotEmpty($this->collection3->getContainedCollections());
        self::assertEquals(3, sizeof($this->collection3->getContainedCollections()));

        foreach ($this->collection3->getContainedCollections() as $subCollection) {
            switch ($subCollection->getId()) {
                case "http://example.org/collection/subcollection1":
                    self::assertEmpty($subCollection->getContainedCollections());
                    break;
                case "http://example.org/collection/subcollection2":
                    self::assertNotEmpty($subCollection->getContainedCollections());
                    self::assertEquals(2, sizeof($subCollection->getContainedCollections()));
                    break;
                case "http://example.org/collection/subcollection3":
                    self::assertNotEmpty($subCollection->getContainedCollections());
                    self::assertEquals(2, sizeof($subCollection->getContainedCollections()));
                    break;
                default:
                    self::fail("unexpected collection id ".$subCollection->getId());
            }
        }
    }

    /**
     * Tests Collection2->getContainedCollectionsAndManifests()
     */
    public function testGetContainedCollectionsAndManifests() {
        self::assertNotNull($this->collection1);
        self::assertInstanceOf(Collection2::class, $this->collection1);
        self::assertEquals("http://example.org/collection/collection1", $this->collection1->getId());
        self::assertEmpty($this->collection1->getContainedCollectionsAndManifests());
        
        self::assertNotNull($this->collection2);
        self::assertInstanceOf(Collection2::class, $this->collection2);
        self::assertEquals("http://example.org/collection/collection2", $this->collection2->getId());
        self::assertEmpty($this->collection2->getContainedCollectionsAndManifests());
        
        self::assertNotNull($this->collection3);
        self::assertInstanceOf(Collection2::class, $this->collection3);
        self::assertEquals("http://example.org/collection/collection3", $this->collection3->getId());
        self::assertNotEmpty($this->collection3->getContainedCollectionsAndManifests());
        self::assertEquals(5, sizeof($this->collection3->getContainedCollectionsAndManifests()));
        
        foreach ($this->collection3->getContainedCollectionsAndManifests() as $member) {
            switch ($member->getId()) {
                case "http://example.org/collection/subcollection1":
                    self::assertInstanceOf(Collection2::class, $member);
                    self::assertNotEmpty($member->getContainedCollectionsAndManifests());
                    self::assertEquals(2, sizeof($member->getContainedCollectionsAndManifests()));
                    break;
                case "http://example.org/collection/subcollection2":
                    self::assertNotEmpty($member->getContainedCollectionsAndManifests());
                    self::assertEquals(4, sizeof($member->getContainedCollectionsAndManifests()));
                    break;
                case "http://example.org/collection/subcollection3":
                    self::assertNotEmpty($member->getContainedCollectionsAndManifests());
                    self::assertEquals(2, sizeof($member->getContainedCollectionsAndManifests()));
                    break;
                case "http://example.org/manifest/manifest5":
                case "http://example.org/manifest/manifest6":
                    self::assertInstanceOf(Manifest2::class, $member);
                    break;
                default:
                    self::fail("unexpected collection id ".$member->getId());
            }
        }
    }

    /**
     * Tests Collection2->getContainedManifests()
     */
    public function testGetContainedManifests() {
        self::assertNotNull($this->collection1);
        self::assertInstanceOf(Collection2::class, $this->collection1);
        self::assertEquals("http://example.org/collection/collection1", $this->collection1->getId());
        self::assertEmpty($this->collection1->getContainedManifests());
        
        self::assertNotNull($this->collection2);
        self::assertInstanceOf(Collection2::class, $this->collection2);
        self::assertEquals("http://example.org/collection/collection2", $this->collection2->getId());
        self::assertEmpty($this->collection2->getContainedManifests());
        
        self::assertNotNull($this->collection3);
        self::assertInstanceOf(Collection2::class, $this->collection3);
        self::assertEquals("http://example.org/collection/collection3", $this->collection3->getId());
        self::assertNotEmpty($this->collection3->getContainedManifests());
        self::assertEquals(2, sizeof($this->collection3->getContainedManifests()));
        
        foreach ($this->collection3->getContainedCollections() as $subCollection) {
            switch ($subCollection->getId()) {
                case "http://example.org/collection/subcollection1":
                    self::assertNotEmpty($subCollection->getContainedManifests());
                    self::assertEquals(2, sizeof($subCollection->getContainedManifests()));
                    break;
                case "http://example.org/collection/subcollection2":
                    self::assertNotEmpty($subCollection->getContainedManifests());
                    self::assertEquals(2, sizeof($subCollection->getContainedManifests()));
                    break;
                case "http://example.org/collection/subcollection3":
                    self::assertEmpty($subCollection->getContainedManifests());
                    break;
                default:
                    self::fail("unexpected collection id ".$subCollection->getId());
            }
        }
    }
}

