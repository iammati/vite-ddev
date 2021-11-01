# vite-ddev

Run `git clone https://github.com/iammati/vite-ddev . && ddev start && ddev composer install && ddev frontend-dev` in an empty directory

## Requirements
- Working DDEV-Local instance

## Caveats

if you get an error related to the package.json you may need to ssh into your ddev web-container by using `ddev ssh` and run `cd app/frontend && pnpm install` so the required dependencies will be installed.
