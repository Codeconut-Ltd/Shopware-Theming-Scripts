<?php

/** @noinspection PhpMethodNamingConventionInspection */

declare(strict_types=1);

namespace CcnTheme\Twig;

use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepository;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Product size properties.
 */
class TwigProperties extends AbstractExtension
{
    private const SIZE_PROPERTY_GROUP_IDS = 'CcnTheme.config.sizePropertyGroupdIds';

    public function __construct(
        public EntityRepository $productRepository,
        public EntityRepository $categoryRepository,
        public SalesChannelRepository $productSalesChannelRepository,
        private readonly SystemConfigService $configService,
    ) {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ccnGetIsSizeProperty', [$this, 'getIsSizeProperty']),
            new TwigFunction('ccnGetSelectedProperties', [$this, 'getSelectedProperties']),
        ];
    }

    /**
     * Return if 'product.configuratorSettings.elements … option.groupId' belongs to group of size properties.
     */
    public function getIsSizeProperty(string $propertyGroupId): bool
    {
        $config = (string) $this->configService->get(self::SIZE_PROPERTY_GROUP_IDS);
        $ids = explode(',', $config);

        return \in_array($propertyGroupId, $ids);
    }

    public function getSelectedProperties(SalesChannelProductEntity $product): array
    {
        $configuratorSettings = $product->getConfiguratorSettings();

        $selectedSettings = [];
        $selectedProperties = [];
        $selectedOptions = [];

        // Not helpful, none 'selected'?
        foreach ($configuratorSettings as $configuratorSetting) {
            $selectedSettings[] = $configuratorSetting->getOption();
        }

        // Non-variant relevant: Material, pattern, …
        // foreach ($product->getProperties() as $property) {
        //    $selectedProperties[] = $property->getTranslation('name');
        // }

        // Variants OCCNY: Selected properties + groups
        foreach ($product->getOptions() as $option) {
            $selectedOptions[] = [
                'group' => $option->getGroup(),
                'option' => $option->getTranslation('name'),
            ];
        }

        return [
            $selectedSettings,
            $selectedProperties,
            $selectedOptions,
        ];
    }
}
