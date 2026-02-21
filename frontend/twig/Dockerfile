FROM node:20-alpine AS builder

WORKDIR /app

COPY package.json package-lock.json* ./

RUN npm ci

COPY assets ./assets
COPY templates ./templates
COPY webpack.config.js ./
COPY .eslintrc.js ./

RUN npm run build

FROM node:20-alpine AS runtime

RUN apk add --no-cache \
        dumb-init \
        curl

WORKDIR /app

COPY --from=builder /app/public ./public

USER node

EXPOSE 3000

CMD ["dumb-init", "npx", "http-server", "public", "-p", "3000"]
