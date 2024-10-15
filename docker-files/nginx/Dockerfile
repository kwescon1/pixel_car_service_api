# Use the stable version of Nginx based on the Alpine Linux distribution
FROM nginx:stable-alpine

# Create the directory where your application files will reside
RUN mkdir -p /var/www/carservice

# Set the working directory inside the container to /var/www/carservice
WORKDIR /var/www/carservice

# Add the Nginx configuration file from local machine to the container
# This file should define how Nginx serves your application
ADD docker-files/nginx/conf.d/app.conf /etc/nginx/conf.d/app.conf

# Set environment variables for the custom Nginx user and group
# These variables can be used to customize the Nginx process ownership
ENV NGINXUSER=carservice
ENV NGINXGROUP=carservice

# Modify the main Nginx configuration file to replace the default user (www-data)
# custom user (carservice)
# This ensures Nginx runs under the 'carservice' user
RUN sed -i "s/user www-data;/user ${NGINXUSER};/g" /etc/nginx/nginx.conf

# Add a new user 'carservice' with the specified group, shell, and home directory
# The -D flag avoids creating a home directory, which is typical for service users
RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}

# Set the ownership of the /var/www/carservice directory to the custom Nginx user and group
# This ensures that the Nginx process can read and serve the files in this directory
RUN chown -R ${NGINXUSER}:${NGINXGROUP} /var/www/carservice
