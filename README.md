<h1 style="text-align: center;">savefavdotcom</h1> 

It's a simple website that you can store your bookmarks independent from your browser.

![savfavdotcom](https://github.com/devcastroitalo/savefavdotcom/blob/main/public/assets/images/homepage-example.png)
![savfavdotcom](https://github.com/devcastroitalo/savefavdotcom/blob/main/public/assets/images/savefavdotcom-example.png)

## Installing project
- Build docker images and setup containers:
    - Build docker images from **Dockerfile**:
        - `sudo docker build . -t savefavdotcom/stable:1.0`
    - Run docker compose to create app's container and database container:
        - `sudo docker up -d`
    - Enter in app's docker container to install dependencies:
        - Enter in docker container:
            - `sudo docker container exec -it [container_id] bash`
            - Install composer dependencies:
                - `composer update`
            - Install npm dependencies:
                - `npm install`
            - Setup Apache server:
                - `vim /etc/apache2/apache2.conf`
                - And edit file like this:
                    ```
                    <Directory /var/www/>
                        Options Indexes FollowSymLinks 
                        AllowOverride All
                        Require all granted
                    </Directory>
                    ```
                - Enable mod_rewrite:
                    - `a2enmod rewrite`
                    - `service apache2 restart`
            - Setup **php.ini** files:
                - In both **php.ini** files in `/etc/php/8.2/cli/` and `/etc/php/8.2/apache2/` edit this configurations:
                    - `vim /etc/php/8.2/(cli, apache2)/php.ini`
                    - Configuration to change:
                        - `error_reporting= E_ALL`
                        - `display_errors = On`
                        - `display_startup_errors = On`
                    - Restart apache server:
                        - `service apache2 restart`
- Create **.env** files. You need to create a **.env** file in root directory and in the `tests/` folder. The **.env** folder sould be based on the **.env_template** folder.
- Now you're good to run the app.

## TODO
- [ ] Send a new confirmation e-mail for updated email.
- [ ] Send an email confirmation to update password.
- [ ] Delete account.

