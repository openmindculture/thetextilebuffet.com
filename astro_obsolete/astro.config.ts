import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';

// import type { PluginOption } from 'vite';

// https://astro.build/config
export default defineConfig({
  integrations: [sitemap()],
  vite: {
    resolve: {
      tsconfigPaths: true,
    },
    plugins: [],
    // Enable detailed error reporting
    // mode: 'development',
    // build: {
    //  minify: false,
    //  sourcemap: true
    // }
  },
  site: 'https://thetextilebuffet.com',
  base: '/',
  trailingSlash: 'always',
  // additional debug info:
  // devToolbar: {
  //  enabled: true
  // }
  redirects: {
  },
});
