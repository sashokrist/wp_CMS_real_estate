# Real Estate Portal (Plugin + Theme)

A WordPress solution for showcasing real estate content:
- Custom post types for Properties, Renovation Services, and News
- Admin meta boxes for property details
- Front‑end shortcodes to render sections on any page
- Archive templates and a filterable Properties archive
- A “REP Dark” theme that styles the UI with a modern dark look

## Requirements

- WordPress >= 6.0
- PHP >= 8.0
- MySQL/MariaDB supported by your WordPress version
- A web server (Apache/Nginx) with pretty permalinks enabled (recommended)

## Repository Layout

The repo contains:
- A WordPress plugin: “Real Estate Portal”
- A WordPress theme: “REP Dark”

You can use the plugin with any theme, but the provided theme offers a polished, ready‑to‑use UI.

## Getting Started

### 1) Clone the repository

From your WordPress root folder (where wp-content lives)

cd wp-content
Clone into a folder (you can also clone elsewhere and copy the subfolders)

git clone [https://github.com/sashokrist/wp_CMS_real_estate.git](https://github.com/sashokrist/wp_CMS_real_estate.git)

After cloning, ensure you place the components like so:

Move/copy plugin folder to plugins

wp-content/plugins/real-estate-portal/

Move/copy theme folder to themes

wp-content/themes/rep-dark/

### 2) Activate the plugin
- Log in to your WordPress Admin → Plugins → activate “Real Estate Portal”.
- Go to Appearance → Themes → activate “REP Dark” (or keep your theme if you prefer).
- Optional (WP-CLI):
```bash
wp plugin activate real-estate-portal
wp theme activate rep-dark
```
## 3) # Activate theme

### 3) Permalinks

For best results, enable pretty permalinks:
- Settings → Permalinks → choose “Post name” → Save.

### 4) Create a Home Page (optional)

Create a page and add any of the shortcodes below to render sections. If you prefer a “static front page”:
- Settings → Reading → Set “Your homepage displays” to “A static page” and assign your page.

## What’s Included

### Custom Post Types

The plugin registers three post types:

- Properties (`property`)
    - Admin meta fields: Price, Address, Bedrooms, Bathrooms, Area
    - Front‑end archive with filters (type, location, price, beds, baths, search) and pagination
- Renovation Services (`renovation_service`)
- News (`news`)

Each post type supports titles, content, featured images, and appears in the admin menu.

### Meta Boxes (Properties)

When editing a Property, you’ll find a “Property Details” box with:
- Price (text)
- Address (text)
- Bedrooms (number)
- Bathrooms (number)
- Area (number)

These values are saved as post meta and can be displayed on single property pages and lists.

### Shortcodes

Add these to any page or post to render portal sections:

- Header/Hero
    - `[rep_header title="Your Title" subtitle="Optional subtitle"]`
- Latest News
    - `[rep_news limit="6"]`
- Latest Properties
    - `[rep_properties limit="6"]`
- Renovation Services
    - `[rep_services limit="6"]`

Notes:
- All shortcodes enqueue the plugin’s CSS/JS automatically.
- `limit` is optional; defaults to 6.

### Archive Templates and Filters

- Properties archive shows:
    - A filter form (keywords, type, location, min/max price, min beds/baths)
    - A responsive card grid
    - Pagination
- Renovation Services and News display as lists/cards with excerpts and “Read more” toggles where applicable.
- Single templates are provided for each post type if your active theme doesn’t supply them.

### Styling and Scripts

- CSS provides a clean layout for:
    - Hero sections, content sections, cards, lists, filters, pagination, and buttons
- JS (jQuery) enhances UX:
    - “Read more”/“Read less” toggling for longer excerpts

### Translations

The plugin loads its text domain from the `languages` directory. You can add `.mo/.po` files there to localize UI strings.

## Typical Usage

1) Add content in WP Admin:
- Properties: add details + featured image
- Renovation Services: add service items
- News: add posts

2) Build a landing/home page:
- Add `[rep_header]`, `[rep_properties]`, `[rep_services]`, and `[rep_news]` in the desired order

3) Visit archives:
- Properties archive will show filters and cards (e.g., `/property/` if your permalinks are set)
- News archive lists recent news
- Services archive lists renovation services

## Development Notes

- PHP 8.0 is the target runtime.
- CSS and JS are lightweight; no build step is required.
- The plugin registers but doesn’t forcibly enqueue assets on all pages; shortcodes enqueue as needed. The theme applies its styling globally.
- You can further customize archive query logic (filters) via hooks if required.

## Troubleshooting

- Filters yield no results:
    - Ensure there is published content matching the filters.
    - Confirm permalinks are set and flushed (Resave permalinks in Settings → Permalinks).
- Assets don’t load:
    - Confirm the plugin is active and your theme calls `wp_head()`/`wp_footer()`.
- Missing templates:
    - The plugin falls back to its internal templates if the theme does not provide custom ones.

## License

This project is provided as-is for educational/demo purposes. Review and set your preferred license in the repository if distributing.

## Credits

- WordPress platform and standard APIs for CPTs, meta boxes, shortcodes, templates, and i18n.

---
Happy building!
