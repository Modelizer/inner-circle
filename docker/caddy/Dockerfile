FROM abiosoft/caddy:no-stats

WORKDIR /code

ADD Caddyfile /etc

CMD ["--conf", "/etc/Caddyfile", "--log", "stdout", "--agree=true"]

EXPOSE 80
