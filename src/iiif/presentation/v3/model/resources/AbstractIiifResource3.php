<?php
namespace iiif\presentation\v3\model\resources;

use iiif\context\IRI;
use iiif\context\JsonLdProcessor;
use iiif\context\Keywords;
use iiif\presentation\common\model\AbstractIiifEntity;

abstract class AbstractIiifResource3 extends AbstractIiifEntity
{
   /**
    * 
    * @var string
    */
    protected $id;
    
    /**
     * 
     * @var string
     */
    protected $type;
    
    /**
     * 
     * @var string
     */
    protected $behavior;
    
    /**
     * 
     * @var array
     */
    protected $label;
    
    /**
     * 
     * @var array
     */
    protected $metadata;
    
    /**
     * 
     * @var array
     */
    protected $summary;
    
    /**
     * 
     * @var ContentResource3[]
     */
    protected $thumbnail;
    
    /**
     * 
     * @var array
     */
    protected $requiredStatement;
    
    /**
     * 
     * @var string
     */
    protected $rights;
    
    /**
     * 
     * @var ContentResource3[]
     */
    protected $seeAlso;
    
    /**
     *
     * @var Service3
     */
    protected $service;
    
    /**
     * 
     * @var ContentResource3[]
     */
    protected $logo;
    
    /**
     * 
     * @var ContentResource3
     */
    protected $homepage;
    
    /**
     * 
     * @var ContentResource3[]
     */
    protected $rendering;
    
    /**
     * @var Collection3[]
     */
    protected $partOf;
    
    /**
     * 
     * @param string|array $resource URI of the IIIF manifest, json string representation of the manifest or decoded json array
     * @return \iiif\presentation\v3\model\resources\AbstractIiifResource3 | NULL
     */
    public static function loadIiifResource($resource)
    {
        if (is_string($resource) && IRI::isAbsoluteIri($resource)) {
            $resource = file_get_contents($resource);
        }
        if (is_string($resource)) {
            $resource = json_decode($resource, true);
        }
        if (JsonLdProcessor::isDictionary($resource)) {
            $r = self::parseDictionary($resource);
            echo "debug";
            return $r;
        }
        return null;
    }
    
    protected function getTranslationFor($dictionary, string $language = null) {
        if ($dictionary == null || !JsonLdProcessor::isDictionary($dictionary)) {
            return null;
        }
        if ($language!=null && array_key_exists($language, $dictionary)) {
            return $dictionary[$language];
        } elseif (array_key_exists(Keywords::NONE, $dictionary)) {
            return $dictionary[Keywords::NONE];
        } elseif ($language == null) {
            return reset($dictionary);
        }
        return null;
    }
    
    public function getLabelTranslated(string $language = null) {
        return $this->getTranslationFor($this->label, $language);
    }
    
    public function getMetadataForLabel($label, string $language = null) {
        if ($this->metadata != null) {
            $selectedMetaDatum = null;
            foreach ($this->metadata as $metadatum) {
                foreach ($metadatum["label"] as $lang=>$labels) {
                    if (array_search($label, $labels)!==false) {
                        $selectedMetaDatum = $metadatum;
                        break 2;
                    }
                }
            }
            if ($selectedMetaDatum != null) {
                $v = $this->getTranslationFor($metadatum["value"], $language);
                return $this->getTranslationFor($metadatum["value"], $language);
            }
        }
        return null;
    }
    
    public function getContainedResourceById($resourceId) {
        if ($this->containedResources != null && array_key_exists($resourceId, $this->containedResources)) {
            return $this->containedResources[$resourceId];
        }
        return null;
    }
    
    public function getLogoUrl($width = 100, $height = null) {
        if ($this->logo != null) {
            if ($this->logo->getService()!=null && $this->logo->getService() == "http://iiif.io/api/image/3/ImageService") {
                // use image service
                return $this->logo->getService()->getId()."/full/".($width==null?"":$width).",".($height==null?"":$width)."/0/default.jpg";
            } elseif (strpos($this->logo->getFormat(), "/image/")===0) {
                // try to use logo id as image url
                return $this->logo->getId();
            }
        }
        return null;
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBehavior()
    {
        return $this->behavior;
    }

    /**
     * @return array
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return array
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return array
     */
    public function getRequiredStatement()
    {
        return $this->requiredStatement;
    }

    /**
     * @return string
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3 
     */
    public function getSeeAlso()
    {
        return $this->seeAlso;
    }

    /**
     * @return \iiif\presentation\v3\model\resources\Service3
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return \iiif\presentation\v3\model\resources\ContentResource3
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3 
     */
    public function getRendering()
    {
        return $this->rendering;
    }

    /**
     * @return multitype:\iiif\presentation\v3\model\resources\Collection3 
     */
    public function getPartOf()
    {
        return $this->partOf;
    }

    
}




