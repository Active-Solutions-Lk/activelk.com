# Active Solutions – scroll-scrubbed video hero (PHP)

Plain PHP 7.4+ (tested on 8.3), vanilla JS and CSS. No Composer, npm or build step.

## Run locally
    php -S localhost:8000
Open http://localhost:8000

## Deploy (Hostinger)
Upload everything into `public_html/` and keep the folder structure.

## Edit content and timing
`config.php`: all copy, which side the text goes on, video times (`t`) and scroll lengths (`vh`).
Styles: `assets/css/style.css`. Scroll logic: `assets/js/scroll-video.js`.

## Hero and header
`config.php` -> `hero` (badge, headline, tagline, feature icons, buttons) and `nav` (menu items; `goto` scrolls to a section, `href` links elsewhere).
"Watch Overview" auto-scrolls through the whole experience and stops as soon as the visitor scrolls.
Logo: `assets/img/logo.png` (white, transparent; turns black automatically on the white product scenes). Replace it with your official logo file.
Font: Montserrat from Google Fonts (see the <link> in index.php); self-host it if you prefer.

## Swap the video
Replace `assets/video/scroll-1080.mp4`, `scroll-720.mp4`, `poster.jpg`, then update `t` in config.php.
Keep the dense-keyframe export or scrubbing will stutter:

    ffmpeg -i in.mp4 -an -vf scale=1920:-2 -c:v libx264 -preset slow -tune fastdecode -crf 23 -g 2 -bf 0 -sc_threshold 0 -pix_fmt yuv420p -movflags +faststart assets/video/scroll-1080.mp4

The host must serve MP4 with HTTP range requests (the default on Apache/Hostinger).

## Smoothness notes
- The videos are encoded with `-tune fastdecode -g 2` (a keyframe every 2 frames, no B-frames, no audio). That roughly halves the time the browser needs per seek.
- Phones, data-saver mode and low-spec devices (<= 4 CPU cores or <= 4 GB RAM) automatically use the 720p file.
- No `backdrop-filter` blur is used over the video: live blur forces the GPU to re-blur on every video frame.
- If it is still not smooth on a specific device, lower the file resolution or switch to a frame-sequence canvas.
