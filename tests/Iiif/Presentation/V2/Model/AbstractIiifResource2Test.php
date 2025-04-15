<?php
/*
 * Copyright (C) 2019 Leipzig University Library <info@ub.uni-leipzig.de>
 * 
 * This file is part of the php-iiif-prezi-reader.
 * 
 * php-iiif-prezi-reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

use Ubl\Iiif\AbstractIiifTest;
use Ubl\Iiif\Presentation\V2\Model\Resources\Manifest2;
use Ubl\Iiif\Presentation\V2\Model\Resources\MockIiifResource;
use Ubl\Iiif\Tools\IiifHelper;
use Ubl\Iiif\Context\JsonLdHelper;

/**
 * AbstractIiifResource2 test case.
 */
class AbstractIiifResource2Test extends AbstractIiifTest
{

    /**
     *
     * @var MockIiifResource
     */
    private $abstractIiifResource;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // TODO Auto-generated AbstractIiifResource2Test::setUp()
        
        $this->abstractIiifResource = new MockIiifResource();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        // TODO Auto-generated AbstractIiifResource2Test::tearDown()
        $this->abstractIiifResource = null;
        
        parent::tearDown();
    }

    /**
     * Tests AbstractIiifResource->getDefaultLabel()
     */
    public function testGetDefaultLabel()
    {
        // TODO Auto-generated AbstractIiifResource2Test->testGetDefaultLabel()
        $this->markTestIncomplete("getDefaultLabel test not implemented");
        
        //$this->abstractIiifResource->getDefaultLabel(/* parameters */);
    }

    /**
     * Tests AbstractIiifResource->isReference()
     */
    public function testIsReference()
    {
        // TODO Auto-generated AbstractIiifResource2Test->testIsReference()
        $this->markTestIncomplete("isReference test not implemented");
        
        $this->abstractIiifResource->isReference(/* parameters */);
    }

    /**
     * Tests AbstractIiifResource->getId()
     */
    public function testGetId()
    {
        // TODO Auto-generated AbstractIiifResource2Test->testGetId()
        $this->markTestIncomplete("getId test not implemented");
        
        $this->abstractIiifResource->getId(/* parameters */);
    }

    /**
     * Tests AbstractIiifResource->getService()
     */
    public function testGetService()
    {
        // TODO Auto-generated AbstractIiifResource2Test->testGetService()
        $this->markTestIncomplete("getService test not implemented");
        
        $this->abstractIiifResource->getService(/* parameters */);
    }
    
    public function testGetSeeAlso() {
        
        // TODO
        $this->markTestIncomplete("getSeeAlso test not implemented");
        
    }

    /**
     * Tests AbstractIiifResource->getThumbnail()
     */
    public function testGetThumbnail()
    {
        // TODO Auto-generated AbstractIiifResource2Test->testGetThumbnail()
        $this->markTestIncomplete("getThumbnail test not implemented");
        
        $this->abstractIiifResource->getThumbnail(/* parameters */);
    }
    
    /**
     * Tests AbstractIiifResource->getLabelForDisplay()
     */
    public function testGetLabelForDisplay()
    {
        // no label
        $this->abstractIiifResource->setLabel(null);
        $label = $this->abstractIiifResource->getLabelForDisplay();
        self::assertNull($label);
        $label = $this->abstractIiifResource->getLabelForDisplay("en");
        self::assertNull($label);
        
        // string as label
        $this->prepareLabel('My label');
        $label = $this->abstractIiifResource->getLabelForDisplay();
        self::assertEquals('My label', $label);
        $label = $this->abstractIiifResource->getLabelForDisplay('en');
        self::assertEquals('My label', $label);

        // multiple strings as label
        $this->prepareLabel('["My label", "My second label", "My third label"]');
        $label = $this->abstractIiifResource->getLabelForDisplay(null, null);
        self::assertTrue(is_array($label));
        self::assertContains('My label', $label);
        self::assertContains('My second label', $label);
        self::assertContains('My third label', $label);
        
        $label = $this->abstractIiifResource->getLabelForDisplay('en', null);
        self::assertTrue(is_array($label));
        self::assertContains('My label', $label);
        self::assertContains('My second label', $label);
        self::assertContains('My third label', $label);
        
        // translated label
        $this->prepareLabel('[{"@value": "Title", "@language": "en"}, {"@value": "Titel", "@language": "de"}, {"@value": "Intitulé", "@language": "fr"}]');
        $label = $this->abstractIiifResource->getLabelForDisplay();
        self::assertEquals('Title', $label);
        $label = $this->abstractIiifResource->getLabelForDisplay('en');
        self::assertEquals('Title', $label);
        $label = $this->abstractIiifResource->getLabelForDisplay('de');
        self::assertEquals('Titel', $label);
        $label = $this->abstractIiifResource->getLabelForDisplay('fr');
        self::assertEquals('Intitulé', $label);
        $label = $this->abstractIiifResource->getLabelForDisplay('ru');
        self::assertEquals('Title', $label);
    }

    /**
     * Tests AbstractIiifResource->getMetadateForLabel()
     */
    public function testGetMetadataForLabel()
    {
        // Test null value
        $this->abstractIiifResource->setMetadata(null);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Hopefully no error if metadata is set to null");
        self::assertNull($metadataValue);
        
        // Test empty metadata
        $this->prepareMetadata('[]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Hopefully no error for empty metadata");
        self::assertNull($metadataValue);
        
        // Test untranslated metadata
        $this->prepareMetadata('[{"label": "My label", "value": "My value"}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label");
        self::assertEquals("My value", $metadataValue);

        // Test translated metadata
        $this->prepareMetadata('[{"label": [{"@value": "My label", "@language": "en"}, {"@value": "Meine Beschriftung", "@language": "de"}],'.
            ' "value": [{"@value": "My value", "@language": "en"}, {"@value": "Mein Wert", "@language": "de"}]}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label", "de");
        self::assertEquals("Mein Wert", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine Beschriftung");
        self::assertEquals("Mein Wert", $metadataValue);
        
        // Test translated metadata with multiple entries
        $this->prepareMetadata('[{"label": [{"@value": "My label", "@language": "en"}, {"@value": "Meine Beschriftung", "@language": "de"}],'.
            ' "value": [{"@value": "My value", "@language": "en"}, {"@value": "Mein Wert", "@language": "de"}]},'.
            ' {"label": [{"@value": "My other label", "@language": "en"}, {"@value": "Meine andere Beschriftung", "@language": "de"}],'.
            ' "value": [{"@value": "My other value", "@language": "en"}, {"@value": "Mein anderer Wert", "@language": "de"}]}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label", "de");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label", "en");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My other label");
        self::assertEquals("My other value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine Beschriftung");
        self::assertEquals("Mein Wert", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine andere Beschriftung");
        self::assertEquals("Mein anderer Wert", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My other label", "de");
        self::assertEquals("Mein anderer Wert", $metadataValue);
        
        // Test metadata with untranslated label and translated values
        $this->prepareMetadata('[{"label": "My label",'.
            ' "value": [{"@value": "My value", "@language": "en"}, {"@value": "Mein Wert", "@language": "de"}]},'.
            ' {"label": "Meine andere Beschriftung",'.
            ' "value": [{"@value": "My other value", "@language": "en"}, {"@value": "Mein anderer Wert", "@language": "de"}]}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label", "en");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label", "de");
        self::assertEquals("Mein Wert", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine andere Beschriftung");
        self::assertEquals("My other value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine andere Beschriftung", "en");
        self::assertEquals("My other value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine andere Beschriftung", "de");
        self::assertEquals("Mein anderer Wert", $metadataValue);
        
        
        // Test metadata with translated label and untranslated values
        $this->prepareMetadata('[{"label": [{"@value": "My label", "@language": "en"}, {"@value": "Meine Beschriftung", "@language": "de"}],'.
            ' "value": "My value"},'.
            ' {"label": [{"@value": "My other label", "@language": "en"}, {"@value": "Meine andere Beschriftung", "@language": "de"}],'.
            ' "value": "Mein anderer Wert"}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label", "en");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label", "de");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine Beschriftung");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine Beschriftung", "de");
        self::assertEquals("My value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My other label");
        self::assertEquals("Mein anderer Wert", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine andere Beschriftung");
        self::assertEquals("Mein anderer Wert", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Meine andere Beschriftung", "en");
        self::assertEquals("Mein anderer Wert", $metadataValue);
        
        // Test metadata with conflicting translations
        $this->prepareMetadata('[{"label": [{"@value": "Date", "@language": "en"}, {"@value": "Datum", "@language": "de"}],'.
            ' "value": [{"@value": "My date", "@language": "en"}, {"@value": "Mein Datum", "@language": "de"}]},'.
            ' {"label": [{"@value": "Datum", "@language": "en"}, {"@value": "Messwert", "@language": "de"}],'.
            ' "value": [{"@value": "My datum", "@language": "en"}, {"@value": "Mein Messwert", "@language": "de"}]}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Date");
        self::assertEquals("My date", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Datum");
        self::assertEquals("Mein Datum", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Datum", "de");
        self::assertEquals("Mein Datum", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Datum", "en");
        self::assertEquals("My datum", $metadataValue);

        // Test metadata with arrays of values
        $this->prepareMetadata('[{"label": "My label", "value": ["My value", "My second value", "My third value"]}, '.
            '{"label": "My other label", "value": ["My other value", "My second other value", "My third other value"]}]');
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("Not my label");
        self::assertNull($metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My label");
        self::assertTrue(is_array($metadataValue));
        self::assertContains("My value", $metadataValue);
        self::assertContains("My second value", $metadataValue);
        self::assertContains("My third value", $metadataValue);
        $metadataValue = $this->abstractIiifResource->getMetadataForLabel("My other label");
        self::assertTrue(is_array($metadataValue));
        self::assertContains("My other value", $metadataValue);
        self::assertContains("My second other value", $metadataValue);
        self::assertContains("My third other value", $metadataValue);
    }
    
    public function testJsonPath()
    {
        $manifest = Manifest2::loadIiifResource(parent::getFile('v2/manifest-0000006761.json'));
        
        /* @var $manifest Manifest2 */
        
        self::assertNotNull($manifest);
        
        $resultId = $manifest->jsonPath("$.['@id']");
        self::assertEquals("https://iiif.ub.uni-leipzig.de/0000006761/manifest.json", $resultId);

        $resultKitodo = $manifest->jsonPath("$.metadata.[?(@.label=='Kitodo')].value");
        self::assertEquals("8642", $resultKitodo);
        
        $resultPPN = $manifest->jsonPath("$.metadata.[?(@.label=='Source PPN (SWB)')].value");
        self::assertEquals("046198466", $resultPPN);
        
    }
    public function testDynamicProperties() {
        // All explicitly declared properties are protected. Ensure no additional public property is set after loading.    
        self::assertEmpty(get_object_vars($this->abstractIiifResource));
    }
    
    public function testGetRenderingUrlsForFormat() {
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-rendering-01.json'));
        $rendering = $manifest->getRenderingUrlsForFormat('application/pdf');
        self::assertEmpty($rendering);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-rendering-02.json'));
        $rendering = $manifest->getRenderingUrlsForFormat('application/pdf');
        self::assertEmpty($rendering);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-rendering-03.json'));
        $rendering = $manifest->getRenderingUrlsForFormat('application/pdf');
        self::assertNotEmpty($rendering);
        self::assertTrue(is_array($rendering));
        self::assertEquals(1, sizeof($rendering));
        self::assertEquals('http://example.org/iiif/manifest-rendering.pdf', $rendering[0]);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-rendering-04.json'));
        $rendering = $manifest->getRenderingUrlsForFormat('application/pdf');
        self::assertNotEmpty($rendering);
        self::assertTrue(is_array($rendering));
        self::assertEquals(1, sizeof($rendering));
        self::assertEquals('http://example.org/iiif/manifest-rendering-2.pdf', $rendering[0]);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-rendering-05.json'));
        $rendering = $manifest->getRenderingUrlsForFormat('application/pdf');
        self::assertNotEmpty($rendering);
        self::assertTrue(is_array($rendering));
        self::assertEquals(2, sizeof($rendering));
        self::assertEquals('http://example.org/iiif/manifest-rendering.pdf', $rendering[0]);
        self::assertEquals('http://example.org/iiif/manifest-rendering-2.pdf', $rendering[1]);
    }
    
    public function testGetSeeAlsoUrlsForFormat() {

        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-01.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForFormat('image/jpg');
        self::assertEmpty($seeAlso);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-02.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForFormat('image/jpg');
        self::assertEmpty($seeAlso);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-03.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForFormat('image/jpg');
        self::assertEmpty($seeAlso);
        $seeAlso = $manifest->getSeeAlsoUrlsForFormat('application/mets+xml');
        self::assertNotEmpty($seeAlso);
        self::assertEquals(1, sizeof($seeAlso));
        self::assertEquals("http://example.org/mets.xml", $seeAlso[0]);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-04.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForFormat('application/mets+xml');
        self::assertEmpty($seeAlso);
        $seeAlso = $manifest->getSeeAlsoUrlsForFormat('image/jpg');
        self::assertNotEmpty($seeAlso);
        self::assertEquals(3, sizeof($seeAlso));
        self::assertEquals("http://example.org/iiif/image/v2", $seeAlso[0]);
        self::assertEquals("http://example.org/iiif/image/v1", $seeAlso[1]);
        self::assertEquals("http://example.org/iiif/image/v2/2", $seeAlso[2]);
        
    }

    public function testGetSeeAlsoUrlsForProfile() {
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-01.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('http://www.loc.gov/standards/mets/');
        self::assertEmpty($seeAlso);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-02.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('http://www.loc.gov/standards/mets/');
        self::assertEmpty($seeAlso);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-03.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('http://www.loc.gov/standards/mets/version111/mets.xsd');
        self::assertNotEmpty($seeAlso);
        self::assertEquals(1, sizeof($seeAlso));
        self::assertEquals("http://example.org/mets.xml", $seeAlso[0]);
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('http://www.loc.gov/standards/mets/');
        self::assertEmpty($seeAlso);
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('http://www.loc.gov/standards/mets/', true);
        self::assertNotEmpty($seeAlso);
        self::assertEquals(1, sizeof($seeAlso));
        self::assertEquals("http://example.org/mets.xml", $seeAlso[0]);
        
        $manifest = IiifHelper::loadIiifResource(parent::getFile('v2/manifest-seealso-04.json'));
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('https://iiif.io/api/image/');
        self::assertEmpty($seeAlso);
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('https://iiif.io/api/image/', true);
        self::assertNotEmpty($seeAlso);
        self::assertEquals(2, sizeof($seeAlso));
        self::assertContains("http://example.org/iiif/image/v2", $seeAlso);
        self::assertContains("http://example.org/iiif/image/v2/2", $seeAlso);
        
        $seeAlso = $manifest->getSeeAlsoUrlsForProfile('http://library.stanford.edu/iiif/image-api/compliance.html#level1');
        self::assertNotEmpty($seeAlso);
        self::assertEquals(1, sizeof($seeAlso));
        self::assertEquals("http://example.org/iiif/image/v1", $seeAlso[0]);

    }
    
    public function testGetWeblinksForDisplay() {
        $manifest = IiifHelper::loadIiifResource(self::getFile("v2/manifest-data.json"));
        self::assertNotNull($manifest);
        /* @var $manifest Manifest2 */
        self::assertInstanceOf(Manifest2::class, $manifest);
        self::assertNotNull($manifest->getWeblinksForDisplay());
        self::assertTrue(is_array($manifest->getWeblinksForDisplay()));
        self::assertTrue(JsonLdHelper::isSimpleArray($manifest->getWeblinksForDisplay()));
        self::assertEquals(1, count($manifest->getWeblinksForDisplay()));
        self::assertTrue(JsonLdHelper::isDictionary($manifest->getWeblinksForDisplay()[0]));
        self::assertEquals("http://www.example.org/related-to-manifest", $manifest->getWeblinksForDisplay()[0]["@id"]);
        $canvases = $manifest->getSequences()[0]->getCanvases();
        self::assertNotNull($canvases);
        self::assertEquals(3, count($canvases));
        self::assertEquals(1, count($canvases[0]->getWeblinksForDisplay()));
        self::assertEquals(1, count($canvases[0]->getWeblinksForDisplay()[0]));
        self::assertEquals("http://www.example.org/related-to-canvas-1", $canvases[0]->getWeblinksForDisplay()[0]["@id"]);
        self::assertEquals(4, count($canvases[1]->getWeblinksForDisplay()));
        self::assertEquals(1, count($canvases[1]->getWeblinksForDisplay()[0]));
        self::assertEquals("http://www.example.org/related-to-canvas-2-1", $canvases[1]->getWeblinksForDisplay()[0]["@id"]);
        self::assertEquals(1, count($canvases[1]->getWeblinksForDisplay()[1]));
        self::assertEquals("http://www.example.org/related-to-canvas-2-2", $canvases[1]->getWeblinksForDisplay()[1]["@id"]);
        self::assertEquals(3, count($canvases[1]->getWeblinksForDisplay()[2]));
        self::assertEquals("http://www.example.org/related-to-canvas-2-3", $canvases[1]->getWeblinksForDisplay()[2]["@id"]);
        self::assertEquals("text/html", $canvases[1]->getWeblinksForDisplay()[2]["format"]);
        self::assertEquals("Label 2-3", $canvases[1]->getWeblinksForDisplay()[2]["label"]);
        self::assertEquals(3, count($canvases[1]->getWeblinksForDisplay()[3]));
        self::assertEquals("http://www.example.org/related-to-canvas-2-4", $canvases[1]->getWeblinksForDisplay()[3]["@id"]);
        self::assertEquals("text/html", $canvases[1]->getWeblinksForDisplay()[3]["format"]);
        self::assertEquals("Label II-IV", $canvases[1]->getWeblinksForDisplay()[3]["label"]);
        self::assertNull($canvases[2]->getWeblinksForDisplay());
    }
    
    private function prepareMetadata($metadataString)
    {
        $metadata = json_decode($metadataString, true);
        $this->abstractIiifResource->setMetadata($metadata);
    }
    private function prepareLabel($labelString)
    {
        $label = json_decode($labelString, true);
        $label = $label==null?$labelString:$label;
        $this->abstractIiifResource->setLabel($label);
    }
}
