# Venia & Luma - script de démo

La boutique d'exemple d'origine, et toujours celle sur laquelle la boutique de démo s'ouvre. Trois
vitrines : **Venia**, mode femme et bijoux, la seule qui vaille la peine d'être montrée ; **Luma**,
vêtements de sport, à moitié meublée ; et une troisième qui est vide.

**À montrer à** quiconque veut voir le comportement de recherche lui-même - synonymes, règles de
tri, recherche vectorielle. Cette boutique a les fonctionnalités de merchandising que les trois
autres n'avaient pas jusqu'à récemment, et la section éditoriale la plus fournie.

**Ouvrir** l'application d'exemple Gally sur la vitrine `com_en` - **en anglais**, pas en français.
Deux raisons, et toutes deux vous joueront des tours si vous les ignorez : l'historique de recherche
derrière la vitrine française a expiré, donc la liste des recherches populaires est vide, et les
produits sont rédigés en anglais, donc la recherche vectorielle ne fonctionne bien que là.

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 85 dans Venia. Luma en a 183 mais rien n'est configuré autour |
| Langues | anglais et français - démo en **anglais** |
| Catégories | 19 |
| Prix | de 15 à 156 |
| Rupture de stock | 22 des 85, la proportion la plus élevée des quatre boutiques |
| En promotion | 9 produits |
| Articles | 57, de loin la plus grande section éditoriale |
| Types de produits | tous - 70 avec variantes, plus un lot, un ensemble groupé et un virtuel |

## À connaître par cœur

Collez une référence dans la barre de recherche pour trouver le produit. Pour `VA13-GO-NA` et
`VA17-SI-NA`, le lot `VA24` qui les contient arrive en premier : ouvrez le deuxième résultat.

| Référence | Pourquoi celle-ci |
|---|---|
| `VSK12` | 20 combinaisons de couleur et de taille derrière une seule fiche |
| `VA24` | un lot, et l'article le plus cher à 156 |
| `VA23` | un ensemble groupé - trois produits vendus ensemble |
| `VVP01` | un service plutôt qu'un objet, et l'article le moins cher de la boutique |
| `VA13-GO-NA` | en promotion, 78 avec 98 barré, et deux badges à la fois |
| `VA17-SI-NA` | en rupture de stock, l'un des 22 |
| `VA11-GO-NA` | une seule matière, donc affiche le badge "100 %" |

| Recherche | Pourquoi celle-ci |
|---|---|
| `dress` | remplit les cinq sections de suggestions - marquez une pause avant de valider |
| `robe` | les mêmes robes grâce à un synonyme, sans la règle de tri |
| `trousers` | une recherche volontairement élargie aux pantalons et shorts |

## Le déroulé - environ dix minutes

| | Taper ou cliquer | Ce que ça montre |
|---|---|---|
| 1 | `dress`, et faire une pause | cinq types de suggestions à la fois |
| 2 | `dress`, puis `robe` | un seul vocabulaire, et une règle de tri par-dessus |
| 3 | `trousers` | une recherche volontairement élargie par le marchand |
| 4 | une phrase absente des mots du produit | recherche par sens, pas par mots |
| 5 | un lot, un ensemble groupé | tous les types de produits dans une seule boutique |
| 6 | le blog | 57 articles cherchés via la même barre |

---

### 1. Taper `dress` et s'arrêter avant de valider

Le panneau de suggestions se remplit avec les cinq types de résultats à la fois : recherches
populaires, couleurs, matières, tailles et styles correspondants, produits, une catégorie et des
articles du blog.

Laissez-le à l'écran un instant. La plupart des barres de recherche n'en proposent qu'un des cinq.

### 2. Chercher `dress`, puis `robe`

Les deux trouvent les robes - le marchand a indiqué au moteur que les deux mots veulent dire la
même chose.

Mais le classement diffère, car une règle fait remonter toutes les robes dont le nom contient "Tank"
sur l'une des deux recherches et pas sur l'autre. Deux choses se passent en même temps ici : un
vocabulaire que le marchand entretient, et une décision de classement que le marchand prend. Ça vaut
la peine de les distinguer à voix haute.

### 3. Chercher `trousers`

Les résultats sont plus larges que le mot : 29 pantalons et shorts remontent, parce que le
marchand a volontairement élargi cette recherche.

Rien ne le signale dans l'interface. Dites-le, sinon ça passe inaperçu.

### 4. Décrire quelque chose plutôt que de le nommer

La page de recherche vectorielle propose cinq suggestions, et elles ont été écrites pour cette
boutique - utilisez-les ici, elles fonctionnent. Quatre renvoient **zéro** depuis la barre de
recherche ordinaire : `jewellery`, parce que le catalogue écrit "Jewelry" et nomme les pièces
"Necklace" et "Earrings" ; `wedding guest outfit` et *"something to wear to the beach"*, parce que
l'acheteur décrit l'occasion et le catalogue décrit le vêtement ; `gift for my wife`, qui ne
contient aucun nom de produit.

La cinquième, `cardigan`, est là exprès comme témoin : la recherche par mots-clés la gère très
bien. Montrez-la en dernier. L'affirmation honnête n'est pas que la recherche vectorielle gagne
partout, c'est qu'elle répond aux questions auxquelles la recherche par mots-clés ne répond pas du
tout - et un public qui repère tout seul les quatre exemples truqués cessera de croire le reste.

### 5. Ouvrir quelques produits

Cette boutique a tous les types de produits : un simple, un vendu en plusieurs couleurs et tailles,
un lot et un ensemble groupé. Aucune des trois boutiques plus récentes n'a de lot ni d'ensemble
groupé.

Vingt-deux des quatre-vingt-cinq produits sont en rupture de stock, donc le filtre de
disponibilité a les deux états et certains boutons "ajouter au panier" sont réellement désactivés.

### 6. Montrer le blog

Cinquante-sept articles, de loin la plus grande section éditoriale des quatre boutiques,
cherchables via la même barre que les produits et avec leurs propres suggestions par sujet,
étiquette et auteur.

---

## À ne pas faire

- **Ne faites pas la démo en français.** La liste des recherches populaires y est vide, et les
  descriptions de produits sont encore en anglais, ce qui ressemble à un bug de traduction devant
  un client.
- **Ne passez pas à la troisième vitrine.** Rien n'y est indexé ; vous obtenez une boutique vide.
- **Ne vous appuyez pas sur Luma**, la boutique de sport. Elle a des produits et partage quelques
  synonymes avec Venia, mais elle n'a ni contenu éditorial ni règle de tri.
- **Ne proposez pas de recommandations.** Cette boutique n'en a aucune de configurée. Les trois
  boutiques plus récentes en ont - même si la boutique de démo ne peut pas encore les afficher non
  plus.
- **Ne cherchez pas de catégorie construite par règle.** Cette boutique n'en a aucune ; Toolbox
  Bricolage et Le livre & le lièvre en ont chacune une.

---

Les chiffres ici ont été mesurés le 2026-08-13. Chaque recherche, suggestion et page du script a été
vérifiée sur une instance réelle le 2026-10-23. La référence complète du jeu de données, avec la
façon dont chaque chiffre a été obtenu et le contenu du catalogue champ par champ, est dans
`../../GUIDE.md`.
