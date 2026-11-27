# Le livre & le lièvre - données du catalogue

> Fiche catalogue. Pour mener la démo, utilisez [`demo-papershop.md`](demo-papershop.md).

Une papeterie, une librairie et un vendeur de mobilier sous un même toit : 250 produits, une seule
liste de prix en euros, un seul catalogue derrière trois vitrines (`papershop_fr`, `papershop_en`,
`papershop_de`). Le français (`papershop_fr`) marche le mieux : les produits sont nommés en français
et tous les contrôles en direct y ont été faits. La recherche vectorielle répond aussi en anglais et
en allemand.

La démo elle-même est dans [demo-papershop.md](demo-papershop.md).

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 250 |
| Rayons | 3 : Papeterie 90, Livres 90, Mobilier 70 |
| Langues | français `papershop_fr`, anglais `papershop_en`, allemand `papershop_de` |
| Catégories | 54, quatre niveaux, une construite par une règle |
| Prix | de 1,20 € à 1290 €, la fourchette la plus large des quatre boutiques |
| Rupture de stock | 11 produits |
| En promotion | 51 produits |
| Articles | 18, le plus par produit de toutes les boutiques, chacun lié à de vrais produits |
| Types de produits | 199 simples, 51 avec variantes (certains cahiers en trois couleurs) ; chaque gamme a ses propres attributs |
| Attributs en autocomplétion | 6 : marque, matière, couleur, réglure, reliure, auteur |

## Catégories

Ids, facettes et nombres mesurés en direct sur `papershop_fr`.

| Catégorie | Id | Produits | Particularité |
|---|---|---|---|
| Le livre & le lièvre (racine) | `cat_llv_1` | 250 | facettes : Catégorie, Prix, Disponibilité, Nouveauté, En promotion, Marque, Pays de fabrication ; ses 3 premiers produits remplissent "Notre sélection" sur la page d'accueil |
| Papeterie | `cat_llv_2` | 90 | ajoute Matière, Couleur, Matières durables ; pas de Réglure à ce niveau |
| Cahiers scolaires | `cat_llv_4` | 8 | ajoute Grammage, Réglure (6 valeurs), Format, Reliure, Nombre de pages |
| Livres | `cat_llv_20` | 90 | ajoute Format, Reliure, Auteur, Nombre de pages, Année de parution. Langue du texte reste masqué : tous les livres sont en anglais, volontairement, pour qu'une seule couverture serve à toutes les boutiques, et la boutique masque un filtre qui n'a qu'une valeur |
| Littérature classique | `cat_llv_22` | 12 | Auteur : Charles Dickens 2, Jane Austen 2, Victor Hugo 2, et d'autres |
| Mobilier | `cat_llv_38` | 70 | ajoute Matière, Couleur, Matières durables, Largeur, Hauteur, Profondeur, Montage nécessaire ; pas d'Auteur |
| Bureaux | `cat_llv_40` | 8 | tri par défaut par position ; prix de 189 € à 829 € |
| Accessoires d'atelier | `cat_llv_52` | 5 | uniquement des serre-livres, alors que 25 produits portent la marque Lumen Atelier |
| Sélection éco-responsable | `cat_llv_54` | 104 | construite par une règle : tout produit marqué durable ; label vert "Éco", jamais sur un livre |

## Produits à connaître

| SKU | Nom | Pourquoi |
|---|---|---|
| `LLV-PAP-AGE-008` | Agenda Vannerie, Poche | durable et en promotion à la fois - les deux marques sur une carte, coins opposés |
| `LLV-MOB-FAU-004` | Fauteuil de lecture Pigeonnier | 1290 €, le haut de la fourchette, avec largeur, hauteur et profondeur |
| `LLV-PAP-CRA-003` | Crayon graphite Vannerie | 1,20 €, le bas de la fourchette ; premier sur un tri par prix |
| `LLV-LIV-CLA-001` | Orgueil et Préjugés - édition intégrale | un livre : auteur, nombre de pages, année ; pas de règle de produits associés, donc la fiche affiche ses 4 produits de vente croisée |
| `LLV-PAP-CAH-001` | Cahier piqué Volute | dix filtres (le maximum, partagé par tous les cahiers scolaires) et trois couleurs |
| `LLV-PAP-CRO-002` | Carnet de croquis Estampe | en rupture de stock, donc "ajouter au panier" est désactivé |
| `LLV-PAP-PLU-001` | Stylo plume Encrier | pas de règle de vente croisée, donc le panier n'affiche aucun bandeau de recommandation |

## Recherches à connaître

| Terme | Langue | Résultat mesuré | Ce que ça montre |
|---|---|---|---|
| `papier` | `papershop_fr` | 49 ; les cinq sections de suggestions remplies | le boost éco se déclenche ; recherches populaires : papier dessin, papier machine, papier aquarelle |
| `atelier` | `papershop_fr` | 25 : Papeterie 12, Livres 5, Mobilier 8 | trois gammes sur une même page ; les 25 viennent de la marque Lumen Atelier |
| `chêne` | `papershop_fr` | 23, tous du mobilier | marques Chêne & Fer 15, Boisclair 5 |
| `cahier` | `papershop_fr` | 8 | la popup propose Marque, Matière, Couleur, Réglure, Reliure |
| `cahir`, `stilo`, `crayom`, `ajenda` | `papershop_fr` | 39, 15, 15, 8 | fautes corrigées (`stilo` = `stylo`, `ajenda` = `agenda`) |
| `krayon`, `kaier`, `karnet`, `buro`, `chèze` | `papershop_fr` | 15, 35, 8, 30, 28 | correspondances phonétiques, scores faibles |
| `voyage` | `papershop_fr` | 8 | une correspondance dans le nom passe devant une dans la description |
| `édition` | `papershop_fr` | 69 | 1 produit en promotion dans les 8 premiers (6e), sur un chargement neuf, mesuré le 2026-11-27 |
| `siège`, `rentrée` | `papershop_fr` | 0, 0 | aucun thésaurus ne les couvre ; `chaise` 8, `fauteuil` 7 |
| `calepin` | `papershop_fr` | les 23 carnets, cahiers et blocs, comme `carnet` | synonyme `calepin` = `carnet`, qui profite aussi de l'expansion de `carnet` |
| `austen` | `papershop_fr` | trouvé depuis les suggestions | attribut auteur dans l'autocomplétion |
| "furnish a home office" | `papershop_en` | 0 depuis la barre de recherche ; page vectorielle : un bureau, une chaise de bureau, une lampe de bureau | l'intention à travers une gamme |
| "siège de bureau" | `papershop_fr` | 0 depuis la barre de recherche ; page vectorielle : des chaises de bureau | recherche par sens |
| "Füllfederhalter" | `papershop_de` | 0 depuis la barre de recherche ; page vectorielle : tous les stylos plume | la boutique dit "Füllhalter" |

## Merchandising configuré

- **Boosts**
  - "Éco-responsable en tête" - actif, +100, les trois vitrines. Remonte les produits durables sur
    les recherches contenant `papier` ou `paper`, et dans `cat_llv_54`.
  - "Reliure du Nord en tête" - inactif, +80, marque = Reliure du Nord, sur toute recherche.
    Activé : `cahier` place les deux cahiers Reliure du Nord en tête, `carnet` fait passer son
    carnet de croquis de la 4e à la 1re place. `papier` ne change pas, le boost éco le décide déjà.
- **Thésaurus**
  - synonymes, un thésaurus par vitrine : `calepin` = `carnet` (fr), `planner` = `diary` (en), `füller` = `füllhalter` (de)
  - expansion `carnet` -> `cahier`, `bloc` (`papershop_fr` uniquement, dans un seul sens)
- **Catégorie construite par une règle (virtuelle)** - "Sélection éco-responsable" `cat_llv_54`,
  104 produits sur 250.
- **Recommandations** - 42 ventes croisées, 24 montées en gamme, aucun produit associé. La fiche
  produit se rabat sur la vente croisée ; le panier affiche la vente croisée ; la montée en gamme
  n'est pas affichée.
- **Attributs en autocomplétion** - `llv_brand`, `llv_material`, `llv_color`, `llv_ruling`,
  `llv_binding`, `llv_author`. "Pays de fabrication" n'est pas activé.
- **Recherches populaires** - les fixtures contiennent 76 recherches `papershop_fr` sur 43 termes,
  aucune mal orthographiée, aucune sans résultat. Exemples : `rom` -> roman policier, romans ados ;
  `sey` -> seyès ; `hug` -> hugo.
- **Recherche vectorielle** - la page de recherche vectorielle propose des requêtes mesurées sur
  cette boutique ; la dernière est un témoin que la recherche par mots gère bien en français et en
  anglais. "Use on no result" est désactivé. Activé, il sauve "siège de bureau", "meubler un
  bureau" et "histoire de détective", mais renvoie environ 173 produits pour n'importe quelle
  phrase, même `zzqx`.

## Lacunes connues

- La plage du filtre de prix est fausse sur toutes les pages : sur le catalogue entier elle
  s'arrête à 10 euros. Le tri par prix fonctionne.
- L'historique de recherche ne contient aucune faute d'orthographe. La tolérance aux fautes dans la
  recherche elle-même fonctionne, voir les fautes ci-dessus.
- Les 90 livres affichent "Langue du texte : Anglais", titres français compris.
- La popularité de chaque terme de recherche suggéré vaut 0.
- En allemand la requête témoin vectorielle "Märchen" renvoie aussi 0 depuis la barre de recherche.
- Les variantes restent légères : 51 produits en ont, mais rien ne se compare à la chaussure à 27
  variantes de Fiora Fashion.
- Les 24 règles de montée en gamme associent des livres à d'autres livres sans rapport - *Les
  Misérables* avec une édition de poche de *La Lettre volée* - et le storefront n'affiche pas la
  montée en gamme.
- "Matières durables" est masqué sur la catégorie racine : seuls 160 produits sur 250 ont une
  valeur.
- Dans l'admin, le premier enregistrement du tri par défaut ou de la règle virtuelle d'une
  catégorie a renvoyé une erreur HTTP 500, deux fois ; le même enregistrement relancé a fonctionné.

## Sources et reproduction

Chiffres repris de l'ancien script de démo (date de mesure non notée). Ids de catégories,
facettes, recherches, boosts et recommandations mesurés en direct sur `papershop_fr` le
2026-11-02. Thésaurus et nombre de recommandations recomptés dans les fixtures
(`src/DataFixtures/02_papershop/`).

**Mesuré en direct le 2026-11-27**, sur un chargement neuf de cette branche :

- `édition` dans `papershop_fr` : 69 livres, 1 en promotion dans les 8 premiers (6e)
- synonymes : `calepin` et `carnet` 23 chacun dans `papershop_fr`, `planner` et `diary` 8 dans
  `papershop_en`, `füller` et `füllhalter` 8 dans `papershop_de`. La paire `calepin` a été posée
  par l'API pour correspondre à la fixture, pas chargée depuis elle

Ce catalogue a été généré, pas écrit à la main (skill `gally-sample-data`,
`references/authoring.md` §9). La version du générateur et la graine ne sont pas notées.

**Reproduire**

- Chargez-le avec `make fixtures_load catalogs=02_papershop`. La commande efface la base et demande
  confirmation. Ne lui envoyez pas `y` par un pipe sans `catalogs=` : le chargement est sauté sans
  message. Boosts, thésaurus, recommandations et recherche vectorielle demandent les bundles
  premium.
- Un chiffre est **attendu** (lu dans les fixtures de `src/DataFixtures/02_papershop/`) sauf si
  cette section le dit **mesuré** en direct, avec sa date.
- Mesurez sur un chargement neuf, ou après la section Remise à zéro du guide de démo. Ce que la démo
  crée en direct (thésaurus, boosts et réglages nommés dans ses étapes) n'est pas dans les données
  commitées, et change les résultats de recherche.
