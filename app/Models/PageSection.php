<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['page', 'type', 'label', 'is_visible', 'sort_order', 'settings'];

    protected $casts = [
        'is_visible' => 'boolean',
        'settings'   => 'array',
    ];

    /**
     * Canonical list of all sections available on the homepage.
     * Used by the seeder and as a reference for the admin UI.
     */
    public static function defaultSections(): array
    {
        return [
            [
                'type'       => 'hero',
                'label'      => 'البانر الرئيسي',
                'sort_order' => 1,
                'is_visible' => true,
                'settings'   => [
                    'title'    => 'بيوت عامرة بريحة الطيب',
                    'subtitle' => 'نقدّم لك بخور فاخر وعود أصيل ومباخر تعبّر عن جمال تراثنا',
                    'cta_text' => 'تسوق الآن',
                    'cta_url'  => '/products',
                    'image'    => '',
                ],
            ],
            [
                'type'       => 'categories',
                'label'      => 'الفئات',
                'sort_order' => 2,
                'is_visible' => true,
                'settings'   => [
                    'title' => 'تسوق حسب الفئة',
                ],
            ],
            [
                'type'       => 'latest',
                'label'      => 'أحدث المنتجات',
                'sort_order' => 3,
                'is_visible' => true,
                'settings'   => [
                    'title' => 'كل اللي يعبّر عن عطرك اليومي',
                    'limit' => 6,
                ],
            ],
            [
                'type'       => 'banner',
                'label'      => 'البانر الترويجي',
                'sort_order' => 4,
                'is_visible' => true,
                'settings'   => [
                    'title'    => 'جديد عبق بلمسة أصيلة',
                    'subtitle' => 'تشكيلة جديدة تجمع بين الفخامة وتزين بيتك بلمسة شرقية أصيلة',
                    'cta_text' => 'تسوق الآن',
                    'cta_url'  => '/products',
                    'image'    => '',
                ],
            ],
            [
                'type'       => 'featured',
                'label'      => 'المنتجات المميزة',
                'sort_order' => 5,
                'is_visible' => true,
                'settings'   => [
                    'title' => 'منتجات مختارة بعناية',
                    'limit' => 6,
                ],
            ],
            [
                'type'       => 'countdown',
                'label'      => 'عداد العروض',
                'sort_order' => 6,
                'is_visible' => true,
                'settings'   => [
                    'title'    => 'خصم يوصل لـ 30% على تشكيلة العود الملكي لفترة محدودة',
                    'ends_at'  => '',
                    'cta_text' => 'تسوق الآن',
                    'cta_url'  => '/products',
                ],
            ],
            [
                'type'       => 'on_offer',
                'label'      => 'منتجات العروض',
                'sort_order' => 7,
                'is_visible' => true,
                'settings'   => [
                    'title' => 'منتجات العروض',
                    'limit' => 6,
                ],
            ],
            [
                'type'       => 'instagram',
                'label'      => 'إنستقرام',
                'sort_order' => 8,
                'is_visible' => true,
                'settings'   => [
                    'title'  => 'تابعونا على إنستقرام',
                    'handle' => '@YourStoreHandle',
                    'count'  => 5,
                ],
            ],
        ];
    }
}
