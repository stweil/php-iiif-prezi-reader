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

namespace Ubl\Iiif\Presentation\V3\Model\Resources;

use Ubl\Iiif\Presentation\Common\Model\Resources\AnnotationContainerInterface;

class AnnotationPage3 extends AbstractIiifResource3 implements AnnotationContainerInterface {

    /**
     *
     * @var Annotation3[]
     */
    protected $items;

    /**
     *
     * @return multitype:\Ubl\Iiif\Presentation\V3\Model\Resources\Annotation3
     */
    public function getItems() {
        return $this->items;
    }
    /**
     * {@inheritDoc}
     * @see \Ubl\Iiif\Presentation\Common\Model\Resources\AnnotationContainerInterface::getTextAnnotations()
     */
    public function getTextAnnotations($motivation = null): ?array
    {
        // TODO Auto-generated method stub
        return null;
    }



}

