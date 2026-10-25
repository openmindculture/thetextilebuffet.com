# The Textile Buffet

[thetextilebuffet.com](https://thetextilebuffet.com/)

![Screenshot preview](public/The-Textile-Buffet-screenshot-preview.jpg)

Tech: WordPress, HTML, CSS

## Image Rotation on Home Page (Front Page)

Select which images to display in WP-Admin Appearance menu -> Image Rotation. Use drag and drop to reorder.

## Shortcodes

- `[ttb_save_the_date]` (requires The Events Calendar plugin, TEC)

## Full Site Editing, Development, Backup

After editing header, footer etc. in WP-Admin site editor, export the modifications as a modified child-theme zip and extract the relevant changes, usually the parts and templates folders, into the child template and commit to git.

Use a plugin like UpdraftPlus to backup and save the page content (database and uploads) and transfer between servers when needed.

## Recommended Plugins

- The Events Calendar (TEC)
- TinyPNG Image Optimization (tiny-compress-images)
- UpdraftPlus - Backup/Restore
- Yoast SEO (wordpress-seo)

TODO add screenshots

## building and testing

- `npm run test`
- `npm run build`
- open `dist/index.html` to preview the front page text
- use the preview server (TODO)
- deploy to production by pushing the main branch to GitHub

TODO refine and replace initial placeholder
- use Astro to eliminate redundancies
- prettify source and export minified
- refine style
- add optional image change
  - use library when it makes sense
  - use TypeScript and transpile to JS
- add more content
- and/or use WP or another CMS suitable for the maintainers
  - they could edit the front matter in GitHub directly
  - how to generate and optimize images?

## Material

- color preferences
- font (preferably free one from Google fonts, hosted locally, matching existing social media material)
- poster image(s) = also use as social media preview og:image, ld+json
- logo / favicon
- initial text
  - intro paragraph
  - title claim / subtitle
- social media links?
- imprint?

## Manual Image Optimization for Placeholder Page

- save JPEG for web between 70 - 80 quality
- save another jpeg-master at 95 quality
- derive webp and avif from the master
  - `cwebp -q 75 -m 6 -mt -sharp_yuv thetextilebuffet-background-01-master.jpg -o thetextilebuffet-background-01.webp`
  - `avifenc -q 65 thetextilebuffet-background-01-master.jpg -o thetextilebuffet-background-01.avif`
