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

namespace PhpOffice\PhpPresentation;

use PhpOffice\Common\Drawing;
use PhpOffice\PhpPresentation\ComparableInterface;

$ffCounter = 0;

/**
 * \PhpOffice\PhpPresentation\Style\Measure
 */
class Measure implements ComparableInterface
{

    public const UNIT_EMU = 'emu';
    public const UNIT_CENTIMETER = 'cm';
    public const UNIT_INCH = 'in';
    public const UNIT_MILLIMETER = 'mm';
    public const UNIT_PIXEL = 'px';
    public const UNIT_POINT = 'pt';

    /**
     * unit.
     *
     * @var string
     */
    private $unit;
    
    /**
     * value.
     *
     * @var float
     */
    private $value;
    
    /**
     * Hash index.
     *
     * @var int
     */
    private $hashIndex;
    
    /**
     * Create a new \PhpOffice\PhpPresentation\Style\Measure
     */
    public function __construct(float $value = 0.0, $unit = 'cm')
    {
        // Initialise values
        $this->value = $value;
        $this->unit = $unit;
    }

    /**
     * return Measure
     */
    public static function toMeasure(string $strValue = '0.0cm') : Measure
    {
        // Initialise values
        $matches = [];
        preg_match('/([\.0-9]*)([a-z]*)/', $strValue, $matches);
        return new Measure((float) $matches[1], $matches[2]);
    }

    /**
     * return Measure
     */
    public static function add(Measure $a, Measure $b) : Measure
    {
        // TODO unit check
        return new Measure($a->getValue() + $b->getValue(), $a->getUnit());
    }

    /**
     * return Measure
     */
    public static function subtract(Measure $a, Measure $b) : Measure
    {
        // TODO unit check
        return new Measure($a->getValue() - $b->getValue(), $a->getUnit());
    }

    /**
     * return Measure
     */
    public static function equals(Measure $a, Measure $b) : bool
    {
        // TODO unit check
        return $a->getValue() === $b->getValue();
    }

    /**
     * return Measure
     */
    public static function greaterThan(Measure $a, Measure $b) : bool
    {
        // TODO unit check
        return $a->getValue() > $b->getValue();
    }
    
    /**
    * return Measure
    */
    public static function lowerThan(Measure $a, Measure $b) : bool
    {
        // TODO unit check
        return $a->getValue() < $b->getValue();
    }
   
    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * Set unit
     *
     * @param string $pValue
     *
     * @return self
     */
    public function setUnit(string $pValue = 'px'): self
    {   
        $this->unit = $pValue;
        return $this;
    }   

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValueForUnit($targetUnit)
    {
        return $this->convertUnit($this->value, $this->unit, $targetUnit);
    }

    /**
     * Set value
     *
     * @param  float                   $pValue
     * @return \PhpOffice\PhpPresentation\Measure
     */
    public function setValue($pValue) : self
    {
        $this->value = $pValue;
        return $this;
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode(): string
    {
        return md5(
            $this->unit
            . $this->value
            . __CLASS__
        );
    }

    /**
     * Get hash index.
     *
     * Note that this index may vary during script execution! Only reliable moment is
     * while doing a write of a workbook and when changes are not allowed.
     *
     * @return int|null Hash index
     */
    public function getHashIndex(): ?int
    {
        return $this->hashIndex;
    }

    /**
     * Set hash index.
     *
     * Note that this index may vary during script execution! Only reliable moment is
     * while doing a write of a workbook and when changes are not allowed.
     *
     * @param int $value Hash index
     *
     * @return $this
     */
    public function setHashIndex(int $value)
    {
        $this->hashIndex = $value;

        return $this;
    }


     /**
     * Convert EMUs to differents units.
     */
    protected function convertUnit(float $value, string $fromUnit, string $toUnit): float
    {
        if ($fromUnit === $toUnit) {
            return $value;
        }

        // Convert from $fromUnit to EMU
        switch ($fromUnit) {
            case self::UNIT_MILLIMETER:
                $value *= 36000.0;
                break;
            case self::UNIT_CENTIMETER:
                $value *= 360000.0;
                break;
            case self::UNIT_INCH:
                $value *= 914400.0;
                break;
            case self::UNIT_PIXEL:
                $value = Drawing::pixelsToEmu($value);
                break;
            case self::UNIT_POINT:
                $value *= 12700.0;
                break;
            case self::UNIT_EMU:
            default:
                // no changes
        }

        // Convert from EMU to $toUnit
        switch ($toUnit) {
            case self::UNIT_MILLIMETER:
                $value /= 36000.0;
                break;
            case self::UNIT_CENTIMETER:
                $value /= 360000.0;
                break;
            case self::UNIT_INCH:
                $value /= 914400.0;
                break;
            case self::UNIT_PIXEL:
                $value = (int) round($value / 9525.0);;
                break;
            case self::UNIT_POINT:
                $value /= 12700.0;
                break;
            case self::UNIT_EMU:
            default:
            // no changes
        }

        return $value;
    }


}
