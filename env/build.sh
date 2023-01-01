#!/usr/bin/env bash

#image='leandroqueiroz/nginx-php-fpm'
image=omsfinances.azurecr.io/nginx-php-fpm
version=7.4

echo Buildind $image:$version
sleep 2

docker build . -f Dockerfile -t $image:$version
docker push $image:$version
echo docker push $image:$version

echo Done
