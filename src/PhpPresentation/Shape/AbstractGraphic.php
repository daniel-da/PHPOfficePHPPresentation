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
use PhpOffice\PhpPresentation\Measure;

/**
 * Abstract drawing.
 */
abstract class AbstractGraphic extends AbstractShape implements ComparableInterface
{
    /**
     * Image counter.
     *
     * @var int
     */
    private static $imageCounter = 0;

    /**
     * Image index.
     *
     * @var int
     */
    private $imageIndex = 0;

    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Description.
     *
     * @var string
     */
    protected $description;

    /**
     * Proportional resize.
     *
     * @var bool
     */
    protected $resizeProportional;

    /**
     * Slide relation ID (should not be used by user code!).
     *
     * @var string
     */
    public $relationId = null;

    /**
     * Create a new \PhpOffice\PhpPresentation\Slide\AbstractDrawing.
     */
    public function __construct()
    {
        // Initialise values
        $this->name = '';
        $this->description = '';
        $this->resizeProportional = true;

        // Set image index
        ++self::$imageCounter;
        $this->imageIndex = self::$imageCounter;

        // Initialize parent
        parent::__construct();
    }

    public function __clone()
    {
        parent::__clone();

        ++self::$imageCounter;
        $this->imageIndex = self::$imageCounter;
    }

    /**
     * Get image index.
     *
     * @return int
     */
    public function getImageIndex()
    {
        return $this->imageIndex;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name.
     *
     * @param string $pValue
     *
     * @return $this
     */
    public function setName($pValue = '')
    {
        $this->name = $pValue;

        return $this;
    }

    /**
     * Get Description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Description.
     *
     * @param string $pValue
     *
     * @return $this
     */
    public function setDescription($pValue = '')
    {
        $this->description = $pValue;

        return $this;
    }

    /**
     * Set Width.
     *
     * @return self
     */
    public function setWidth(Measure $pMeasure)
    {
        // Resize proportional?
        if ($this->resizeProportional && 0 != $pMeasure->getValue() && 0 != $this->width->getValue()) {
            $ratio = $this->height->getValue() / $this->width->getValue();
            $this->height->setValue($ratio * $pMeasure->getValue());
        }

        // Set width
        $this->width = $pMeasure;

        return $this;
    }

    /**
     * Set Height.
     *
     * @return self
     */
    public function setHeight(Measure $pMeasure)
    {
        // Resize proportional?
        if ($this->resizeProportional && 0 != $pMeasure->getValue() && 0 != $this->height->getValue()) {
            $ratio = $this->width->getValue() / $this->height->getValue();
            $this->width->setValue($ratio * $pMeasure->getValue());
        }
        // Set height
        $this->height = $pMeasure;
        return $this;
    }

    /**
     * Set width and height with proportional resize.
     *
     * @author Vincent@luo MSN:kele_100@hotmail.com
     *
     * @return self
     */
    public function setWidthAndHeight(Measure $width, Measure $height)
    {
        $xratio = $width->getValue() / $this->width->getValue();
        $yratio = $height->getValue() / $this->height->getValue();
        if ($this->resizeProportional && !(0 == $width->getValue() || 0 == $height->getValue())) {
            if (($xratio * $this->height->getValue()) < $height->getValue()) {
                $this->height->setValue($xratio * $this->height->getValue());
                $this->width = $width;
            } else {
                $this->width->setValue($yratio * $this->width->getValue());
                $this->height = $height;
            }
        }
        return $this;
    }

    /**
     * Get ResizeProportional.
     *
     * @return bool
     */
    public function isResizeProportional()
    {
        return $this->resizeProportional;
    }

    /**
     * Set ResizeProportional.
     *
     * @param bool $pValue
     */
    public function setResizeProportional($pValue = true): self
    {
        $this->resizeProportional = $pValue;

        return $this;
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode(): string
    {
        return md5($this->name . $this->description . parent::getHashCode() . __CLASS__);
    }
}
