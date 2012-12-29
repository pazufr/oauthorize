Oauthorize Facebook Twitter is a MOD for Phpbb 3.0.x forums 

It enables the automatic link between a forum account and Facebook and/or Twitter accounts, then the authentication and the registration through these social networks.

Usage Sample
------------

[Animint forum](https://www.animint.com/outils/forum/)

Installation
------------  

Installation is set at intermediate level because there are manual tasks to be done at the end of the normal installation process, especially 
- the registration of your site as an application on Facebook and Twitter.
- the creation of 2 custom profile fields via your Administration Control Panel
       
I assume, that if you know how to register a Faceboook and a Twitter application to get your application credentials, you will manage to create custom profile fields and edit the 2 files at the end of the installation to enter the keys. An integration within Administration Control Panel to avoid the edit of last 2 files, may be implemented in the future but it works as it today ;)

Notes
----

MOD code tested under 
- MySQL 5.5.24
- PostgreSQL 9.2
- PHP 5.3.12
- Phpbb 3.0.11 

Automatic installation tested with Automod 1.0.2 under MySQL.

This mod is derived from [OAuthorize phpBB](https://github.com/PaoloUmali/OAuthorize-phpBB) by Paolo Umali.