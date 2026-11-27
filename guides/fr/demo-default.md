[English](../en/demo-default.md)

# Guide de démo Gally - Venia

> Script de démo. Pour les faits et chiffres de cette boutique, voir [`catalog-default.md`](catalog-default.md).

Ce guide déroule une démo Gally dans deux fenêtres : le back office et la boutique d'exemple. On
fait quelque chose dans le back office, on recharge la boutique, et on montre ce qui est apparu.

- **Public :** un marchand ou un product owner - quelqu'un qui utilisera le back office.
- **La question à laquelle il répond :** "qu'est-ce que je contrôle, et qu'est-ce que j'obtiens
  sans rien faire ?"
- **Il vous faut :** des notions de base de Gally (ce que sont un catalogue, une facette, un boost)
  et une pile locale avec les données d'exemple chargées.
- **Boutique utilisée :** Venia (`com_en`) : mode femme et bijoux, 85 produits, **en anglais** -
  les textes produits sont en anglais dans les deux langues, et la boutique française n'a pas
  d'historique de recherche. Ses chiffres et références sont dans [`catalog-default.md`](catalog-default.md).
- **Durée :** environ 30 minutes, ou 20 sans la partie 1.

Le guide a trois parties :

1. **Ce que Gally fait tout seul** - rien de configuré, boutique seulement.
2. **Action et réaction** - 12 actions dans le back office. Chacune s'ajoute aux précédentes.
   Rien n'est annulé avant la fin de la démo.
3. **Dans l'autre sens** - ce que la boutique renvoie au back office.

---

## Avant de commencer

1. Ouvrez la boutique : `https://demo.gally.dev/example/com_en`. La page d'accueil doit
   s'afficher.
2. Ouvrez le back office : `https://demo.gally.dev/fr`. Connectez-vous avec `admin@example.com` /
   `apassword`.
3. Placez les deux fenêtres côte à côte. Gardez la fenêtre de la boutique **plus large que 768
   pixels** : plus étroite, le popup de recherche passe en onglets (Produits, Blog, Suggestions) et
   ne montre que l'onglet Produits tant qu'on n'en clique pas un autre.
4. Vérifiez l'état de départ dans la boutique :
   - chercher `jumper` - **0 résultat**
   - chercher `office` - **0 résultat**
   - la rangée "Our selection" de la page d'accueil commence par Gold Omni Bangle Set
   - tapez `dress` et attendez : le premier produit du popup est Candace Dress

   Si l'un de ces points diffère, une démo précédente n'a pas été annulée. Passez d'abord par
   [Remise à zéro](#remise-à-zéro).

Bon à savoir :

- **Un changement se voit quand on recharge la page de la boutique.** Rien n'est mis en cache
  entre la boutique et Gally.
- **Trois choses demandent un rechargement complet (F5) :** les options de tri, le menu des
  catégories et la liste des boutiques. La boutique les lit une fois par onglet.
- **Ouvrez le back office en français**, avec `/fr` dans l'adresse : les libellés cités ici sont
  ceux de l'interface française. Quelques-uns restent en anglais à l'écran ; le guide les cite
  tels quels.
- **Faites les étapes dans l'ordre, et gardez chaque changement.** Chaque étape a été vérifiée
  avec toutes les précédentes en place. L'ordre compte : par exemple, l'étape 2.3 donne des
  résultats à toutes les recherches qui n'en avaient pas, donc les étapes "0 résultat" viennent
  avant. Annulez tout à la fin, avec [Remise à zéro](#remise-à-zéro).

## Deux façons de chercher

Ce guide emploie deux mots différents pour deux écrans différents. Ne les confondez pas.

| Le guide dit | Ce que vous faites | Ce que vous regardez |
|---|---|---|
| **Tapez** `mot` | Tapez le mot dans la barre de recherche, puis arrêtez-vous. **N'appuyez pas sur Entrée.** | La petite fenêtre qui s'ouvre sous la barre de recherche (le popup) : recherches suggérées, filtres, quelques produits. |
| **Cherchez** `mot` | Tapez le mot, puis **appuyez sur Entrée**. | La page de résultats : tous les produits trouvés, avec les filtres sur le côté. |

Les deux écrans ne montrent pas toujours les mêmes produits dans le même ordre. Un réglage du back
office peut changer l'un et pas l'autre.

## Vue d'ensemble

| Étape | Où | Action | Ce que voit le public |
|---|---|---|---|
| 1.1 | boutique | ouvrir trois catégories | des filtres différents dans chacune, sans réglage |
| 1.2 | boutique | cocher une matière | des compteurs qui restent complets |
| 1.3 | boutique | chercher avec des fautes | les bons produits malgré tout |
| 1.4 | boutique | chercher `lace` | les noms avant les descriptions |
| 1.5 | boutique | taper dans la barre de recherche | des suggestions qui suivent la requête |
| 1.6 | boutique | taper, puis chercher `dress` | produits et articles depuis une seule barre |
| 2.1 | back office | créer un synonyme | 0 résultat devient 8 |
| 2.2 | back office | créer une expansion | 0 résultat devient 19 pièces de bureau |
| 2.3 | back office | activer la recherche vectorielle sans résultat | des besoins décrits trouvent ceintures, boucles d'oreilles, pantalons |
| 2.4 | back office | créer un boost | les produits soldés prennent la tête |
| 2.5 | back office | étendre un boost à la barre de recherche | le popup suit la même règle |
| 2.6 | back office | épingler un produit | la page d'accueil change |
| 2.7 | back office | changer le tri par défaut d'une catégorie | la catégorie s'ouvre par prix |
| 2.8 | back office | forcer une facette et la déplacer | un filtre masqué apparaît en premier |
| 2.9 | back office | ajouter un attribut à l'autocomplétion | une nouvelle section dans la barre de recherche |
| 2.10 | back office | rendre une catégorie virtuelle | 1 produit devient 12 |
| 2.11 | back office | créer des produits associés pour une catégorie | chaque robe montre d'autres robes |
| 2.12 | back office | créer un cross-sell entre catégories | toute jupe suggère des ceintures |
| 3 | les deux | ouvrir Analyse | l'activité de la boutique dans le back office |

---

## Partie 1 - Ce que Gally fait tout seul

Aucune facette de cette boutique n'a été configurée. Dites-le d'abord : tout dans cette partie est
le comportement par défaut de Gally.

### 1.1 Des filtres qui suivent la catégorie

1. Ouvrez la catégorie de tête, [Default Category](https://demo.gally.dev/example/com_en/category/cat_2), et regardez les filtres du catalogue entier
   (85 produits) : Category, Price, Availability, Color, Material, et deux autres.
2. Ouvrez [Tops](https://demo.gally.dev/example/com_en/category/cat_8) (24 produits). S'ajoutent : Size et Style.
3. Ouvrez [Accessories > Jewelry](https://demo.gally.dev/example/com_en/category/cat_5) (14 produits). Ni Size ni Style : les bijoux n'en ont pas.
4. Ouvrez [Accessories > Belts](https://demo.gally.dev/example/com_en/category/cat_4) (4 produits). Size revient - chaque ceinture a une taille - mais
   pas Style.

**À souligner :** Gally n'affiche un filtre que si au moins 90 % des produits de la page ont cet
attribut. Il le recalcule pour chaque page, chaque recherche et chaque filtre.

### 1.2 Des compteurs qui restent complets

1. Ouvrez [Tops](https://demo.gally.dev/example/com_en/category/cat_8) (24 produits).
2. Dans **Material**, cochez **Cashmere**.

**Vous devez voir :**

- 4 produits : Rosalina, Sabina Hooded, Helena Cardigan, Echo Sweater.
- Le filtre Material liste toujours toutes les matières avec leur compteur complet : Cotton 15,
  Rayon 6, Acrylic 4, et les autres. Cochez-en une deuxième et les produits s'additionnent.
- Style ne compte plus que les hauts en cachemire : Long Sleeve 3, Open Front 3.

### 1.3 Fautes de frappe et mots qui se prononcent pareil

1. Cherchez `skrit` - 13 résultats, avec les mêmes trois premiers que `skirt` : Rowena, Johanna,
   Pomona Skirt.
2. Cherchez `earings` - 8 résultats, avec les mêmes trois premiers que `earrings`.
3. Cherchez `kardigan` - les 7 cardigans : Helena, Carina, Phoebe et les autres.

**À souligner :**

- Les étapes 1-2 relèvent de la tolérance aux fautes.
- L'étape 3 change la première lettre, ce que la tolérance aux fautes ne fait jamais. Elle marche
  parce que les mots se prononcent pareil (correspondance phonétique).
- Aucun message "vouliez-vous dire". L'acheteur obtient simplement des résultats.

### 1.4 Le nom compte plus que la description

1. Cherchez `lace` - 6 produits.

**Vous devez voir :**

- D'abord, les trois qui ont "Lace" dans leur nom : Liana Lace Shorts, Corina Lace-Back Sweater,
  Emilia Cropped Lace Top.
- En dernier, les trois qui ne parlent de dentelle que dans leur description : Anna Draped Top,
  Cora Open-Back Tank, Jillian Top.

**À souligner :** par défaut, le nom du produit pèse dix fois plus que les autres champs.

### 1.5 Des suggestions qui suivent la requête

1. Tapez `dress` et attendez, sans appuyer sur Entrée. Color montre Gold, Lilac, Peach ; Style montre Above Knee, Short
   Sleeve, Sleeveless.
2. Tapez `skirt` et attendez, sans appuyer sur Entrée. Color montre Gold, Rain, Lilac ; Style montre Full Length en tête.
3. Tapez `dre` et attendez, sans appuyer sur Entrée. Section des recherches populaires : "hot weather dress", "summer dress", "cocktail
   dress" et d'autres.

Dans une fenêtre étroite, les recherches suggérées sont sous l'onglet **Suggestions**.

**À souligner :**

- Le marchand a choisi les quatre attributs qui peuvent apparaître. Gally choisit leurs valeurs et
  leurs compteurs pour chaque requête.
- Les recherches suggérées viennent de ce que les acheteurs ont réellement cherché dans cette
  boutique.

### 1.6 Une barre de recherche, plusieurs types de contenu

1. Tapez `dress` et attendez, sans appuyer sur Entrée. Sous les catégories, le popup a une section
   **Blog** : les articles qui correspondent au mot, les mêmes qu'à l'étape 3. Si le popup montre
   des onglets, la fenêtre est trop étroite : cliquez **Blog**.
2. Appuyez sur Entrée. La page de résultats montre 18 produits.
3. Passez de **Produits** à **Articles**. 27 articles, menés par "The Cocktail Dress Code, Decoded" et "Finding Your Dress Size Online".

**À souligner :**

- Gally indexe plus que des produits. Il indexe aussi les catégories et le contenu CMS - dans
  cette boutique, les articles du blog, qui sont des pages CMS.
- Chaque type de contenu est un type à part dans Gally, avec ses propres champs, filtres et
  classement. Des blocs CMS, des pages magasin ou des entrées de FAQ peuvent être indexés de la
  même façon, comme un type de plus.
- Une seule barre de recherche les sert tous. La boutique décide comment montrer chacun.

---

## Partie 2 - Action et réaction

Chaque étape suit le même schéma :

1. **Avant** - montrer la boutique.
2. **Back office** - faire un changement.
3. **Après** - recharger la boutique et montrer ce qui est apparu.

N'annulez pas le changement : l'étape suivante s'appuie dessus.

Si l'enregistrement d'une catégorie affiche une erreur, cliquez à nouveau sur **Enregistrer**. Cela
marche la deuxième fois.

### 2.1 Créer un synonyme

1. **Avant :** cherchez `jumper` - **0 résultat**. Un acheteur britannique dit jumper, le
   catalogue emploie le mot américain, sweater. Les deux mots désignent le même vêtement.
2. **Back office :** allez dans **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : "Demo jumper", Actif : oui
   - Type de contexte : **Catalog localisé**, puis Catalogue(s) localisé(s) : COM English Catalog
   - Type de thésaurus : **Synonyme**
   - Synonymes : `jumper`, `sweater`
4. Cliquez **Créer**.
5. **Après :** cherchez `jumper` - **8 résultats** : Juno, Hanna, Echo, Roxana Cropped et Corina
   Lace-Back Sweater, puis trois cardigans dont la description dit sweater : Helena, Rosalina et
   Brigid Boucle.
6. Cherchez `sweater` - les mêmes 8, dans le même ordre.

**À souligner :**

- Pas de développeur, pas de réindexation. Cela s'applique à l'enregistrement.
- Un synonyme réunit des mots qui veulent dire exactement la même chose, dans la langue de la
  boutique : ici un mot britannique et un mot américain pour un même vêtement. Il marche dans
  tous les sens.
- Un cardigan n'est pas un jumper, donc `cardigan` reste hors de la liste. Un mot large qui doit
  ramener des mots plus précis (`knitwear` pour les sweaters et les cardigans) n'est pas non plus
  un synonyme. C'est une expansion - étape suivante.
- N'utilisez pas un thésaurus pour traduire (`robe` = `dress`). Chaque langue a son propre
  catalogue et son propre thésaurus.
- Le thésaurus compare les mots exacts, pas leurs variantes.

### 2.2 Créer une expansion

1. **Avant :** cherchez `office` - **0 résultat**.
2. **Back office :** **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : "Demo office", Actif : oui
   - Type de contexte : Catalog localisé, puis Catalogue(s) localisé(s) : COM English Catalog
   - Type de thésaurus : **Expansion**
   - Terme de référence : `office`
   - Termes étendus : `blouse`, `cardigan`, `pants`
4. Cliquez **Créer**.
5. **Après :** cherchez `office` - **19 résultats** : quatre blouses d'abord (Serena, Penelope
   Peasant, Isabella Sleeveless, Aurora Sleeveless), puis cardigans et pantalons, et Candace
   Dress en dernier.

**À souligner :** une expansion va dans un seul sens. `office` ramène les blouses ; `blouse`
renvoie toujours ses 4 produits. C'est ainsi qu'un marchand construit une occasion, ou fait
ramener à un mot large les mots plus précis.

### 2.3 Répondre aux recherches que personne n'a prévues

1. **Avant :** cherchez `a belt for my jeans` - **0 résultat**. Pareil pour `sparkly earrings` et
   `comfortable trousers for summer`.
2. **Back office :** allez dans **Paramètres > Configurations**, onglet **Recherche vectorielle**.
3. Dans **La configuration s'applique à:**, choisissez COM English Catalog.
4. Activez **Utiliser en cas d'absence de résultat**. Cliquez **Enregistrer**.
5. **Après :**
   - `a belt for my jeans` - Stretch Belt With Leather Clasp, puis deux ceintures en cuir tressé
   - `sparkly earrings` - Augusta, Gold Sol et Carmina Earrings
   - `comfortable trousers for summer` - Honora Wide Leg, Camilla Palazzo, Calista Linen Pants

**À souligner :** quand la recherche par mots ne trouve rien, Gally cherche par le sens. Le
thésaurus couvre les mots qu'on attend ; ceci couvre ceux auxquels on n'a pas pensé.

**Attention :**

- Utilisez ces phrases. `something to keep my neck warm` et `gift for my wife` donnent de
  mauvais premiers résultats.
- Le compteur affiche au plus 100 produits (la **Valeur K** du même formulaire), classés par
  proximité - pas un nombre de produits pertinents. Parlez de la première ligne, pas du nombre.
- À partir d'ici, aucune recherche n'affiche "0 résultat". Toutes les étapes qui partent de 0
  viennent avant celle-ci.

### 2.4 Créer un boost

1. **Avant :** cherchez `tank`. Valeria Two-Layer Tank, avec le badge "On Sale", est 8e. Cherchez
   `pants` : Honora Wide Leg Pants, soldé lui aussi, est 6e.
2. **Back office :** allez dans **Merchandising > Boosts**, cliquez **Créer boost**.
3. Remplissez :
   - Nom : "Demo sale", Actif : oui
   - Catalogue(s) localisé(s) : COM English Catalog
   - Type de requête : **Search result**, Tous les termes de recherches
   - Règle virtuelle : **Ajouter une condition > Condition attribut**, **Promotion** est égal
     **vrai**
   - Modèle : **Constante**, Valeur du boost (%) : 100
4. Cliquez **Créer**.
5. **Après :** cherchez `tank` - Valeria Two-Layer Tank est 1er.
6. Cherchez `pants` - Honora Wide Leg Pants est 1er.

**À souligner :**

- Le formulaire a un bloc **Preview** : choisissez le catalogue localisé et un terme de recherche,
  puis cliquez **Prévisualiser** pour vérifier la règle avant de l'enregistrer.
- Le boost multiplie le score, il ne le remplace pas : sur `top`, Roxana Cropped Sweater, soldé,
  ne passe que de la 11e à la 6e place, et une robe soldée qui ne correspond que par sa
  description ne bouge pas.
- Il s'applique à toutes les recherches. `jumper` s'ouvre maintenant sur Roxana Cropped Sweater,
  et `office` sur Honora Wide Leg Pants.
- Le popup de la barre de recherche n'est pas concerné. C'est un type de requête à part,
  **Autocomplete** - étape suivante.

### 2.5 Étendre un boost à la barre de recherche

Venia est livrée avec une règle, `Boost "Tank dress"` : sur les recherches qui contiennent
"dress", elle remonte les Tank dresses. Elle s'applique à la page de résultats, pas au popup de la
barre de recherche.

1. **Avant :** tapez `dress` et arrêtez-vous. Les produits du popup commencent par Candace Dress,
   puis Angelina Tank, Felicia Maxi, Veronica Maxi. Appuyez sur Entrée : la page de résultats
   montre Angelina, Valentina, Alexia Maxi, Karena Halter, Flora, Athena. Alexia et Karena sont
   soldées : le boost de l'étape 2.4 s'y ajoute à la règle Tank dress. Les deux listes diffèrent.
2. **Back office :** allez dans **Merchandising > Boosts**, ouvrez **`Boost "Tank dress"`**.
3. Dans **Type de requête**, ajoutez **Autocomplete**, avec la même limitation de recherche. Enregistrer.
4. **Après :** tapez `dress` à nouveau. Le popup commence maintenant par Angelina, Valentina,
   Flora, Athena Tank Dress et Paulina Draped Tank Dress : les Tank dresses passent en tête.

**À souligner :**

- Une règle, trois endroits où elle peut s'appliquer - les pages catégorie, la page de résultats
  et la barre de recherche. Le marchand choisit lesquels.
- La page de résultats diffère toujours : Alexia Maxi et Karena Halter y sont 3e et 4e. Le boost
  soldes de l'étape 2.4 ne vaut que pour Search result, donc le popup ne le reçoit pas.

### 2.6 Épingler un produit sur la page d'accueil

1. **Avant :** la rangée "Our selection" de la page d'accueil montre Gold Omni Bangle Set, Gold
   Cirque Earrings, Silver Cirque Earrings.
2. **Back office :** allez dans **Merchandising > Catégories**.
3. Dans **Choisir un catalogue**, prenez COM Catalog ; dans **Choisir une langue**, prenez
   la langue anglaise.
4. Sélectionnez la **catégorie de tête** de l'arbre, **Default Category**.
5. Vérifiez que **Tri par défaut** est **Position**. Sinon l'épinglage est refusé.
   L'épingle vaut pour toutes les langues de la boutique.
6. Dans la liste des produits, trouvez **Karena Halter Dress** (`VD03`).
7. Cliquez **Épingler** et placez-la en premier. Cliquez **Enregistrer**.
8. **Après :** rechargez la page d'accueil. La robe ouvre la rangée "Our selection", avec son badge
   "On Sale".

**À souligner :** la rangée de la page d'accueil, c'est tout le catalogue dans son ordre marchand.
Le marchand décide de ce qui accueille l'acheteur.

### 2.7 Changer le tri par défaut d'une catégorie

1. **Avant :** ouvrez [Accessories > Jewelry](https://demo.gally.dev/example/com_en/category/cat_5). Gold Omni Bangle Set (78) est premier.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Default Category > Accessories > Jewelry**.
3. Passez **Tri par défaut** à **Price**. Enregistrer.
4. **Après :** rechargez la boutique avec **F5**. Jewelry s'ouvre du moins cher au plus cher : Gold
   Sol Earrings et Silver Sol Earrings à 48, et Night Out Collection à 156 en dernier.

### 2.8 Forcer une facette et la mettre en premier

1. **Avant :** ouvrez [Accessories](https://demo.gally.dev/example/com_en/category/cat_3). Pas de filtre Brand : seuls 4 des 24 produits ont une
   marque - sous la règle des 90 % de l'étape 1.1.
2. **Back office :** allez dans **Recherche > Facettes**. Dans le panneau **Catégories** à gauche,
   sous **Par catégorie**, sélectionnez **Default Category > Accessories**.
3. Sur la ligne de l'attribut de marque - libellé **Marque** dans le back office :
   - Affichage : **Affiché**
   - Position : **1**

   Il n'y a pas de bouton Enregistrer : chaque changement est enregistré tout de suite.
4. **Après :** rechargez. "Brand" est le premier filtre : Luma 3, Venia 2. Ouvrez Jewelry - rien
   n'a changé.

**À souligner :** Gally le masquait par défaut. Le marchand est passé outre, pour cette catégorie
seulement.

### 2.9 Ajouter un attribut à la barre de recherche

1. **Avant :** tapez `necklace`. Des sections Color et Material - pas de marque.
2. **Back office :** allez dans **Paramètres**, onglet **Attributs**.
3. Sur l'attribut de marque (**Marque**), cochez **Affiché dans l'autocomplete**. La case est enregistrée
   tout de suite, sans bouton Enregistrer.
4. **Après :** tapez `necklace` - une nouvelle section Brand : Luma 2, Venia 1.
5. Tapez `dress` - pas de section Brand : aucune robe n'a de marque. Les sections suivent la
   requête.

**Attention :** les compteurs sont petits - seuls quelques accessoires ont une marque.

### 2.10 Rendre une catégorie virtuelle

1. **Avant :** ouvrez [New Products](https://demo.gally.dev/example/com_en/category/cat_7). 1 produit : Venia Stylist Consultation.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Default Category > New Products**.
3. Activez **Catégorie virtuelle**.
4. Règle : **Nouveauté** (l'attribut nouveauté) est égal **vrai**. Enregistrer - deux fois si le premier enregistrement affiche une
   erreur.
5. **Après :** rechargez. **12 produits**, tous avec le badge "New" : Night Out Collection, Luna
   Scarf, Angelina et Athena Tank Dress, Selena Pants, et d'autres.

**À souligner :**

- La catégorie se remplit maintenant à partir des données produit. Un produit marqué nouveau demain
  y apparaît de lui-même, et en sort quand la marque disparaît.
- La consultation n'y est plus : elle n'est pas marquée nouvelle.

**Attention :** le compteur à côté de la catégorie dans le menu reste à 1. Cliquez sur la page.

### 2.11 Créer des produits associés pour toute une catégorie

1. **Avant :** ouvrez [Claudia Crochet Dress](https://demo.gally.dev/example/com_en/product/VD10) (`VD10`). Pas de bandeau de recommandation : cette
   boutique n'a aucune règle de recommandation.
2. **Back office :** allez dans **Merchandising > Recommandations > Recommandations automatiques**, cliquez
   **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo related"
   - Catalogue(s) localisé(s) : COM English Catalog
   - Applied to : **Related product**
4. Règle source (**Source rule engine**) - quels produits reçoivent la recommandation :
   1. Cliquez **Ajouter une condition**, puis **Condition attribut**.
   2. Attribut : **Catégorie** (l'attribut catégorie). Opérateur : **est égal**.
   3. Dans l'arbre des catégories, choisissez **Default Category > Dresses**.
5. Règle cible (**Target rule engine**) - ce qui est recommandé : la même condition, la même catégorie.
6. Cliquez **Créer**.
7. **Après :** rechargez la robe. Un bandeau montre six autres robes : Petra Sundress, Athena Tank,
   Alexia Maxi, Valentina Tank, Paulina Draped Tank, Flora Tank.
8. Ouvrez **Candace Dress** - elle reçoit elle aussi six robes.
9. Ouvrez **Rowena Skirt** - rien n'a changé.

**À souligner :**

- Une règle, aucune liste de produits : elle couvre toutes les robes, et une nouvelle robe la
  rejoint toute seule.
- Ce sont des règles, pas un apprentissage sur les acheteurs. La liste vient dans un ordre fixe,
  moins le produit affiché - "le même rayon", pas une recommandation personnelle.

### 2.12 Créer un cross-sell pour le panier

1. **Avant :** ajoutez **Johanna Skirt** au panier et ouvrez le panier. Pas de bandeau de
   suggestion.
2. **Back office :** **Merchandising > Recommandations > Recommandations automatiques**, cliquez **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo cross-sell"
   - Catalogue(s) localisé(s) : COM English Catalog
   - Applied to : **Cross-sell**
4. Règle source (**Source rule engine**) : **Catégorie** est égal **Default Category > Bottoms > Skirts**.
5. Règle cible (**Target rule engine**) : **Catégorie** est égal **Default Category > Accessories > Belts**.
6. Cliquez **Créer**.
7. **Après :** rechargez le panier. Un bandeau de suggestion montre les quatre ceintures : Stretch
   Belt With Leather Clasp, Thin et Thick Leather Braided Belt, Laser Cut Stretch Belt.
8. Remplacez la jupe par **Pomona Skirt** - les mêmes quatre. Toute jupe les reçoit.

**À souligner :** la fiche produit d'une jupe montre maintenant les ceintures elle aussi. Sans
règle de produits associés, la fiche produit se rabat sur le cross-sell.

---

## Partie 3 - Dans l'autre sens

Chaque recherche, vue de produit et ajout au panier dans la boutique est envoyé à Gally.

1. Dans la boutique, cliquez le bouton **Gally Insights**, en bas à gauche. Le panneau liste
   les événements envoyés par la boutique.
2. Dans le back office, ouvrez **Analyse > Utilisation de la recherche** : recherches, produits
   vus, ajouts au panier, sessions, et le tableau **Recherches populaires** avec sa colonne
   **Taux de conv.**
3. Ouvrez **Analyse > Résultats**. Choisissez le catalogue, le **Type de requête** (Search result
   ou Category listing), puis un terme de recherche ou une catégorie. Il montre le classement ;
   cliquez une ligne pour le détail de ce produit. Essayez `tank`, avec le boost de l'étape 2.4
   actif.

**Attention :** les événements sont traités chaque minute, mais le délai avant que le tableau de
bord les affiche n'a pas été mesuré. Faites quelques recherches avant la démo plutôt que de compter
dessus en direct.

**À souligner :** les recherches suggérées de l'étape 1.5 viennent des mêmes données. Gally les
filtre : pas de fautes de frappe, pas de recherche sans résultat, rien de plus de 180 jours.

---

## Si quelque chose cloche

- **Une recherche donne des résultats là où le guide dit 0** - la démo précédente n'a pas été
  remise à zéro, ou l'étape 2.3 est déjà faite. Vérifiez Recherche > Thésaurus et Paramètres >
  Configurations, onglet Recherche vectorielle.
- **Category, Price et Availability disparaissent de la catégorie de tête après l'étape 2.9 ou la remise à zéro** -
  vu deux fois sur huit enregistrements d'un réglage d'autocomplétion. Décochez puis recochez
  Affiché dans l'autocomplete.
- **L'enregistrement d'une catégorie affiche une erreur** - cliquez à nouveau sur Enregistrer.
- **Le tri n'a pas changé** - rechargez avec F5.
- **Le popup ne montre ni articles ni recherches suggérées** - la fenêtre de la boutique fait 768
  pixels ou moins, le popup utilise donc des onglets. Élargissez la fenêtre, ou cliquez **Blog**
  ou **Suggestions**.
- **Un boost ne change rien** - vérifiez le terme cherché. Chaque étape de boost indique le terme à
  utiliser.
- **Le bandeau du panier n'apparaît pas** - vérifiez que c'est bien une jupe, et pas un autre
  produit, qui est dans le panier.

## Ce qui ne se montre pas en direct

Ces réglages sont réels, mais ils ne s'appliquent qu'après une réindexation du catalogue. Sur la
pile de démo, réindexer veut dire recharger toutes les données d'exemple, ce qui efface aussi tous
les changements du back office. Décrivez-les, ne cliquez pas :

- rendre un attribut cherchable, ou changer son poids de recherche
- rendre un attribut triable (l'option apparaît, mais le tri ne marche pas encore)
- "Use category name in product search"
- les réglages de correction orthographique, d'analyseur et de span sur un attribut
- les champs vectorisés et leurs prompts (l'interrupteur "Utiliser en cas d'absence de résultat" fait exception)
- les réglages de pertinence (tolérance aux fautes, phonétique, mots requis) : ils s'appliquent
  tout de suite, mais rien à l'écran ne les montre

## Ce qui relève de la boutique, pas de Gally

Ne présentez pas ceci comme des fonctions de Gally :

- masquer un filtre qui n'a qu'une seule valeur
- les catégories du popup de recherche (une recherche de texte faite dans le navigateur)
- les pastilles de couleur, "voir plus" après cinq options, le popup qui attend deux caractères
- la règle de disponibilité et le bouton "ajouter au panier" désactivé
- l'upsell : Gally gère des règles d'upsell, mais la boutique ne les affiche jamais, et Venia n'en a aucune

## À éviter dans cette boutique

Les résultats ci-dessous sont ceux de l'état de départ. Après l'étape 2.3, une recherche qui ne
trouvait rien renvoie à la place la liste de la recherche vectorielle.

- **Faire la démo en français** - les textes produits y sont aussi en anglais, et la barre de
  recherche n'a pas de recherches suggérées.
- **Les deux derniers filtres de la catégorie de tête** - ils affichent des codes bruts,
  "Date_of_manufacture" et "Manufacture_location".
- **Chercher `jewelry`** - cela renvoie 0, alors qu'une catégorie porte ce nom.
- **Promettre un ordre de tailles** - aucun mode de tri ne donne XS, S, M, L, XL dans cet ordre.
- **Les recherches suggérées hors robes** - l'historique contient des recherches de robes,
  "shoes", que cette boutique ne vend pas, et quelques recherches sur les conditions de vente
  ("terms of sale", "sale conditions").

## Remise à zéro

Parcourez cette liste après la démo, ou avant si la vérification de l'état de départ a échoué.

1. Recherche > Thésaurus - supprimez "Demo jumper" et "Demo office".
2. Paramètres > Configurations, onglet Recherche vectorielle, COM English Catalog -
   Utiliser en cas d'absence de résultat **désactivé**.
3. Merchandising > Boosts - supprimez "Demo sale" ; `Boost "Tank dress"` : types de requête de
   nouveau limités à **Category listing** et **Search result**.
4. Merchandising > Catégories, catégorie de tête (**Default Category**) - Karena Halter Dress **désépinglée**.
5. Merchandising > Catégories, **Default Category > Accessories > Jewelry** - Tri par défaut **Position**.
6. Merchandising > Catégories, **Default Category > New Products** - Catégorie virtuelle **désactivée**, règle vidée.
7. Recherche > Facettes, panneau Catégories, **Default Category > Accessories**, Marque - Affichage **Auto**, sans position.
8. Paramètres, onglet Attributs - Marque, Affiché dans l'autocomplete **décoché**.
9. Merchandising > Recommandations > Recommandations automatiques - supprimez "Demo related" et "Demo cross-sell".
10. Dans la boutique, videz le panier.
11. Vérifiez à nouveau l'état de départ (Avant de commencer, étape 4). Vérifiez aussi que la
    catégorie de tête affiche toujours les filtres Category, Price et Availability - voir [Si quelque chose
    cloche](#si-quelque-chose-cloche).

Remettre une facette ou une configuration enregistre la valeur par défaut au lieu de la supprimer.
La boutique se comporte exactement comme avant.

---

Chaque étape, compteur et nom de produit a été vérifié sur une instance réelle le 2026-11-02, via
l'API du back office : les étapes dans cet ordre, chaque changement gardé, puis la remise à zéro.
Le 2026-11-09, un script Playwright a parcouru le guide de la boutique papershop dans les écrans
du back office et de la boutique, et les libellés d'écran de ce guide ont été corrigés d'après ce
passage. Les compteurs et noms de produits de ce guide n'ont pas été revérifiés à l'écran : ils
viennent de la vérification par l'API décrite ci-dessus. Les autres boutiques d'exemple sont décrites dans leurs fiches - voir
[`README.md`](README.md).
