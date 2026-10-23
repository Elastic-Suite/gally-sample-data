# Venia & Luma - données du catalogue

> Fiche catalogue. Pour mener la démo, utilisez [`demo-default.md`](demo-default.md).

La boutique d'exemple d'origine, celle sur laquelle le storefront s'ouvre. Trois catalogues :
**Venia** (mode femme et bijoux, `com_en` / `com_fr`), **Luma** (sport, `fr_en` / `fr_fr`) et un
troisième, `en_en` / `en_fr`, où rien n'est indexé. Utiliser l'**anglais** (`com_en`) : les produits
sont rédigés en anglais, donc la recherche vectorielle y marche le mieux, et l'historique de
recherche français a expiré.

Les démos sont listées dans [README.md](README.md).

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 85 dans Venia. Luma en a 183 mais rien n'est configuré autour |
| Rayons | Venia : accessoires et bijoux, hauts, bas, robes, plus des ensembles "Shop The Look" |
| Langues | anglais `com_en` et français `com_fr` pour Venia ; `fr_en` / `fr_fr` pour Luma ; `en_en` / `en_fr` vides |
| Catégories | 19 |
| Prix | de 15 à 156 |
| Rupture de stock | 22 sur 85, la plus forte proportion des quatre boutiques |
| En promotion | 9 produits |
| Articles | 57, de loin la plus grande partie éditoriale, avec des suggestions par thème, tag et auteur |
| Types de produits | tous - 70 avec variantes, plus un bundle, un lot groupé et un produit virtuel |
| Attributs en autocomplétion | Color, Material, Size, Style |

## Catégories

Venia, `com_en`. Le nombre de produits vient des fixtures, les facettes et les prix d'un contrôle
en direct.

| Catégorie | Id | Produits | Particularité |
|---|---|---|---|
| Accessories | `cat_3` | 24 | pas de facette Size, Style ni Brand |
| Belts | `cat_4` | 4 | a une facette Size (4 options) |
| Jewelry | `cat_5` | 14 | prix de 48 à 156, 8 tranches de prix |
| Tops | `cat_8` | 24 | Blouses & Shirts 12 + Sweaters 12 ; facettes Size et Style |
| Bottoms | `cat_11` | 24 | prix de 78 à 118 |
| Dresses | `cat_14` | 12 | 8 en stock, 4 en rupture ; le boost "Tank dress" s'applique ici |
| Shop The Look | `cat_15` | 10 | ensembles de produits présentés ensemble |

## Produits à connaître

| SKU | Nom ou type | Pourquoi |
|---|---|---|
| `VSK12` | configurable | 20 combinaisons de couleur et de taille derrière une seule carte |
| `VA24` | bundle | l'article le plus cher, 156 ; contient `VA13-GO-NA` et `VA17-SI-NA` |
| `VA23` | lot groupé | trois produits vendus ensemble |
| `VVP01` | virtuel | un service plutôt qu'un objet, et le moins cher de la boutique |
| `VA13-GO-NA` | simple | en promotion, 78 au lieu de 98 barré, deux badges à la fois ; chercher le SKU renvoie d'abord `VA24` |
| `VA17-SI-NA` | simple | en rupture de stock ; chercher le SKU renvoie d'abord `VA24` |
| `VA11-GO-NA` | simple | une seule matière, donc le badge "100 %" |
| `VD10` | Claudia Crochet Dress | 11e dans la liste Dresses par défaut, sous les cinq robes Tank remontées par le boost |

## Recherches à connaître

| Terme | Langue | Résultat mesuré | Ce que ça montre |
|---|---|---|---|
| `dress` | `com_en` | 18 produits ; les cinq sections de suggestions remplies | robes Tank en tête (boost) ; la popup propose Color, Material, Size, Style |
| `robe` | `com_en` | les mêmes robes | synonyme de `dress`, sans le boost |
| `trousers` | `com_en` | 29 pantalons et shorts | thésaurus d'expansion ; 0 quand ce thésaurus est désactivé |
| `skrit`, `sweter`, `kardigan` | `com_en` | 13, 16, 7 | fautes corrigées : jupes, pulls, cardigans |
| `skirts` | `com_en` | 13, même top 3 que `skirt` | pluriel géré |
| `lace` | `com_en` | 6 | une correspondance dans le nom pèse environ 8 fois plus qu'une dans la description |
| `jewellery`, `wedding guest outfit`, "something to wear to the beach", `gift for my wife` | `com_en` | 0 depuis la barre de recherche | suggestions de la page de recherche vectorielle auxquelles la recherche par mots ne répond pas |
| `cardigan` | `com_en` | la recherche par mots s'en sort | le témoin parmi les suggestions de la recherche vectorielle |

## Merchandising configuré

- **Boost "Tank dress"** - actif, +100, `com_en` et `com_fr`. Remonte les produits dont le nom
  contient "Tank" sur les recherches contenant "Dress" et dans la catégorie Dresses `cat_14`. Cinq
  robes Tank arrivent en tête dans les deux cas. Ne s'applique pas à `robe`.
- **Thésaurus**
  - synonyme `robe` = `dress` (`com_en`, `com_fr`, `fr_en`)
  - expansion `trousers` -> `pants`, `shorts` (`com_en`, `fr_en`)
  - expansion `blazer` -> `jackets`, `tanks`, portée par locale (fr_FR, fr_CA), donc présente sur
    toutes les vitrines françaises
- **Catégories construites par une règle (virtuelles)** - aucune.
- **Recommandations** - aucune.
- **Attributs en autocomplétion** - `fashion_color`, `fashion_material`, `fashion_size`,
  `fashion_style`.
- **Recherches populaires** - `com_en` suggère 10 termes pour `dress` ; `com_fr` n'en suggère aucun
  pour `dress` ni `robe`.
- **Recherche vectorielle** - le nom du produit est vectorisé (réglage commun à toutes les
  boutiques). La page de recherche vectorielle propose cinq suggestions écrites pour cette
  boutique. "Use on no result" est désactivé : une phrase comme "something light to wear on a hot
  day at the beach" renvoie 0 depuis la barre de recherche.

## Lacunes connues

- Le français est faible : la liste des recherches populaires est vide et les descriptions produit
  sont en anglais.
- Le troisième catalogue (`en_en` / `en_fr`) n'a rien d'indexé.
- Luma a des produits et partage quelques synonymes avec Venia, mais pas de contenu éditorial ni de
  boost.
- Pas de recommandations ni de catégorie construite par une règle. Toolbox Bricolage et Le livre &
  le lièvre en ont chacune une.
- Aucune facette Brand n'apparaît dans une catégorie de `com_en` : la marque couvre 4 produits sur
  24 dans Accessories, sous le seuil d'affichage.
- Aucun ordre de tri de facette ne donne les tailles dans l'ordre XS, S, M, L, XL.

## Sources

Comptages mesurés le 2026-08-13 ; recherches et pages vérifiées le 2026-10-23 ; catégories,
facettes et fautes d'orthographe vérifiées en direct le 2026-11-02 ; nombre de produits par
catégorie tiré des fixtures.
