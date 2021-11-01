ARG BASE_IMAGE
FROM $BASE_IMAGE

# Installing pnpm inside the web-container
RUN curl -f https://get.pnpm.io/v6.16.js | node - add --global pnpm &&\
    # making sure to have the latest pnpm version and updating if possible
    pnpm add -g pnpm &&\
    # enable pre/post hooks for pnpm's run-script lifecycle
    pnpm config set enable-pre-post-script true

