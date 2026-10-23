# Toolbox Bricolage - script de démo

Une boutique de bricolage et de quincaillerie. 525 produits, trois langues, une seule liste de prix
en euros.

**À montrer à** quiconque a un catalogue technique : fourniture industrielle, bâtiment, pièces
détachées, tout ce où un produit se décrit par ses spécifications plutôt que par son apparence.
C'est le catalogue où le filtrage fait le travail.

**Ouvrir** l'application d'exemple Gally et choisir "Toolbox Bricolage" (`toolbox_fr`) dans le
sélecteur de l'en-tête. La démo s'ouvre par défaut sur une autre boutique, donc changez avant
l'arrivée du visiteur.

## En un coup d'œil

| Élément | Dans cette boutique |
|---|---|
| Produits | 525, tous vendus à l'unité - pas de variantes |
| Langues | français, anglais, allemand - un seul catalogue derrière les trois |
| Catégories | 85, trois niveaux, une construite par une règle |
| Prix | de 3,90 € à 699,90 € |
| Rupture de stock | 11 produits |
| En promotion | 38 produits |
| Articles | 15 |
| Filtres | 47 - 6 sont des spécifications triables |

## À connaître par cœur

Collez une référence dans la barre de recherche : la page de résultats affiche ce seul produit.

| Référence | Pourquoi celle-ci |
|---|---|
| `TBX-ELP-PV-001` | un des 32 produits sans fil que la règle de tri fait remonter |
| `TBX-MAT-TM-002` | 699,90 €, le haut de la fourchette de prix |
| `TBX-PEI-BA-003` | 3,90 €, le bas de gamme - à montrer avec le précédent sur le filtre de prix |
| `TBX-ELP-SE-008` | en rupture de stock, donc "ajouter au panier" est réellement désactivé |
| `TBX-OAM-TV-005` | en promotion, 34,90 € au lieu de 39,90 € |

| Recherche | Pourquoi celle-ci |
|---|---|
| `perceuse` | les cinq sections de suggestions, et la règle de tri se déclenche |
| `ponceuse` | la même boutique sans règle - à lancer juste après |
| `Bohrschruber` (boutique allemande) | une faute d'orthographe, corrigée |
| `sandre` (boutique anglaise) | une autre, et une vraie, tirée des journaux |
| `forcemax` | un nom de marque : le panneau suggère la marque et ses produits |

**`perceuse` remplit tout le panneau de suggestions.** Recherches populaires, marque, produits,
catégorie et articles répondent tous. Un nom de marque comme `forcemax` ne remplit que trois
sections.

## Le déroulé - environ dix minutes

| | Taper ou cliquer | Ce que ça montre |
|---|---|---|
| 1 | `perceuse`, puis `ponceuse` | une règle de tri posée par le marchand, et ses limites |
| 2 | `perceuse` dans la boutique anglaise | un seul vocabulaire dans trois langues |
| 3 | `Bohrschruber`, `sandre` | fautes d'orthographe gérées |
| 4 | une catégorie d'outillage électroportatif | filtrage par spécification, tri par puissance |
| 5 | "Univers 18V sans fil" | une catégorie qui se remplit toute seule à partir d'une règle |
| 6 | *"protect my eyes while drilling"*, boutique anglaise | recherche par sens, pas par mots |

---

### 1. Chercher `perceuse`, puis `ponceuse`

La première recherche met les perceuses sans fil en tête. La seconde, une ponceuse, donne un
classement de pertinence ordinaire.

Rien dans le catalogue n'a changé entre les deux. Quelqu'un a décidé que sur cette boutique, quand
un client tape "perceuse", les outils sans fil passent devant - et cette décision a pris effet
immédiatement, sans rien reconstruire et sans que l'équipe de développement soit impliquée. Tapez
les deux recherches l'une après l'autre et laissez la différence parler.

Une deuxième règle est prête et désactivée. Si vous avez un accès admin, activez-la sous les yeux
du visiteur et refaites la recherche : l'ordre change devant lui.

### 2. Taper `perceuse` dans la boutique anglaise

Passez la langue en anglais et cherchez le mot français. Les perceuses reviennent quand même.

Ça marche aussi en allemand. Un seul catalogue produit, trois vitrines, et les mots que les clients
utilisent réellement dans chacune d'elles traités comme un vocabulaire que le marchand entretient -
pas comme trois traductions des données.

### 3. Faire une faute d'orthographe

Dans la boutique allemande, tapez `Bohrschruber` - une lettre en moins que "Bohrschrauber". En
anglais, `sandre` au lieu de "sander". Les deux trouvent les bons produits.

Ça vaut la peine de le dire à voix haute : ce ne sont pas des fautes inventées pour la démo, ce sont
le genre de choses qui apparaissent dans de vrais journaux de recherche.

### 4. Ouvrir une catégorie d'outillage électroportatif et utiliser les filtres

C'est la partie la plus dense du catalogue. Les filtres sont les spécifications propres au produit :
**Sans fil**, **Tension**, **Type de moteur**, **Vitesses**, **Marque**. Cochez-en quelques-uns et
regardez le compteur baisser.

L'intérêt pour un catalogue technique : le client affine selon ce que l'outil *fait*, pas en
devinant dans quelle catégorie quelqu'un l'a classé. Pour trier par puissance, ouvrez "Machines
d'atelier" et choisissez "Puissance (W)" : la plus petite machine vient en premier. Les outils
électroportatifs n'ont pas de valeur de puissance, donc le tri ne change rien chez eux.

### 5. Ouvrir "Univers 18V sans fil"

Une catégorie dans le menu principal contenant 45 produits - les outils sans fil et les batteries
qui leur correspondent, côte à côte.

Personne n'a mis un seul produit dedans. Elle contient tout ce qui correspond à une règle écrite
par le marchand, et elle se met à jour toute seule : ajoutez un nouvel outil 18V au catalogue
demain et il apparaît ici, sans que personne ne touche à la catégorie.

C'est en général le moment qui frappe le plus un merchandiser, parce que c'est celui qu'il fait
actuellement à la main.

### 6. Décrire un outil plutôt que de le nommer

**Passez d'abord à la boutique anglaise.** Le modèle derrière cette fonction ne parle qu'anglais ;
en français ou en allemand il renvoie des réponses aberrantes avec assurance, et la page ne
vous avertit pas.

Sur la page de recherche vectorielle, tapez *"protect my eyes while drilling"*. Reviennent des
lunettes de sécurité, une visière et des lunettes de protection. Aucun texte produit ne contient
"eyes", et aucun ne contient tous les mots.

La barre de recherche ordinaire renvoie **zéro** pour cette phrase. Lancez-la d'abord là, puis sur
la page de recherche vectorielle. Ce contraste, c'est la démo, et c'est l'affirmation honnête : la
recherche vectorielle ne bat pas la recherche par mots-clés partout, elle répond aux questions
auxquelles la recherche par mots-clés ne répond pas du tout.

---

## Si vous avez plus de temps

- **Les prix** vont de moins de 4 euros à près de 700. Le curseur de prix a de quoi mordre.
- **Rupture de stock** : onze produits sont indisponibles, donc le filtre de disponibilité a les
  deux états et le bouton "ajouter au panier" est réellement désactivé sur certains produits.
- **Trois langues** : passez du français à l'anglais et à l'allemand sur la même page. Catégories,
  filtres et contenu éditorial suivent tous.
- **Quinze articles** accompagnent les produits et apparaissent dans les suggestions de recherche -
  "Bien choisir sa perceuse-visseuse" est le plus évident à ouvrir après la recherche `perceuse`.
- **Recommandations** - les plus parlantes des trois boutiques. Ouvrez la perceuse ForceMax 18V 50
  Nm `TBX-ELP-PV-001` : "Vous aimerez aussi" liste trois autres perceuses, ses produits associés.
  Ajoutez-la au panier : le panier propose deux batteries ForceMax, un chargeur, deux coffrets de
  forets et des lunettes de protection, ses ventes croisées. Cette boutique a 154 règles
  d'association et 190 de ventes croisées.

---

## À ne pas faire

- **Ne cherchez pas "Univers 18V sans fil" dans le filtre de catégorie de "Tous les produits".**
  Elle n'y figure pas. Ouvrez-la plutôt depuis le menu principal.
- **Servez-vous des requêtes suggérées sur la page de recherche vectorielle : elles sont propres à
  cette boutique.** Chacune a été mesurée ici : les premières ne renvoient rien du tout dans la
  barre de recherche ordinaire, et la dernière est un témoin volontaire, que la recherche ordinaire
  traite très bien. Gardez le témoin pour la fin et dites ce qu'il prouve, sinon le public
  supposera que toute la page est truquée.
- **Ne promettez pas de sélecteur de taille ou de couleur.** Rien dans cette boutique n'a de
  variantes. Utilisez Fiora Fashion pour ça.
- **Ne présentez pas les recommandations comme apprises des clients.** Ce sont des règles qu'un
  marchand a configurées dans Gally ; rien ne lit les données de tracking. Choisissez un produit qui
  en a une (la perceuse ci-dessus) : un produit sans règle n'affiche aucun bandeau. Les 67 règles de
  montée en gamme - celle de la perceuse propose la même perceuse en kit avec deux batteries 4Ah,
  et le kit brushless 82 Nm - ne sont affichées nulle part.
