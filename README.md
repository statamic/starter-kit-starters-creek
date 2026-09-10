<!-- statamic:hide -->
<p align="center"><img src="https://statamic.com/assets/branding/squircle/statamic-mark-lime.svg" width="100" alt="Statamic Logo" /></p>

<h1 align="center">Statamic Starter Kit: Starter’s Creek</h1>
<!-- /statamic:hide -->

An independent-publication starter kit for Statamic. Two personalities, four ways to read.

## Features

- **Casual:** Londrina Solid, Poppins, paper tones, hand-drawn rules, tilted artwork, and a little editorial mischief.
- **Formal:** Inter Variable, straight rules, restrained accents, and quieter layouts.
- **Light and dark:** a sun-and-moon toggle, system preference by default, and a remembered reader choice.
- Featured homepage, chronological archive, topics, About, author profiles, search, and a custom 404.
- Bard articles with code highlighting, captioned images, pull quotes, tables, and related reading.
- Optional newsletter signup link and configurable social links.
- Tailwind CSS 4, Vite 8, Alpine 3, and responsive Glide images.

<!-- statamic:hide -->
## Screenshots

| Casual | Formal |
| --- | --- |
| ![Casual homepage](https://github.com/statamic/starter-kit-starters-creek/raw/master/screenshot-casual.png) | ![Formal homepage](https://github.com/statamic/starter-kit-starters-creek/raw/master/screenshot-formal.png) |

[Casual dark mode](https://github.com/statamic/starter-kit-starters-creek/raw/master/screenshot-casual-dark.png) · [Formal dark mode](https://github.com/statamic/starter-kit-starters-creek/raw/master/screenshot-formal-dark.png)
<!-- /statamic:hide -->

## Quick Start

Create a new Statamic site with the Statamic CLI:

```sh
statamic new creek-site statamic/starter-kit-starters-creek
cd creek-site
php please search:update --all
```

Follow the installer’s user-creation prompts. With Herd, open `http://creek-site.test` and `/cp` to edit the site. The included production assets let you start without running a development server.

This refresh targets Statamic 6 and PHP 8.3+. Multiple users require Statamic Pro; local trial mode is suitable for development. No user accounts or credentials are distributed with the kit. Assign article authors after creating your own users.

To edit the frontend, use Node 22.12+ (or another version supported by Vite 8):

```sh
npm ci
npm run dev
# Or generate production assets:
npm run build
```

## Writing and Customization

- **Globals → Settings:** site name and description, casual/formal personality, social links with a compact icon picker, and newsletter settings. The newsletter link appears only when Show Signup is enabled and a valid signup URL is supplied. Link to your provider’s signup page; the kit does not collect email addresses.
- **Globals → Personality Strings:** edit casual and formal headlines, section labels, footer copy, newsletter heading, and 404 messages in separate tabs. The active personality is still selected in Settings.
- **Collections → Pages → Home:** eyebrow and introduction. The newest published article leads the homepage.
- **Collections → Blog:** optional hero image, author, topics, and Bard content. Existing `/{slug}` article URLs are preserved.
- **Taxonomies → Topics:** titles and descriptions. `/topics/{slug}` lists published articles in that topic.
- **Navigation → Main:** links used in the header, mobile menu, and footer.
- **Users:** optional public handle, biography, avatar, and website. Enable Show on About page for contributors. A public handle gives the user an `/authors/{handle}` profile.

The default pages use the Pages blueprint; Home has its own blueprint. Select the Pages blueprint for additional content pages and use the `default` template for a simple Markdown page.

Personality is a publication-wide editorial setting. The light switch is a reader preference, stored separately as `starters-creek-theme`. It follows the operating system until the reader chooses a theme. Without JavaScript, articles and navigation remain available and the color scheme follows the system.

The kit supplies escaped BlogPosting JSON-LD on article pages. If SEO Pro is installed, its metadata replaces the fallback title, description, and canonical tags; the article schema remains available alongside its site schema.

## Search and static output

Search uses the `blog` local index and searches article titles, introductions, and Bard content. Run `php please search:update --all` after installation or bulk file imports. Drafts and future-dated articles are excluded from public results.

Static output is optional:

```sh
composer require statamic/ssg
# Set APP_URL to the intended site URL before generating.
php please ssg:generate
```

Output goes to `storage/app/static`. Article, page, topic, author, and 404 templates can be generated, along with Glide images and compiled assets. Custom author URLs are registered automatically when SSG is installed.

**Search requires PHP.** `/search` is excluded from static generation. Route that endpoint to the Statamic application, or replace/remove search links and forms before deploying to a purely static host. Configure the host to serve `404.html` with a 404 status. Newsletter links work without a backend in the kit.


## Contributing

Contributions are always welcome, no matter how large or small. Before contributing, please read the [code of conduct](https://github.com/statamic/cms/wiki/Code-of-Conduct).
