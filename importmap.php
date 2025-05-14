<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'reaction' => [
        'path' => './assets/reaction.js',
        'entrypoint' => true,
    ],
    'share' => [
        'path' => './assets/share.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.13',
    ],
    'tailwind' => [
        'version' => '4.0.0',
    ],
    'install' => [
        'version' => '0.13.0',
    ],
    'update' => [
        'version' => '0.7.4',
    ],
    'tom-select' => [
        'version' => '2.4.3',
    ],
    '@orchidjs/sifter' => [
        'version' => '1.1.0',
    ],
    '@orchidjs/unicode-variants' => [
        'version' => '1.1.2',
    ],
    'tom-select/dist/css/tom-select.default.min.css' => [
        'version' => '2.4.3',
        'type' => 'css',
    ],
    'tom-select/dist/css/tom-select.default.css' => [
        'version' => '2.4.3',
        'type' => 'css',
    ],
    'bootstrap' => [
        'version' => '5.3.6',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.6',
        'type' => 'css',
    ],
    'tom-select/dist/css/tom-select.bootstrap5.css' => [
        'version' => '2.4.3',
        'type' => 'css',
    ],
    'chart.js' => [
        'version' => '4.4.9',
    ],
    '@kurkle/color' => [
        'version' => '0.3.4',
    ],
    '@symfony/ux-chartjs' => [
        'version' => '2.24.0',
    ],
    'chartjs-plugin-zoom' => [
        'version' => '2.2.0',
    ],
    'hammerjs' => [
        'version' => '2.0.8',
    ],
    'chart.js/helpers' => [
        'version' => '4.4.9',
    ],
    'tailwindcss' => [
        'version' => '4.1.6',
    ],
    'tailwindcss/index.min.css' => [
        'version' => '4.1.6',
        'type' => 'css',
    ],
    '@symfony/ux-autocomplete' => [
        'version' => '2.24.0',
    ],
];
