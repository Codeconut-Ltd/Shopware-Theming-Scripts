<?php declare(strict_types=1);

namespace CcnTheme\Twig;

use Shopware\Core\Content\Property\Aggregate\PropertyGroupOption\PropertyGroupOptionEntity;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigVariantExtension extends AbstractExtension
{
    private array $variantCache = [];

    public function __construct(
        private readonly SalesChannelRepository $productRepository
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getVariantStockForOption', [$this, 'getVariantStockForOption']),
            new TwigFunction('loadVariantsForProduct', [$this, 'loadVariantsForProduct']),
        ];
    }

    public function loadVariantsForProduct(string $parentId, SalesChannelContext $context): array
    {
        if (isset($this->variantCache[$parentId])) {
            return $this->variantCache[$parentId];
        }

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('parentId', $parentId));
        $criteria->addAssociation('options');
        $criteria->addAssociation('customFields');

        $variants = $this->productRepository->search(
            $criteria,
            $context
        )->getEntities()->getElements();

        $this->variantCache[$parentId] = $variants;
        return $variants;
    }

    public function getVariantStockForOption(
        string $productId,
        PropertyGroupOptionEntity $option,
        SalesChannelContext $context
    ): ?array {
        $variants = $this->loadVariantsForProduct($productId, $context);

        foreach ($variants as $variant) {
            if (empty($variant->getOptionIds())) {
                continue;
            }

            if (in_array($option->getId(), $variant->getOptionIds())) {
                return [
                    'availableStock' => $variant->getAvailableStock(),
                    'customFields' => $variant->getCustomFields() ?? []
                ];
            }
        }

        return null;
    }
}