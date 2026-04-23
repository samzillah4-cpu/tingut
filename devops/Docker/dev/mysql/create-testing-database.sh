#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS testing;
    GRANT ALL PRIVILEGES ON \`testing%\`.* TO '$MYSQL_USER'@'%';

    CREATE DATABASE IF NOT EXISTS test_db;
    GRANT ALL PRIVILEGES ON \`test_db%\`.* TO '$MYSQL_USER'@'%';
EOSQL
