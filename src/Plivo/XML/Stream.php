<?php

namespace Plivo\XML;


/**
 * Class Stream
 * @package Plivo\XML
 */
class Stream extends Element
{
    protected $nestables = [];

    protected $valid_attributes = [
        'bidirectional',
        'audioTrack',
        'streamTimeout',
        'statusCallbackUrl',
        'statusCallbackMethod',
        'contentType',
        'extraHeaders'
    ];

    /**
     * Record constructor.
     * @param array $attributes
     */
    function __construct($body, $attributes = [])
    {
        if (array_key_exists("extraHeaders",$attributes)) {
            $attributes['extraHeaders'] = $this->processExtraHeaders($attributes['extraHeaders']);
        }
        parent::__construct($body, $attributes);
    }

    function processExtraHeaders($extraHeaders): string
    {
        $processedExtraHeaders = '';
        foreach ($extraHeaders as $key => $value) {
            {
                $processedExtraHeaders .= "'";
                if ($this->endsWith($key,'X-PH')) {
                    $processedExtraHeaders .= $key . "'";
                } else {
                    $processedExtraHeaders .= $key . "X-PH" . "'";
                }
                $processedExtraHeaders .= ":" . "'" . $value . "'" . ",";
            }
        }

        return rtrim($processedExtraHeaders, ",");
    }

    function endsWith($haystack, $needle): bool
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}