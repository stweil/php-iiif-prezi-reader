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

namespace Ubl\Iiif\Presentation\Common\Model\Resources;

interface AnnotationInterface extends IiifResourceInterface {
    
    /**
     * version 2: resource
     * version 3: body
     * @return ContentResourceInterface
     */
    public function getBody();
    
    /**
     * @return string
     */
    public function getMotivation();
    
    /**
     * @return ?string The id of the resource (usually a Canvas) that is referenced by
     *                the annotation, without any fragments and not enclosed in specific resources
     */
    public function getTargetResourceId(): ?string;


    public function getOnSelector();
}

