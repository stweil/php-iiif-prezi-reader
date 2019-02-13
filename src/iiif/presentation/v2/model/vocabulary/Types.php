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

namespace iiif\presentation\v2\model\vocabulary;

use iiif\presentation\v2\model\resources\Manifest;
use iiif\presentation\v2\model\resources\Sequence;
use iiif\presentation\v2\model\resources\Canvas;
use iiif\presentation\v2\model\resources\AnnotationList;
use iiif\presentation\v2\model\resources\Range;
use iiif\presentation\v2\model\resources\Layer;
use iiif\presentation\v2\model\resources\Collection;
use iiif\presentation\v2\model\resources\Annotation;

class Types {

    const SC_MANIFEST = "sc:Manifest";

    const SC_SEQUENCE = "sc:Sequence";

    const SC_CANVAS = "sc:Canvas";

    const SC_ANNOTATION_LIST = "sc:AnnotationList";

    const SC_RANGE = "sc:Range";

    const SC_LAYER = "sc:Layer";

    const SC_COLLECTION = "sc:Collection";

    const CNT_CONTENTASTEXT = "cnt:ContentAsText";

    const OA_ANNOTATION = "oa:Annotation";

    const DCTYPES_IMAGE = "dctypes:Image";

    const IIIF_RESOURCE_TYPES = array(
        self::SC_MANIFEST => Manifest::class,
        self::SC_SEQUENCE => Sequence::class,
        self::SC_CANVAS => Canvas::class,
        self::SC_ANNOTATION_LIST => AnnotationList::class,
        self::SC_RANGE => Range::class,
        self::SC_LAYER => Layer::class,
        self::SC_COLLECTION => Collection::class,
        self::OA_ANNOTATION => Annotation::class
    );
    
    // TODO more in http://iiif.io/api/presentation/2/context.json
}