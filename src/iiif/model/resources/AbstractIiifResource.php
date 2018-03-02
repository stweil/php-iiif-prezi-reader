<?php
namespace iiif\model\resources;

use iiif\model\vocabulary\Names;
use iiif\model\vocabulary\MiscNames;

/**
 * Bundles all resource properties that every single iiif resource type may have 
 * see http://iiif.io/api/presentation/2.1/#resource-properties
 * 
 * @author lutzhelm
 *
 */
abstract class AbstractIiifResource
{
    // http://iiif.io/api/presentation/2.1/#technical-properties
    /**
     * 
     * @var string
     */
    protected $id;
    protected $type;
    protected $viewingHint;
    
    // http://iiif.io/api/presentation/2.1/#descriptive-properties
    protected $label;
    protected $metadata;
    protected $description;
    /**
     * 
     * @var Thumbnail
     */
    protected $thumbnail;
    
    // http://iiif.io/api/presentation/2.1/#rights-and-licensing-properties
    protected $attribution;
    protected $license;
    protected $logo;
    
    // http://iiif.io/api/presentation/2.1/#linking-properties
    protected $related;
    protected $rendering;
    
    /**
     * 
     * @var Service
     */
    protected $service;
    protected $seeAlso;
    protected $within;

    protected $preferredLanguage;
    
    // keep it for faster and easier searches
    protected $originalJsonArray;
    
    /**
     * 
     * @var boolean
     */
    protected $reference;
    
    public static function fromJson($jsonAsString)
    {
        $jsonAsArray = json_decode($jsonAsString, true);
        return static::fromArray($jsonAsArray);
    }

    abstract public static function fromArray($jsonAsArray, &$allResources = array());
    
    // could be static
    protected function getTranslatedField($field, $language)
    {
        if (is_null($field)) return null;
        if (is_string($field)) return $field;
        if (is_array($field)) {
            $selectedValue = $field[0];
            if (!(is_null($language))) {
                foreach ($field as $valueAndLanguage) {
                    if ($valueAndLanguage["@language"] == $language)
                    {
                        $selectedValue = $valueAndLanguage;
                    }
                }
            }
            return is_null($selectedValue ? null : $selectedValue["@value"]);
        }
        return null;
    }

    protected function getPreferredTranslation($field)
    {
        return $this->getTranslatedField($field, $this->preferredLanguage);
    }
    
    public function getDefaultLabel()
    {
        return $this->getPreferredTranslation($this->label);
    }
    
    protected static function loadPropertiesFromArray($jsonAsArray, &$allResources)
    {
        // everything but sequences and annotations MUST have an id, annotations still should have an id
        $resourceId=array_key_exists(Names::ID, $jsonAsArray) ? $jsonAsArray[Names::ID] : null;
        
        $instance = null;
        if ($resourceId != null && array_key_exists($resourceId, $allResources) && $allResources[$resourceId] != null) {
            // TODO Is there any way that there is more than a reference in the $allResources array?
            $instance = &$allResources[$resourceId];
        } else {
            $clazz = get_called_class();
            $instance = new $clazz();
            $allResources[$resourceId] = &$instance;
        }
        
        /* @var $instance AbstractIiifResource */
        $instance->originalJsonArray = $jsonAsArray;
        $instance->id = $resourceId;
        $instance->label = array_key_exists(Names::LABEL, $jsonAsArray) ? $jsonAsArray[Names::LABEL] : null;
        
        $instance->service = array_key_exists(Names::SERVICE, $jsonAsArray) ? Service::fromArray($jsonAsArray[Names::SERVICE]) : null;
        // TODO According to the specs, some of the resources may provide more than one thumbnail per resource. Value for "thumbnail" can be json array and json object 
        $instance->thumbnail = array_key_exists(Names::THUMBNAIL, $jsonAsArray) ? Thumbnail::fromArray($jsonAsArray[Names::THUMBNAIL]) : null;
        
        // TODO alle the other properties
        
        return $instance;
    }
    
    // TODO check if one unified method for resource loading is possible
    // FIXME make this static and return value
    protected function loadResources($jsonAsArray, $resourceFieldName, $resourceClass, &$targetArray, &$allResources)
    {
        if (!is_array($jsonAsArray))
        {
            throw new \Exception("$jsonAsArray ".$jsonAsArray." is not an array.");
        }
        if (array_key_exists($resourceFieldName, $jsonAsArray))
        {
            $resourcesAsArray = $jsonAsArray[$resourceFieldName];
            foreach ($resourcesAsArray as $resourceAsArray)
            {
                $resource = null;
                if (is_array($resourceAsArray)) {
                    $resource = $resourceClass::fromArray($resourceAsArray, $allResources);
                }
                elseif (is_string($resourceAsArray)) {
                    if (array_key_exists($resourceAsArray, $allResources)) {
                        $resource = &$allResources[$resourceAsArray];
                    }
                    else {
                        $resource = new $resourceClass();
                        $resource->reference = true;
                        $resource->id = $resourceAsArray;
                        $allResources[$resourceAsArray] = $resource;
                    }
                }
                $targetArray[] = $resource;
            }
        }
    }

    // FIXME make this static and return value
    protected function loadSingleResouce($jsonAsArray, $resourceFieldName, $resourceClass, &$targetField, &$allResources)
    {
        if (!is_array($jsonAsArray))
        {
            throw new \Exception("$jsonAsArray ".$jsonArray." is not an array.");
        }
        if (array_key_exists($resourceFieldName, $jsonAsArray))
        {
            $resourceAsArray = $jsonAsArray[$resourceFieldName];
            $resource = $resourceClass::fromArray($resourceAsArray, $allResources);
            $targetField = $resource;
        }
    }
    
    // FIXME make this static and return value
    protected function loadMixedResources($jsonAsArray, $resourceFieldName, $configArray, &$targetArray, &$allResources)
    {
        if (!is_array($jsonAsArray))
        {
            throw new \Exception("$jsonAsArray ".$jsonArray." is not an array.");
        }
        if (array_key_exists($resourceFieldName, $jsonAsArray))
        {
            $resourcesAsArray = $jsonAsArray[$resourceFieldName];
            foreach ($resourcesAsArray as $resourceAsArray)
            {
                foreach ($configArray as $config)
                {
                    if ($resourceAsArray[Names::TYPE]==$config[Names::TYPE])
                    {
                        $resourceClass = $config[MiscNames::CLAZZ];
                        $resource = $resourceClass::fromArray($resourceAsArray, $allResources);
                        $targetArray[] = $resource;
                        break;
                    }
                }
            }
        }
    }
    protected function getContainedResources()
    {
        
    }
    
    /**
     * @return boolean
     */
    public function isReference()
    {
        return $this->reference;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return \iiif\model\resources\Service
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * @return \iiif\model\resources\Thumbnail
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}

