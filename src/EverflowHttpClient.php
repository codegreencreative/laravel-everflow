<?php

namespace CodeGreenCreative\Everflow;

class EverflowHttpClient
{
    private const BASE_URL = 'https://api.eflow.team/v1/';

    public static function request($method, $url, $data = [], $options = [])
    {
        // Start a new cURL session
        $handle = curl_init(static::BASE_URL . $url);

        // Setup base cURL options
        curl_setopt_array($handle, $options);
        curl_setopt_array($handle, [
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        // Setup HTTP method
        switch (strtolower($method)) {
            // HTTP POST
            case 'post':
                curl_setopt($handle, CURLOPT_POST, true);
                break;

            // HTTP PUT
            case 'put':
                curl_setopt($handle, CURLOPT_PUT, true);
                break;

            // HTTP PATCH
            case 'patch':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PATCH');
                break;

            // HTTP DELETE
            case 'delete':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            // HTTP GET
            case 'get':
            default:
                curl_setopt($handle, CURLOPT_HTTPGET, true);
                break;
        }

        // Setup request headers
        $headers = array_merge(
            isset($options[CURLOPT_HTTPHEADER]) ? $options[CURLOPT_HTTPHEADER] : [],
            array(
                'Accept: application/json',
                'X-Eflow-API-Key: ' . config('everflow.api_key'),
            )
        );

        // If any $data is set, add fields
        if (!empty($data)) {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Apply request headers
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

        // Executes request
        $response = curl_exec($handle);

        // Handles cURL request errors
        if (curl_error($handle)) {
            throw new \Exception('Error connecting to Everflow API: ' . curl_error($handle));
        }

        // Parses response JSON
        $response = json_decode($response);

        // Handles Everflow errors
        if (isset($response->Error)) {
            throw new \Exception('Error from Everflow API: ' . $response->Error);
        }
        
        // Done
        return $response;
    }

    public static function get($url, $options = [])
    {
        return static::request('GET', $url, [], $options);
    }

    public static function post($url, $data = [], $options = [])
    {
        return static::request('POST', $url, $data, $options);
    }

    public static function put($url, $data = [], $options = [])
    {
        return static::request('PUT', $url, $data, $options);
    }

    public static function delete($url, $data = [], $options = [])
    {
        return static::request('DELETE', $url, $data, $options);
    }

    public static function patch($url, $data = [], $options = [])
    {
        return static::request('PATCH', $url, $data, $options);
    }
}