<?php

/*
|--------------------------------------------------------------------------
| Peppermint Africa: site-wide settings
|--------------------------------------------------------------------------
| Edit contact details, navigation and social links here. Views read these
| values with config('site.xxx'), so nothing is hard-coded in templates.
*/

return [
    'name' => 'Peppermint Africa',
    'tagline' => 'Strategic Communications. Experiential Impact.',
    'description' => 'Peppermint Africa is a Nairobi-based strategic communications and integrated marketing agency helping brands, institutions and development partners build influence across global markets.',
    'established' => 2010,

    'phone' => '+254 700 346 490',
    'phone_href' => '+254700346490',
    // WhatsApp number: digits only, with country code, no "+"
    'whatsapp' => '254700346490',
    'whatsapp_message' => 'Hello Peppermint Africa, I would like to discuss a project.',
    'email' => 'hello@peppermintafrica.com',
    // Where website inquiries are delivered (set INQUIRY_TO_ADDRESS in .env to change)
    'inquiry_to' => env('INQUIRY_TO_ADDRESS', 'hello@peppermintafrica.com'),

    'address' => [
        'Mituntu Building',
        'Ring Road, Kileleshwa',
        'Nairobi, Kenya',
    ],

    // Your social profile links. While a URL is empty the icon links to that platform's home page.
    'social' => [
        'LinkedIn' => env('SOCIAL_LINKEDIN', ''),
        'Instagram' => env('SOCIAL_INSTAGRAM', ''),
        'Facebook' => env('SOCIAL_FACEBOOK', ''),
        'X' => env('SOCIAL_X', ''),
    ],

    // Main navigation (route names are defined in routes/web.php)
    'nav' => [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Services', 'route' => 'services'],
        ['label' => 'Work', 'route' => 'work'],
        ['label' => 'Gallery', 'route' => 'gallery'],
        ['label' => 'Blog', 'route' => 'blog'],
    ],

    'stats' => [
        ['value' => 50, 'suffix' => '+', 'label' => 'Successful campaigns & activations'],
        ['value' => 95, 'suffix' => '%', 'label' => 'Client retention rate'],
        ['value' => 100, 'suffix' => '+', 'label' => 'Media & influencer network partners'],
        ['value' => 15, 'suffix' => '+', 'label' => 'Years of industry experience'],
    ],
];
