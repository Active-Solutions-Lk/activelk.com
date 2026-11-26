<?php
/**
 * All content + timing lives here.
 * t   = video seconds [sectionStart, holdStart, holdEnd, sectionEnd]
 * vh  = scroll length in vh [arrive, hold, transition]  (long hold = video barely moves while people read)
 * side = which side the TEXT goes on (opposite of the product); tone = text colour (light|dark backdrop)
 * objX = object-position X % so the product stays visible on narrow screens
 */
return [
    'site' => [
        'title'       => 'Active Solutions | Value Added Distributor',
        'description' => 'Storage, networking and security solutions from the brands businesses trust.',
        'tail_vh'     => 40,   // empty scroll after the last hold
    ],
    'video' => [
        'desktop' => 'assets/video/scroll-1080.mp4',
        'mobile'  => 'assets/video/scroll-720.mp4',
        'poster'  => 'assets/video/poster.jpg',
    ],
    'hero' => [
        'badge'     => 'Value Added Distributor',
        'title'     => ['Active', 'Solutions'],
        'subtitle'  => ['Your ', 'Trusted', ' Technology Partner'],   // middle word is bold
        'tagline'   => 'Storage, networking and security solutions from the brands businesses trust.',
        'features'  => [['shield', 'Reliable', 'Solutions'], ['headset', 'Dedicated', 'Support'], ['bulb', 'Innovative', 'Technology']],
        'primary'   => ['Explore Solutions', 1],   // [label, section index to scroll to]
        'secondary' => 'Watch Overview',           // auto-scrolls through the whole experience
        'contact'   => 'Re-Seller Register',
    ],
    // goto = section index in the scroll experience; href is used otherwise.
    // About / Services / Projects point to #contact for now: change them to your real pages.
    'nav' => [
        ['label' => 'Home', 'href' => '/', 'goto' => 0, 'icon' => 'home'],
        ['label' => 'About', 'href' => '#contact'],
        ['label' => 'Services', 'href' => '#contact', 'children' => [
            ['label' => 'Consulting & design', 'href' => '#contact'],
            ['label' => 'Installation & integration', 'href' => '#contact'],
            ['label' => 'Support & maintenance', 'href' => '#contact']]],
        ['label' => 'Solutions', 'href' => '/solutions', 'goto' => 1, 'children' => [
            ['label' => 'Storage (Synology NAS)', 'goto' => 1],
            ['label' => 'Switching (BDCOM)', 'goto' => 2],
            ['label' => 'Routing (DrayTek)', 'goto' => 3],
            ['label' => 'SYNALYZE log analytics', 'goto' => 4]]],
        ['label' => 'Projects', 'href' => '/projects'],
        ['label' => 'Contact', 'href' => '/contact'],
    ],
    'sections' => [
        ['id' => 'intro', 'label' => 'Welcome', 'side' => 'left', 'tone' => 'dark', 'objX' => 50,
         't' => [0, 0, 1.0, 3], 'vh' => [0, 100, 200],
         'badge' => 'Value added distributor', 'title' => 'Active Solutions',
         'body' => 'Storage, networking and security solutions from the brands businesses trust.',
         'cta' => ['Explore solutions', '#contact']],
        ['id' => 'nas', 'label' => 'Storage', 'side' => 'left', 'tone' => 'light', 'objX' => 70,
         't' => [3, 5, 8.5, 8.8], 'vh' => [80, 200, 30],
         'badge' => 'Synology NAS', 'title' => 'Storage that never slows you down',
         'body' => 'Synology NAS for backup, file sharing and secure team collaboration.',
         'cta' => ['View NAS solutions', '#contact']],
        ['id' => 'switch', 'label' => 'Switching', 'side' => 'right', 'tone' => 'light', 'objX' => 30,
         't' => [8.8, 9.8, 14.4, 14.7], 'vh' => [60, 200, 30],
         'badge' => 'BDCOM', 'title' => 'Switching built for scale',
         'body' => 'Managed enterprise switches for reliable, high-density networks.',
         'cta' => ['View switches', '#contact']],
        ['id' => 'router', 'label' => 'Routing', 'side' => 'right', 'tone' => 'light', 'objX' => 30,
         't' => [14.7, 16, 21, 22], 'vh' => [70, 200, 50],
         'badge' => 'DrayTek', 'title' => 'Secure connectivity, everywhere',
         'body' => 'VPN-ready routers and firewalls for branches and growing teams.',
         'cta' => ['View routers', '#contact']],
        ['id' => 'software', 'label' => 'SYNALYZE', 'side' => 'left', 'tone' => 'light', 'objX' => 70,
         't' => [22, 24, 27.166, 27.166], 'vh' => [80, 200, 0],
         'badge' => 'SYNALYZE', 'title' => 'See every file event instantly',
         'body' => 'SYNALYZE turns NAS logs into real-time alerts and audit-ready reports.',
         'cta' => ['Book a demo', '#contact']],
    ],
];
