<?php

/** @noinspection PhpMethodNamingConventionInspection */

declare(strict_types=1);

namespace CcnTheme\Twig;

use Swag\CmsExtensions\Storefront\Pagelet\Quickview\QuickviewPagelet;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Check if page (content) is for the commercial quickview feature.
 * Allows to distinct between regular and modal pages.
 */
class TwigQuickviewPage extends AbstractExtension
{
    public function __construct()
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ccnGetQuickviewPage', [$this, 'ccnGetQuickviewPage']),
        ];
    }

    public function ccnGetQuickviewPage(mixed $page): bool
    {
        return $page instanceof QuickviewPagelet;
    }
}
