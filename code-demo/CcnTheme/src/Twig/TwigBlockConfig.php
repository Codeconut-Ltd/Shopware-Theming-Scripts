<?php

/** @noinspection PhpMethodNamingConventionInspection */

declare(strict_types=1);

namespace CcnTheme\Twig;

use Shopware\Core\Content\Cms\Aggregate\CmsBlock\CmsBlockEntity;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * CMS block config via CSS class parsing.
 *
 * @example
 *   Apply '--CCN_CFG_SLIDES[3]' as CSS class to an image slider block
 */
class TwigBlockConfig extends AbstractExtension
{
    private const SLIDES_CONFIG_PREFIX = '--CCN_CFG_SLIDES';
    private const SLIDES_DEFAULT_MAX = 4;

    public function __construct()
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ccnGetBlockSliderMaxSlides', [$this, 'ccnGetBlockSliderMaxSlides']),
        ];
    }

    public function ccnGetBlockSliderMaxSlides(CmsBlockEntity $block): int
    {
        $result = $this->getCssClassValue($block, self::SLIDES_CONFIG_PREFIX);
        $maxSlides = (int) ($result ?? self::SLIDES_DEFAULT_MAX);

        return $maxSlides;
    }

    /**
     * Parse value out of specific variable.
     *
     * @return mixed|null
     */
    private function getCssClassValue(CmsBlockEntity $block, string $prefix)
    {
        $cssClasses = $block->getCssClass() ?? '';
        $pattern = '/'.$prefix.'\[(\w+)\]/';
        $matches = [];

        preg_match($pattern, $cssClasses, $matches);

        return $matches[1] ?? null;
    }
}
