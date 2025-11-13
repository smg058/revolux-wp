# Revolux Backend / Customizer File Structure

```bash
revolux/
├── inc/
│   ├── classes/
│   │   ├── Theme.php              ← Main theme class (existing)
│   │   ├── Backend.php            ← NEW: Customizer integration class
│   │   └── Autoloader.php         ← Class autoloader (existing)
│   │
│   ├── backend/                   ← NEW: Backend configuration directory
│   │   ├── customizer-config.php  ← Main config loader
│   │   └── modules/               ← Modular configuration files
│   │       ├── general.php        ← Preloader, performance, scripts
│   │       ├── header.php         ← Header layouts and settings
│   │       ├── footer.php         ← Footer layouts and settings
│   │       ├── layout.php         ← Container and layout options
│   │       ├── typography.php     ← Font settings
│   │       ├── colors.php         ← Color scheme
│   │       └── blog.php           ← Blog archive and single settings
│   │
│   ├── helpers/
│   │   ├── customizer-helpers.php ← NEW: Global helper functions
│   │   └── [other helpers]        ← Other helper files
│   │
│   ├── hooks/                     ← Action/filter hooks (to be created)
│   └── template-tags/             ← Template tag functions (to be created)
│
├── assets/
│   ├── images/
│   │   └── admin/                 ← TO CREATE: Admin preview images
│   │       ├── header-1.png       ← Header style previews (300x200px)
│   │       ├── header-2.png
│   │       ├── header-3.png
│   │       ├── footer-1.png       ← Footer style previews (300x200px)
│   │       ├── footer-2.png
│   │       ├── footer-3.png
│   │       ├── blog-list.png      ← Blog layout previews (300x200px)
│   │       ├── blog-grid.png
│   │       └── blog-masonry.png
│   │
│   ├── css/                       ← Compiled CSS from webpack
│   │   ├── main.css
│   │   └── vendor.css
│   │
│   └── js/                        ← Compiled JS from webpack
│       ├── main.js
│       ├── vendor.js
│       └── customizer.js          ← TO CREATE: Live preview JS
│
├── functions.php                  ← Theme bootstrap file
│                                    UPDATE: Add helper file require
│
└── style.css                      ← Theme stylesheet
                                    UPDATE: CSS variables from customizer
```

## Key Files Created

1. Backend.php
	- Main customizer integration class
	- Singleton pattern
	- Kirki registration
	- Configuration loading
	- Option retrieval methods
	
2. customizer-config.php
	- Main configuration loader
	- Dynamic module loading
	- Merges all module configs
	
3. Module Files
	- general.php
	- header.php
	- footer.php
	- layout.php
	- typography.php
	- colors.php
	- blog.php
	
4. customizer-helpers.php
	- 11 global helper functions
	- Filter integration
	- Type-safe implementations
	
5. Documentation
	- BACKEND-README.md
	- IMPLEMENTATION-CHECKLIST.md
	- Backend.md (this file)

---

## Integration Checklist

### Files Created
[ ] Backend.php class
[ ] customizer-config.php
[ ] All 7 module files
[ ] customizer-helpers.php
[ ] Complete documentation

### Next Steps
[ ] Update functions.php to require customizer-helpers.php
[ ] Update Theme.php to initialize Backend
[ ] Install/bundle Kirki plugin
[ ] Create admin preview images
[ ] Test in WordPress customizer
[ ] Create customizer.js for live preview
[ ] Add meta boxes for per-page overrides

---

## Usage Quick Reference

Get any option:
`revolux_get_option( 'option_name' )`

Check Toggle:
`revolux_is_option_enabled( 'preloader_enable' )`

Get Color:
`revolux_get_color( 'primary_color' )`

Get Typography:
`revolux_get_typography( 'body_typography' )`

Check Sidebar:
```php
if ( revolux_has_sidebar() ) {
	$position = revolux_get_sidebar_position();
}
```

Get Social Links:
`revolux_get_social_links( 'footer' )`

Get Copyright:
`revolux_get_copyright()`

---

## Module Organization

General Panel
├── Site Identity
├── Static Front Page
├── Preloader (toggle, type, colors, image)
├── Performance (emoji/embed disabling)
└── Custom Scripts (header/footer code)

Header Panel
├── Layout (style, transparent, colors, padding)
├── Top Bar (enable, phone, email, hours, social)
├── Sticky Header (enable, mobile, logo)
├── CTA Button (enable, text, URL, style)
└── Mobile Menu (breakpoint, style, logo)

Footer Panel
├── Layout (style, colors, padding)
├── Widgets (enable, columns)
├── Bottom Bar (enable, copyright, back-to-top)
└── Social Links (all major platforms + Yelp)

Layout Section
├── Container (width, type)
├── Content (padding)
├── Sidebar (width, gap)
└── Responsive (mobile sidebar position)

Typography Section
├── Enable Toggle
├── Body Font
└── Heading 1-6 Fonts

Color Scheme Section
├── Brand Colors (primary, secondary, accent)
├── Background (body)
├── Text Colors (body, heading, link, hover)
└── Border Color

Blog Panel
├── Archive (layout, columns, sidebar, meta options)
└── Single (sidebar, author box, tags, share, related)

---

## Customizer Field Types

Used in Revolux:
- toggle              On/off switch
- text                Text input
- textarea            Multi-line text
- select              Dropdown
- radio-buttonset     Radio as buttons
- radio-image         Radio with image previews
- color               Color picker
- image               Image uploader
- link                URL input
- slider              Number slider
- number              Number input
- dimensions          Top/right/bottom/left
- typography          Complete typography controls
- code                Code editor with syntax

Available, but not used yet:
- date, datetime, time
- repeater
- sortable
- multicheck
- switch
- generic
- custom

---

## PHP Version Requirements

Minimum: PHP 7.4+
Recommended: PHP 8.0+

Features Used:
- Type declarations (string, bool, int, array, void)
- Return type hints
- Null coalescing operator (??)
- Short array syntax []
- Namespaces

---

## WordPress Version Requirements

Minimum: WordPress 6.0+
Tested up to: WordPress 6.4+

Kirki Requirements:
- Kirki 4.0+ (plugin not bundled)
- Compatible with WordPress Customizer API

---

## Coding Standards

Following WordPress Coding Standards with exceptions:
✓ Short array syntax: [] instead of array()
✓ Snake_case for all PHP variables
✓ camelCase for JavaScript
✓ kebab-case for CSS/SCSS
✓ Type hints on all functions/methods
✓ DocBlocks on all functions/methods
✓ Namespace: Revolux\Classes
