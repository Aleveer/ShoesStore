<?php
/**
 * PHP URL Helper Functions
 * Tương tự như url_builder.js nhưng dành cho PHP
 */

/**
 * Generate a URL for page navigation
 * @param array $options - URL configuration options
 * @param string $options['module'] - The module name
 * @param string $options['view'] - The view name (for dashboard module)
 * @param string $options['action'] - The action name (for non-dashboard modules)
 * @param array $options['params'] - Additional query parameters
 * @return string - The formatted URL
 */
function generateUrl($options)
{
    $url = '?module=' . $options['module'];

    if ($options['module'] === 'dashboard' && isset($options['view'])) {
        $url .= '&view=' . $options['view'];
    } elseif (isset($options['action'])) {
        $url .= '&action=' . $options['action'];
    }

    if (isset($options['params']) && is_array($options['params'])) {
        foreach ($options['params'] as $key => $value) {
            if ($value !== null && $value !== '') {
                $url .= '&' . urlencode($key) . '=' . urlencode($value);
            }
        }
    }

    return $url;
}

/**
 * Generate full URL with base path
 * @param array $options - Same as generateUrl
 * @return string - Full URL with base path
 */
function generateFullUrl($options)
{
    $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
    return $baseUrl . generateUrl($options);
}
?>