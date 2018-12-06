<?php
namespace iiif\presentation\v3\model\resources;

use iiif\context\JsonLdProcessor;
use iiif\context\Keywords;
use iiif\presentation\IiifHelper;
use iiif\presentation\common\model\AbstractIiifEntity;
use iiif\presentation\common\model\resources\IiifResourceInterface;
use iiif\services\AbstractImageService;
use iiif\services\Service;
use iiif\context\JsonLdHelper;

abstract class AbstractIiifResource3 extends AbstractIiifEntity implements IiifResourceInterface {

    /**
     *
     * @var string
     */
    protected $id;

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
     * @var Service
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
     *
     * @var Collection3[]
     */
    protected $partOf;

    /**
     *
     * @param string|array $resource
     *            URI of the IIIF manifest, json string representation of the manifest or decoded json array
     * @return \iiif\presentation\v3\model\resources\AbstractIiifResource3 | NULL
     */

    protected function getTranslationFor($dictionary, string $language = null, $joinValueDelimiter = null) {
        if ($dictionary == null || ! JsonLdHelper::isDictionary($dictionary)) {
            return null;
        }
        if ($language != null && array_key_exists($language, $dictionary)) {
            return $joinValueDelimiter === null ? $dictionary[$language] : implode($joinValueDelimiter, $dictionary[$language]);
        } elseif (array_key_exists(Keywords::NONE, $dictionary)) {
            return $joinValueDelimiter === null ? $dictionary[Keywords::NONE] : implode($joinValueDelimiter, $dictionary[Keywords::NONE]);
        } elseif (empty($language) && ! empty($dictionary)) {
            $value = reset($dictionary);
            return $joinValueDelimiter === null ? $value : implode($joinValueDelimiter, $value);
        }
        return null;
    }

    public function getLabelTranslated(string $language = null, $joinValueDelimiter = null) {
        return $this->getTranslationFor($this->label, $language, $joinValueDelimiter);
    }

    public function getMetadataForLabel($label, string $language = null, $joinValueDelimiter = null) {
        if ($this->metadata != null) {
            $selectedMetaDatum = null;
            foreach ($this->metadata as $metadatum) {
                foreach ($metadatum["label"] as $lang => $labels) {
                    if (array_search($label, $labels) !== false) {
                        $selectedMetaDatum = $metadatum;
                        break 2;
                    }
                }
            }
            if ($selectedMetaDatum != null) {
                $v = $this->getTranslationFor($metadatum["value"], $language);
                if ($joinValueDelimiter === null) {
                    return $this->getTranslationFor($metadatum["value"], $language);
                } else {
                    return implode($joinValueDelimiter, $this->getTranslationFor($metadatum["value"], $language));
                }
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
            if ($this->logo->getService() != null && $this->logo->getService() == "http://iiif.io/api/image/3/ImageService") {
                // use image service
                return $this->logo->getService()->getId() . "/full/" . ($width == null ? "" : $width) . "," . ($height == null ? "" : $width) . "/0/default.jpg";
            } elseif (strpos($this->logo->getFormat(), "/image/") === 0) {
                // try to use logo id as image url
                return $this->logo->getId();
            }
        }
        return null;
    }

    /**
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     *
     * @return string
     */
    public function getBehavior() {
        return $this->behavior;
    }

    /**
     *
     * @return array
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     *
     * @return array
     */
    public function getMetadata() {
        return $this->metadata;
    }

    /**
     *
     * @return array
     */
    public function getSummary() {
        return $this->summary;
    }

    /**
     *
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3
     */
    public function getThumbnail() {
        return $this->thumbnail;
    }

    /**
     *
     * @return array
     */
    public function getRequiredStatement() {
        return $this->requiredStatement;
    }

    /**
     *
     * @return string
     */
    public function getRights() {
        return $this->rights;
    }

    /**
     *
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3
     */
    public function getSeeAlso() {
        return $this->seeAlso;
    }

    /**
     *
     * @return \iiif\services\Service
     */
    public function getService() {
        return $this->service;
    }

    /**
     *
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3
     */
    public function getLogo() {
        return $this->logo;
    }

    /**
     *
     * @return \iiif\presentation\v3\model\resources\ContentResource3
     */
    public function getHomepage() {
        return $this->homepage;
    }

    /**
     *
     * @return multitype:\iiif\presentation\v3\model\resources\ContentResource3
     */
    public function getRendering() {
        return $this->rendering;
    }

    /**
     *
     * @return multitype:\iiif\presentation\v3\model\resources\Collection3
     */
    public function getPartOf() {
        return $this->partOf;
    }

    public function getLabelForDisplay(string $language = null, string $joinChars = "; ", bool $switchToExistingLanguage = true) {
        if (empty($this->label)) {
            return null;
        }
        $label = null;
        if (isset($language) && array_key_exists($language, $this->label)) {
            $label = $this->label[$language];
        } elseif (array_key_exists(Keywords::NONE, $this->label)) {
            $label = $this->label[Keywords::NONE];
        }
        if ($label == null && $switchToExistingLanguage) {
            $label = reset($this->label);
        }
        if (is_array($label) && isset($joinChars)) {
            $label = implode($joinChars, $label);
        }
        return $label;
            
    }
    
    public function getRenderingUrlsForFormat(string $format, bool $useChildResources = true) {
        $renderingUrls = [];
        if (empty($format) || !JsonLdHelper::isSequentialArray($this->rendering)) {
            return $renderingUrls;
        }
        foreach ($this->rendering as $rendering) {
            if (!is_array($rendering)) {
                continue;
            }
            if (array_key_exists("format", $rendering) && $rendering["format"] == $format && array_key_exists("@id", $rendering)) {
                $renderingUrls[] = $rendering["@id"];
            }
        }
        if (empty($renderingUrls) && $useChildResources) {
            if (empty($renderingUrls) && $useChildResources) {
                if ($this instanceof Manifest3) {
                    // TODO use rendering of Range with behaviour="sequence" 
                }
                elseif ($this instanceof Canvas3 && !empty($this->getImageAnnotations())) {
                    $renderingUrls = $this->getImageAnnotations()[0]->getRenderingUrlsForFormat($format);
                }
                elseif ($this instanceof Annotation3 && $this->getResource()!=null) {
                    $renderingUrls = $this->getBody()->getRenderingUrlsForFormat($format);
                }
            }
        }
        return $renderingUrls;
    }
    
    public function getSeeAlsoUrlsForFormat(string $format) {
        if (!is_array($this->seeAlso)) {
            return null;
        }
        $result = [];
        $seeAlso = JsonLdHelper::isSequentialArray($this->seeAlso) ? $this->seeAlso : [$this->seeAlso];
        foreach ($seeAlso as $candidate) {
            if (array_key_exists("format", $candidate)) {
                if ($format == $candidate["format"]) {
                    $result[] = $candidate["@id"];
                }
            }
        }
        return $result;
    }
    
    public function getSeeAlsoUrlsForProfile(string $profile, bool $startsWith = false) {
        if (!is_array($this->seeAlso)) {
            return null;
        }
        $seeAlso = JsonLdHelper::isSequentialArray($this->seeAlso) ? $this->seeAlso : [$this->seeAlso];
        $result = [];
        foreach ($seeAlso as $candidate) {
            if (array_key_exists("profile", $candidate)) {
                if (is_string($candidate["profile"])) {
                    if ($candidate["profile"] == $profile || ($startsWith && strpos($candidate["profile"], $profile)===0)) {
                        $result[] = $candidate["@id"];
                    }
                } elseif (JsonLdHelper::isSequentialArray($candidate["profile"])) {
                    foreach ($candidate["profile"] as $profileItem) {
                        if (is_string($profileItem) && ($profileItem == $profile || ($startsWith && strpos($profileItem, $profile)===0))) {
                            $result[] = $candidate["@id"];
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function getSingleService() {
        return empty($this->service) ? null : $this->service[0];
    }
    
    public function getThumbnailUrl() {
        if ($this->thumbnail!=null) {
            $imageService = null;
            $width = null;
            $height = null;
            if ($thumbnail instanceof ContentResource3) {
                $imageService = $thumbnail->getService();
                $width = $thumbnail->getWidth();
                $height = $thumbnail->getHeight();
            } elseif (JsonLdHelper::isDictionary($thumbnail)) {
                if (array_key_exists("service", $thumbnail)) {
                    if (JsonLdHelper::isDictionary($thumbnail["service"])) {
                        $imageService = IiifHelper::loadIiifResource($thumbnail["service"]);
                    }
                }
            }
            if ($imageService!=null && $imageService instanceof AbstractImageService) {
                // TODO Add level 0 support. The following uses level 1 features sizeByW or sizeByH
                $width = $width == null ? 100 : $width;
                $height = $heigth == null ? 100 : $heigth;
                $size = $width <= $height ? (",".$height) : ($width.",");
                return $imageService->getImageUrl(null, $size, null, null, null);
            }
        }
    }
    
    
}
