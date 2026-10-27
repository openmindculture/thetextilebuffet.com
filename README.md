# The Textile Buffet

[thetextilebuffet.com](https://thetextilebuffet.com/)

Tech: WordPress, HTML, CSS

## Intro Image Rotation

Select in WP-Admin Appearance menu -> Image Rotation which images to display in the intro on the frontpage. Use drag and drop to reorder.

## Shortcodes

- `[ttb_save_the_date]` (requires The Events Calendar plugin, TEC)

## Full Site Editing, Development, Backup

After editing header, footer etc. in WP-Admin site editor, export the modifications as a modified child-theme zip and extract the relevant changes, usually the parts and templates folders, into the child template and commit to git. In the Site Editor (`/wp-admin/site-editor.php?canvas=edit`), click the three vertical dots at the top right. Select “Export” from that menu.

Use a plugin like UpdraftPlus to backup and save the page content (database and uploads) and transfer between servers when needed.

## Recommended Plugins

- MetaSlider Gallery (ml-slider-lightbox, shortcode: `ml_gallery`)
- Simple Page Ordering
- The Events Calendar (TEC)
- TinyPNG Image Optimization (tiny-compress-images)
- UpdraftPlus - Backup/Restore
- Yoast SEO (wordpress-seo)

## Table Talks

Use Quote blocks (not pullquote). The colors schemes will alter automatically. They can optionally be controlled by adding custom CSS class names. ... TODO

Put the quotes in a columns group of two columns that stack on mobile. 

## Customize Events

You can set a custom field `schedule_text` with a text like "Sat 21 + Sun 22 November 2026 (4 sessions)" to replace the default "November 21 @ 5:00 pm – November 22 @ 6:00 pm" which might look misleading.

