<?php

/*
|--------------------------------------------------------------------------
| Peppermint Africa: page content (Phase 3)
|--------------------------------------------------------------------------
| All copy below comes from the Peppermint corporate profile. In Phase 6 this
| moves into the admin panel (database); the page templates will not change.
*/

return [

    'services' => [
        [
            'slug' => 'public-relations',
            'includes' => ['Media relations', 'Press conferences', 'Reputation management', 'Executive profiling', 'Crisis communication', 'Strategic media engagement'],
            'title' => 'Public Relations & Media Management',
            'description' => 'Media relations, press conferences, reputation management, executive profiling, crisis communication and strategic media engagement.',
        ],
        [
            'slug' => 'events',
            'includes' => ['Conferences and summits', 'Product and brand launches', 'Activations and roadshows', 'Corporate events', 'Immersive brand experiences'],
            'title' => 'Event Management & Experiential Marketing',
            'description' => 'Conferences, launches, summits, activations, roadshows, corporate events and immersive brand experiences, planned and delivered end to end.',
        ],
        [
            'slug' => 'brand-strategy',
            'includes' => ['Brand positioning', 'Messaging frameworks', 'Visual identity development', 'Campaign concepts', 'Storytelling systems'],
            'title' => 'Brand Strategy & Corporate Identity',
            'description' => 'Brand positioning, messaging frameworks, visual identity development, campaign concepts and storytelling systems.',
        ],
        [
            'slug' => 'project-management',
            'includes' => ['Planning and budgeting', 'Stakeholder management', 'Logistics', 'Reporting', 'Execution oversight'],
            'title' => 'Project Management',
            'description' => 'End-to-end coordination covering planning, budgeting, stakeholder management, logistics, reporting and execution oversight.',
        ],
        [
            'slug' => 'digital-content',
            'includes' => ['Social media strategy', 'Content production', 'Digital campaigns', 'Influencer engagement', 'Photography and video production', 'Performance marketing'],
            'title' => 'Digital Marketing & Content Creation',
            'description' => 'Social media strategy, content production, digital campaigns, influencer engagement, photography, video and performance marketing.',
        ],
        [
            'slug' => 'strategic-communications',
            'includes' => ['Communication strategy development', 'Audience analysis and stakeholder mapping', 'Visibility and perception strategy', 'Positioning in competitive markets'],
            'title' => 'Strategic Communications',
            'description' => 'Communication strategies designed to strengthen visibility, shape perception and position brands effectively in competitive markets.',
        ],
    ],

    'process' => [
        ['title' => 'Discover', 'description' => 'Deep market research, audience analysis, stakeholder mapping and strategic assessments.'],
        ['title' => 'Design', 'description' => 'Communication strategies, campaign concepts, messaging systems and execution roadmaps.'],
        ['title' => 'Deliver', 'description' => 'Campaigns executed with precision through integrated channels and operational excellence.'],
        ['title' => 'Measure', 'description' => 'Performance tracked through data-driven reporting, analytics and measurable KPIs.'],
        ['title' => 'Evolve', 'description' => 'Continuous optimisation to improve engagement, visibility and long-term impact.'],
    ],

    'why' => [
        ['title' => 'Strategic Thinking', 'text' => 'We combine creativity with business intelligence to create communication solutions that deliver measurable value.'],
        ['title' => 'African Insight, Global Standards', 'text' => 'Headquartered in Nairobi, we understand African markets while delivering work aligned with international standards.'],
        ['title' => 'End-to-End Execution', 'text' => 'From strategy development to implementation and reporting, we manage every stage with precision and professionalism.'],
        ['title' => 'Creative Excellence', 'text' => 'Compelling narratives and memorable experiences that connect brands with audiences.'],
        ['title' => 'Reliable Partnership', 'text' => 'Long-term relationships built on trust, responsiveness and results.'],
    ],

    'industries' => [
        'Corporate & Private Sector',
        'Government & Public Institutions',
        'NGOs & Development Organisations',
        'Real Estate & Infrastructure',
        'FMCG & Consumer Brands',
        'Hospitality & Tourism',
        'Technology & Innovation',
        'Healthcare & Social Impact',
        'Education & Youth Programmes',
        'Financial Services',
    ],

    /*
     | STARTER portfolio used by the ContentSeeder (database/seeders/ContentSeeder.php).
     | 'image' and 'gallery' point to PLACEHOLDER artwork in database/seeders/media/. Replace them with
     | real photos in the admin panel (Projects > Edit). After the first seed, edit content in /admin, not here.
     | 'public' => false keeps a project off the website (see Wiper Party below).
     */
    'projects' => [
        [
            'title' => '1st National Mango Conference, Kenya',
            'client' => 'USAID · Government of Makueni County · Agriculture Food Authority',
            'category' => 'Event Management',
            'summary' => 'End-to-end event management for Kenya’s first national conference dedicated to the mango value chain.',
            'image' => 'mango-cover.webp',
            'gallery' => ['mango-1.webp', 'mango-2.webp', 'mango-3.webp'],
            'featured' => true,
            'public' => true,
        ],
        [
            'title' => 'FLOCCA Project: Documentary & Publications',
            'client' => 'FLOCCA, funded by the World Bank',
            'category' => 'Content & Publications',
            'summary' => 'A documentary and printed publications telling the story of a World Bank-funded programme.',
            'image' => 'flocca-cover.webp',
            'gallery' => ['flocca-1.webp', 'flocca-2.webp', 'flocca-3.webp'],
            'featured' => true,
            'public' => true,
        ],
        [
            'title' => '7th Annual Devolution Conference',
            'client' => 'Devolution Conference, Kenya',
            'category' => 'Video & Documentary',
            'summary' => 'Documentary clips capturing the people, moments and messages of the 7th Annual Devolution Conference.',
            'image' => 'devolution-cover.webp',
            'gallery' => ['devolution-1.webp', 'devolution-2.webp', 'devolution-3.webp'],
            'featured' => true,
            'public' => true,
        ],
        [
            'title' => 'Commercial Radio Station Setup',
            'client' => 'ENE FM',
            'category' => 'Project Management',
            'summary' => 'End-to-end project management for the setup of a commercial radio station.',
            'image' => 'enefm-cover.webp',
            'gallery' => ['enefm-1.webp', 'enefm-2.webp', 'enefm-3.webp'],
            'featured' => true,
            'public' => true,
        ],
        [
            'title' => 'Digital Communications & Marketing',
            'client' => 'The Tunnel & Uptown Lavington',
            'category' => 'Digital Marketing',
            'summary' => 'Digital communications and marketing for two Nairobi restaurant brands.',
            'image' => 'digital-cover.webp',
            'gallery' => ['digital-1.webp', 'digital-2.webp', 'digital-3.webp'],
            'featured' => false,
            'public' => true,
        ],
        [
            'title' => 'Campaign Materials Branding',
            'client' => 'Wiper Party',
            'category' => 'Brand Strategy',
            'summary' => 'Branding of campaign materials.',
            'image' => null,
            'featured' => false,
            // Hidden until you confirm you want political work shown publicly.
            'public' => false,
        ],
    ],

    /*
     | Names shown in the "organisations we've worked with" strip.
     | Replace with logos once you have them (Phase 6 admin: Clients).
     */
    'clients' => [
        'USAID',
        'Government of Makueni County',
        'Agriculture Food Authority',
        'World Bank',
        'FLOCCA',
        'ENE FM',
        'The Tunnel',
        'Uptown Lavington',
        'Devolution Conference',
    ],

    /*
     | Testimonials. Intentionally EMPTY: the section stays hidden until you add real ones.
     | Format: ['quote' => '...', 'name' => '...', 'role' => '...', 'company' => '...']
     */
    'testimonials' => [],

    'mission' => 'To help organisations communicate with purpose, strengthen brand reputation, engage audiences meaningfully, and deliver measurable business and social outcomes.',

    'values' => [
        ['title' => 'Excellence', 'text' => 'We deliver world-class creative and strategic solutions with precision and professionalism.'],
        ['title' => 'Integrity', 'text' => 'We build relationships grounded in honesty, accountability and transparency.'],
        ['title' => 'Innovation', 'text' => 'We embrace fresh ideas, emerging technologies and modern communication trends.'],
        ['title' => 'Collaboration', 'text' => 'We work as an extension of our clients’ teams to achieve shared goals.'],
        ['title' => 'Impact', 'text' => 'We focus on meaningful outcomes that create long-term value for brands and communities.'],
    ],

    /*
     | Real portfolio examples shown on the Industries page, matched by industry name.
     | Industries not listed here show a general invitation instead. Edit freely.
     */
    'industry_examples' => [
        'Government & Public Institutions' => ['1st National Mango Conference (Government of Makueni County)', '7th Annual Devolution Conference'],
        'NGOs & Development Organisations' => ['1st National Mango Conference (USAID)', 'FLOCCA project (World Bank)'],
        'Hospitality & Tourism' => ['The Tunnel', 'Uptown Lavington'],
        'Corporate & Private Sector' => ['ENE FM commercial radio setup'],
    ],
];
