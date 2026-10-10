<?php

/** @noinspection PhpMethodNamingConventionInspection */

declare(strict_types=1);

namespace CcnTheme\Twig;

use Shopware\Core\Content\Property\PropertyGroupEntity;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Distinct product color property from other properties.
 */
class TwigColorProperty extends AbstractExtension
{
    public function __construct()
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ccnGetIsColorProperty', [$this, 'ccnGetIsColorProperty']),
        ];
    }

    public function ccnGetIsColorProperty(?PropertyGroupEntity $group): bool
    {
        if ($group === null) {
            return false;
        }

        $displayType = $group->displayType;
        $isColorOrMedia = $displayType === 'color' || $displayType === 'media';

        return $isColorOrMedia;
    }
}
