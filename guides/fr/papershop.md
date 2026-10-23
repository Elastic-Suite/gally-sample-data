# Le livre & le lièvre - script de démo

Une papeterie, une librairie et un fabricant de meubles sous un même toit. 250 produits, trois
langues, une seule liste de prix en euros.

**À montrer à** quiconque a un catalogue non uniforme : une marketplace, un grand magasin, un
distributeur dont les gammes n'ont rien en commun. Une seule barre de recherche doit gérer un
crayon à 1,20 euro et un fauteuil à 1290 euros, et c'est ça la démo.

**Ouvrir** l'application d'exemple Gally et choisir "Le livre & le lièvre" (`papershop_fr`) dans
le sélecteur de l'en-tête.

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 250 - 90 papeterie, 90 livres, 70 meubles |
| Langues | français, anglais, allemand - un seul catalogue derrière les trois |
| Catégories | 54, quatre niveaux, une construite par une règle |
| Prix | de 1,20 € à 1290 €, la fourchette la plus large des quatre boutiques |
| Rupture de stock | 11 produits |
| En promotion | 51 produits |
| Articles | 18, le plus par produit de toutes les boutiques |
| Suggestions de recherche | 6 types - marques, matières, couleurs, réglures, reliures, auteurs |

## À connaître par cœur

Collez une référence directement dans la barre de recherche pour faire remonter ce produit seul.

| Référence | Pourquoi celle-ci |
|---|---|
| `LLV-PAP-AGE-008` | **durable et en promotion à la fois** - les deux badges sur une fiche, coins opposés |
| `LLV-MOB-FAU-004` | 1290 €, le haut de la gamme, avec une vraie largeur, hauteur et profondeur |
| `LLV-PAP-CRA-003` | 1,20 €, le bas de gamme - à montrer avec le précédent grâce au tri par prix |
| `LLV-LIV-CLA-001` | un livre : auteur, nombre de pages, année de parution |
| `LLV-PAP-CAH-001` | dix filtres (le maximum, comme tous les cahiers) et trois couleurs |
| `LLV-PAP-CRO-002` | en rupture de stock, donc "ajouter au panier" est réellement désactivé |

| Recherche | Pourquoi celle-ci |
|---|---|
| `papier` | **remplit les cinq sections de suggestions à la fois**, et la règle de tri se déclenche |
| `atelier` | trois rayons sans rapport sur une seule page de résultats |
| `pen` dans la boutique française | le même mot qui fonctionne dans plusieurs langues |
| `austen` | un nom d'auteur, tout droit sorti des suggestions |

## Le déroulé - environ dix minutes

| | Taper ou cliquer | Ce que ça montre |
|---|---|---|
| 1 | `atelier` | trois gammes sans rapport, une seule page de résultats |
| 2 | "Sélection éco-responsable" | une catégorie qui se remplit toute seule à partir d'une règle, 104 produits |
| 3 | `papier` | la même règle qui décide ce qui remonte en premier |
| 4 | le tri par prix | de 1,20 € à 1290 € dans un seul catalogue |
| 5 | `pen` dans la boutique française | un seul vocabulaire dans plusieurs langues |
| 6 | un livre, puis `austen` | chaque gamme qui garde son propre vocabulaire |

---

### 1. Chercher `atelier`

Reviennent un crayon graphite, un beau livre, un calendrier et une liseuse. Le filtre de catégorie
compte 12 produits de papeterie, 5 livres et 8 meubles : trois rayons sans rapport, une seule page
de résultats.

Dites ce que ça remplace : les boutiques avec des gammes aussi différentes finissent d'habitude
avec trois barres de recherche, ou une seule qui ne marche bien que pour l'une d'entre elles.

### 2. Ouvrir "Sélection éco-responsable"

Une catégorie dans le menu principal contenant **104 des 250 produits**, chacun marqué d'un badge
vert **Éco**.

Personne n'a rempli cette catégorie. Elle contient tout ce qui correspond à une règle écrite par le
marchand, et elle se met à jour toute seule : marquez un nouveau produit comme durable demain et il
apparaît ici tout seul. Le même badge vert revient sur une partie des fiches dans la plupart des
catégories de papeterie et de mobilier, jamais sur un livre, ce qui montre la portée de la règle.

C'est en général le moment où un merchandiser réagit, parce que c'est le travail qu'il fait
actuellement à la main chaque saison.

### 3. Chercher `papier`

Les produits durables passent en tête des résultats. La même règle qui remplit la catégorie
ci-dessus décide aussi de ce qui remonte en premier sur cette recherche, et rien de tout ça n'a eu
besoin d'un développeur.

### 4. Trier par prix

Sur la page de catégorie "Le livre & le lièvre", choisissez **Prix** dans la liste de tri. Un crayon
graphite à 1,20 euro arrive en premier. Cliquez sur la flèche à côté de la liste et un fauteuil de
lecture à 1290 euros prend sa place, dans le même catalogue.

Sur un catalogue uniforme, trier par prix change peu de chose. Ici c'est le moyen le plus rapide de
dire "j'aménage un bureau" plutôt que "j'achète un crayon".

### 5. Chercher `pen` dans la boutique française

Les stylos plume reviennent, même si chaque produit est nommé en français. Ça marche aussi dans
l'autre sens : `stylo` dans la boutique anglaise.

### 6. Montrer ce que les filtres savent d'un livre

Ouvrez un livre - "Orgueil et Préjugés - édition intégrale" est le plus clair. Il porte un
**Auteur**, un **Nombre de pages** et une **Année de parution**. Un bureau porte plutôt une largeur,
une hauteur et une profondeur. Un carnet porte sa **Réglure**.

L'idée : chaque gamme garde son propre vocabulaire, et le client ne voit toujours qu'une seule
boutique. Taper un nom d'auteur, `austen`, le trouve directement dans les suggestions de recherche.

---

## Si vous avez plus de temps

- **Six types de suggestions dans la barre de recherche** - les plus riches des quatre boutiques.
  Marques, matières, couleurs, réglures, reliures et auteurs apparaissent tous au fil de la frappe.
- **Dix-huit articles** accompagnent les produits, chacun renvoyant vers de vrais produits : "Le
  grammage, et pourquoi 80 g ne suffit pas toujours" est un bon choix après une recherche sur le
  papier.
- **Rupture de stock** : onze produits, donc cocher le filtre de disponibilité en retire vraiment.
- **Trois langues** sur la même page.
- **Décrivez quelque chose plutôt que de le nommer** sur la page de recherche vectorielle. En
  anglais, *"furnish a home office"* ramène un bureau, une chaise de bureau et une lampe de bureau,
  en sortant le rayon meubles par l'intention ; en français, *"siège de bureau"* ramène des chaises
  de bureau ; en allemand, *"Füllfederhalter"* ramène tous les stylos plume, que cette boutique
  appelle "Füllhalter". La barre de recherche ordinaire renvoie zéro pour les trois.
- **Recommandations.** Cette boutique n'a pas de règles de produits associés, donc la fiche produit
  se rabat sur les ventes croisées. Ouvrez *Orgueil et Préjugés* `LLV-LIV-CLA-001` : "Vous aimerez
  aussi" liste un carnet de croquis, une ramette de papier, un trieur et un fauteuil de lecture.
  Ajoutez-le au panier et le panier propose les mêmes quatre. Cette boutique a 42 règles de ventes
  croisées.

---

## À ne pas faire

- **Ne montrez pas la correction orthographique ici.** L'historique de recherche de cette boutique
  ne contient aucune faute. Utilisez Toolbox Bricolage, qui en a exprès.
- **Ne déplacez pas le filtre de prix.** Sa plage est fausse sur chaque page : sur tout le
  catalogue, il s'arrête à 10 euros. Triez plutôt par prix.
- **Servez-vous des requêtes suggérées sur la page de recherche vectorielle : elles sont propres à
  cette boutique.** Chacune a été mesurée ici : les premières ne renvoient rien du tout dans la
  barre de recherche ordinaire, et la dernière est un témoin volontaire, que la recherche ordinaire
  traite très bien en français et en anglais. En allemand, le témoin "Märchen" renvoie zéro lui
  aussi dans la recherche ordinaire : sautez-le. Gardez le témoin pour la fin et dites ce qu'il
  prouve, sinon le public supposera que toute la page est truquée.
- **Ne vous appuyez pas sur les variantes.** Certains carnets existent en trois couleurs, mais rien
  ici ne rivalise avec la chaussure à 27 variantes de Fiora Fashion.
- **Ne montrez pas la montée en gamme ici.** Les 24 règles de montée en gamme associent un livre à
  d'autres livres sans rapport - *Les Misérables* avec une édition de poche de *La Lettre volée* -
  et la boutique ne l'affiche de toute façon pas. Les ventes croisées, ci-dessus, sont celles à
  montrer.
