<?php

if (!function_exists('get_media_url')) {
    /**
     * Resolves a UUID or legacy path to a full URL.
     * Supports the professional storage provider routes.
     */
    function get_media_url($value)
    {
        if (empty($value))
            return '';

        // Check if it looks like a UUID (e.g., xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx)
        if (preg_match('/^[a-f\d]{8}-(?:[a-f\d]{4}-){3}[a-f\d]{12}$/i', $value)) {
            return base_url('media/serve/' . $value);
        }

        // Otherwise assume it is a legacy public path
        return base_url(ltrim($value, '/'));
    }
}
