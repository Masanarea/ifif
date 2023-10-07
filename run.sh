#!/bin/bash
service php8.0-fpm start
/usr/sbin/nginx -g 'daemon off;' -c /etc/nginx/nginx.conf
echo "main start"

