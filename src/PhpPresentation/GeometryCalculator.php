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
 * PhpOffice\PhpPresentation\GeometryCalculator.
 */
class GeometryCalculator
{
    public const X = 'X';
    public const Y = 'Y';

    /**
     * Calculate X and Y offsets for a set of shapes within a container such as a slide or group.
     *
     * @return array<string, Measure>
     */
    public static function calculateOffsets(ShapeContainerInterface $container): array
    {
        $offsets = [self::X => new Measure(), self::Y => new Measure()];

        if (null !== $container && 0 != count($container->getShapeCollection())) {
            $shapes = $container->getShapeCollection();
            if (null !== $shapes[0]) {
                $offsets[self::X] = $shapes[0]->getOffsetX();
                $offsets[self::Y] = $shapes[0]->getOffsetY();
            }

            foreach ($shapes as $shape) {
                if (null !== $shape) {
                    if (Measure::lowerThan($shape->getOffsetX(), $offsets[self::X])) {
                        $offsets[self::X] = $shape->getOffsetX();
                    }

                    if (Measure::lowerThan($shape->getOffsetY(), $offsets[self::Y])) {
                        $offsets[self::Y] = $shape->getOffsetY();
                    }
                }
            }
        }

        return $offsets;
    }

    /**
     * Calculate X and Y extents for a set of shapes within a container such as a slide or group.
     *
     * @return array<string, Measure>
     */
    public static function calculateExtents(ShapeContainerInterface $container): array
    {
        /** @var array<string, Measure> $extents */
        $extents = [self::X => new Measure(), self::Y => new Measure()];

        if (null !== $container && 0 != count($container->getShapeCollection())) {
            $shapes = $container->getShapeCollection();
            if (null !== $shapes[0]) {
                $extents[self::X] = Measure::add($shapes[0]->getOffsetX(), $shapes[0]->getWidth());
                $extents[self::Y] = Measure::add($shapes[0]->getOffsetY(), $shapes[0]->getHeight());
            }

            foreach ($shapes as $shape) {
                if (null !== $shape) {
                    $extentX = Measure::add($shape->getOffsetX(), $shape->getWidth());
                    $extentY = Measure::add($shape->getOffsetY(), $shape->getHeight());
                    if (Measure::greaterThan($extentX, $extents[self::X])) {
                        $extents[self::X] = $extentX;
                    }
                    if (Measure::greaterThan($extentY, $extents[self::Y])) {
                        $extents[self::Y] = $extentY;
                    }
                }
            }
        }

        return $extents;
    }
}
