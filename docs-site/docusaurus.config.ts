import {themes as prismThemes} from 'prism-react-renderer';
import type {Config} from '@docusaurus/types';
import type * as Preset from '@docusaurus/preset-classic';

const config: Config = {
  title: 'DreamPay API',
  tagline: 'High-integrity financial API for Santri Market Day',
  favicon: 'img/favicon.ico',

  // Konfigurasi Deployment GitHub Pages
  url: 'https://albnnaardy11.github.io',
  baseUrl: '/dreampay_api/', 
  organizationName: 'albnnaardy11',
  projectName: 'dreampay_api',
  deploymentBranch: 'gh-pages',
  trailingSlash: false,

  onBrokenLinks: 'warn',
  onBrokenMarkdownLinks: 'warn',

  i18n: {
    defaultLocale: 'en',
    locales: ['en'],
  },

  presets: [
    [
      'classic',
      {
        docs: {
          sidebarPath: './sidebars.ts',
          routeBasePath: 'docs', // Dokumentasi biasa ada di /docs
          docItemComponent: "@theme/ApiItem", // Komponen khusus OpenAPI
        },
        blog: false,
        theme: {
          customCss: './src/css/custom.css',
        },
      } satisfies Preset.Options,
    ],
  ],

  plugins: [
    [
      'docusaurus-plugin-openapi-docs',
      {
        id: "api",
        docsPluginId: "classic",
        config: {
          dreampay: {
            specPath: "../storage/api-docs/api-docs.json", // Jalur ke file JSON Laravel
            outputDir: "docs/api", // Tempat file markdown API akan di-generate
            sidebarOptions: {
              groupPathsBy: "tag",
              categoryLinkSource: "tag",
            },
          } satisfies any,
        } satisfies any,
      },
    ]
  ],

  themes: ["docusaurus-theme-openapi-docs"],

  themeConfig: {
    image: 'img/docusaurus-social-card.jpg',
    colorMode: {
      defaultMode: 'dark',
      respectPrefersColorScheme: true,
    },
    navbar: {
      title: 'DreamPay',
      logo: {
        alt: 'DreamPay Logo',
        src: 'img/logo.svg',
      },
      items: [
        {
          type: 'docSidebar',
          sidebarId: 'tutorialSidebar',
          position: 'left',
          label: 'Guide',
        },
        {
          to: '/docs/api',
          label: 'API Reference',
          position: 'left'
        },
        {
          href: 'https://github.com/albnnaardy11/dreampay_api',
          label: 'GitHub',
          position: 'right',
        },
      ],
    },
    footer: {
      style: 'dark',
      links: [
        {
          title: 'Docs',
          items: [
            { label: 'Introduction', to: '/docs/intro' },
            { label: 'API Reference', to: '/docs/api' },
          ],
        },
        {
          title: 'Community',
          items: [
            { label: 'GitHub', href: 'https://github.com/albnnaardy11/dreampay_api' },
          ],
        },
      ],
      copyright: `Copyright © ${new Date().getFullYear()} DreamPay. Built with Docusaurus.`,
    },
    prism: {
      theme: prismThemes.github,
      darkTheme: prismThemes.dracula,
      additionalLanguages: ['php', 'bash', 'json'],
    },
  } satisfies Preset.ThemeConfig,
};

export default config;