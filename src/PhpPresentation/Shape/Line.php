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
use PhpOffice\PhpPresentation\Measure;
use PhpOffice\PhpPresentation\ComparableInterface;
use PhpOffice\PhpPresentation\Style\Border;

/**
 * Line shape.
 */
class Line extends AbstractShape implements ComparableInterface
{
    /**
     * Create a new \PhpOffice\PhpPresentation\Shape\Line instance.
     *
     * @param float $fromX
     * @param float $fromY
     * @param float $toX
     * @param float $toY
     * @param string $unit
     * 
     */
    public function __construct($fromX, $fromY, $toX, $toY, $unit)
    {
        parent::__construct();
        $this->getBorder()->setLineStyle(Border::LINE_SINGLE);

        $this->setOffsetX(new Measure($fromX, $unit));
        $this->setOffsetY(new Measure($fromY, $unit));
        $this->setWidth(new Measure($toX - $fromX, $unit));
        $this->setHeight(new Measure($toY - $fromY, $unit));
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode(): string
    {
        return md5($this->getBorder()->getLineStyle() . parent::getHashCode() . __CLASS__);
    }
}
