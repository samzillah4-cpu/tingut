# VERSION defines the version for the docker containers.
# To build a specific set of containers with a version,
# you can use the VERSION as an arg of the docker build command (e.g make docker VERSION=0.0.2)
VERSION ?= v0.0.1

# REGISTRY defines the registry where we store our images.
# To push to a specific registry,
# you can use the REGISTRY as an arg of the docker build command (e.g make docker REGISTRY=my_registry.com/username)
# You may also change the default value if you are using a different registry as a default
# REGISTRY ?= registry.gitlab.com/laravel-in-kubernetes/laravel-app
REGISTRY ?= denniskainga/tingut
ENV_FILE ?= /var/www/tingut/.env
NETWORK ?= tingut-net

# Commands
docker: docker-build docker-push

docker-build:
	docker build . --target php_fpm -t ${REGISTRY}_php_fpm:${VERSION}

	docker build . --target nginx_server -t ${REGISTRY}_nginx:${VERSION}

docker-scan:
	@echo "Scanning PHP-FPM image..."
	trivy image --exit-code 0 --ignore-unfixed --severity CRITICAL,HIGH ${REGISTRY}_php_fpm:${VERSION}
	@echo "Scanning Nginx image..."
	trivy image --exit-code 0 --ignore-unfixed --severity CRITICAL,HIGH ${REGISTRY}_nginx:${VERSION}

docker-push:
	docker push ${REGISTRY}_php_fpm:${VERSION}
	docker push ${REGISTRY}_nginx:${VERSION}

# Run this inthe VPS
docker-pull-php_fpm:
	docker pull $(REGISTRY)_php_fpm:$(VERSION)

docker-pull-nginx:
	docker pull $(REGISTRY)_nginx:$(VERSION)

docker-network:
	docker network create $(NETWORK) || true

docker-prune-tingut:
	docker images "$(REGISTRY)*" --format "{{.Repository}}:{{.Tag}}" \
	| grep -v "$(VERSION)" \
	| xargs -r docker rmi -f

docker-run-php_fpm_garage:
	docker rm -f php_fpm_garage || true
	docker run -d \
		--name php_fpm_garage \
		--network $(NETWORK) \
		--restart unless-stopped \
		--env-file $(ENV_FILE) \
		$(REGISTRY)_php_fpm:$(VERSION)

docker-run-nginx_garage:
	docker rm -f nginx_garage || true
	docker run -d \
		--name nginx_garage \
		--network $(NETWORK) \
		--restart unless-stopped \
		-e FPM_HOST=php_fpm_garage:9000 \
		-p 8086:80 \
		$(REGISTRY)_nginx:$(VERSION)