# Social Links Icons

[![Plugin Version](https://img.shields.io/badge/version-1.0-%231769f.svg)](https://fr.wordpress.org/plugins/social-links-icons/) 
[![WordPress Tested](https://img.shields.io/badge/wordpress-5.2.2%20tested-orange.svg)](https://fr.wordpress.org/plugins/social-links-icons/) 
![PHP Version](https://img.shields.io/badge/php-7.2-yellow.svg)

[Social Links Icons](https://fr.wordpress.org/plugins/social-links-icons/) est un plugin Wordpress qui permet de gérer simplement les liens vers les réseaux sociaux. 
Actuellement le plugin supporte plus de 25 réseaux sociaux comme par exemple Facebook, Twitch, Twitter, Github, LinkedIn ou encore Youtube.

Le plugin permet également des gérer les icônes (au format svg) et couleurs de chaque réseaux sociaux afin de personnaliser l'affichage sur le site.

##### Réseaux sociaux supportés par défaut :

Behance, Blogger, Discord, Dribbble, Facebook, Flickr, Github, Google Play, Instagram, LinkedIn, Medium, Pinterest, Reddit,
Skype, Slack, Snapchat, Soundcloud, Stackoverflow, Steam, Telegram, Tumblr, Twitch, Twitter, Vimeo, WhatsApp et Youtube.


## Shortcode

Le plugin contient pour le moment un seul shortcode qui permet d'afficher la liste des réseaux dont l'url est renseignée :

```php
// Depuis une page
[sli-list]

// Depuis un fichier php
do_shortcode('[sli-list]');
```

Par défaut, une liste des réseaux sociaux est affichée avec le nom de chaque réseau social. 
Cependant, il est possible d'afficher le svg à la place du nom à l'aide du paramètre `content="svg"` :
```php
[sli-list content="svg"]
```

De plus, le shortcode peut également prendre le paramètre `networks` qui permet de préciser la liste des réseaux sociaux à afficher. 
Le paramètre attendu est une liste des slugs séparés par une virgule :
```php
[sli-list networks="facebook, twitter, github"]
```



## Comment ajouter un réseau social ?

L'ajout d'un réseau social se fait en deux étapes :
- Création d'une classe qui hérite de `SLI_Social_Abstract` 
- puis d'appeler le filter `sn_networks` et ajouter le nom de la classe au tableau.

Voici un exemple :

```php
class MyDefaultNetwork extends SLI_Social_Abstract {
	
    /**
     * @var string
     */
	public $name = 'My default Network';

    /**
     * @var string
     */
	public $slug = 'my-default-network';

}

apply_filters('sn_networks', function($networks) {
	
	$networks[] = MyDefaultNetwork::class;

	return $networks;

});
```