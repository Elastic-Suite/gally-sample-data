# Fiora Fashion - script de démo

Une boutique de prêt-à-porter. 433 produits, presque tous vendus en plusieurs couleurs et tailles,
trois langues, une seule liste de prix en euros.

**À montrer à** quiconque vend du vêtement, de la chaussure ou autre chose où un produit veut dire
une douzaine de variantes, et à quiconque s'intéresse aux promotions et au contenu éditorial.
C'est le catalogue le plus soigné des quatre et celui à utiliser quand le public achète avec les
yeux.

**Ouvrir** l'application d'exemple Gally et choisir "Fiora Fashion" (`fashion_fr`) dans le
sélecteur de l'en-tête. La démo s'ouvre par défaut sur une autre boutique.

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 433, dont 409 vendus en plusieurs couleurs ou tailles |
| Langues | français, anglais, allemand - un seul catalogue derrière les trois |
| Catégories | 63, sur quatre niveaux, le maximum à égalité avec papershop |
| Prix | de 12,90 € à 349,90 € |
| Rupture de stock | 20 produits, répartis dans tous les rayons |
| En promotion | 72 produits, chacun avec son ancien prix barré |
| Articles | 15, trouvés par la même barre de recherche que les produits |
| Produit le plus large | 27 combinaisons de couleur et de taille, sur chacune de 50 chaussures |

## À connaître par cœur

Collez une référence directement dans la barre de recherche pour accéder au produit.

| Référence | Pourquoi celle-ci |
|---|---|
| `FIO-CHA-BA-001` | **27 combinaisons couleur-taille** sur une fiche, comme 49 autres chaussures |
| `FIO-FRO-RC-001` | huit filtres sur une robe, le maximum pour un produit - 40 robes à égalité |
| `FIO-MAN-BC-001` | 349,90 €, le haut de la gamme |
| `FIO-LIN-CS-002` | 12,90 €, le bas de gamme |
| `FIO-FTP-BL-002` | en promotion, 39,90 € avec 49,90 € barré |
| `FIO-FTP-BL-003` | en rupture de stock, donc "ajouter au panier" est réellement désactivé |

| Recherche | Pourquoi celle-ci |
|---|---|
| `lin` | **remplit six des sept sections de suggestions à la fois**, toutes sauf les recherches populaires - celle sur laquelle marquer une pause |
| `robe` | la règle de tri se déclenche, les promotions passent devant |
| `jupe` | la même boutique sans règle - à lancer juste après |
| `robe` dans la boutique anglaise | le même mot qui fonctionne dans plusieurs langues |
| `bracellet` | une faute d'orthographe, corrigée |

## Le déroulé - environ dix minutes

| | Taper ou cliquer | Ce que ça montre |
|---|---|---|
| 1 | `robe`, puis `jupe` | une règle de tri posée par le marchand, et ses limites |
| 2 | `robe` dans la boutique anglaise | un seul vocabulaire dans trois langues |
| 3 | la basket en cuir blanc | 27 variantes derrière une seule fiche |
| 4 | les filtres d'une catégorie | des filtres qui changent selon ce qu'on regarde |
| 5 | n'importe quel listing | 72 promotions, ancien prix à côté du nouveau |
| 6 | `robe de soirée` | éditorial et produits dans une seule recherche |

---

### 1. Chercher `robe`, puis `jupe`

Les robes reviennent avec celles en promotion en premier. Les jupes reviennent dans l'ordre de
pertinence ordinaire.

Même catalogue, même barre de recherche. Quelqu'un a décidé que sur une recherche de robe, ce qui
est en promotion passe devant - et l'a changé sans développeur. Une deuxième règle est prête et
désactivée ; si vous avez un accès admin, activez-la en direct et refaites la recherche.

### 2. Taper `robe` dans la boutique anglaise

Passez en anglais et cherchez le mot français : les robes sont toujours là. Ça marche aussi en
allemand avec `Kleid`.

Un seul catalogue produit, trois vitrines, et le marchand qui entretient les mots que les clients
tapent réellement dans chaque langue.

### 3. Ouvrir une basket et changer de couleur et de taille

"Basket minimaliste en cuir blanc Essential" est la plus efficace à ouvrir : c'est un seul produit
vendu en **27 combinaisons** de couleur et de taille. "Robe courte en lin lavé Riviera" est un bon
second choix.

Le listing montre une seule fiche, pas 27. C'est tout l'intérêt : le client voit un produit, le
marchand gère les variantes.

### 4. Filtrer une catégorie

**Couleur**, **Matière haut**, **Taille vêtement**, **Pointure**, **Marque**. Les filtres changent
selon ce qu'on regarde : les chaussures proposent une pointure, les hauts proposent une encolure et
une longueur de manche. Ce n'est pas une liste générique unique collée sur chaque produit.

### 5. Montrer les promotions

Soixante-douze produits sont en promotion, chacun avec son ancien prix barré à côté du nouveau.
Combiné à la règle de l'étape 1, c'est une histoire de promotion complète : le marchand signale les
produits, puis décide où ils remontent.

### 6. Chercher `robe de soirée`, puis ouvrir un article

Quinze articles éditoriaux accompagnent le catalogue. Cherchez `robe de soirée` : la page de
résultats compte 10 produits et 2 articles, dont "Choisir sa robe de soirée". Ouvrez-le. La page de
l'article ne renvoie pas elle-même vers des produits.

Ça vaut la peine d'être souligné : le même moteur cherche dans les articles et dans les produits,
donc le contenu éditorial n'est pas un silo à part que personne ne trouve.

---

## Si vous avez plus de temps

- **Faites une faute d'orthographe** : `bracellet` en français, `dres` ou `neckless` en anglais,
  `Ohringe` en allemand. Toutes trouvent la bonne chose.
- **Les prix** vont d'environ 13 à 350 euros.
- **Rupture de stock** : vingt produits dans tous les rayons, donc le filtre de disponibilité
  fonctionne et certains boutons "ajouter au panier" sont réellement désactivés.
- **Décrivez un vêtement plutôt que de le nommer** sur la page de recherche vectorielle. En anglais,
  *"something to wear to the beach"* ramène un poncho de plage et un short de bain ; en français,
  *"tenue de soirée"* place deux robes de soirée dans les quatre premiers. La barre de recherche
  ordinaire renvoie zéro pour les deux. Le modèle est d'abord anglophone : en français et en
  allemand, restez sur des expressions courtes. Faites les deux.
- **Recommandations.** Ouvrez la blouse en soie `FIO-FTP-BL-001` : "Vous aimerez aussi" liste trois
  autres hauts, ses produits associés. Ajoutez-la au panier : le panier propose le pantalon
  cigarette, la jupe crayon, les escarpins Diva 85 et le sac matelassé, ses ventes croisées. Le
  T-shirt `FIO-FTP-TS-001` fonctionne de la même façon. Cette boutique a 52 règles d'association et
  49 de ventes croisées, une par produit.
- **Trois langues** sur la même page, catégories et articles suivant le mouvement.

---

## À ne pas faire

- **Ne promettez pas de tri par une spécification produit.** La liste propose pertinence, nom, prix,
  disponibilité et date de création. Elle affiche aussi Accessory_brand et Date_of_manufacture, des
  libellés bruts venus d'une autre boutique : ignorez-les. Cette boutique n'a pas de spécification
  triable comme celle du bricolage.
- **Ne présentez pas les recommandations comme apprises des clients.** Ce sont des règles qu'un
  marchand a configurées dans Gally ; rien ne lit les données de tracking. Choisissez un produit qui
  en a une (la blouse ou le T-shirt ci-dessus) : un produit sans règle n'affiche aucun bandeau. Les
  61 règles de montée en gamme ne sont affichées nulle part.
- **Servez-vous des requêtes suggérées sur la page de recherche vectorielle : elles sont propres à
  cette boutique.** Chacune a été mesurée ici : les premières ne renvoient rien du tout dans la
  barre de recherche ordinaire (en allemand, seulement les deux premières : `Abendkleid` en trouve
  quatre), et la dernière est un témoin volontaire, que la recherche ordinaire traite très bien.
  Gardez le témoin pour la fin et dites ce qu'il prouve, sinon le public supposera que toute la page
  est truquée.
- **Ne cherchez pas de catégorie construite par règle.** Cette boutique n'en a aucune. Utilisez
  Toolbox Bricolage ou Le livre & le lièvre pour ça.
