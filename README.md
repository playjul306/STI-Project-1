# STI-Project1

> Auteurs : Sütcü Volkan & Benoit Julien  
> Date : 10.10.2019

## Introduction

Le but de ce projet était de créer un site web permettant d’échanger des messages à travers une base de donnée entre les utiisateurs et de gérer ces derniers. Nous étions mendaté par une entreprise qui n’avait malheureusement pas le budget pour s’occuper de l’aspect sécuritaire de l’application.

## Comment lancer l'application

Afin de lancer notre application il faut au préalable avoir docker qui soit installé sur la machine.

L’arborescence de fichier doit être comme sur l’image si dessous :

![arboressence.png](capture/arboressence.png)

Tout ce qui concerne le site dois se trouver dans `html` et tout ce qui concerne la base de donnée dans `databases`. 

Pour lancer le container docker avec le serveur nginx et PHP5, il faut se positionner dans le répértoire contenant le dossier `site` puis faire comme suit :

1. lancer la commande (le port 8080 peut être changer par un autre port si vous le voulez) :

   ```bash
   docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018
   ```

2. ensuite pour lancer les services nginx et PHP lancer les commandes suivantes :

   ```bash
   docker exec -u root sti_project service nginx start
   docker exec -u root sti_project service php5-fpm start
   ```

   

3. Ensuite sur la page d’administration de la base de donnée qui se trouve à l’adresse 

   - **Docker toolbox avec port 8080 :**	http://192.168.99.100:8080/phpliteadmin.php
   - **Docker Desktop avec port 8080 :**   http://localhost:8080/phpliteadmin.php

   il faut importer le dump sql qui se trouve dans `site/databases/database_2019-09-27.dump.sql` comme ci dessous (Le mot de passe pour phpliteadmin est "admin ».):

   ![phpliteadmin.png](capture/phpliteadmin.png)

   

Deux utilisateurs seront ainsi créé avec respectivement les login et mot de passe : 

- volkan / volkan2019 (administrateur)
- julien / julien2019 (collaborateur)

pour vous connecter à l’application :

- **Docker toolbox avec port 8080 :**	http://192.168.99.100:8080/ 
- **Docker Desktop avec port 8080 :**	http://localhost:8080/

Pour finir, il suffit de stopper le container docker.