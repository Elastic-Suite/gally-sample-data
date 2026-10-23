[English](../en/README.md)

# Scripts de démo

Un par boutique d'exemple. Chacun est écrit pour la personne qui anime la démo : quoi ouvrir, quoi
taper, ce qui se passe et quoi en dire. Pas de chemin de fichier, pas de nom de champ - la
référence du jeu de données pour le catalogue d'origine est dans `../../GUIDE.md`.

| Boutique | Script | À utiliser quand le public s'intéresse à |
|---|---|---|
| Toolbox Bricolage | [`toolbox.md`](toolbox.md) | les catalogues techniques, le filtrage par spécification, une catégorie qui se remplit toute seule |
| Fiora Fashion | [`fashion.md`](fashion.md) | les variantes, les promotions, l'éditorial lié aux produits |
| Le livre & le lièvre | [`papershop.md`](papershop.md) | les assortiments hétérogènes, une large fourchette de prix, une catégorie qui se remplit toute seule |
| Venia & Luma | [`default.md`](default.md) | le comportement de recherche lui-même - synonymes, règles de tri, recherche vectorielle |

## Quelle boutique montre quoi

À lire dans l'autre sens quand un client demande quelque chose de précis : trouvez la ligne, ouvrez
cette boutique.

| Ce que vous voulez montrer | Toolbox | Fiora | Le livre | Venia |
|---|:---:|:---:|:---:|:---:|
| Une règle de tri que le marchand a posée sur une recherche | oui | oui | oui | oui |
| Une deuxième règle, désactivée, à activer en direct | oui | oui | oui | - |
| Le même mot qui fonctionne dans plusieurs langues | 3 langues | 3 langues | 2 langues | 2 langues |
| Une recherche volontairement élargie à des mots liés | oui | oui | oui | oui |
| Fautes d'orthographe corrigées | **le mieux** | oui | - | - |
| Une catégorie qui se remplit toute seule à partir d'une règle | 45 articles | - | **104 articles** | - |
| Un produit vendu en plusieurs couleurs et tailles | - | **27 sur une fiche** | léger | 70 sur 85 |
| Promotions, ancien prix à côté du nouveau | 38 | **72** | 51 | 9 |
| Rupture de stock, et un filtre avec les deux états | 11 | 20 | 11 | 22 sur 85 |
| Filtrage par spécification technique | **47 filtres** | oui | oui | oui |
| Tri par une spécification, pas seulement par prix | 6 façons | - | 6 façons | - |
| Articles éditoriaux liés à de vrais produits | 15 | 15 | 18 | 57 |
| Une fourchette de prix assez large pour compter | 4-700 € | 13-350 € | **1-1290 €** | 15-156 |
| Recherche par sens plutôt que par mots | oui | oui | oui | oui |
| Recommandations | associés + ventes croisées | associés + ventes croisées | ventes croisées seules | aucune |

**L'application d'exemple Gally s'ouvre sur Venia & Luma.** Choisissez toute autre boutique dans
le sélecteur de l'en-tête : `toolbox_fr`, `fashion_fr`, `papershop_fr`.

Quatre choses sont vraies pour chaque boutique et ne valent pas la peine d'être découvertes en
direct :

- **La recherche par sens fonctionne dans toutes les boutiques, au mieux en anglais.** Le modèle
  qui la fait tourner est d'abord anglophone. Le français et l'allemand ont leurs propres
  suggestions, gardées parce qu'elles y ramènent les bons produits : surtout des expressions courtes
  et des synonymes, pas de longues phrases. Dans la boutique anglaise, la dernière suggestion de
  chaque liste est un témoin que la recherche ordinaire traite très bien - gardez-le pour la fin et
  dites-le, sinon la démo paraît truquée.

- La fiche produit et le panier affichent de vraies recommandations : des règles qu'un marchand a
  configurées dans Gally, pas apprises des clients. La fiche produit montre les produits associés,
  ou les ventes croisées quand un produit n'a pas de règle d'association ; le panier montre les
  ventes croisées de son contenu. Des règles de montée en gamme existent mais ne sont pas affichées.
  Le guide de chaque boutique nomme un produit qui en a - un produit sans règle n'affiche aucun
  bandeau.
- Là où une boutique a une catégorie construite par règle, le nombre de produits affiché à côté
  dans le menu indique zéro alors que la page elle-même liste les produits. Cliquez plutôt que de
  lire le nombre.
- Chaque boutique thématique est un seul catalogue en trois langues ; Venia en a deux. Changer de
  langue change les catégories, les filtres et les articles - pas les produits.

## Garder les deux langues synchronisées

`en/` et `fr/` forment un seul document en deux langues, pas deux documents. Si vous modifiez l'un,
modifiez l'autre dans la foulée : mêmes sections dans le même ordre, et mêmes lignes dans chaque
tableau. Les références produit, les termes de recherche et les noms de boutique restent non
traduits des deux côtés, pour qu'un démonstrateur tape exactement la même chose quelle que soit la
version qu'il lit.

Depuis `guides/`, `./check-sync.py` le vérifie. Il compare la liste des fichiers, la structure des
titres et le nombre de lignes de tableau, et résout tous les liens. Il ne vérifie pas la
traduction, seulement qu'un côté n'a pas gagné une section qui manque à l'autre.
