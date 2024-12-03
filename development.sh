#!/bin/sh

docker rm -f wichtel-php-container && \
docker build -t wichtel-php-site . && \
docker run -d -p 8080:80 --name wichtel-php-container wichtel-php-site

echo "Open page via: http://localhost:8080/?key=key-wichtel"