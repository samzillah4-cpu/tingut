FROM node:24-alpine AS dev

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USERNAME=kainga
ARG USER_HOME=/home/${USERNAME}

WORKDIR /var/www/html

COPY ./start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

#Allow user to fail fast and safe
RUN set -ex && \ 
    # We use the passwd database so as to query the username, UID, primary GID, home directory, shell
    if getent passwd ${USER_ID}; then \    
        EXISTING_USER_NAME=$(getent passwd ${USER_ID} | cut -d: -f1); \
        deluser ${EXISTING_USER_NAME}; \
    fi && \
    # We use the group database so as to query the group name, GID, member list
    if getent group ${GROUP_ID}; then \
        EXISTING_GROUP_NAME=$(getent group ${GROUP_ID} | cut -d: -f1); \
        delgroup ${EXISTING_GROUP_NAME}; \
    fi && \
    \
    addgroup -S -g ${GROUP_ID} ${USERNAME} && \
    adduser -S -D -u ${USER_ID} -G ${USERNAME} -h ${USER_HOME} ${USERNAME} && \
    \
    mkdir -p ${USER_HOME} && \
    chown -R ${USER_ID}:${GROUP_ID} ${USER_HOME}

USER ${USERNAME}

# We do docker for "dummies" XD to keep the container running tailing dev null
ENTRYPOINT ["/usr/local/bin/start-container"]