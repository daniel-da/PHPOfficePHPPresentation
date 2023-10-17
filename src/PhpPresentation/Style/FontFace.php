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

namespace PhpOffice\PhpPresentation\Style;

use PhpOffice\PhpPresentation\ComparableInterface;

$ffCounter = 0;

/**
 * \PhpOffice\PhpPresentation\Style\FontFace
 */
class FontFace implements ComparableInterface
{
    /**
     * Name.
     *
     * @var string
     */
    private $name;
    
    /**
     * fontFamily
     *
     * @var string
     */
    private $fontFamily;
    /**
     * font-family-generic
     *
     * @var string
     */
    private $fontFamilyGeneric;

    /**
     * font-pitch
     *
     * @var string
     */
    private $fontPitch;
    
    /**
     * Hash index.
     *
     * @var int
     */
    private $hashIndex;
    
    private $count;
    
    /**
     * Create a new \PhpOffice\PhpPresentation\Style\FontFace
     */
    public function __construct()
    {
        global $ffCounter;
        $ffCounter ++;
        $this->count = $ffCounter;
        // Initialise values
        $this->name = '';
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $pValue
     *
     * @return self
     */
    public function setName(string $pValue = ''): self
    {   
        $this->name = $pValue;
        return $this;
    }   

    /**
     * Get fontFamily
     *
     * @return string
     */
    public function getFontFamily()
    {
        return $this->fontFamily;
    }

    /**
     * Set fontFamily
     *
     * @param  string                   $pValue
     * @return \PhpOffice\PhpPresentation\Style\FontFace
     */
    public function setFontFamily($pValue) : FontFace
    {
        if ($pValue == '') {
            $pValue = '';
        }
        $this->fontFamily = $pValue;

        return $this;
    }
    /**
     * Get fontFamilyGeneric
     *
     * @return string
     */
    public function getFontFamilyGeneric()
    {
        return $this->fontFamilyGeneric;
    }

    /**
     * Set fontFamilyGeneric
     *
     * @param  string                   $pValue
     * @return \PhpOffice\PhpPresentation\Style\Font
     */
    public function setFontFamilyGeneric($pValue)
    {
        $this->fontFamilyGeneric = $pValue;
        return $this;
    }

    /**
     * Get fontPitch
     *
     * @return string
     */
    public function getFontPitch()
    {
        return $this->fontPitch;
    }

    /**
     * Set fontPitch
     *
     * @param  string                   $pValue
     * @return \PhpOffice\PhpPresentation\Style\Font
     */
    public function setFontPitch($pValue)
    {
        $this->fontPitch = $pValue;
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
            $this->name
            . $this->fontFamily
            . $this->fontFamilyGeneric
            . $this->fontPitch
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

    public function getCount() {
        return $this->count;
    }
    
}
