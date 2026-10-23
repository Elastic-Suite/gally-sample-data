# Toolbox Bricolage - données du catalogue

> Fiche catalogue. Pour mener la démo, utilisez [`demo-toolbox.md`](demo-toolbox.md).

Une boutique de bricolage et de quincaillerie : 525 produits, une seule liste de prix en euros, un
seul catalogue derrière trois vitrines (`toolbox_fr`, `toolbox_en`, `toolbox_de`). Le français est
la langue de référence. Utiliser l'anglais (`toolbox_en`) pour la recherche vectorielle : le modèle
ne gère bien que l'anglais.

Les démos sont listées dans [README.md](README.md).

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 525, tous vendus à l'unité - pas de variantes |
| Rayons | 11 : outillage à main, électroportatif, batteries et chargeurs, accessoires, peinture, plomberie, électricité, quincaillerie, jardin, sécurité, machines d'atelier |
| Langues | français `toolbox_fr`, anglais `toolbox_en`, allemand `toolbox_de` |
| Catégories | 85, trois niveaux, une construite par une règle |
| Prix | de 3,90 € à 699,90 € |
| Rupture de stock | 11 produits |
| En promotion | 38 produits |
| Articles | 15 |
| Types de produits | simples uniquement ; 47 filtres, dont 6 spécifications triables |
| Attributs en autocomplétion | marque, matériau de l'outil, couleur de peinture |

## Catégories

Nombre de produits tiré des fixtures (`toolbox_fr`), sauf pour la catégorie construite par une
règle.

| Catégorie | Id | Produits | Particularité |
|---|---|---|---|
| Outillage électroportatif (Power Tools) | `cat_tbx_10` | 61 | filtres les plus denses : Sans fil, Tension, Type de moteur, Vitesses, Marque ; aucune valeur de puissance, donc le tri par puissance n'a pas d'effet |
| Perceuses & Visseuses (Drills & Drivers) | `cat_tbx_11` | 10 | perceuses ; les modèles sans fil arrivent en tête sur une recherche `perceuse` |
| Batteries & Chargeurs (Batteries & Chargers) | `cat_tbx_19` | 25 | batteries 12V, 18V, 36V et chargeurs |
| Protection des yeux (Eye Protection) | `cat_tbx_69` | 5 | fait partie de Sécurité & EPI (Safety & PPE, 35 produits) |
| Machines d'atelier (Workshop Machines) | `cat_tbx_76` | 49 | le tri par "Puissance (W)" fonctionne ici, la plus petite machine d'abord |
| Univers 18V sans fil (18V cordless range) | `cat_tbx_85` | 45 | construite par une règle : sans fil, ou batterie 18V ; uniquement dans le menu principal |

## Produits à connaître

| SKU | Nom ou type | Pourquoi |
|---|---|---|
| `TBX-ELP-PV-001` | Perceuse-visseuse sans fil ForceMax 18V 50 Nm | un des 32 produits sans fil que le boost remonte ; a des règles de produits associés, de vente croisée et de montée en gamme |
| `TBX-MAT-TM-002` | Fraiseuse d'établi AtelierPro | 699,90 €, le haut de la fourchette de prix |
| `TBX-PEI-BA-003` | Ruban de masquage peintre bleu | 3,90 €, le bas de la fourchette de prix |
| `TBX-ELP-SE-008` | Scie à onglet 216 mm 1500W | en rupture de stock, donc "ajouter au panier" est désactivé |
| `TBX-OAM-TV-005` | Jeu de 7 tournevis isolés 1000V | en promotion, 34,90 € au lieu de 39,90 € |

## Recherches à connaître

| Terme | Langue | Résultat mesuré | Ce que ça montre |
|---|---|---|---|
| `perceuse` | `toolbox_fr` | les cinq sections de suggestions : recherches populaires, marque, produits, catégorie, articles | le boost sans fil se déclenche ; l'article "Bien choisir sa perceuse-visseuse" est suggéré |
| `ponceuse` | `toolbox_fr` | ordre de pertinence simple | pas de boost sur ce terme |
| `perceuse` | `toolbox_en`, `toolbox_de` | les perceuses | synonyme `perceuse` = `drill` = `bohrschrauber` |
| `Bohrschruber` | `toolbox_de` | les bons produits | faute d'orthographe corrigée |
| `sandre` | `toolbox_en` | les bons produits | faute de frappe pour "sander", tirée de vrais journaux de recherche, corrigée |
| `forcemax` | `toolbox_fr` | trois sections de suggestions, la marque et ses produits | un nom de marque |
| "protect my eyes while drilling" | `toolbox_en` | 0 depuis la barre de recherche ; la page vectorielle renvoie des lunettes-masque, une visière, des lunettes de sécurité | aucun texte produit ne contient "eyes" ni tous les mots |

## Merchandising configuré

- **Boosts**
  - "Sans fil d'abord" - actif, +100, les trois vitrines. Remonte les produits Sans fil = oui sur
    les recherches contenant `perceuse` ou `drill`, et dans la catégorie `cat_tbx_85`.
  - "Brushless en tête" - inactif, +80, type de moteur = brushless, sur toute recherche. Livré
    désactivé pour être activé depuis l'admin.
- **Thésaurus**
  - synonyme `perceuse` = `drill` = `bohrschrauber` (les trois vitrines)
  - expansion `visseuse` -> `perceuse`, `tournevis` (`toolbox_fr` uniquement, dans un seul sens)
- **Catégorie construite par une règle (virtuelle)** - "Univers 18V sans fil" `cat_tbx_85`, 45
  produits : outils sans fil et batteries 18V.
- **Recommandations** - 154 produits associés, 190 ventes croisées, 67 montées en gamme, toutes des
  règles posées à la main. Le storefront affiche les produits associés ("You May Also Like" sur la
  fiche produit) et la vente croisée (panier), pas la montée en gamme.
  - `TBX-ELP-PV-001` : associés = trois autres perceuses ; vente croisée = deux batteries ForceMax,
    un chargeur, deux coffrets de forets, des lunettes de sécurité ; montée en gamme = la même
    perceuse en kit avec deux batteries 4Ah, et le kit brushless 82 Nm.
- **Attributs en autocomplétion** - `tbx_brand`, `tbx_tool_material`, `tbx_paint_color`.
- **Recherche vectorielle** - la page de recherche vectorielle propose des requêtes mesurées sur
  cette boutique : les premières renvoient 0 depuis la barre de recherche, la dernière est un
  témoin que la recherche par mots gère bien.

## Lacunes connues

- "Univers 18V sans fil" n'apparaît pas dans le filtre de catégorie de "Tous les produits".
- Aucun produit n'a de variantes, donc pas de sélecteur de taille ou de couleur.
- L'électroportatif n'a aucune valeur de puissance ; le trier par puissance n'a pas d'effet.
- Le modèle vectoriel ne gère que l'anglais. En français ou en allemand il renvoie des résultats
  faux avec assurance, sans avertissement.
- Certains SKU portent un nom de produit différent selon la langue, avec le même prix, le même stock
  et la même catégorie : `TBX-ELP-SE-008` est "Scie à onglet 216 mm 1500W" en français et "Cordless
  reciprocating saw 18V body only ForceMax" en anglais ; `TBX-OAM-TV-005` est un jeu de 7 tournevis
  isolés en français et un seul tournevis court en anglais.
- Les recommandations sont des règles, pas un apprentissage sur les données de tracking. Un produit
  sans règle n'affiche aucun bandeau. Les 67 règles de montée en gamme ne sont affichées nulle part.

## Sources

Chiffres repris de l'ancien script de démo (date de mesure non notée). Nombre de produits par
catégorie, boosts, thésaurus et nombre de recommandations recomptés dans les fixtures
(`src/DataFixtures/00_toolbox/`) le 2026-11-02.
