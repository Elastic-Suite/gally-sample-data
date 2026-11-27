[English](../en/demo-fashion.md)

# Guide de démo Gally - Fiora Fashion

> Script de démo. Pour les faits et chiffres de cette boutique, voir [`catalog-fashion.md`](catalog-fashion.md).

Ce guide déroule une démo Gally dans deux fenêtres : le back office et la boutique d'exemple. On
fait quelque chose dans le back office, on recharge la boutique, et on montre ce qui est apparu.

- **Public :** un marchand ou un product owner - quelqu'un qui utilisera le back office.
- **La question à laquelle il répond :** "qu'est-ce que je contrôle, et qu'est-ce que j'obtiens
  sans rien faire ?"
- **Il vous faut :** des notions de base de Gally (ce que sont un catalogue, une facette, un boost)
  et une pile locale avec les données d'exemple chargées.
- **Boutique utilisée :** Fiora Fashion (`fashion_fr`) : vêtements femme et homme, chaussures,
  sport, accessoires et bijoux, en français. Ses chiffres et références sont dans
  [`catalog-fashion.md`](catalog-fashion.md).
- **Durée :** environ 30 minutes, ou 20 sans la partie 1.

Le guide a trois parties :

1. **Ce que Gally fait tout seul** - rien de configuré, boutique seulement.
2. **Action et réaction** - 12 actions dans le back office. Chacune s'ajoute aux précédentes.
   Rien n'est annulé avant la fin de la démo.
3. **Dans l'autre sens** - ce que la boutique renvoie au back office.

---

## Avant de commencer

1. Ouvrez la boutique : `https://demo.gally.dev/example/fashion_fr`. La page d'accueil doit
   s'afficher.
2. Ouvrez le back office : `https://demo.gally.dev/fr`. Connectez-vous avec `admin@example.com` /
   `apassword`.
3. Placez les deux fenêtres côte à côte. Gardez la fenêtre de la boutique **plus large que 768
   pixels** : plus étroite, le popup de recherche passe en onglets (Produits, Blog, Suggestions) et
   ne montre que l'onglet Produits tant qu'on n'en clique pas un autre.
4. Vérifiez l'état de départ dans la boutique :
   - chercher `futal` - **0 résultat**
   - chercher `réveillon` - **0 résultat**
   - la rangée "Notre sélection" de la page d'accueil commence par Robe longue drapée en jersey Muse

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
| 1.2 | boutique | cocher une marque | des compteurs qui restent complets |
| 1.3 | boutique | chercher avec des fautes | les bons produits malgré tout |
| 1.4 | boutique | chercher `velours` | les noms avant les descriptions |
| 1.5 | boutique | taper dans la barre de recherche | des suggestions qui suivent la requête |
| 1.6 | boutique | taper, puis chercher `robe` | produits et articles depuis une seule barre |
| 2.1 | back office | créer un synonyme | 0 résultat devient 36 |
| 2.2 | back office | créer une expansion | 0 résultat devient 28 pièces de soirée |
| 2.3 | back office | activer la recherche vectorielle sans résultat | des phrases courtes trouvent lunettes, tenue de yoga, sandales |
| 2.4 | back office | activer un boost préparé | une marque prend la tête |
| 2.5 | back office | créer un boost | les nouveautés prennent la tête |
| 2.6 | back office | épingler un produit | la page d'accueil change |
| 2.7 | back office | changer le tri par défaut d'une catégorie | la catégorie s'ouvre par prix |
| 2.8 | back office | forcer une facette et la déplacer | un filtre masqué apparaît en premier |
| 2.9 | back office | ajouter un attribut à l'autocomplétion | une nouvelle section dans la barre de recherche |
| 2.10 | back office | rendre une catégorie virtuelle | 8 produits deviennent 39 |
| 2.11 | back office | créer des produits associés pour une catégorie | chaque collant en montre d'autres |
| 2.12 | back office | créer un cross-sell entre catégories | toute cape suggère des chapeaux |
| 3 | les deux | ouvrir Analyse | l'activité de la boutique dans le back office |

---

## Partie 1 - Ce que Gally fait tout seul

Aucune facette de cette boutique n'a été configurée. Dites-le d'abord : tout dans cette partie est
le comportement par défaut de Gally.

### 1.1 Des filtres qui suivent la catégorie

1. Ouvrez la catégorie de tête, [Fiora Mode](https://demo.gally.dev/example/fashion_fr/category/cat_fio_1), et regardez les filtres du catalogue entier
   (433 produits) : Catégorie, Prix, Disponibilité, Nouveauté, En promotion, Couleur, Marque.
2. Ouvrez [Femme > Robes & Combinaisons](https://demo.gally.dev/example/fashion_fr/category/cat_fio_16) (40 produits). S'ajoutent : Taille vêtement, Occasion, Matière
   robe, Dos nu, Couleur robe, Longueur robe.
3. Ouvrez [Chaussures](https://demo.gally.dev/example/fashion_fr/category/cat_fio_44) (50 produits). Les filtres des robes ont disparu. S'ajoutent : Pointure,
   Hauteur de talon, Matière chaussure, Type de semelle, Vegan.
4. Ouvrez [Sport & Performance](https://demo.gally.dev/example/fashion_fr/category/cat_fio_60) (40 produits). S'ajoutent : Taille sport, Tissu technique,
   Intensité, Protection UV, Séchage rapide.

**À souligner :** Gally n'affiche un filtre que si au moins 90 % des produits de la page ont cet
attribut. Il le recalcule pour chaque page, chaque recherche et chaque filtre. Les robes ont des
filtres de robe et les chaussures des filtres de chaussure, sans rien faire.

### 1.2 Des compteurs qui restent complets

1. Ouvrez [Femme > Robes & Combinaisons](https://demo.gally.dev/example/fashion_fr/category/cat_fio_16) (40 produits).
2. Dans **Marque**, cochez **PureBasics**.

**Vous devez voir :**

- 8 produits.
- Le filtre Marque liste toujours toutes les marques avec leur compteur complet : Fiora 28,
  PureBasics 8, UrbanEdge 4. L'acheteur peut ajouter une deuxième marque.
- Occasion ne compte plus que les robes PureBasics : Casual 4, Bureau 3, Cocktail 1.

### 1.3 Fautes de frappe et mots qui se prononcent pareil

1. Cherchez `juppe` - 23 résultats, comme `jupe`.
2. Cherchez `ecarpin` - 8 résultats, avec les mêmes trois premiers que `escarpin`.
3. Cherchez `kachemire` - 9 résultats, comme `cachemire`.

**À souligner :**

- Les étapes 1-2 relèvent de la tolérance aux fautes.
- L'étape 3 change la première lettre, ce que la tolérance aux fautes ne fait jamais. Elle marche
  parce que les mots se prononcent pareil (correspondance phonétique).
- Aucun message "vouliez-vous dire". L'acheteur obtient simplement des résultats.

### 1.4 Le nom compte plus que la description

1. Cherchez `velours` - 8 produits.

**Vous devez voir :**

- D'abord, les cinq produits qui ont "velours" dans leur nom : Pantalon velours côtelé Automnal,
  Sweat à capuche velours Cozy, Blazer en velours côtelé Bohème, Robe de soirée en velours
  Noblesse, Escarpin kitten heel en velours Rétro.
- En dernier, trois produits dont le nom ne dit pas velours : Blouson en daim Seventies et
  Mocassin Tassel le mentionnent dans leur description, la Veste denim Atelier a Velours comme
  matière.

**À souligner :** par défaut, le nom du produit pèse dix fois plus que les autres champs.

### 1.5 Des suggestions qui suivent la requête

1. Tapez `pull` et attendez, sans appuyer sur Entrée. Les sections d'attributs sont Couleur (Noir, Gris chiné, Beige),
   Matière haut et Marque.
2. Tapez `cuir` et attendez, sans appuyer sur Entrée. Seulement Couleur et Marque (Fiora, LuxeLine, UrbanEdge).
3. Tapez `rob` et attendez, sans appuyer sur Entrée. Section **Recherches populaires** : "robe longue", "robe noire", "robe soirée" et
   d'autres.

Dans une fenêtre étroite, les recherches suggérées sont sous l'onglet **Suggestions**.

**À souligner :**

- Le marchand choisit quels attributs peuvent apparaître. Gally choisit ceux qui conviennent à la
  requête, et leurs valeurs.
- Les recherches suggérées viennent de ce que les acheteurs ont réellement cherché dans cette
  boutique.

### 1.6 Une barre de recherche, plusieurs types de contenu

1. Tapez `robe` et attendez, sans appuyer sur Entrée. Sous les catégories, le popup a une section
   **Blog** : les articles qui correspondent au mot, les mêmes qu'à l'étape 3. Si le popup montre
   des onglets, la fenêtre est trop étroite : cliquez **Blog**.
2. Appuyez sur Entrée. La page de résultats montre 44 produits.
3. Passez de **Produits** à **Articles**. 4 articles, menés par "Choisir sa robe de soirée" et "S'habiller pour un mariage sans se tromper".

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

1. **Avant :** cherchez `futal` - **0 résultat**. Les acheteurs disent futal, le catalogue dit
   pantalon. Les deux mots désignent les mêmes pantalons.
2. **Back office :** allez dans **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : "Demo futal", Actif : oui
   - Type de contexte : **Catalog localisé**, puis Catalogue(s) localisé(s) : Fiora Français
   - Type de thésaurus : **Synonyme**
   - Synonymes : `futal`, `pantalon`
4. Cliquez **Créer**.
5. **Après :** cherchez `futal` - **36 résultats**, les pantalons : Tregging pantalon-legging
   Hybrid, Pantalon palazzo fluide Liberté, Pantalon velours côtelé Automnal, et d'autres.
6. Cherchez `pantalon` - les mêmes 36, dans le même ordre.

**À souligner :**

- Pas de développeur, pas de réindexation. Cela s'applique à l'enregistrement.
- Un synonyme réunit des mots qui veulent dire exactement la même chose, dans la langue de la
  boutique : un mot courant, un mot régional, une abréviation. Il marche dans tous les sens.
- Un mot large qui doit ramener des mots plus précis (`anorak` pour les doudounes, les parkas et
  les coupe-vent) n'est pas un synonyme. En synonyme, `parka` ramènerait aussi les doudounes.
  C'est une expansion - étape suivante.
- N'utilisez pas un thésaurus pour traduire (`dress` = `robe`). Chaque langue a son propre
  catalogue et son propre thésaurus.
- Le thésaurus compare le mot exact. Gardez des mots simples : `cache-nez`, avec son trait
  d'union, n'a pas ramené `écharpe` lors d'un test.

### 2.2 Créer une expansion

1. **Avant :** cherchez `réveillon` - **0 résultat**.
2. **Back office :** **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : "Demo réveillon", Actif : oui
   - Type de contexte : Catalog localisé, puis Catalogue(s) localisé(s) : Fiora Français
   - Type de thésaurus : **Expansion**
   - Terme de référence : `réveillon`
   - Termes étendus : `soirée`, `sequins`, `paillettes`, `fourreau`, `taffetas`
4. Cliquez **Créer**.
5. **Après :** cherchez `réveillon` - **28 résultats**, les pièces de soirée en tête : Robe
   bustier taffetas Opéra, Escarpin pailleté Sparkle, Robe fourreau pailletée Midnight, puis d'autres robes de soirée,
   une mule en satin et une pochette plus bas.

**À souligner :** une expansion va dans un seul sens. `réveillon` ramène les robes de soirée ;
`soirée` renvoie toujours ses 27 produits. C'est ainsi qu'un marchand prépare une saison, ou
fait ramener à un mot large les mots plus précis.

### 2.3 Répondre aux recherches que personne n'a prévues

1. **Avant :** cherchez `lunettes soleil femme` - **0 résultat**. Pareil pour `tenue yoga` et
   `sandales plage`.
2. **Back office :** allez dans **Paramètres > Configurations**, onglet **Recherche vectorielle**.
3. Dans **La configuration s'applique à:**, choisissez Fiora Français.
4. Activez **Utiliser en cas d'absence de résultat**. Cliquez **Enregistrer**.
5. **Après :**
   - `lunettes soleil femme` - trois paires de lunettes de soleil en tête
   - `tenue yoga` - Legging yoga Zen, Short yoga Flow, Sweat Pilates
   - `sandales plage` - trois paires de sandales en tête

**À souligner :** quand la recherche par mots ne trouve rien, Gally cherche par le sens. Le
thésaurus couvre les mots qu'on attend ; ceci couvre ceux auxquels on n'a pas pensé.

**Attention :**

- N'utilisez que ces trois phrases. Les phrases avec "chaussures" ramènent d'abord des chaussettes,
  et `tenue de plage` ramène un portefeuille.
- Le compteur affiche environ 100 produits, quelle que soit la phrase : c'est la **Valeur K** du même
  formulaire, pas un nombre de produits pertinents. Parlez de la première ligne, pas du nombre.
- À partir d'ici, aucune recherche n'affiche "0 résultat". Toutes les étapes qui partent de 0
  viennent avant celle-ci.

### 2.4 Activer un boost préparé

1. **Avant :** cherchez `cuir` - 100 produits, un seul article LuxeLine dans les huit premiers.
2. **Back office :** **Merchandising > Boosts**. Ouvrez **"LuxeLine en tête"**. Il est livré
   désactivé.
3. Cochez **Actif**. Enregistrer.
4. **Après :** cherchez `cuir` - les sept premiers sont tous LuxeLine : pochettes, portefeuilles,
   une trousse.
5. Cherchez `portefeuille` - les cinq portefeuilles LuxeLine passent des places 4-8 aux places
   1-5.

**À souligner :** une règle peut attendre, désactivée ou datée, et passer en ligne au bon moment.

**Attention :** utilisez `cuir` ou `portefeuille`. Sur `robe`, `jupe` ou `lunettes` rien ne
change - aucun produit LuxeLine.

### 2.5 Créer un boost

1. **Avant :** cherchez `jean`. Jean bio regular Natural, avec le badge "Nouveau", est 4e. Jean
   slim brut selvedge Premium, nouveau lui aussi, est 16e.
2. **Back office :** allez dans **Merchandising > Boosts**, cliquez **Créer boost**.
3. Remplissez :
   - Nom : "Demo nouveautés", Actif : oui
   - Catalogue(s) localisé(s) : Fiora Français
   - Type de requête : **Search result**, Tous les termes de recherches
   - Règle virtuelle : **Ajouter une condition > Condition attribut**, **Nouveauté** est égal
     **vrai**
   - Modèle : **Constante**, Valeur du boost (%) : 100
4. Cliquez **Créer**.
5. **Après :** cherchez `jean` - les deux jeans nouveaux sont 1er et 2e.
6. Cherchez `veste` - Veste Shacket passe de la 13e place à la 1re.

**À souligner :**

- La boutique a déjà une règle de promotions ("Promotions en tête") sur les robes. Celle-ci
  remonte les nouveautés - une règle de plus, sur un autre attribut.
- Le formulaire a un bloc **Preview** : choisissez le catalogue localisé et un terme de recherche,
  puis cliquez **Prévisualiser** pour vérifier la règle avant de l'enregistrer.
- Les boosts s'additionnent. Le boost LuxeLine de l'étape 2.4 est toujours actif : un nouveau
  produit LuxeLine reçoit les deux. Cherchez à nouveau `cuir` - Ceinture boucle dorée et Montre
  Rose, nouvelles et LuxeLine, sont maintenant 1re et 2e, puis trois chaussures Fiora nouvelles,
  puis les autres articles LuxeLine.

### 2.6 Épingler un produit sur la page d'accueil

1. **Avant :** la rangée "Notre sélection" de la page d'accueil montre Robe longue drapée en jersey
   Muse, Robe cocktail en dentelle Guipure Sublime, Robe de soirée bustier en taffetas Opéra.
2. **Back office :** allez dans **Merchandising > Catégories**.
3. Dans **Choisir un catalogue**, prenez Fiora Fashion ; dans **Choisir une langue**, prenez
   la langue française.
4. Sélectionnez la **catégorie de tête** de l'arbre, **Fiora Mode**.
5. Vérifiez que **Tri par défaut** est **Position**. Sinon l'épinglage est refusé.
   L'épingle vaut pour toutes les langues de la boutique.
6. Dans la liste des produits, trouvez **Basket minimaliste en cuir blanc Essential**
   (`FIO-CHA-BA-001`).
7. Cliquez **Épingler** et placez-la en premier. Cliquez **Enregistrer**.
8. **Après :** rechargez la page d'accueil. La basket ouvre la rangée "Notre sélection", avec son
   badge "Nouveau".

**À souligner :** la rangée de la page d'accueil, c'est tout le catalogue dans son ordre marchand.
Le marchand décide de ce qui accueille l'acheteur.

### 2.7 Changer le tri par défaut d'une catégorie

1. **Avant :** ouvrez [Accessoires & Bijoux > Bijoux](https://demo.gally.dev/example/fashion_fr/category/cat_fio_58) (16 produits). Collier rivière Éternité
   (89,90 €) est premier.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Fiora Mode > Accessoires & Bijoux > Bijoux**.
3. Passez **Tri par défaut** à **Price**. Enregistrer.
4. **Après :** rechargez la boutique avec **F5**. Bijoux s'ouvre du moins cher au plus cher :
   Chaîne de cheville Summer à 15,90 €, et les boucles puces diamant à 199,90 € en dernier.

### 2.8 Forcer une facette et la mettre en premier

1. **Avant :** ouvrez [Accessoires & Bijoux](https://demo.gally.dev/example/fashion_fr/category/cat_fio_54). Pas de filtre "Couleur" : seuls 28 des 52
   produits en ont une (54 %) - ceintures, lunettes et chapeaux - sous la règle des 90 % de
   l'étape 1.1.
2. **Back office :** allez dans **Recherche > Facettes**. Dans le panneau **Catégories** à gauche,
   sous **Par catégorie**, sélectionnez **Fiora Mode > Accessoires & Bijoux**.
3. Sur la ligne **Couleur** :
   - Affichage : **Affiché**
   - Position : **1**

   Il n'y a pas de bouton Enregistrer : chaque changement est enregistré tout de suite.
4. **Après :** rechargez. "Couleur" est le premier filtre : Beige 15, Bordeaux 13, Camel 12, Gris
   chiné 11, et les autres.

**À souligner :** Gally le masquait par défaut. Le marchand a décidé que la couleur compte ici, et
l'a mise en premier. Le réglage ne vaut que pour cette catégorie.

### 2.9 Ajouter un attribut à la barre de recherche

1. **Avant :** tapez `robe`. Pas de section de longueur.
2. **Back office :** allez dans **Paramètres**, onglet **Attributs**.
3. Sur **Longueur robe**, cochez **Affiché dans l'autocomplete**. La case est enregistrée
   tout de suite, sans bouton Enregistrer.
4. **Après :** tapez `robe` - une nouvelle section Longueur robe : Maxi 16, Midi 9, Au-dessus du
   genou 8.
5. Tapez `soirée` - la même section avec Maxi 9 en tête. Tapez `jean` - pas de section : aucun
   jean n'a de longueur de robe. Les valeurs suivent la requête.

### 2.10 Rendre une catégorie virtuelle

1. **Avant :** ouvrez [Sport & Performance > Shorts & Joggings](https://demo.gally.dev/example/fashion_fr/category/cat_fio_63). 8 produits.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Fiora Mode > Sport & Performance > Shorts & Joggings**.
3. Activez **Catégorie virtuelle**.
4. Règle : **Marque** est égal **ActivePulse**. Enregistrer - deux fois si le premier enregistrement
   affiche une erreur.
5. **Après :** rechargez. **39 produits** : tous les articles ActivePulse, des leggings aux
   brassières.

**À souligner :**

- Une catégorie virtuelle se tient à jour toute seule : un nouveau produit ActivePulse y apparaît
  de lui-même.
- Choisissez la règle avec soin : la plupart des catégories de cette boutique mélangent les
  marques, une règle de marque y ferait donc disparaître des produits. Shorts & Joggings ne contient que
  des produits ActivePulse, c'est pourquoi elle est utilisée ici.

### 2.11 Créer des produits associés pour toute une catégorie

1. **Avant :** ouvrez [Collant opaque 80 deniers Everyday](https://demo.gally.dev/example/fashion_fr/product/FIO-LIN-CC-001) (`FIO-LIN-CC-001`). Pas de bandeau de
   recommandation : collants et chaussettes n'ont aucune règle.
2. **Back office :** allez dans **Merchandising > Recommandations > Recommandations automatiques**, cliquez
   **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo related"
   - Catalogue(s) localisé(s) : Fiora Français
   - Applied to : **Related product**
4. Règle source (**Source rule engine**) - quels produits reçoivent la recommandation :
   1. Cliquez **Ajouter une condition**, puis **Condition attribut**.
   2. Attribut : **Catégorie**. Opérateur : **est égal**.
   3. Dans l'arbre des catégories, choisissez **Fiora Mode > Femme > Lingerie & Homewear >
      Collants & Chaussettes**.
5. Règle cible (**Target rule engine**) - ce qui est recommandé : la même condition, la même catégorie.
6. Cliquez **Créer**.
7. **Après :** rechargez le collant. Un bandeau montre six autres collants et chaussettes.
8. Ouvrez un autre produit de la même catégorie - il en reçoit six lui aussi.
9. Ouvrez [un legging](https://demo.gally.dev/example/fashion_fr/product/FIO-FBA-LE-001) (`FIO-FBA-LE-001`) - rien n'a changé.

**À souligner :**

- Une règle, aucune liste de produits : elle couvre toute la catégorie, et un nouveau collant la
  rejoint tout seul.
- Ce sont des règles, pas un apprentissage sur les acheteurs. La liste vient dans un ordre fixe,
  moins le produit affiché - "le même rayon", pas une recommandation personnelle.

### 2.12 Créer un cross-sell pour le panier

1. **Avant :** ajoutez [Cape Élégance](https://demo.gally.dev/example/fashion_fr/product/FIO-MAN-CP-001) (`FIO-MAN-CP-001`) au panier et ouvrez le panier. Pas de
   bandeau de suggestion.
2. **Back office :** **Merchandising > Recommandations > Recommandations automatiques**, cliquez **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo cross-sell"
   - Catalogue(s) localisé(s) : Fiora Français
   - Applied to : **Cross-sell**
4. Règle source (**Source rule engine**) : **Catégorie** est égal **Fiora Mode > Femme > Manteaux & Vestes > Capes &
   Ponchos**. Prenez celle sous Femme : Homme a aussi un "Manteaux & Vestes".
5. Règle cible (**Target rule engine**) : **Catégorie** est égal **Fiora Mode > Accessoires & Bijoux > Chapeaux &
   Bonnets**.
6. Cliquez **Créer**.
7. **Après :** rechargez le panier. Un bandeau de suggestion montre les sept chapeaux : un fedora,
   un bonnet mérinos, une casquette, un bob, un béret, un Panama, un bonnet cachemire.
8. Remplacez la cape par [un poncho](https://demo.gally.dev/example/fashion_fr/product/FIO-MAN-CP-004) (`FIO-MAN-CP-004`) - les mêmes sept. Toute cape ou tout poncho
   les reçoit.

---

## Partie 3 - Dans l'autre sens

Chaque recherche, vue de produit et ajout au panier dans la boutique est envoyé à Gally.

1. Dans la boutique, cliquez le bouton **Gally Insights**, en bas à gauche. Le panneau "Ce que
   Gally sait" liste les événements envoyés par la boutique.
2. Dans le back office, ouvrez **Analyse > Utilisation de la recherche** : recherches, produits
   vus, ajouts au panier, sessions, et le tableau **Recherches populaires** avec sa colonne
   **Taux de conv.**
3. Ouvrez **Analyse > Résultats**. Choisissez le catalogue, le **Type de requête** (Search result
   ou Category listing), puis un terme de recherche ou une catégorie. Il montre le classement ;
   cliquez une ligne pour le détail de ce produit. Essayez `cuir`, avec le boost de l'étape 2.4
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
- **Catégorie, Prix et Disponibilité disparaissent de la catégorie de tête après l'étape 2.9 ou la remise à zéro** -
  vu deux fois sur huit enregistrements d'un réglage d'autocomplétion. Décochez puis recochez
  Affiché dans l'autocomplete.
- **L'enregistrement d'une catégorie affiche une erreur** - cliquez à nouveau sur Enregistrer.
- **Le tri n'a pas changé** - rechargez avec F5.
- **Le popup ne montre ni articles ni recherches suggérées** - la fenêtre de la boutique fait 768
  pixels ou moins, le popup utilise donc des onglets. Élargissez la fenêtre, ou cliquez **Blog**
  ou **Suggestions**.
- **Un boost ne change rien** - vérifiez le terme cherché. Chaque étape de boost indique le terme à
  utiliser.
- **Le bandeau du panier n'apparaît pas** - vérifiez que c'est bien une cape ou un poncho, et pas
  un autre produit, qui est dans le panier.

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
- l'upsell : Gally a des règles d'upsell, mais la boutique ne les affiche jamais

## À éviter dans cette boutique

Les résultats ci-dessous sont ceux de l'état de départ. Après l'étape 2.3, une recherche qui ne
trouvait rien renvoie à la place la liste de la recherche vectorielle.

- **Les recherches de plusieurs mots** - chaque mot doit correspondre : `tenue de soirée` renvoie
  0, alors que `soirée` renvoie 27.
- **`lin`** - 86 résultats : les 12 produits en lin, puis 74 articles de lingerie.
- **Les fautes de frappe en montrant "Promotions en tête"** - ce boost livré se déclenche quand la
  recherche contient "robe", donc `rboe` trouve les robes mais dans un autre ordre.
- **Un synonyme avec un trait d'union** - `nu-pieds` tapé avec son trait d'union n'a pas
  correspondu lors d'un test ; préférez des mots simples, comme à l'étape 2.1.
- **Passer la boutique en anglais** - certains produits y ont un autre nom (par exemple
  `FIO-FTP-BL-002`, `FIO-FTP-BL-003`).

## Remise à zéro

Parcourez cette liste après la démo, ou avant si la vérification de l'état de départ a échoué.

1. Recherche > Thésaurus - supprimez "Demo futal" et "Demo réveillon".
2. Paramètres > Configurations, onglet Recherche vectorielle, Fiora Français -
   Utiliser en cas d'absence de résultat **désactivé**.
3. Merchandising > Boosts - supprimez "Demo nouveautés" ; "LuxeLine en tête" **désactivé**.
4. Merchandising > Catégories, catégorie de tête (**Fiora Mode**) - Basket minimaliste en cuir blanc Essential
   **désépinglée**.
5. Merchandising > Catégories, **Fiora Mode > Accessoires & Bijoux > Bijoux** - Tri par défaut **Position**.
6. Merchandising > Catégories, **Fiora Mode > Sport & Performance > Shorts & Joggings** - Catégorie virtuelle **désactivée**, règle vidée.
7. Recherche > Facettes, panneau Catégories, **Fiora Mode > Accessoires & Bijoux**, Couleur - Affichage **Auto**, sans position.
8. Paramètres, onglet Attributs - Longueur robe, Affiché dans l'autocomplete
   **décoché**.
9. Merchandising > Recommandations > Recommandations automatiques - supprimez "Demo related" et "Demo cross-sell".
10. Dans la boutique, videz le panier.
11. Vérifiez à nouveau l'état de départ (Avant de commencer, étape 4). Vérifiez aussi que la
    catégorie de tête affiche toujours les filtres Catégorie, Prix et Disponibilité - voir [Si quelque chose
    cloche](#si-quelque-chose-cloche).

Remettre une facette ou une configuration enregistre la valeur par défaut au lieu de la supprimer.
La boutique se comporte exactement comme avant.

---

Chaque étape, compteur et nom de produit a été vérifié sur une instance réelle le 2026-11-02, via
l'API du back office : les étapes dans cet ordre, chaque changement gardé, puis la remise à zéro. Le 2026-11-09, un script Playwright a parcouru le guide de la boutique papershop dans les écrans
du back office et de la boutique, et les libellés d'écran de ce guide ont été corrigés d'après ce
passage. Les compteurs et noms de produits de ce guide n'ont pas été revérifiés à l'écran : ils
viennent de la vérification par l'API décrite ci-dessus. Les autres boutiques d'exemple sont décrites dans leurs fiches - voir
[`README.md`](README.md).
