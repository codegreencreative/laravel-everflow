<?php

namespace CodeGreenCreative\Everflow\Api;

use CodeGreenCreative\Everflow\EverflowApiBase;
use CodeGreenCreative\Everflow\EverflowHttpClient;
use CodeGreenCreative\Everflow\Traits\HasPagination;

class EverflowNetworkAffiliates extends EverflowApiBase
{
    use HasPagination;

    /**
     * Maps endpoints on this API to other APIs
     */
    public $childApis = [
        'users' => EverflowNetworkAffiliatesUsers::class,
        'apikeys' => EverflowNetworkAffiliatesKeys::class,
        'domains' => EverflowNetworkAffiliatesDomains::class,
    ];

    public function all()
    {
        return $this->pageAll(EverflowHttpClient::route('networks/affiliates'), 'affiliates');
    }

    public function get($relationships = [])
    {
        return EverflowHttpClient::get(EverflowHttpClient::route('networks/affiliates/:affiliateId', [
            'affiliateId' => $this->id(),
        ], $relationships));
    }

    public function create($data = [])
    {
        return EverflowHttpClient::post(EverflowHttpClient::route('networks/affiliates'), $data);
    }

    public function signup($data = [])
    {
        return EverflowHttpClient::post(EverflowHttpClient::route('networks/affiliate/signup'), $data);
    }

    public function update($data = [])
    {
        return EverflowHttpClient::put(EverflowHttpClient::route('networks/affiliates/:affiliateId', [
            'affiliateId' => $this->id(),
        ]), $data);
    }

    public function find($field, $value)
    {
        return EverflowHttpClient::get(EverflowHttpClient::route('networks/affiliates?filter=:field%3D:value', [
            'field' => $field,
            'value' => $value
        ]));
    }

    public function notifications($pageSize = 5)
    {
        // Fetch the Affiliate's users
        $users = $this->asAdmin()->users()->all()->users;

        // If no users are found, return an error
        if (empty($users)) {
            throw new \Exception('The provided Affiliate has no users');
        }

        // Gets the first user and passes it to the notifications API call
        $user = $users[0];

        return $this->asAffiliate($this->id(), $user->network_affiliate_user_id)->users($user->network_affiliate_user_id)->notifications($pageSize);
    }
}
