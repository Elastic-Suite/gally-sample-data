# Fiora Fashion - données du catalogue

> Fiche catalogue. Pour mener la démo, utilisez [`demo-fashion.md`](demo-fashion.md).

Une boutique de prêt-à-porter : 433 produits, presque tous vendus en plusieurs couleurs et tailles,
une seule liste de prix en euros, un seul catalogue derrière trois vitrines (`fashion_fr`,
`fashion_en`, `fashion_de`). Le français est la langue de référence et marche pour la recherche et
les suggestions. Utiliser l'anglais pour la recherche vectorielle : le modèle est d'abord anglais.

Les démos sont listées dans [README.md](README.md).

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 433, dont 409 vendus en plusieurs couleurs ou tailles |
| Rayons | 6 : Femme 201, Homme 55, Chaussures 50, Sacs & Maroquinerie 35, Accessoires & Bijoux 52, Sport & Performance 40 |
| Langues | français `fashion_fr`, anglais `fashion_en`, allemand `fashion_de` |
| Catégories | 63, quatre niveaux, le maximum, comme papershop et Luma |
| Prix | de 12,90 € à 349,90 € |
| Rupture de stock | 20 produits, répartis dans tous les rayons |
| En promotion | 72 produits, chacun avec son ancien prix barré |
| Articles | 15, trouvés par la même barre de recherche que les produits |
| Types de produits | produit le plus large : 27 combinaisons de couleur et de taille, sur chacune de 50 chaussures |
| Attributs en autocomplétion | couleur, matière, marque |

## Catégories

Nombre de produits tiré des fixtures ; facettes mesurées en direct sur `fashion_en`.

| Catégorie | Id | Produits | Particularité |
|---|---|---|---|
| racine | `cat_fio_1` | 433 | facettes : Category, Price, Availability, New, On sale, Colour, Brand |
| Robes & Combinaisons (Dresses & Jumpsuits) | `cat_fio_16` | 40 | ajoute Clothing size, Dress length, Occasion, Dress fabric, Backless, Dress colour ; le boost promotions s'applique ici |
| Robes de soirée (Evening Dresses) | `cat_fio_20` | 8 | correspond à l'article "Choisir sa robe de soirée" |
| Chaussures (Shoes) | `cat_fio_44` | 50 | ajoute Shoe size, Heel height, Shoe material, Sole type, Vegan |
| Baskets & Sneakers (Trainers & Sneakers) | `cat_fio_45` | 8 | contient la basket à 27 variantes |
| Accessoires & Bijoux (Accessories & Jewelry) | `cat_fio_54` | 52 | pas de facette Colour, seulement Brand |

## Produits à connaître

| SKU | Nom | Pourquoi |
|---|---|---|
| `FIO-CHA-BA-001` | Basket minimaliste en cuir blanc Essential | 27 combinaisons de couleur et de taille sur une seule carte, comme 49 autres chaussures |
| `FIO-FRO-RC-001` | Robe courte en lin lavé Riviera | huit filtres, le maximum - 40 robes sont à égalité |
| `FIO-MAN-BC-001` | Perfecto en cuir d'agneau Rebel | 349,90 €, le haut de la fourchette |
| `FIO-LIN-CS-002` | String en microfibre Seconde Peau | 12,90 €, le bas de la fourchette |
| `FIO-FTP-BL-001` | Blouse en soie col lavallière Éléonore | associés : 3 autres hauts (`BL-002`, `BL-003`, `BL-005`) ; vente croisée : pantalon cigarette, jupe crayon, escarpins Diva 85, sac matelassé `FIO-ACC-SM-002` |
| `FIO-FTP-BL-002` | Top fluide imprimé floral Printemps | en promotion, 39,90 € au lieu de 49,90 € barré |
| `FIO-FTP-BL-003` | Blouse à volants col montant Victoire | en rupture de stock, donc "ajouter au panier" est désactivé |
| `FIO-FTP-TS-001` | T-shirt col rond basique coton bio | règles de produits associés et de vente croisée, comme la blouse |

## Recherches à connaître

| Terme | Langue | Résultat mesuré | Ce que ça montre |
|---|---|---|---|
| `lin` | `fashion_fr` | six des sept sections de suggestions, toutes sauf les recherches populaires | le panneau de suggestions le plus riche |
| `robe` | `fashion_fr` | les 6 premiers tous en promotion | le boost promotions se déclenche ; 8 suggestions de recherches populaires |
| `jupe` | `fashion_fr` | ordre de pertinence simple | pas de boost sur ce terme |
| `chandail` | `fashion_fr` | les pulls | synonyme `chandail` = `pull` |
| `dress` | `fashion_en` | les 6 premiers tous en promotion ; 9 suggestions de recherches populaires | boost ; la popup propose Colour et Brand |
| `bracellet`, `dres`, `neckless`, `Ohringe` | fr, en, en, de | les bons produits | fautes d'orthographe corrigées |
| `robe de soirée` | `fashion_fr` | 10 produits et 2 articles | contenu éditorial et produits dans une même recherche |
| `leather` | `fashion_en` | 100, dont 22 LuxeLine | la requête où le boost LuxeLine inactif se voit quand on l'active |
| "something to wear to the beach" | `fashion_en` | 0 depuis la barre de recherche ; page vectorielle : un poncho de plage, un short de bain | recherche par sens |
| "tenue de soirée" | `fashion_fr` | 0 depuis la barre de recherche ; page vectorielle : deux robes du soir dans les quatre premiers | les phrases courtes en français marchent |

## Merchandising configuré

- **Boosts**
  - "Promotions en tête" - actif, +100, les trois vitrines. Remonte les produits en promotion sur
    les recherches contenant `robe` ou `dress`, et dans `cat_fio_16`. Désactivé, `dress` donne un
    ordre plat et mélangé.
  - "LuxeLine en tête" - inactif, +80, marque = LuxeLine (41 produits sur 433), sur toute
    recherche. Activé : `leather` place cinq produits LuxeLine dans le top 5 ; `dress` et `coat` ne
    changent pas, car il n'existe aucune robe LuxeLine.
- **Thésaurus**
  - synonymes, un thésaurus par vitrine : `chandail` = `pull` (fr), `sweater` = `jumper` (en), `portemonnaie` = `geldbörse` (de)
  - expansion `veste` -> `manteau`, `trench` (`fashion_fr` uniquement, dans un seul sens)
- **Catégories construites par une règle (virtuelles)** - aucune.
- **Recommandations** - 52 produits associés, 49 ventes croisées, 61 montées en gamme, une par
  produit, toutes des règles posées à la main. Le storefront affiche les produits associés ("You May
  Also Like") et la vente croisée (panier), pas la montée en gamme. Sans produits associés, la fiche
  produit se rabat sur la vente croisée.
- **Attributs en autocomplétion** - `fio_color`, `fio_fabric`, `fio_brand`. "Longueur robe" n'est
  pas activé.
- **Recherche vectorielle** - la page de recherche vectorielle propose des requêtes mesurées sur
  cette boutique : les premières renvoient 0 depuis la barre de recherche, la dernière est un
  témoin que la recherche par mots gère bien. En allemand seules les deux premières renvoient 0 :
  `Abendkleid` en trouve quatre.

## Lacunes connues

- Aucune spécification produit triable. La liste de tri propose pertinence, nom, prix,
  disponibilité et date de création, plus Accessory_brand et Date_of_manufacture, des libellés bruts
  venus d'une autre boutique.
- Aucune catégorie construite par une règle. Toolbox Bricolage et Le livre & le lièvre en ont
  chacune une.
- Les recommandations sont des règles, pas un apprentissage sur les données de tracking. Un produit
  sans règle n'affiche aucun bandeau. Les 61 règles de montée en gamme ne sont affichées nulle part.
- Certains SKU portent un nom de produit différent selon la langue, avec le même prix, le même stock
  et la même catégorie : `FIO-FTP-BL-002` est "Top fluide imprimé floral Printemps" en français et
  "Cold shoulder V-neck top Grace" en anglais ; `FIO-FTP-BL-003` est "Blouse à volants col montant
  Victoire" et "Sheer chiffon blouse with ribbon collar Cloud".
- Les pages d'articles ne renvoient pas vers les produits.
- Le modèle vectoriel est d'abord anglais : garder des phrases courtes en français et en allemand.

## Sources et reproduction

Chiffres repris de l'ancien script de démo (date de mesure non notée). Facettes, boosts,
suggestions et recommandations de `fashion_en` / `fashion_fr` vérifiés en direct le 2026-11-02.
Nombre de produits par catégorie, thésaurus et nombre de recommandations recomptés dans les
fixtures (`src/DataFixtures/01_fashion/`).

**Mesuré en direct le 2026-11-27**, sur un chargement neuf de cette branche :

- synonymes : `chandail` et `pull` 19 chacun dans `fashion_fr`, `sweater` et `jumper` 13 dans
  `fashion_en`, `portemonnaie` et `geldbörse` 6 dans `fashion_de`

**Reproduire**

- Chargez-le avec `make fixtures_load catalogs=01_fashion`. La commande efface la base et demande
  confirmation. Ne lui envoyez pas `y` par un pipe sans `catalogs=` : le chargement est sauté sans
  message. Boosts, thésaurus, recommandations et recherche vectorielle demandent les bundles
  premium.
- Un chiffre est **attendu** (lu dans les fixtures de `src/DataFixtures/01_fashion/`) sauf si cette
  section le dit **mesuré** en direct, avec sa date.
- Mesurez sur un chargement neuf, ou après la section Remise à zéro du guide de démo. Ce que la démo
  crée en direct (thésaurus, boosts et réglages nommés dans ses étapes) n'est pas dans les données
  commitées, et change les résultats de recherche.
