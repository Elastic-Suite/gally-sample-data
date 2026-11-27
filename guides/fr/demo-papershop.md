[English](../en/demo-papershop.md)

# Guide de démo Gally - back office et boutique

> Script de démo. Pour les faits et chiffres de cette boutique, voir [`catalog-papershop.md`](catalog-papershop.md).

Ce guide déroule une démo Gally dans deux fenêtres : le back office et la boutique d'exemple. On
fait quelque chose dans le back office, on recharge la boutique, et on montre ce qui est apparu.

- **Public :** un marchand ou un product owner - quelqu'un qui utilisera le back office.
- **La question à laquelle il répond :** "qu'est-ce que je contrôle, et qu'est-ce que j'obtiens
  sans rien faire ?"
- **Il vous faut :** des notions de base de Gally (ce que sont un catalogue, une facette, un boost)
  et une pile locale avec les données d'exemple chargées.
- **Boutique utilisée :** Le livre & le lièvre (`papershop_fr`) : papeterie, livres et mobilier, en
  français. Ses chiffres et références sont dans [`catalog-papershop.md`](catalog-papershop.md).
- **Durée :** environ 30 minutes, ou 20 sans la partie 1.

Le guide a trois parties :

1. **Ce que Gally fait tout seul** - rien de configuré, boutique seulement.
2. **Action et réaction** - 12 actions dans le back office. Chacune s'ajoute aux précédentes.
   Rien n'est annulé avant la fin de la démo.
3. **Dans l'autre sens** - ce que la boutique renvoie au back office.

---

## Avant de commencer

1. Ouvrez la boutique : `https://demo.gally.dev/example/papershop_fr`. La page d'accueil doit
   s'afficher.
2. Ouvrez le back office : `https://demo.gally.dev/fr`. Connectez-vous avec `admin@example.com` /
   `apassword`.
3. Placez les deux fenêtres côte à côte. Gardez la fenêtre de la boutique **plus large que 768
   pixels** : plus étroite, le popup de recherche passe en onglets (Produits, Blog, Suggestions) et
   ne montre que l'onglet Produits tant qu'on n'en clique pas un autre.
4. Vérifiez l'état de départ dans la boutique :
   - chercher `rame` - **0 résultat**
   - chercher `rentrée` - **0 résultat**
   - chercher `siège de bureau` - **0 résultat**
   - la rangée "Notre sélection" de la page d'accueil commence par Crayon graphite Tourbière

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
| 1.4 | boutique | chercher `voyage` | les titres avant les descriptions |
| 1.5 | boutique | taper dans la barre de recherche | des suggestions qui suivent la requête |
| 1.6 | boutique | taper, puis chercher `papier` | produits et articles depuis une seule barre |
| 2.1 | back office | créer un synonyme | 0 résultat devient 7 |
| 2.2 | back office | créer une expansion | 0 résultat devient 46 |
| 2.3 | back office | activer la recherche vectorielle sans résultat | une phrase trouve des chaises de bureau |
| 2.4 | back office | activer un boost préparé | une marque prend la tête |
| 2.5 | back office | créer un boost | les livres en promotion prennent la tête |
| 2.6 | back office | épingler un produit | la page d'accueil change |
| 2.7 | back office | changer le tri par défaut d'une catégorie | la catégorie s'ouvre par prix |
| 2.8 | back office | forcer une facette et la déplacer | un filtre masqué apparaît en premier |
| 2.9 | back office | ajouter un attribut à l'autocomplétion | une nouvelle section dans la barre de recherche |
| 2.10 | back office | rendre une catégorie virtuelle | 5 produits deviennent 25 |
| 2.11 | back office | créer des produits associés pour une catégorie | chaque classique montre d'autres classiques |
| 2.12 | back office | créer un cross-sell entre catégories | tout stylo plume suggère des encres |
| 3 | les deux | ouvrir Analyse | l'activité de la boutique dans le back office |

---

## Partie 1 - Ce que Gally fait tout seul

Aucune facette de cette boutique n'a été configurée. Dites-le d'abord : tout dans cette partie est
le comportement par défaut de Gally.

### 1.1 Des filtres qui suivent la catégorie

1. Ouvrez la catégorie de tête, [Le livre & le lièvre](https://demo.gally.dev/example/papershop_fr/category/cat_llv_1), et regardez les filtres du catalogue entier : Catégorie, Prix,
   Disponibilité, Nouveauté, En promotion, Marque, Pays de fabrication.
2. Ouvrez [Livres](https://demo.gally.dev/example/papershop_fr/category/cat_llv_20). Cinq filtres s'ajoutent : Format, Reliure, Auteur, Nombre de pages, Année de
   parution.
3. Ouvrez [Mobilier](https://demo.gally.dev/example/papershop_fr/category/cat_llv_38). Les filtres des livres ont disparu. Nouveaux : Matière, Couleur, Matières
   durables, Largeur, Hauteur, Profondeur, Montage nécessaire.
4. Ouvrez [Papeterie > Cahiers & carnets > Cahiers scolaires](https://demo.gally.dev/example/papershop_fr/category/cat_llv_4) (8 produits). Grammage et Réglure apparaissent.

**À souligner :** Gally n'affiche un filtre que si au moins 90 % des produits de la page ont cet
attribut. Il le recalcule pour chaque page, chaque recherche et chaque filtre.

### 1.2 Des compteurs qui restent complets

1. Ouvrez [Mobilier](https://demo.gally.dev/example/papershop_fr/category/cat_llv_38) (70 produits).
2. Dans **Marque**, cochez **Boisclair**.

**Vous devez voir :**

- 17 produits.
- Le filtre Marque liste toujours toutes les marques avec leur compteur complet : Verso 16, Chêne
  & Fer 15, et ainsi de suite. L'acheteur peut ajouter une deuxième marque.
- Couleur et les autres filtres ne comptent plus que les produits Boisclair.

### 1.3 Fautes de frappe et mots qui se prononcent pareil

1. Cherchez `cahir` - les cahiers reviennent.
2. Cherchez `stilo` - les mêmes 15 résultats que `stylo`.
3. Cherchez `krayon` - 15 résultats, dont les 7 crayons graphite.
4. Cherchez `chèze` - les chaises de bureau en tête.

**À souligner :**

- Les étapes 1-2 relèvent de la tolérance aux fautes.
- Les étapes 3-4 changent la première lettre, ce que la tolérance aux fautes ne fait jamais. Elles
  marchent parce que les mots se prononcent pareil (correspondance phonétique).
- Aucun message "vouliez-vous dire". L'acheteur obtient simplement des résultats.

### 1.4 Le nom compte plus que la description

1. Cherchez `voyage` - 8 livres.

**Vous devez voir :**

- D'abord, les quatre titres qui contiennent "Voyage" : Voyage en Italie, Le Voyage du Beagle,
  Voyage au centre de la Terre, Voyage avec un âne.
- En dernier, les livres qui ne parlent de voyage que dans leur description.

**À souligner :** par défaut, le nom du produit pèse dix fois plus que les autres champs.

### 1.5 Des suggestions qui suivent la requête

1. Tapez `cahier` et attendez, sans appuyer sur Entrée. Les sections d'attributs sont Marque, Matière, Couleur, Réglure,
   Reliure.
2. Tapez `bureau` et attendez, sans appuyer sur Entrée. Seulement Marque, Matière, Couleur.
3. Tapez `rom` et attendez, sans appuyer sur Entrée. Section **Recherches populaires** : "roman policier", "romans ados".

Dans une fenêtre étroite, les recherches suggérées sont sous l'onglet **Suggestions**.

**À souligner :**

- Le marchand choisit quels attributs peuvent apparaître. Gally choisit ceux qui conviennent à la
  requête, et leurs valeurs.
- Les recherches suggérées viennent de ce que les acheteurs ont réellement cherché dans cette
  boutique.

### 1.6 Une barre de recherche, plusieurs types de contenu

1. Tapez `papier` et attendez, sans appuyer sur Entrée. Sous les catégories, le popup a une section
   **Blog** : les articles qui correspondent au mot, les mêmes qu'à l'étape 3. Si le popup montre
   des onglets, la fenêtre est trop étroite : cliquez **Blog**.
2. Appuyez sur Entrée. La page de résultats montre 49 produits.
3. Passez de **Produits** à **Articles**. 5 articles, menés par "Le papier recyclé passe-t-il vraiment en imprimante" et "Le grammage, et pourquoi 80 g ne suffit pas toujours".

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

1. **Avant :** cherchez `rame` - **0 résultat**. Les acheteurs disent rame, le catalogue dit
   ramette. Les deux mots désignent le même paquet de papier.
2. **Back office :** allez dans **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : au choix, par exemple "Demo rame"
   - Actif : oui
   - Type de contexte : **Catalog localisé**, puis Catalogue(s) localisé(s) : Le livre & le lièvre France
   - Type de thésaurus : **Synonyme**
   - Synonymes : `rame`, `ramette`
4. Cliquez **Créer**.
5. **Après :** cherchez `rame` - **7 résultats**, les sept ramettes de papier. Cherchez `ramette` -
   les mêmes 7, dans le même ordre.

**À souligner :**

- Pas de développeur, pas de réindexation. Cela s'applique à l'enregistrement.
- Un synonyme réunit des mots qui veulent dire exactement la même chose, dans la langue de la
  boutique : un mot courant, un mot régional, une abréviation. Il marche dans tous les sens.
- Un mot large qui doit ramener des mots plus précis (`siège` pour les chaises et les fauteuils)
  n'est pas un synonyme. En synonyme, `chaise` ramènerait aussi les fauteuils. C'est une
  expansion - étape suivante.
- N'utilisez pas un thésaurus pour traduire (`pen` = `stylo`). Chaque langue a son propre
  catalogue et son propre thésaurus.
- Le thésaurus compare le mot exact : `rames`, au pluriel, ne trouve toujours rien.

### 2.2 Créer une expansion

1. **Avant :** cherchez `rentrée` - **0 résultat**.
2. **Back office :** **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : "Demo rentrée", Actif : oui
   - Type de contexte : Catalog localisé, puis Catalogue(s) localisé(s) : Le livre & le lièvre France
   - Type de thésaurus : **Expansion**
   - Terme de référence : `rentrée`
   - Termes étendus : `cahier`, `crayon`, `stylo`, `agenda`
4. Cliquez **Créer**.
5. **Après :** cherchez `rentrée` - **46 résultats**, tous de la papeterie : les crayons d'abord,
   puis agendas, cahiers, carnets, encres, stylos. `rentree` sans accent marche aussi.

**À souligner :** une expansion va dans un seul sens. `rentrée` ramène les cahiers ; `cahier` ne
ramène rien de plus. C'est ainsi qu'un marchand prépare une saison, ou fait ramener à un mot
large les mots plus précis.

### 2.3 Répondre aux recherches que personne n'a prévues

1. **Avant :** cherchez `siège de bureau` - **0 résultat**. Pareil pour `meubler un bureau` et
   `histoire de détective`.
2. **Back office :** allez dans **Paramètres > Configurations**, onglet **Recherche vectorielle**.
3. Dans **La configuration s'applique à:**, choisissez Le livre & le lièvre France.
4. Activez **Utiliser en cas d'absence de résultat**. Cliquez **Enregistrer**.
5. **Après :**
   - `siège de bureau` - les chaises de bureau en tête
   - `meubler un bureau` - les bureaux assis-debout en tête
   - `histoire de détective` - Histoires extraordinaires, Nouvelles histoires extraordinaires, puis
     un Sherlock Holmes

**À souligner :** quand la recherche par mots ne trouve rien, Gally cherche par le sens. Le
thésaurus couvre les mots qu'on attend ; ceci couvre ceux auxquels on n'a pas pensé.

**Attention :**

- N'utilisez que ces trois phrases. D'autres donnent des premiers résultats étranges.
- Le compteur affiche environ 100 produits, classés par proximité : c'est la **Valeur K** du même
  formulaire, pas un nombre de produits pertinents. Parlez de la première ligne, pas du nombre.
- À partir d'ici, aucune recherche n'affiche "0 résultat". Toutes les étapes qui partent de 0
  viennent avant celle-ci.

### 2.4 Activer un boost préparé

1. **Avant :** cherchez `cahier`. Cahier piqué Bastide est 4e, Cahier piqué Colombage 6e.
2. **Back office :** **Merchandising > Boosts**. Ouvrez **"Reliure du Nord en tête"**. Il est livré
   désactivé.
3. Cochez **Actif**. Enregistrer.
4. **Après :** cherchez `cahier` - les deux cahiers Reliure du Nord sont 1er et 2e.
5. Cherchez `carnet` - Carnet de croquis Pigeonnier passe de la 4e place à la 1re.

**À souligner :** une règle peut attendre, désactivée ou datée, et passer en ligne au bon moment.

**Attention :** utilisez `cahier`, pas `papier` - sur `papier` les huit premiers ne changent pas.

### 2.5 Créer un boost

1. **Avant :** cherchez `édition` - 69 livres. Un seul des huit premiers porte le badge de
   promotion : Les Confessions, 6e.
2. **Back office :** allez dans **Merchandising > Boosts**, cliquez **Créer boost**.
3. Remplissez :
   - Nom : "Demo promotions", Actif : oui
   - Catalogue(s) localisé(s) : Le livre & le lièvre France
   - Type de requête : **Search result**, Tous les termes de recherches
   - Règle virtuelle : **Ajouter une condition > Condition attribut**, **En promotion** est égal
     **vrai**
   - Modèle : **Constante**, Valeur du boost (%) : 100
4. Cliquez **Créer**.
5. **Après :** cherchez `édition` - **les huit** premiers livres sont en promotion : Les
   Confessions, Les Misérables, Voyage en Italie, Le Voyage du Beagle, et d'autres.
6. Cherchez `bureau` - les bureaux en promotion passent devant aussi.

**À souligner :**

- Le formulaire a un bloc **Preview** : choisissez le catalogue localisé et un terme de recherche,
  puis cliquez **Prévisualiser** pour vérifier la règle avant de l'enregistrer.
- Les boosts s'additionnent. Le boost Reliure du Nord de l'étape 2.4 est toujours actif : un
  cahier Reliure du Nord en promotion reçoit les deux.
- Le popup de la barre de recherche n'est pas concerné. C'est un type de requête à part,
  **Autocomplete**.

### 2.6 Épingler un produit sur la page d'accueil

1. **Avant :** la rangée "Notre sélection" de la page d'accueil montre Crayon graphite Tourbière,
   Roller Lucarne, Roller Colline.
2. **Back office :** allez dans **Merchandising > Catégories**.
3. Dans **Choisir un catalogue**, prenez Le livre & le lièvre ; dans **Choisir une langue**, prenez
   la langue française.
4. Sélectionnez la **catégorie de tête** (**Le livre & le lièvre**) de l'arbre.
5. Vérifiez que **Tri par défaut** est **Position**. Sinon l'épinglage est refusé.
   L'épingle vaut pour toutes les langues de la boutique.
6. Dans la liste des produits, trouvez **Fauteuil de lecture Pigeonnier** (`LLV-MOB-FAU-004`).
7. Cliquez **Épingler** et placez-le en premier. Cliquez **Enregistrer**.
8. **Après :** rechargez la page d'accueil. Le fauteuil ouvre la rangée "Notre sélection".

**À souligner :** la rangée de la page d'accueil, c'est tout le catalogue dans son ordre marchand.
Le marchand décide de ce qui accueille l'acheteur.

### 2.7 Changer le tri par défaut d'une catégorie

1. **Avant :** ouvrez [Mobilier > Bureaux & tables > Bureaux](https://demo.gally.dev/example/papershop_fr/category/cat_llv_40). Pigeonnier (829 €) est premier.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Le livre & le lièvre > Mobilier > Bureaux & tables > Bureaux**.
3. Passez **Tri par défaut** à **Price**. Enregistrer.
4. **Après :** rechargez la boutique avec **F5**. Bureaux s'ouvre du moins cher au plus cher :
   Passerelle 189 €, Guéret 249 €, Colombage 329 €, et Pigeonnier en dernier.

### 2.8 Forcer une facette et la mettre en premier

1. **Avant :** le catalogue entier n'a pas de filtre "Matières durables". Seuls 160 des 250
   produits ont cet attribut - sous la règle des 90 % de l'étape 1.1.
2. **Back office :** allez dans **Recherche > Facettes**. Dans le panneau **Catégories** à gauche,
   sous **Par catégorie**, sélectionnez la catégorie de tête, **Le livre & le lièvre**.
3. Sur la ligne **Matières durables** :
   - Affichage : **Affiché**
   - Position : **1**

   Il n'y a pas de bouton Enregistrer : chaque changement est enregistré tout de suite.
4. **Après :** rechargez. "Matières durables" est le premier filtre, avec une case **Oui**.

**À souligner :** Gally le masquait par défaut. Le marchand a décidé que la durabilité fait vendre,
et l'a mis en premier. Le réglage ne vaut que pour cette catégorie.

### 2.9 Ajouter un attribut à la barre de recherche

1. **Avant :** tapez `cahier`. Sections : Marque, Matière, Couleur, Réglure, Reliure.
2. **Back office :** allez dans **Paramètres**, onglet **Attributs**.
3. Sur **Pays de fabrication**, cochez **Affiché dans l'autocomplete**. La case est enregistrée
   tout de suite, sans bouton Enregistrer.
4. **Après :** tapez `cahier` - une nouvelle section Pays de fabrication : France 4, Allemagne 1,
   Espagne 1.
5. Tapez `bureau` - la même section, avec la Pologne en tête. Les valeurs suivent la requête.

### 2.10 Rendre une catégorie virtuelle

1. **Avant :** ouvrez [Mobilier > Accessoires d'atelier](https://demo.gally.dev/example/papershop_fr/category/cat_llv_52). 5 produits, tous des serre-livres.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Le livre & le lièvre > Mobilier > Accessoires d'atelier**.
3. Activez **Catégorie virtuelle**.
4. Règle : **Marque** est égal **Lumen Atelier**. Enregistrer.
5. **Après :** rechargez. **25 produits** venus de toute la boutique : lampes, liseuses, calendriers,
   carnets, encres, et même des livres - tout ce que fait la marque. Les serre-livres ont quitté la
   catégorie : dans une catégorie virtuelle, la règle remplace la liste des produits. La liste de Mobilier passe de 70 à 87 produits.

**À souligner :**

- La boutique a déjà une catégorie de ce genre : "Sélection éco-responsable".
- Une catégorie virtuelle se tient à jour toute seule : un nouveau produit Lumen Atelier y apparaît
  de lui-même.

### 2.11 Créer des produits associés pour toute une catégorie

1. **Avant :** ouvrez [Orgueil et Préjugés](https://demo.gally.dev/example/papershop_fr/product/LLV-LIV-CLA-001) (`LLV-LIV-CLA-001`). Le bandeau "Vous aimerez aussi"
   montre du cross-sell : un carnet de croquis, une ramette, un trieur, un fauteuil. Cette boutique
   n'a aucune règle de produits associés.
2. **Back office :** allez dans **Merchandising > Recommandations > Recommandations automatiques**, cliquez
   **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo related"
   - Catalogue(s) localisé(s) : Le livre & le lièvre France
   - Applied to : **Related product**
4. Règle source (**Source rule engine**) - quels produits reçoivent la recommandation :
   1. Cliquez **Ajouter une condition**, puis **Condition attribut**.
   2. Attribut : **Catégorie**. Opérateur : **est égal**.
   3. Dans l'arbre des catégories, choisissez **Le livre & le lièvre > Livres > Romans & littérature > Littérature
      classique**.
5. Règle cible (**Target rule engine**) - ce qui est recommandé : la même condition, la même catégorie.
6. Cliquez **Créer**.
7. **Après :** rechargez le livre. Le bandeau montre six autres classiques : Les Misérables,
   Madame Bovary, Les Hauts de Hurlevent, De grandes espérances, Moby Dick, La Métamorphose.
8. Ouvrez **Moby Dick** - il reçoit lui aussi six classiques, sans Moby Dick lui-même.
9. Ouvrez **Le Chien des Baskerville**, un roman policier - rien n'a changé.

**À souligner :**

- Une règle, aucune liste de produits : elle couvre les 12 classiques, et un classique ajouté
  demain la rejoint tout seul.
- La boutique demande d'abord les produits associés, et se rabat sur le cross-sell quand il n'y en
  a pas.
- Ce sont des règles, pas un apprentissage sur les acheteurs. La liste vient dans un ordre fixe, moins le
  produit affiché - "le même rayon", pas une recommandation personnelle.

### 2.12 Créer un cross-sell pour le panier

1. **Avant :** ajoutez [Stylo plume Encrier](https://demo.gally.dev/example/papershop_fr/product/LLV-PAP-PLU-001) (`LLV-PAP-PLU-001`) au panier et ouvrez le panier.
   Pas de bandeau de suggestion.
2. **Back office :** **Merchandising > Recommandations > Recommandations automatiques**, cliquez **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo cross-sell"
   - Catalogue(s) localisé(s) : Le livre & le lièvre France
   - Applied to : **Cross-sell**
4. Règle source (**Source rule engine**) : **Catégorie** est égal **Le livre & le lièvre > Papeterie > Écriture > Stylos plume**.
5. Règle cible (**Target rule engine**) : **Catégorie** est égal **Le livre & le lièvre > Papeterie > Écriture > Encres & recharges**.
6. Cliquez **Créer**.
7. **Après :** rechargez le panier. Un bandeau "Complète bien votre panier" montre les sept
   encres : Bleu Frimaire, Noir Ardoise, Sauge Clairière, et les autres.
8. Remplacez le stylo par **Stylo plume Sillage** - les mêmes sept encres. Tout stylo plume les
   reçoit.

**À souligner :** avec deux produits dans le panier, les suggestions des deux sont réunies, jusqu'à
huit.

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
   cliquez une ligne pour le détail de ce produit. Essayez `édition`, avec le boost de l'étape 2.5
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
- **Après l'étape 2.10, le bandeau de Mobilier indique toujours 70 produits** - c'est la boutique ;
  la liste en dessous en compte bien 87. Montrez la liste.
- **Le popup ne montre ni articles ni recherches suggérées** - la fenêtre de la boutique fait 768
  pixels ou moins, le popup utilise donc des onglets. Élargissez la fenêtre, ou cliquez **Blog**
  ou **Suggestions**.
- **Un boost ne change rien** - vérifiez le terme cherché. Chaque étape de boost indique le terme à
  utiliser.
- **Le bandeau du panier n'apparaît pas** - vérifiez que c'est bien le stylo, et pas un autre
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
- l'upsell : Gally a des règles d'upsell, mais la boutique ne les affiche jamais

## À éviter dans cette boutique

Les résultats ci-dessous sont ceux de l'état de départ. Après l'étape 2.3, une recherche qui ne
trouvait rien renvoie à la place la liste de la recherche vectorielle.

- **Chercher un nom de catégorie** - `policier` et `classique` ne renvoient rien, alors que ces
  catégories existent.
- **Faire glisser le filtre de prix** - sa plage est fausse. Utilisez le tri par prix à la place.

## Remise à zéro

Parcourez cette liste après la démo, ou avant si la vérification de l'état de départ a échoué.

1. Recherche > Thésaurus - supprimez "Demo rame" et "Demo rentrée".
2. Paramètres > Configurations, onglet Recherche vectorielle, Le livre & le lièvre France -
   Utiliser en cas d'absence de résultat **désactivé**.
3. Merchandising > Boosts - supprimez "Demo promotions" ; "Reliure du Nord en tête" **désactivé**.
4. Merchandising > Catégories, catégorie de tête (**Le livre & le lièvre**) - Fauteuil de lecture Pigeonnier **désépinglé**.
5. Merchandising > Catégories, **Le livre & le lièvre > Mobilier > Bureaux & tables > Bureaux** - Tri par défaut **Position**.
6. Merchandising > Catégories, **Le livre & le lièvre > Mobilier > Accessoires d'atelier** - Catégorie virtuelle **désactivée**, règle vidée.
7. Recherche > Facettes, panneau Catégories, catégorie de tête (**Le livre & le lièvre**), Matières durables - Affichage **Auto**, sans
   position.
8. Paramètres, onglet Attributs - Pays de fabrication, Affiché dans l'autocomplete
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
l'API du back office : les étapes dans cet ordre, chaque changement gardé, puis la remise à zéro.
Le 2026-11-09, un script Playwright a parcouru tout le guide dans les écrans du back office et de
la boutique, et ses libellés ont été corrigés d'après ce passage. Les autres boutiques d'exemple sont décrites dans leurs fiches - voir
[`README.md`](README.md).
