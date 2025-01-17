<?php

return [
    'logo' => env('APP_LOGO', 'stock-img/qwo_logo.png'),

    'internal_iframe_prefix' => env('INTERNAL_IFRAME_PREFIX', 'iframes'),

    'external_iframe_prefix' =>  env('EXTERNAL_IFRAME_PREFIX', 'extras'),

    'fake_passwd' => '123456',

    'splash_page' => env('SPLASH_PAGE', 'qwo'),

    'icon_picker_columns' => env('ICON_PICKER_COLUMNS', '4'),

    'icon_picker_rows' => env('ICON_PICKER_ROWS', '4'),

    'iframe_main_height' => env('IFRAME_MAIN_HEIGHT', '890px'),

    'iframe_extras_height' => env('IFRAME_EXTRAS_HEIGHT', '890px'),

    'db_sidebar_connection' => env('DB_SIDEBAR_CONNECTION', 'company'),

    'iframe_main_width' =>  env('IFRAME_MAIN_WIDTH', '100%'),

    'banking_date_from' => env('BANKING_DATE_FROM', null),

    'gitreports' => env('GIT_REPORTS', 'https://gitreports.com'),

    'default_background' => env('DEFAULT_BACKGROUND', 'storage/drawing-shadow.svg'),

    'business_name_one' => env('BIZ_NAME', 'Example Business, LLC'),

    'business_name_two' => env('DBA', 'Example Doing-Business-As'),

    'show_admin_sidebar' => env('SHOW_ADMIN_SIDEBAR', true),
];
