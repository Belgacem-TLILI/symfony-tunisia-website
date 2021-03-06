Symfony tunisia community Website
==================================

Welcome to Symfony tunisia community  

This document contains information on how to download, install, and start using the website  Symfony tunisia community.

1) Installing the website Symfony tunisia community
----------------------------------------------------

If you don't have Composer yet, download it following the instructions on http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new Symfony application:

    php composer.phar install



2) Checking and configuring your website
----------------------------------------

Before starting coding, make sure that your local system is properly configured for Symfony and the Kunstmaan Bundles.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met, `1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path/to/app/web/config.php


3) Generating your website
--------------------------

Create the database and fill it using the fixtures

    app/console doctrine:schema:create
    app/console doctrine:fixtures:load


4) Browsing the WebSite administration pages
----------------------------------------

Congratulations! You're now ready to use the Kunstmaan Bundles CMS. Browse to:

    http://localhost/path/to/app/en/admin

Log in using admin/admin.

