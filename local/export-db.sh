#!/bin/sh
set -eu

dump_directory=/docker-entrypoint-initdb.d
dump_file="$dump_directory/gourmeta.sql"
temporary_dump=$(mktemp "$dump_directory/.gourmeta.XXXXXX")
trap 'rm -f -- "$temporary_dump"' EXIT

MYSQL_PWD=$(cat /run/secrets/db_password)
export MYSQL_PWD
mariadb-dump --user=gourmeta --lock-tables --quick --hex-blob \
    --default-character-set=utf8mb4 --skip-add-drop-table --skip-add-locks \
    gourmeta > "$temporary_dump"

grep -Eq '^CREATE TABLE .wp_posts.' "$temporary_dump"
grep -Eq '^CREATE TABLE .wp_options.' "$temporary_dump"
tail -n 8 "$temporary_dump" | grep -q '^-- Dump completed'

if [ -f "$dump_file" ]; then
    chown --reference="$dump_file" "$temporary_dump"
    chmod --reference="$dump_file" "$temporary_dump"
fi
mv -f -- "$temporary_dump" "$dump_file"
printf '%s\n' 'Updated local/database/gourmeta.sql'
