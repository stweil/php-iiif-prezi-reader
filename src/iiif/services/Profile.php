<?php
namespace iiif\services;

class Profile {
    
    // Features
    
    const BASE_URI_REDIRECT = "baseUriRedirect";

    const CANONICAL_LINK_HEADER = "canonicalLinkHeader";

    const CORS = "cors";

    const JSONLD_MEDIA_TYPE = "jsonldMediaType";

    const MIRRORING = "mirroring";

    const PROFILE_LINK_HEADER = "profileLinkHeader";

    const REGION_BY_PCT = "regionByPct";

    const REGION_BY_PX = "regionByPx";

    const REGION_SQUARE = "regionSquare";

    const ROTATION_ARBITRARY = "rotationArbitrary";

    const ROTATION_BY_90S = "rotationBy90s";

    const SIZE_ABOVE_FULL = "sizeAboveFull";

    const SIZE_BY_CONFINED_WH = "sizeByConfinedWh";

    const SIZE_BY_DISTORTED_WH = "sizeByDistortedWh";

    const SIZE_BY_FORCED_WH = "sizeByForcedWh";

    const SIZE_BY_H = "sizeByH";

    const SIZE_BY_PCT = "sizeByPct";

    const SIZE_BY_W = "sizeByW";

    const SIZE_BY_WH = "sizeByWh";

    const SIZE_BY_WH_LISTED = "sizeByWhListed";
    
    // Formats
    
    const JPG = "jpg";
    
    const PNG = "png";
    
    const TIF = "tif";
    
    const GIF = "gif";
    
    const PDF = "pdf";
    
    const JP2 = "jp2";
    
    // Qualities
    
    const DEFAULT_ = "default";
    
    const NATIVE = "native";
    
    const GREY = "grey";
    
    const GRAY = "gray";
    
    const BITONAL = "bitonal";
    
    const COLOR = "color";

    // Compliance level profiles

    public const IMAGE1_LEVEL0 = [
        "formats" => [],
        "qualities" => [
            self::NATIVE
        ],
        "supported" => []
    ];

    public const IMAGE1_LEVEL1 = [
        "formats" => [
            self::JPG
        ],
        "qualities" => [
            self::NATIVE
        ],
        "supported" => [
            self::REGION_BY_PX,
            self::SIZE_BY_W,
            self::SIZE_BY_H, 
            self::SIZE_BY_PCT, 
            self::ROTATION_BY_90S
        ]
    ];

    public const IMAGE1_LEVEL2 = [
        "formats" => [
            self::JPG,
            self::PNG
        ],
        "qualities" => [
            self::NATIVE, 
            self::COLOR, 
            self::GREY, 
            self::BITONAL
        ],
        "supported" => [
            self::REGION_BY_PX, 
            self::REGION_BY_PCT, 
            self::SIZE_BY_W, 
            self::SIZE_BY_H, 
            self::SIZE_BY_PCT, 
            self::SIZE_BY_WH, 
            self::SIZE_BY_CONFINED_WH, 
            self::ROTATION_BY_90S
        ]
    ];
    
    public const IMAGE2_LEVEL0 = [
        "formats" => [
            self::JPG
        ],
        "qualities" => [
            self::DEFAULT_
        ],
        "supported" => [
            self::SIZE_BY_WH_LISTED
        ]
    ];

    public const IMAGE2_LEVEL1 = [
        "formats" => [
            self::JPG
        ],
        "qualities" => [
            self::DEFAULT_
        ],
        "supported" => [
            self::SIZE_BY_WH_LISTED,
            self::BASE_URI_REDIRECT,
            self::CORS,
            self::JSONLD_MEDIA_TYPE,
            self::REGION_BY_PX,
            self::SIZE_BY_H,
            self::SIZE_BY_PCT,
            self::SIZE_BY_W
        ]
    ];
    
    public const IMAGE2_LEVEL2 = [
        "formats" => [
            self::JPG,
            self::PNG
        ],
        "qualities" => [
            self::DEFAULT_,
            self::BITONAL
        ],
        "supported" => [
            self::BASE_URI_REDIRECT,
            self::CORS,
            self::JSONLD_MEDIA_TYPE,
            self::REGION_BY_PCT,
            self::REGION_BY_PX,
            self::ROTATION_BY_90S,
            self::SIZE_BY_WH_LISTED,
            self::SIZE_BY_H,
            self::SIZE_BY_PCT,
            self::SIZE_BY_CONFINED_WH,
            self::SIZE_BY_FORCED_WH,
            self::SIZE_BY_DISTORTED_WH,
            self::SIZE_BY_W,
            self::SIZE_BY_WH
        ]
    ];
    
    public const IMAGE3_LEVEL0 = [
        "formats" => [
            self::JPG
        ],
        "qualities" => [
            self::DEFAULT_
        ],
        "supported" => []
    ];
    
    public const IMAGE3_LEVEL1 = [
        "formats" => [self::JPG],
        "qualities" => [
            self::DEFAULT_
        ],
        "supported" => [
            self::BASE_URI_REDIRECT,
            self::CORS,
            self::JSONLD_MEDIA_TYPE,
            self::REGION_BY_PX,
            self::REGION_SQUARE,
            self::SIZE_BY_H,
            self::SIZE_BY_W
        ]
    ];
    
    public const IMAGE3_LEVEL2 = [
        "formats" => [
            self::JPG,
            self::PNG
        ],
        "qualities" => [
            self::DEFAULT_,
            self::COLOR,
            self::GRAY,
            self::BITONAL
        ],
        "supported" => [
            self::BASE_URI_REDIRECT,
            self::CORS,
            self::JSONLD_MEDIA_TYPE,
            self::REGION_BY_PCT,
            self::REGION_BY_PX,
            self::REGION_SQUARE,
            self::ROTATION_BY_90S,
            self::SIZE_BY_H,
            self::SIZE_BY_PCT,
            self::SIZE_BY_CONFINED_WH,
            self::SIZE_BY_W,
            self::SIZE_BY_WH
        ]
        
    ];
    
    // FIXME this will only work as long as versions beyond 3 will either have the same supported features as 3 or different level identifiers 
    public const PROFILES = [
        "http://library.stanford.edu/iiif/image-api/compliance.html#level0" => self::IMAGE1_LEVEL0,
        "http://library.stanford.edu/iiif/image-api/compliance.html#level1" => self::IMAGE1_LEVEL1,
        "http://library.stanford.edu/iiif/image-api/compliance.html#level2" => self::IMAGE1_LEVEL2,
        "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level0" => self::IMAGE1_LEVEL0,
        "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level1" => self::IMAGE1_LEVEL1,
        "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level2" => self::IMAGE1_LEVEL2,
        "http://iiif.io/api/image/2/level0.json" => self::IMAGE2_LEVEL0,
        "http://iiif.io/api/image/2/level1.json" => self::IMAGE2_LEVEL1,
        "http://iiif.io/api/image/2/level2.json" => self::IMAGE2_LEVEL2,
        "http://iiif.io/api/image/3/level0.json" => self::IMAGE3_LEVEL0,
        "http://iiif.io/api/image/3/level1.json" => self::IMAGE3_LEVEL1,
        "http://iiif.io/api/image/3/level2.json" => self::IMAGE3_LEVEL2,
        "level0" => self::IMAGE3_LEVEL0,
        "level1" => self::IMAGE3_LEVEL1,
        "level2" => self::IMAGE3_LEVEL2
    ];
    
    public static function getComplianceLevelProfile($level) {
        return array_key_exists($level, Profile::PROFILES) ? Profile::PROFILES[$level] : null;
    }
    
    public static function getQualities($level) {
        return array_key_exists($level, Profile::PROFILES) ? Profile::PROFILES[$level]["qualities"] : null;
    }
    
    public static function getFormats($level) {
        return array_key_exists($level, Profile::PROFILES) ? Profile::PROFILES[$level]["formats"] : null;
    }
    
    public static function getSupported($level) {
        return array_key_exists($level, Profile::PROFILES) ? Profile::PROFILES[$level]["supported"] : null;
    }
    
    public static function isFeatureSupported($level, $feature) {
        return array_key_exists($level, Profile::PROFILES) && array_key_exists($feature, Profile::PROFILES[$level]["supported"]) ;
        
    }
    
}

