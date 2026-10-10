<?php

/** @noinspection PhpMethodNamingConventionInspection */

declare(strict_types=1);

namespace CcnTheme\Twig;

use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Categories for sliders.
 */
class TwigSliderCategories extends AbstractExtension
{
    private const FIELD_SORTING_SLIDER_CATEGORY = 'ccn_categories_sorting_slider_category';
    private const FIELD_SORTING_SLIDER_PROMO = 'ccn_categories_sorting_slider_promo';
    private const FIELD_MEDIA = 'ccn_categories_slider_media';

    public function __construct(
        private readonly EntityRepository $categoryRepository,
        private readonly EntityRepository $mediaRepository,
    ) {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ccnGetSliderCategories', [$this, 'ccnGetSliderCategories']),
            new TwigFunction('ccnGetPromoSliderCategories', [$this, 'ccnGetPromoSliderCategories']),
        ];
    }

    public function ccnGetSliderCategories(SalesChannelContext $context): array
    {
        return $this->getSliderCategories($context, false);
    }

    public function ccnGetPromoSliderCategories(SalesChannelContext $context): array
    {
        return $this->getSliderCategories($context, true);
    }

    /**
     * UX: Duplicate numbers just get overridden, it's up to users to edit it correctly.
     *
     * @return array [int => ['category' => CategoryEntity, 'media' => MediaEntity]]
     */
    private function getSliderCategories(SalesChannelContext $salesChannelContext, bool $isPromo): array
    {
        $context = $salesChannelContext->getContext();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('active', 1));
        // $criteria->addAssociation('media');

        $categories = $this->categoryRepository->search($criteria, $context);
        $result = [];

        /* @var CategoryEntity $category */
        foreach ($categories as $category) {
            /* @var array|null $fields */
            $fields = $category->getCustomFields();
            $isValid = $this->hasValidCategoryCustomFields($fields);

            if (!$isValid) {
                continue;
            }

            $mediaField = $fields[self::FIELD_MEDIA];
            $sortField = $isPromo ? self::FIELD_SORTING_SLIDER_PROMO : self::FIELD_SORTING_SLIDER_CATEGORY;

            // $media = $media = $category->getMedia();
            $media = $this->getMediaById($salesChannelContext, $mediaField);
            $customSorting = $fields[$sortField];

            $result[$customSorting] = [
                'category' => $category,
                'media' => $media, // Can be null
            ];
        }

        ksort($result, SORT_NUMERIC);

        return $result;
    }

    /**
     * Get media by ID, if it exists (fallback).
     *
     * Fallback is intended for DEV ENVs and potentially incomplete
     * DB migrations. This avoids a crash for a single feature.
     */
    private function getMediaById(SalesChannelContext $salesChannelContext, string $id): ?MediaEntity
    {
        $context = $salesChannelContext->getContext();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('id', $id));

        return $this->mediaRepository->search($criteria, $context)->first();
    }

    private function hasValidCategoryCustomFields($fields): bool
    {
        if (!$fields) {
            return false;
        }

        $hasMedia = \array_key_exists(self::FIELD_MEDIA, $fields);
        $hasSortingCategory = \array_key_exists(self::FIELD_SORTING_SLIDER_CATEGORY, $fields);
        $hasSortingPromo = \array_key_exists(self::FIELD_SORTING_SLIDER_PROMO, $fields);

        return $hasMedia && ($hasSortingCategory || $hasSortingPromo);
    }
}
