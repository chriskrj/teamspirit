import fs from 'fs';
import { fileURLToPath, URL } from 'url';
import { defineConfig } from 'vite';
import { resolve } from 'path';
import svgLoader from 'vite-svg-loader';
import autoprefixer from 'autoprefixer';
import mkcert from'vite-plugin-mkcert';

const host = 'www.teamspirit-therapie.intern';
const port = 5173;


// plugin for full reload on html file change
const hotUpdateHtml = () => ({
  name: 'hot-update-html',
  handleHotUpdate({file, server}) {
    if (file.endsWith('.html')) {
      server.ws.send({
        type: 'full-reload',
        path: '*'
      });
    }
  }
});

const config= {
  server: {
    host,
    port: port,
    hmr: { host },
    origin: `https://${host}:${port}`,
    https: true,
  },
  base: '',
  publicDir: 'fake_dir_so_nothing_gets_copied',
  build: {
    manifest: true,
    outDir: 'Resources/Public/Frontend',
    rollupOptions: {
      input: {
        'main': resolve(__dirname, 'Resources/Private/Frontend/main.js'),
        'rte': resolve(__dirname, 'Resources/Private/Frontend/Scss/rte.scss')
      },
      output: {
        entryFileNames: 'assets/[name].js',
        chunkFileNames: 'assets/[name].js',
        assetFileNames: 'assets/[name].[ext]',
        // manualChunks: {
        //   vue: ['vue']
        // }
      }
    }
  },
  resolve: {
    alias: [
      { find: '@', replacement: fileURLToPath(new URL('Resources/Private/Frontend/', import.meta.url)) },
      { find: '@scss', replacement: fileURLToPath(new URL('Resources/Private/Frontend/Scss/', import.meta.url)) },
      { find: '@js', replacement: fileURLToPath(new URL('Resources/Private/Frontend/JavaScript/', import.meta.url)) },
      { find: '@webfonts', replacement: fileURLToPath(new URL('Resources/Private/Frontend/Webfonts/', import.meta.url)) },
      { find: '@images', replacement: fileURLToPath(new URL('Resources/Private/Frontend/Images/', import.meta.url)) },
      { find: '@svglibrary', replacement: fileURLToPath(new URL('Resources/Private/Frontend/SvgLibrary/', import.meta.url)) }
    ]
  },
  plugins: [
    // vue(),
    svgLoader(),
    mkcert(
      {
        autoUpgrade: true,
      }
    ),
    hotUpdateHtml()
  ],
  css: {
    devSourcemap: true,
    postcss: {
      plugins: [
        autoprefixer
      ],
    }
  }
};

export default defineConfig(config);
