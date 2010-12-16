# Naxasius installation

Howto install Naxasius with a playable interface.

> Note: It's still in development.

## Requirements

* PHP 4+
* MySQL
* A browser like Firefox <http://getfirefox.com/>

## Installation

Step 1: Download the source!
Download the source and copy the files into your webroot or any subdirectory of it.

Step 2: Create a database
Create a database and import the naxasius.sql found in /resources/sql/naxasius.sql. If you are updating an installed version checkout the correct sql in the /updates/ directory.

Step 3: Change the default CakePHP config
Open /app/config/core.php and change the following values:
* Security.salt
* Security.cipherSeed

Keep it open, and add (or change, in case it's already set) the following values:
* Configure::write('Routing.prefixes', array('admin', 'game'));

Now save and close the file.

Step 4: Config your database
Rename /app/config/database.php.default to /app/config/database.php and change the values of $default to your database settings.

(Optional) Step 5: Default game settings
I've added the default game settings in /app/config/boostrap.php witch you can edit if you like. If this is your first installation I recommend you to let it as it is.

Step 6: Create a user
Create a user through the default User Interface and edit this user in your database. Set the `role` to "admin". Now you can login and start making your game!