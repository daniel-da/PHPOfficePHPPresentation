<?php
/**
 * This file is part of PHPPresentation - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPresentation is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPresentation/contributors.
 *
 * @see        https://github.com/PHPOffice/PHPPresentation
 *
 * @copyright   2009-2015 PHPPresentation contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpPresentation\Shape;

use PhpOffice\PhpPresentation\AbstractShape;
use PhpOffice\PhpPresentation\ComparableInterface;
use PhpOffice\PhpPresentation\Exception\OutOfBoundsException;
use PhpOffice\PhpPresentation\Shape\RichText\EnhancedGeometry;
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
use PhpOffice\PhpPresentation\Shape\RichText\TextElementInterface;

/**
 * \PhpOffice\PhpPresentation\Shape\CustomShape.
 */
class CustomShape extends RichText
{

    // enhanced-geometry
    private EnhancedGeometry $enhancedGeometry;

    /**
     * Create a new \PhpOffice\PhpPresentation\Shape\CustomShape instance.
     */
    public function __construct()
    {
        // Initialize parent
        parent::__construct();
    }

    /**
     * Magic Method : clone
     */
    public function __clone()
    {
        // Call perent clonage for heritage
        parent::__clone();
    }

    
    /**
     * Convert to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getPlainText();
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode(): string
    {
        $hashElements = '';

        return md5(
            $hashElements
            . $this->enhancedGeometry->getHashCode()
            . parent::getHashCode()
            . __CLASS__
        );
    }
}
