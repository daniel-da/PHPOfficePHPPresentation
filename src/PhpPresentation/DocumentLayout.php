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

use PhpOffice\PhpPresentation\Measure;

/**
 * \PhpOffice\PhpPresentation\DocumentLayout.
 */
class DocumentLayout
{
    public const LAYOUT_CUSTOM = '';
    public const LAYOUT_SCREEN_4X3 = 'screen4x3';
    public const LAYOUT_SCREEN_16X10 = 'screen16x10';
    public const LAYOUT_SCREEN_16X9 = 'screen16x9';
    public const LAYOUT_35MM = '35mm';
    public const LAYOUT_A3 = 'A3';
    public const LAYOUT_A4 = 'A4';
    public const LAYOUT_B4ISO = 'B4ISO';
    public const LAYOUT_B5ISO = 'B5ISO';
    public const LAYOUT_BANNER = 'banner';
    public const LAYOUT_LETTER = 'letter';
    public const LAYOUT_OVERHEAD = 'overhead';


    /**
     * Dimension types.
     *
     * 1 px = 9525 EMU @ 96dpi (which is seems to be the default)
     * Absolute distances are specified in English Metric Units (EMUs),
     * occasionally referred to as A units; there are 360000 EMUs per
     * centimeter, 914400 EMUs per inch, 12700 EMUs per point.
     *
     * @var array<string, array<string, int>>
     */
    private $dimension = [
        self::LAYOUT_SCREEN_4X3 => ['cx' => 9144000, 'cy' => 6858000],
        self::LAYOUT_SCREEN_16X10 => ['cx' => 9144000, 'cy' => 5715000],
        self::LAYOUT_SCREEN_16X9 => ['cx' => 9144000, 'cy' => 5143500],
        self::LAYOUT_35MM => ['cx' => 10287000, 'cy' => 6858000],
        self::LAYOUT_A3 => ['cx' => 15120000, 'cy' => 10692000],
        self::LAYOUT_A4 => ['cx' => 10692000, 'cy' => 7560000],
        self::LAYOUT_B4ISO => ['cx' => 10826750, 'cy' => 8120063],
        self::LAYOUT_B5ISO => ['cx' => 7169150, 'cy' => 5376863],
        self::LAYOUT_BANNER => ['cx' => 7315200, 'cy' => 914400],
        self::LAYOUT_LETTER => ['cx' => 9144000, 'cy' => 6858000],
        self::LAYOUT_OVERHEAD => ['cx' => 9144000, 'cy' => 6858000],
    ];

    /**
     * Layout name.
     *
     * @var string
     */
    private $layout;

    /**
     * Layout X dimension.
     *
     * @var Measure
     */
    private $dimensionX;

    /**
     * Layout Y dimension.
     *
     * @var Measure
     */
    private $dimensionY;

    /**
     * Create a new \PhpOffice\PhpPresentation\DocumentLayout.
     */
    public function __construct()
    {
        $this->setDocumentLayout(self::LAYOUT_SCREEN_4X3);
    }

    /**
     * Get Document Layout.
     */
    public function getDocumentLayout(): string
    {
        return $this->layout;
    }

    /**
     * Set Document Layout.
     *
     * @param array<string, int>|string $pValue
     * @param bool $isLandscape
     */
    public function setDocumentLayout($pValue = self::LAYOUT_SCREEN_4X3, $isLandscape = true): self
    {
        switch ($pValue) {
            case self::LAYOUT_SCREEN_4X3:
            case self::LAYOUT_SCREEN_16X10:
            case self::LAYOUT_SCREEN_16X9:
            case self::LAYOUT_35MM:
            case self::LAYOUT_A3:
            case self::LAYOUT_A4:
            case self::LAYOUT_B4ISO:
            case self::LAYOUT_B5ISO:
            case self::LAYOUT_BANNER:
            case self::LAYOUT_LETTER:
            case self::LAYOUT_OVERHEAD:
                $this->layout = $pValue;
                $this->dimensionX = new Measure($this->dimension[$this->layout]['cx'], Measure::UNIT_EMU);
                $this->dimensionY = new Measure($this->dimension[$this->layout]['cy'], Measure::UNIT_EMU);
                break;
            case self::LAYOUT_CUSTOM:
            default:
                $this->layout = self::LAYOUT_CUSTOM;
                $this->dimensionX = new Measure($pValue['cx'], Measure::UNIT_EMU);
                $this->dimensionY = new Measure($pValue['cy'], Measure::UNIT_EMU);
                break;
        }

        if (!$isLandscape) {
            $tmp = $this->dimensionX;
            $this->dimensionX = $this->dimensionY;
            $this->dimensionY = $tmp;
        }

        return $this;
    }

    /**
     * Get Document Layout cx.
     */
    public function getCX(): Measure
    {
        return $this->dimensionX;
    }
    
    /**
     * Get Document Layout cx.
     */
    public function getCXForUnit(string $unit = Measure::UNIT_EMU): float
    {
        return $this->dimensionX->getValueForUnit($unit);
    }

    /**
     * Get Document Layout cy.
     */
    public function getCY(): Measure
    {
        return $this->dimensionY;
    }

    /**
     * Get Document Layout cy.
     */
    public function getCYForUnit(string $unit = Measure::UNIT_EMU): float
    {
        return $this->dimensionY->getValueForUnit($unit);
    }

    /**
     * Get Document Layout cx.
     */
    public function setCX(Measure $value): self
    {
        $this->layout = self::LAYOUT_CUSTOM;
        $this->dimensionX = $value;
        return $this;
    }

    /**
     * Get Document Layout cy.
     */
    public function setCY(Measure $value): self
    {
        $this->layout = self::LAYOUT_CUSTOM;
        $this->dimensionY = $value ;
        return $this;
    }

}
