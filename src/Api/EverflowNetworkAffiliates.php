<?php

namespace CodeGreenCreative\Everflow\Api;

use CodeGreenCreative\Everflow\EverflowApiBase;
use CodeGreenCreative\Everflow\EverflowHttpClient;

class EverflowNetworkAffiliates extends EverflowApiBase
{
    /**
     * Maps endpoints on this API to other APIs
     */
    public $childApis = [
        'users' => EverflowNetworkAffiliatesUsers::class,
        'domains' => EverflowNetworkAffiliatesDomains::class,
    ];

    public function all()
    {
        return EverflowHttpClient::get(EverflowHttpClient::route('networks/affiliates'));
    }

    public function get($affiliateId)
    {
        return EverflowHttpClient::get(EverflowHttpClient::route('networks/affiliates/:affiliateId', [
            'affiliateId' => $affiliateId
        ]));
    }

    public function create($data = [])
    {
        return EverflowHttpClient::post(EverflowHttpClient::route('networks/affiliates'), $data);
    }

    public function update($data = [])
    {
        return EverflowHttpClient::put(EverflowHttpClient::route('networks/affiliates/:affiliateId', [
            'affiliateId' => $this->id(),
        ]), $data);
    }
}