#!/bin/sh
set -eu

owner=$(stat -c '%u:%g' local)

create_directory() {
    if [ ! -d "$1" ]; then
        mkdir -m "$2" "$1"
        chown "$owner" "$1"
    fi
}

create_directory local/database 755
create_directory local/secrets 700

for name in db-password db-root-password wp-salt; do
    secret="local/secrets/$name"
    if [ ! -e "$secret" ]; then
        value=$(php -r 'echo bin2hex(random_bytes(32));')
        (umask 022; set -C; printf '%s' "$value" > "$secret")
        chown "$owner" "$secret"
    fi
    if [ ! -s "$secret" ]; then
        printf 'Empty local credential file: %s\n' "$secret" >&2
        exit 1
    fi
done

config=gourmeta.ru/docs/wp-config.php
if [ ! -e "$config" ]; then
    cp local/wp-config.example.php "$config"
    chown "$owner" "$config"
fi

printf '%s\n' 'Local Docker configuration is ready.'
