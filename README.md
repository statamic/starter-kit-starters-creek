<!-- statamic:hide -->
<p align="center"><img src="https://statamic.com/assets/branding/Statamic-Logo-Rad.png" width="100" alt="Statamic Logo" /></p>
<h1 align="center">
  Statamic Starter Kit: Starter's Creek
</h1>

![Statamic 3.0+](https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge&link=https://statamic.com)
<!-- /statamic:hide -->

## Features
- Multi-author blog with author pages
- [Bard](https://statamic.dev/fieldtypes/bard) focused writing experience
- Code highlighting with [prism.js](https://prismjs.com/)
- Two personality modes: `casual` and `formal` to adapt to your personal style
- Customizable social links and icons
- Configurable static newsletter sign up form on blog pages
- Pre-configured, native search
- Automatic image resizing with Glide
- Beautifully responsive
- [Static Site Generator](https://github.com/statamic/ssg) ready
- Built with [TailwindCSS](https://tailwindcss.com)
- Itty bitty [Alpine.js](https://github.com/alpinejs/alpine) for interactions
- :100:/:100:/:100:/:100: Lighthouse score

<!-- statamic:hide -->
## Screenshots

| Casual  | Formal  |
|---|---|
| ![Casual Screenshot](https://github.com/statamic/starter-kit-starters-creek/raw/master/screenshot-casual.jpg)  |  ![Formal Screenshot](https://github.com/statamic/starter-kit-starters-creek/raw/master/screenshot-formal.jpg) |
<!-- /statamic:hide -->

## Quick Start

**1. Create a new site** with the [Statamic CLI](https://github.com/statamic/cli).

```
statamic new blog-site
```

**2. Enter the starter kit package name**

```
statamic/starter-kit-starters-creek
```

**3. Follow the prompt to create a new Super Admin user.**

**4. Recompile the CSS** (optional)

The [TailwindCSS](https://tailwindcss.com/) included in this kit is compiled with [PurgeCSS](https://purgecss.com/) to reduce filesize on any unused classes and selectors. If you want to modify anything, just start the watcher to recompile it on the fly.

```
npm i && npm run watch
```

To compile for production again:

```
npm run production
```

**5. Do your thing!**

If you're using [Laravel Valet](https://laravel.com/docs/valet) (or similar), your site should be available at `http://blog-site.test`. You can access the control panel at `http://blog-site.test/cp` and login with your new user. Open up the source code, follow along with the [Statamic docs](https://statamic.dev), and enjoy!

## Contributing

Contributions are always welcome, no matter how large or small. Before contributing, please read the [code of conduct](https://github.com/statamic/cms/wiki/Code-of-Conduct).
