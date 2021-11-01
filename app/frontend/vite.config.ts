import { defineConfig, UserConfig } from 'vite'
import eslintPlugin from 'vite-plugin-eslint'
import { resolve } from 'path'
import WindiCSS from 'vite-plugin-windicss'

const production = process.env.NODE_ENV === 'production'

const configuration: UserConfig = {
    base: '/dist/',

    plugins: [
        eslintPlugin(),
        WindiCSS()
    ],

    build: {
        bundle: production,
        minify: production,
        outDir: resolve(__dirname, '../../public/dist'),

        target: 'esnext',

        emptyOutDir: true,
        manifest: true,
        sourcemap: true,

        watch: {
            include: './src/**'
        },

        rollupOptions: {
            input: ['./src/TypeScript/app.ts'],
        }
    },

    // HMR server-port which is exposed by DDEV-Local in .ddev/docker-compose.hmr.yaml
    server: {
        port: 3000,

        watch: {
            usePolling: true
        }
    }
}

export default defineConfig(configuration)
