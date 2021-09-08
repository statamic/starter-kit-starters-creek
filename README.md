<!-- statamic:hide -->
<p align="center"><img src="https://statamic.com/assets/branding/Statamic-Logo-Rad.png" width="100" alt="Statamic Logo" /></p>
<h1 align="center">
  Statamic Starter Kit: Starter's Creek
</h1>

![Statamic 3.2+](https://img.shields.io/badge/Statamic-3.2+-FF269E?style=for-the-badge&link=https://statamic.com)
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

### Install as a New Site
You can spin up a new install of Statamic along with this Starter Kit all in one command by using the [Statamic CLI Tool](https://github.com/statamic/cli)

```
statamic new mysite statamic/starter-kit-starters-creek
```

Follow the prompts and you'll be up and running shortly.

### Install into an existing site
You can alternatively install Starter Kits into an existing Statamic 3.2+ site by running the following command while inside that install's root directory:

```
php please starter-kit:install statamic/starter-kit-starters-creek
```


### Customizing (optional)

The [TailwindCSS](https://tailwindcss.com/) included in this kit is compiled with [PurgeCSS](https://purgecss.com/) to reduce filesize on any unused classes and selectors. If you want to modify anything you'll need to recompile it.

```
npm i && npm run dev
```

To compile for production again:

```
npm run production
```

## Contributing

Contributions are always welcome, no matter how large or small. Before contributing, please read the [code of conduct](https://github.com/statamic/cms/wiki/Code-of-Conduct).
