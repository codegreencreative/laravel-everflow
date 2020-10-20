<?php

namespace CodeGreenCreative\Everflow;

class Everflow extends EverflowApiBase
{
    /**
     * Maps endpoints on this API to other APIs
     */
    public $childApis = [
        'network' => Api\EverflowNetwork::class,
        'metadata' => Api\EverflowMetadata::class,
        'affiliate' => Api\EverflowAffiliate::class,
        'advertiser' => Api\EverflowAdvertiser::class,
    ];
}