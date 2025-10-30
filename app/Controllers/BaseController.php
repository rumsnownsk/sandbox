<?php

namespace App\Controllers;

class BaseController
{
    protected function getTinyImageUrl($imagesMetaHref): string
    {
        if ( empty($imagesMetaHref)) {
            return '';
        }

        $imgUrl = makeApiRequest($imagesMetaHref);

        return $imgUrl['rows'][0]['miniature']['downloadHref'] ?? '';
    }
}