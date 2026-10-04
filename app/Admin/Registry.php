<?php

namespace App\Admin;

use App\Admin\Resources\AboutBlockResource;
use App\Admin\Resources\FaqResource;
use App\Admin\Resources\FeatureCardResource;
use App\Admin\Resources\GalleryPhotoResource;
use App\Admin\Resources\GalleryVideoResource;
use App\Admin\Resources\MenuItemResource;
use App\Admin\Resources\NewsCategoryResource;
use App\Admin\Resources\NewsResource;
use App\Admin\Resources\PageResource;
use App\Admin\Resources\PartnerResource;
use App\Admin\Resources\PersonResource;
use App\Admin\Resources\ReceptionResource;
use App\Admin\Resources\SliderResource;
use App\Admin\Resources\StructureNodeResource;
use App\Admin\Resources\UserResource;

class Registry
{
    /** @return array<int, class-string<Resource>> */
    public static function all(): array
    {
        return [
            NewsResource::class,
            NewsCategoryResource::class,
            SliderResource::class,
            FeatureCardResource::class,
            PageResource::class,
            AboutBlockResource::class,
            PersonResource::class,
            StructureNodeResource::class,
            FaqResource::class,
            ReceptionResource::class,
            PartnerResource::class,
            GalleryPhotoResource::class,
            GalleryVideoResource::class,
            MenuItemResource::class,
            UserResource::class,
        ];
    }
}
