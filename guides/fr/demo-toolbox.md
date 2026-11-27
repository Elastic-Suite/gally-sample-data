[English](../en/demo-toolbox.md)

# Guide de démo Gally - Toolbox Bricolage

> Script de démo. Pour les faits et chiffres de cette boutique, voir [`catalog-toolbox.md`](catalog-toolbox.md).

Ce guide déroule une démo Gally dans deux fenêtres : le back office et la boutique d'exemple. On
fait quelque chose dans le back office, on recharge la boutique, et on montre ce qui est apparu.

- **Public :** un marchand ou un product owner - quelqu'un qui utilisera le back office.
- **La question à laquelle il répond :** "qu'est-ce que je contrôle, et qu'est-ce que j'obtiens
  sans rien faire ?"
- **Il vous faut :** des notions de base de Gally (ce que sont un catalogue, une facette, un boost)
  et une pile locale avec les données d'exemple chargées.
- **Boutique utilisée :** Toolbox Bricolage (`toolbox_fr`) : électroportatif, outillage à main,
  peinture, jardin et équipements de protection, en français. Ses chiffres et références sont dans
  [`catalog-toolbox.md`](catalog-toolbox.md).
- **Durée :** environ 30 minutes, ou 20 sans la partie 1.

Le guide a trois parties :

1. **Ce que Gally fait tout seul** - rien de configuré, boutique seulement.
2. **Action et réaction** - 12 actions dans le back office. Chacune s'ajoute aux précédentes.
   Rien n'est annulé avant la fin de la démo.
3. **Dans l'autre sens** - ce que la boutique renvoie au back office.

---

## Avant de commencer

1. Ouvrez la boutique : `https://demo.gally.dev/example/toolbox_fr`. La page d'accueil doit
   s'afficher.
2. Ouvrez le back office : `https://demo.gally.dev/fr`. Connectez-vous avec `admin@example.com` /
   `apassword`.
3. Placez les deux fenêtres côte à côte. Gardez la fenêtre de la boutique **plus large que 768
   pixels** : plus étroite, le popup de recherche passe en onglets (Produits, Blog, Suggestions) et
   ne montre que l'onglet Produits tant qu'on n'en clique pas un autre.
4. Vérifiez l'état de départ dans la boutique :
   - chercher `clé anglaise` - **2 résultats**, les jeux de clés Torx et Allen
   - chercher `printemps` - **0 résultat**
   - chercher `gants jardinage` - **0 résultat**
   - la rangée "Notre sélection" de la page d'accueil commence par Ponceuse à bande 900W 75 x 533 mm

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
| 1.4 | boutique | chercher `carrelage` | les noms avant les descriptions |
| 1.5 | boutique | taper dans la barre de recherche | des suggestions qui suivent la requête |
| 1.6 | boutique | taper, puis chercher `peinture` | produits et articles depuis une seule barre |
| 2.1 | back office | créer un synonyme | 2 mauvais résultats deviennent 3 clés à molette |
| 2.2 | back office | créer une expansion | 0 résultat devient 15 produits de jardin |
| 2.3 | back office | activer la recherche vectorielle sans résultat | des phrases courtes trouvent gants et lunettes |
| 2.4 | back office | activer un boost préparé | les outils brushless prennent la tête |
| 2.5 | back office | créer un boost | les produits en promotion prennent la tête |
| 2.6 | back office | épingler un produit | la page d'accueil change |
| 2.7 | back office | changer le tri par défaut d'une catégorie | la catégorie s'ouvre par prix |
| 2.8 | back office | forcer une facette et la déplacer | un filtre masqué apparaît en premier |
| 2.9 | back office | ajouter un attribut à l'autocomplétion | une nouvelle section dans la barre de recherche |
| 2.10 | back office | rendre une catégorie virtuelle | 6 produits deviennent 50 |
| 2.11 | back office | créer des produits associés pour une catégorie | chaque outil de mesure en montre d'autres |
| 2.12 | back office | créer un cross-sell entre catégories | tout tournevis suggère des embouts |
| 3 | les deux | ouvrir Analyse | l'activité de la boutique dans le back office |

---

## Partie 1 - Ce que Gally fait tout seul

Aucune facette de cette boutique n'a été configurée. Dites-le d'abord : tout dans cette partie est
le comportement par défaut de Gally.

### 1.1 Des filtres qui suivent la catégorie

1. Ouvrez la catégorie de tête, [Toolbox Bricolage](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_1), et regardez les filtres du catalogue entier (525 produits) :
   Catégorie, Prix, Disponibilité, Nouveauté, En promotion.
2. Ouvrez [Outillage électroportatif](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_10) (61 produits). S'ajoutent : Tension, Type de moteur,
   Vitesses, Sans fil, Marque.
3. Ouvrez [Peinture & Décoration > Peintures murales](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_32) (10 produits). Ceux-là ont disparu. S'ajoutent : Couleur,
   Finition, Rendement, Séchage rapide, Marque.
4. Ouvrez [Sécurité & EPI](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_68) (35 produits). S'ajoutent : Tailles disponibles, Haute visibilité,
   Niveau de confort.

**À souligner :** Gally n'affiche un filtre que si au moins 90 % des produits de la page ont cet
attribut. Il le recalcule pour chaque page, chaque recherche et chaque filtre. Une boutique qui
vend de l'électroportatif et de la peinture obtient des filtres différents pour chacun, sans rien
faire.

### 1.2 Des compteurs qui restent complets

1. Ouvrez [Outillage électroportatif](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_10) (61 produits).
2. Dans **Marque**, cochez **TurboTec**.

**Vous devez voir :**

- 9 produits.
- Le filtre Marque liste toujours toutes les marques avec leur compteur complet : ForceMax 50,
  TurboTec 9, AtelierPro 1. L'acheteur peut ajouter une deuxième marque.
- Tension ne compte plus que les produits TurboTec : 18V 8, 12V 1.

### 1.3 Fautes de frappe et mots qui se prononcent pareil

1. Cherchez `ponseuse` - les ponceuses, avec les mêmes trois premiers que `ponceuse`.
2. Cherchez `meleuse` - les mêmes 12 résultats que `meuleuse`.
3. Cherchez `kable` - les mêmes 6 résultats que `cable`.

**À souligner :**

- Les étapes 1-2 relèvent de la tolérance aux fautes.
- L'étape 3 change la première lettre, ce que la tolérance aux fautes ne fait jamais. Elle marche
  parce que les mots se prononcent pareil (correspondance phonétique).
- Aucun message "vouliez-vous dire". L'acheteur obtient simplement des résultats.

### 1.4 Le nom compte plus que la description

1. Cherchez `carrelage` - 10 produits.

**Vous devez voir :**

- D'abord, quatre produits dont le nom correspond : Disque diamant carrelage, puis trois trépans
  pour carrelage (Trépan Ø 55, Trépan Ø 35, Coffret 4 trépans).
- En dernier, six produits qui ne parlent de carrelage que dans leur description, comme Maillet
  caoutchouc et Mastic silicone.

**À souligner :** par défaut, le nom du produit pèse dix fois plus que les autres champs.

### 1.5 Des suggestions qui suivent la requête

1. Tapez `peinture` et attendez, sans appuyer sur Entrée. Les sections d'attributs sont Couleur (Blanc, Gris, Noir) et
   Marque.
2. Tapez `clé` et attendez, sans appuyer sur Entrée. Les sections sont Matériau (Acier chrome-vanadium, Acier S2) et
   Marque.
3. Tapez `sci` et attendez, sans appuyer sur Entrée. Section **Recherches populaires** : "scie à onglet", "scie circulaire", "scie
   sabre" et d'autres.

Dans une fenêtre étroite, les recherches suggérées sont sous l'onglet **Suggestions**.

**À souligner :**

- Le marchand choisit quels attributs peuvent apparaître. Gally choisit ceux qui conviennent à la
  requête, et leurs valeurs.
- Les recherches suggérées viennent de ce que les acheteurs ont réellement cherché dans cette
  boutique.

### 1.6 Une barre de recherche, plusieurs types de contenu

1. Tapez `peinture` et attendez, sans appuyer sur Entrée. Sous les catégories, le popup a une section
   **Blog** : les articles qui correspondent au mot, les mêmes qu'à l'étape 3. Si le popup montre
   des onglets, la fenêtre est trop étroite : cliquez **Blog**.
2. Appuyez sur Entrée. La page de résultats montre 49 produits.
3. Passez de **Produits** à **Articles**. 2 articles, menés par "Quel rouleau pour quelle peinture" et "Peindre un mur sans laisser de traces".

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

1. **Avant :** cherchez `clé anglaise` - **2 résultats**, et tous deux sont faux : Jeu de 9 clés
   Torx et Jeu de 9 clés Allen. Les acheteurs disent clé anglaise, le catalogue dit clé à
   molette. Les deux mots désignent le même outil.
2. **Back office :** allez dans **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : au choix, par exemple "Demo clé anglaise"
   - Actif : oui
   - Type de contexte : **Catalog localisé**, puis Catalogue(s) localisé(s) : Toolbox Français
   - Type de thésaurus : **Synonyme**
   - Synonymes : `clé anglaise`, `clé à molette`
4. Cliquez **Créer**.
5. **Après :** cherchez `clé anglaise` - **3 résultats**, les trois clés à molette : Clé à
   molette 250 mm chromée FluxPro, Clé à molette 250 mm ouverture 30 mm, Clé à molette 300 mm
   ouverture 36 mm. Cherchez `clé à molette` - les mêmes 3.

**À souligner :**

- Pas de développeur, pas de réindexation. Cela s'applique à l'enregistrement.
- Un synonyme réunit des mots qui veulent dire exactement la même chose, dans la langue de la
  boutique : un mot courant, un mot régional, une abréviation. Il marche dans tous les sens.
- Un mot large qui doit ramener des mots plus précis (`luminaire` pour les ampoules et les spots)
  n'est pas un synonyme. En synonyme, `ampoule` ramènerait aussi les spots et les projecteurs.
  C'est une expansion - étape suivante.
- N'utilisez pas un thésaurus pour traduire (`drill` = `perceuse`). Chaque langue a son propre
  catalogue et son propre thésaurus.
- Le thésaurus compare les mots exacts : chercher `clé` seul donne toujours les mêmes 18
  résultats.

### 2.2 Créer une expansion

1. **Avant :** cherchez `printemps` - **0 résultat**.
2. **Back office :** **Recherche > Thésaurus**, cliquez **Créer thésaurus**.
3. Remplissez :
   - Nom : "Demo printemps", Actif : oui
   - Type de contexte : Catalog localisé, puis Catalogue(s) localisé(s) : Toolbox Français
   - Type de thésaurus : **Expansion**
   - Terme de référence : `printemps`
   - Termes étendus : `tondeuse`, `taille-haie`, `arrosage`, `sécateur`, `terreau`
4. Cliquez **Créer**.
5. **Après :** cherchez `printemps` - **15 résultats**, dont 12 du rayon jardin : terreau,
   sécateurs, lance d'arrosage, programmateur d'arrosage, tondeuses.

**À souligner :** une expansion va dans un seul sens. `printemps` ramène les tondeuses ;
`tondeuse` renvoie toujours ses 5 produits. C'est ainsi qu'un marchand prépare une saison, ou
qu'un mot large ramène les mots plus précis.

### 2.3 Répondre aux recherches que personne n'a prévues

1. **Avant :** cherchez `gants jardinage` - **0 résultat**. Pareil pour `lunettes bricolage` et
   `lunettes soudure`.
2. **Back office :** allez dans **Paramètres > Configurations**, onglet **Recherche vectorielle**.
3. Dans **La configuration s'applique à:**, choisissez Toolbox Français.
4. Activez **Utiliser en cas d'absence de résultat**. Cliquez **Enregistrer**.
5. **Après :**
   - `gants jardinage` - trois paires de gants en tête
   - `lunettes bricolage` - trois paires de lunettes de protection en tête
   - `lunettes soudure` - des lunettes de protection en tête

**À souligner :** quand la recherche par mots ne trouve rien, Gally cherche par le sens. Le
thésaurus couvre les mots qu'on attend ; ceci couvre ceux auxquels on n'a pas pensé.

**Attention :**

- N'utilisez que des groupes nominaux courts comme ceux-ci. Les phrases complètes ("réparer une
  fuite", "peindre une chambre") donnent ici des premiers résultats sans rapport.
- Le compteur affiche environ 100 produits, quelle que soit la phrase : c'est la **Valeur K** du même
  formulaire, pas un nombre de produits pertinents. Parlez de la première ligne, pas du nombre.
- À partir d'ici, aucune recherche n'affiche "0 résultat". Toutes les étapes qui partent de 0
  viennent avant celle-ci.

### 2.4 Activer un boost préparé

1. **Avant :** cherchez `sans fil` - 44 produits, aucun outil brushless dans les huit premiers.
2. **Back office :** **Merchandising > Boosts**. Ouvrez **"Brushless en tête"**. Il est livré
   désactivé.
3. Cochez **Actif**. Enregistrer.
4. **Après :** cherchez `sans fil` - les six premiers sont tous les outils brushless.
5. Cherchez `meuleuse` - Meuleuse Brushless passe de la 8e place à la 1re.

**À souligner :** une règle peut attendre, désactivée ou datée, et passer en ligne au bon moment.

**Attention :** utilisez `sans fil` ou `meuleuse`. Sur `scie` ou `ponceuse` rien ne change - pas
de modèle brushless.

### 2.5 Créer un boost

1. **Avant :** cherchez `coffret`. Les deux premiers produits en promotion sont 5e et 19e. Cherchez `scie` :
   aucune promotion dans les huit premiers.
2. **Back office :** allez dans **Merchandising > Boosts**, cliquez **Créer boost**.
3. Remplissez :
   - Nom : "Demo promotions", Actif : oui
   - Catalogue(s) localisé(s) : Toolbox Français
   - Type de requête : **Search result**, Tous les termes de recherches
   - Règle virtuelle : **Ajouter une condition > Condition attribut**, **En promotion** est égal
     **vrai**
   - Modèle : **Constante**, Valeur du boost (%) : 100
4. Cliquez **Créer**.
5. **Après :** cherchez `coffret` - Coffret 25 forets HSS et Coffret 9 scies cloches, tous deux
   avec le badge "En promo", sont 1er et 2e.
6. Cherchez `scie` - Scie à onglet radiale 1800W et Scie circulaire sur table 1500W, toutes deux
   en promotion, sont 1re et 2e.

**À souligner :**

- Le formulaire a un bloc **Preview** : choisissez le catalogue localisé et un terme de recherche,
  puis cliquez **Prévisualiser** pour vérifier la règle avant de l'enregistrer.
- Le boost multiplie le score, il ne le remplace pas : un produit qui correspond mal à la
  recherche reste bas, même en promotion.
- Les boosts s'additionnent. Le boost "Brushless en tête" de l'étape 2.4 est toujours actif : un
  outil brushless en promotion reçoit les deux. Sur `sans fil`, deux kits de perceuse en promotion
  arrivent maintenant 5e et 6e, parmi les outils brushless.

### 2.6 Épingler un produit sur la page d'accueil

1. **Avant :** la rangée "Notre sélection" de la page d'accueil montre Ponceuse à bande 900W,
   Ponceuse vibrante 1/3 de feuille 220W, Ponceuse excentrique filaire 400W.
2. **Back office :** allez dans **Merchandising > Catégories**.
3. Dans **Choisir un catalogue**, prenez Toolbox Bricolage ; dans **Choisir une langue**, prenez
   la langue française.
4. Sélectionnez la **catégorie de tête** (**Toolbox Bricolage**) de l'arbre.
5. Vérifiez que **Tri par défaut** est **Position**. Sinon l'épinglage est refusé.
   L'épingle vaut pour toutes les langues de la boutique.
6. Dans la liste des produits, trouvez **Perceuse-visseuse Brushless Kit 2x5Ah**
   (`TBX-ELP-PV-004`).
7. Cliquez **Épingler** et placez-la en premier. Cliquez **Enregistrer**.
8. **Après :** rechargez la page d'accueil. La perceuse ouvre la rangée "Notre sélection", avec
   son badge de promotion.

**À souligner :** la rangée de la page d'accueil, c'est tout le catalogue dans son ordre marchand.
Le marchand décide de ce qui accueille l'acheteur.

### 2.7 Changer le tri par défaut d'une catégorie

1. **Avant :** ouvrez [Outillage électroportatif > Scies électriques](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_15). Scie circulaire TurboTec (139,90 €) est première.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Toolbox Bricolage > Outillage électroportatif > Scies électriques**.
3. Passez **Tri par défaut** à **Price**. Enregistrer.
4. **Après :** rechargez la boutique avec **F5**. Scies électriques s'ouvre du moins cher au plus
   cher : Scie sauteuse filaire à 69,90 €, et Scie à onglet radiale à 269,90 € en dernier.

### 2.8 Forcer une facette et la mettre en premier

1. **Avant :** le catalogue entier n'a pas de filtre "Marque". 388 des 525 produits ont une
   marque (74 %) - sous la règle des 90 % de l'étape 1.1. L'outillage à main et les accessoires
   n'en ont pas.
2. **Back office :** allez dans **Recherche > Facettes**. Dans le panneau **Catégories** à gauche,
   sous **Par catégorie**, sélectionnez la
   catégorie de tête, **Toolbox Bricolage**.
3. Sur la ligne **Marque** :
   - Affichage : **Affiché**
   - Position : **1**

   Il n'y a pas de bouton Enregistrer : chaque changement est enregistré tout de suite.
4. **Après :** rechargez. "Marque" est le premier filtre : ForceMax 71, VoltSafe 55, AtelierPro
   50, FixMaster 48, et les autres.

**À souligner :** Gally le masquait par défaut. Le marchand a décidé que les marques font vendre,
et les a mises en premier. Le réglage ne vaut que pour cette catégorie.

### 2.9 Ajouter un attribut à la barre de recherche

1. **Avant :** tapez `visseuse`. Pas de section de tension.
2. **Back office :** allez dans **Paramètres**, onglet **Attributs**.
3. Sur **Tension**, cochez **Affiché dans l'autocomplete**. La case est enregistrée
   tout de suite, sans bouton Enregistrer.
4. **Après :** tapez `visseuse` - une nouvelle section Tension : 18V 10, 12V 2, 230V 2.
5. Tapez `meuleuse` - la même section avec 18V 4, 230V 3. Les valeurs suivent la requête.

### 2.10 Rendre une catégorie virtuelle

1. **Avant :** ouvrez [Machines d'atelier > Accessoires d'atelier](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_84). 6 produits.
2. **Back office :** **Merchandising > Catégories**, sélectionnez **Toolbox Bricolage > Machines d'atelier > Accessoires d'atelier**.
3. Activez **Catégorie virtuelle**.
4. Règle : **Marque** est égal **AtelierPro**. Enregistrer - deux fois si le premier enregistrement
   affiche une erreur.
5. **Après :** rechargez. **50 produits** : les 6 accessoires, la gamme d'aspiration et toutes les
   machines AtelierPro.

**À souligner :**

- La boutique a déjà une catégorie de ce genre : "Univers 18V sans fil".
- Une catégorie virtuelle se tient à jour toute seule : un nouveau produit AtelierPro y apparaît
  de lui-même.

### 2.11 Créer des produits associés pour toute une catégorie

1. **Avant :** ouvrez [Mètre ruban 5 m](https://demo.gally.dev/example/toolbox_fr/product/TBX-OAM-ME-001) (`TBX-OAM-ME-001`). Pas de bandeau de recommandation :
   les outils de mesure n'ont aucune règle.
2. **Back office :** allez dans **Merchandising > Recommandations > Recommandations automatiques**, cliquez
   **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo related"
   - Catalogue(s) localisé(s) : Toolbox Français
   - Applied to : **Related product**
4. Règle source (**Source rule engine**) - quels produits reçoivent la recommandation :
   1. Cliquez **Ajouter une condition**, puis **Condition attribut**.
   2. Attribut : **Catégorie**. Opérateur : **est égal**.
   3. Dans l'arbre des catégories, choisissez **Toolbox Bricolage > Outillage à main > Mesure & Traçage**.
5. Règle cible (**Target rule engine**) - ce qui est recommandé : la même condition, la même catégorie.
6. Cliquez **Créer**.
7. **Après :** rechargez le mètre ruban. Un bandeau montre six autres outils de mesure : Mètre
   ruban 8 m, deux niveaux à bulle, un niveau laser, un télémètre laser, une équerre.
8. Ouvrez **Détecteur de métaux** - il reçoit lui aussi six outils de mesure.
9. Ouvrez **Scie égoïne**, une scie à main - rien n'a changé.

**À souligner :**

- Une règle, aucune liste de produits : elle couvre toute la catégorie, et un nouvel outil de
  mesure la rejoint tout seul.
- Ce sont des règles, pas un apprentissage sur les acheteurs. La liste vient dans un ordre fixe, moins le
  produit affiché - "le même rayon", pas une recommandation personnelle.

### 2.12 Créer un cross-sell pour le panier

1. **Avant :** ajoutez [un tournevis](https://demo.gally.dev/example/toolbox_fr/product/TBX-OAM-TV-001) (`TBX-OAM-TV-001`) au panier et ouvrez le panier. Pas de
   bandeau de suggestion.
2. **Back office :** **Merchandising > Recommandations > Recommandations automatiques**, cliquez **Créer recommandation automatique**.
3. Remplissez :
   - Actif : oui, Nom : "Demo cross-sell"
   - Catalogue(s) localisé(s) : Toolbox Français
   - Applied to : **Cross-sell**
4. Règle source (**Source rule engine**) : **Catégorie** est égal **Toolbox Bricolage > Outillage à main > Tournevis**.
5. Règle cible (**Target rule engine**) : **Catégorie** est égal **Toolbox Bricolage > Accessoires & Consommables > Embouts de vissage**.
6. Cliquez **Créer**.
7. **Après :** rechargez le panier. Un bandeau "Complète bien votre panier" montre huit
   embouts et porte-embouts : Coffret 32 embouts, les lots PH2, PZ2, T20 et T25, un porte-embout, et d'autres.
8. Remplacez le tournevis par [un autre](https://demo.gally.dev/example/toolbox_fr/product/TBX-OAM-TV-004) (`TBX-OAM-TV-004`) - les mêmes huit. Tout tournevis les
   reçoit.

**À souligner :** les perceuses ne sont pas utilisées ici volontairement : chacune a déjà sa
propre règle de cross-sell, le bandeau serait donc déjà à l'écran.

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
   cliquez une ligne pour le détail de ce produit. Essayez `sans fil`, avec le boost de l'étape 2.4
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
- **Le bandeau du panier n'apparaît pas** - vérifiez que c'est bien un tournevis, et pas un autre
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

- **Passer la boutique en anglais** - certains produits y ont un autre nom : `TBX-ELP-PO-004` est
  une ponceuse à bande en français et une ponceuse vibrante en anglais.
- **Le compteur de "Univers 18V sans fil" dans le menu** - il indique 0, alors que la page liste
  les produits. Cliquez dessus.
- **Mal écrire `perceuse` en montrant "Sans fil d'abord"** - ce boost livré se déclenche quand la
  recherche contient "perceuse", donc `perseuse` trouve les perceuses mais sans le boost.
- **La section Tension sur `batterie`** - elle ne montre que 18V et 12V ; la tension des batteries
  est dans un attribut à part, les batteries 36V n'y apparaissent donc pas.

## Remise à zéro

Parcourez cette liste après la démo, ou avant si la vérification de l'état de départ a échoué.

1. Recherche > Thésaurus - supprimez "Demo clé anglaise" et "Demo printemps".
2. Paramètres > Configurations, onglet Recherche vectorielle, Toolbox Français -
   Utiliser en cas d'absence de résultat **désactivé**.
3. Merchandising > Boosts - supprimez "Demo promotions" ; "Brushless en tête" **désactivé**.
4. Merchandising > Catégories, catégorie de tête (**Toolbox Bricolage**) - Perceuse-visseuse Brushless Kit 2x5Ah
   **désépinglée**.
5. Merchandising > Catégories, **Toolbox Bricolage > Outillage électroportatif > Scies électriques** - Tri par défaut **Position**.
6. Merchandising > Catégories, **Toolbox Bricolage > Machines d'atelier > Accessoires d'atelier** - Catégorie virtuelle **désactivée**, règle vidée.
7. Recherche > Facettes, panneau Catégories, catégorie de tête (**Toolbox Bricolage**), Marque - Affichage **Auto**, sans position.
8. Paramètres, onglet Attributs - Tension, Affiché dans l'autocomplete
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
L'étape 2.1 a été mesurée seule, depuis l'état de départ : le parcours cumulé utilisait un autre
synonyme, et aucune étape suivante ne cherche un mot que `clé anglaise` modifie.
Le 2026-11-09, un script Playwright a parcouru le guide de la boutique papershop dans les écrans
du back office et de la boutique, et les libellés d'écran de ce guide ont été corrigés d'après ce
passage. Les compteurs et noms de produits de ce guide n'ont pas été revérifiés à l'écran : ils
viennent de la vérification par l'API décrite ci-dessus. Les autres boutiques d'exemple sont décrites dans leurs fiches - voir
[`README.md`](README.md).
