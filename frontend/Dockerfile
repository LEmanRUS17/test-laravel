# Сборка Vue-приложения
FROM node:22-alpine AS build

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build-only

# Caddy отдаёт собранный фронт и проксирует /api в Laravel
FROM caddy:2-alpine

COPY Caddyfile /etc/caddy/Caddyfile
COPY --from=build /app/dist /srv
