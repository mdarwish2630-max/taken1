<?php
/**
 * TakweenWeb Security Helper Functions
 * Provides sanitization utilities for theme template files
 */

if (!function_exists('e')) {
    /**
     * Escape HTML output — shorthand for htmlspecialchars
     */
    function e($string, $flags = ENT_QUOTES, $encoding = 'UTF-8') {
        return htmlspecialchars((string)$string, $flags, $encoding);
    }
}

if (!function_exists('sanitizeHTML')) {
    /**
     * Sanitize rich HTML content from CMS editors (pages, services, etc.)
     * Allows safe HTML tags and attributes, strips dangerous ones.
     * This is NOT a full HTML Purifier — it strips script tags, event handlers,
     * javascript: URLs, and data: URIs while preserving safe HTML structure.
     *
     * @param string $html The HTML content to sanitize
     * @return string Sanitized HTML
     */
    function sanitizeHTML($html) {
        if (empty($html)) return '';

        $html = (string)$html;

        // 1. Remove <script> tags and their content
        $html = preg_replace('#<script[^>]*>.*?</script>#si', '', $html);
        // Also handle unclosed script tags
        $html = preg_replace('#<script[^>]*>#si', '', $html);

        // 2. Remove on* event handler attributes (onclick, onerror, onload, etc.)
        $html = preg_replace('#\s+on\w+\s*=\s*(["\'])(?:.*?)\1#si', '', $html);
        $html = preg_replace('#\s+on\w+\s*=\s*\S+#si', '', $html);

        // 3. Remove javascript: and data: URLs in href, src, action, formaction, xlink:href
        $html = preg_replace('#(href|src|action|formaction|xlink:href)\s*=\s*["\']?\s*javascript\s*:[^"\'>\s]*["\']?#si', '', $html);
        $html = preg_replace('#(href|src|action|formaction|xlink:href)\s*=\s*["\']?\s*data\s*:[^"\'>\s]*["\']?#si', '', $html);

        // 4. Remove <base> tags (can redirect all relative URLs)
        $html = preg_replace('#<base[^>]*>#si', '', $html);

        // 5. Remove <meta> tags with http-equiv (can redirect or set cookies)
        $html = preg_replace('#<meta[^>]*http-equiv[^>]*>#si', '', $html);

        // 6. Remove <link> tags (can load external stylesheets)
        $html = preg_replace('#<link[^>]*>#si', '', $html);

        // 7. Remove <style> blocks (can contain CSS injection attacks)
        $html = preg_replace('#<style[^>]*>.*?</style>#si', '', $html);
        $html = preg_replace('#<style[^>]*>#si', '', $html);

        // 8. Remove <iframe>, <embed>, <object>, <applet> tags (can load external content)
        $html = preg_replace('#<(iframe|embed|object|applet)[^>]*>.*?</\1>#si', '', $html);
        $html = preg_replace('#<(iframe|embed|object|applet)[^>]*>#si', '', $html);

        // 9. Remove <form> tags with external action
        $html = preg_replace('#<form[^>]*action\s*=\s*["\']?(?:https?://|//)[^"\'>\s]*["\']?[^>]*>.*?</form>#si', '', $html);

        // 10. Remove style attributes that contain expression(), url(javascript:), or url(data:)
        $html = preg_replace('#style\s*=\s*["\'][^"\']*expression\s*\([^"\']*\)[^"\']*["\']#si', '', $html);
        $html = preg_replace('#style\s*=\s*["\'][^"\']*url\s*\(\s*["\']?\s*javascript\s*:[^)]*\)[^"\']*["\']#si', '', $html);
        $html = preg_replace('#style\s*=\s*["\'][^"\']*url\s*\(\s*["\']?\s*data\s*:[^)]*\)[^"\']*["\']#si', '', $html);
        $html = preg_replace('#style\s*=\s*["\'][^"\']*behavior\s*:\s*url[^"\']*["\']#si', '', $html);

        // 11. Remove -moz-binding CSS property (Firefox XSS)
        $html = preg_replace('#-moz-binding\s*:\s*[^;"\'>]+#si', '', $html);

        // 12. Remove SVG-based XSS vectors
        $html = preg_replace('#<svg[^>]*on\w+\s*=\s*["\'][^"\']*["\'][^>]*>#si', '', $html);
        $html = preg_replace('#<svg[^>]*>.*?</svg>#si', '', $html);
        $html = preg_replace('#<svg[^>]*>#si', '', $html);

        // 13. Remove <noscript> tags (can be used for XSS in some browsers)
        $html = preg_replace('#<noscript[^>]*>.*?</noscript>#si', '', $html);

        // 14. Remove import in CSS
        $html = preg_replace('#@import\s+(?:url\s*\()?\s*["\']?\s*(?:https?://|//|javascript:|data:)#si', '', $html);

        return trim($html);
    }
}

if (!function_exists('sanitizeCSS')) {
    /**
     * Sanitize custom CSS from theme settings.
     * Removes dangerous CSS that could be used for exfiltration attacks.
     *
     * @param string $css The CSS to sanitize
     * @return string Sanitized CSS
     */
    function sanitizeCSS($css) {
        if (empty($css)) return '';

        $css = (string)$css;

        // Remove @import statements (can load external resources)
        $css = preg_replace('#@import\s+[^;]+;#si', '', $css);

        // Remove expression() (IE CSS XSS)
        $css = preg_replace('#expression\s*\([^)]*\)#si', '', $css);

        // Remove -moz-binding (Firefox XSS)
        $css = preg_replace('#-moz-binding\s*:\s*[^;]+;#si', '', $css);

        // Remove behavior: url() (IE XSS)
        $css = preg_replace('#behavior\s*:\s*url\s*\([^)]*\)\s*;?#si', '', $css);

        // Remove url() with javascript: or data: protocols
        $css = preg_replace('#url\s*\(\s*["\']?\s*javascript\s*:[^)]*\)#si', '', $css);
        $css = preg_replace('#url\s*\(\s*["\']?\s*data\s*:[^)]*\)#si', '', $css);

        return trim($css);
    }
}

if (!function_exists('validateHexColor')) {
    /**
     * Validate a hex color string.
     * Returns the color if valid, or a default fallback.
     *
     * @param string $color The color to validate
     * @param string $default Default color to return if invalid
     * @return string Valid hex color
     */
    function validateHexColor($color, $default = '#000000') {
        $color = trim((string)$color);
        if (preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $color)) {
            return $color;
        }
        return $default;
    }
}

if (!function_exists('safeJS')) {
    /**
     * Safely encode a PHP value for use in JavaScript context.
     * Uses json_encode + htmlspecialchars to prevent JS injection.
     *
     * @param mixed $value The value to encode
     * @return string Safe JavaScript string
     */
    function safeJS($value) {
        return htmlspecialchars(json_encode((string)$value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('safeFontUrl')) {
    /**
     * Validate a Google Fonts URL.
     * Only allows https://fonts.googleapis.com URLs.
     *
     * @param string $url The URL to validate
     * @return string Valid URL or empty string
     */
    function safeFontUrl($url) {
        $url = trim((string)$url);
        if (empty($url)) return '';
        // Only allow Google Fonts URLs
        if (preg_match('#^https://fonts\.googleapis\.com/css2\?.+#i', $url)) {
            return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        }
        return '';
    }
}
