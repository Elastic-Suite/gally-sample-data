---
applyTo: '**'
---

# Gally Sample Data — Agent Rules

Symfony bundle (`gally/gally-sample-data`, PSR-4 `Gally\SampleData\`) that seeds a Gally
instance with demo catalogs, metadata and Elasticsearch documents. Apart from a test-data
generator CLI it holds **little logic** — it is a data package. Most of the work here is editing
YAML fixtures and JSON document files.

This repo is `Elastic-Suite/gally-sample-data`: commit here, not in the monorepo. The monorepo map
is `../../../AGENTS.md`.

Checked out inside the Gally monorepo at `api/packages/gally-sample-data`; composer wires it
as a path repository (`make switch-dev-env`). Sibling packages: `gally-standard` (core, OSS),
`gally-premium` (boost/thesaurus/vector search). Front-ends live in `../../../front`
(`gally-admin`, `pwa`, `example-app`).

**The demo narrative dictates what the data must contain.** Read the guide of the shop you change
in `guides/` (`demo-*.md` and `catalog-*.md`) before changing data. Known gaps are tracked in the
`gally-sample-data` skill, not here: a snapshot of what is missing goes stale in a file that
loads on every task.

## Where to read what

This file is the entry point and carries routing plus the traps that fail silently. Detail lives
in the files below — open the one you need, not all of them.

| You need | Read |
|---|---|
| Running a demo: what to open, what to type, what to say | `guides/en/` and `guides/fr/` — one script per shop, for the demoer. `guides/check-sync.py` checks the two languages match |
| Fixture formats, the data model, Elasticsearch documents, the checks a data change must pass, catalog generation, known data gaps | the `gally-sample-data` skill: its `SKILL.md` routes to each topic |

Paths starting `../../../` are relative to this file. Paths starting `gally-sample-data/` are in
the `gally-sample-data` skill folder. Everything else is relative to the repo root.

---

## 1. How the data is loaded

Two separate loaders run in this order (see `Makefile: fixtures_load` at the monorepo root):

```
make fixtures_load        # drops DB + ES, migrates, then:
  bin/console hautelook:fixtures:load --no-interaction --append   # 1) YAML → PostgreSQL
  bin/console doctrine:fixtures:load  --no-interaction --append   # 2) JSON → Elasticsearch
```

Useful sub-commands (run inside the `php` container: `make sh`, or `make sf c='…'`):

| Command | Effect |
| --- | --- |
| `make fixtures_load` | Full reset (**destroys DB + ES**), the only fully reliable path |
| `make index_clear` | `gally:index:clear --with-data-streams --with-transforms` |
| `make sf c='hautelook:fixtures:load --append -vv'` | Reload YAML only |
| `make sf c='doctrine:fixtures:load --append'` | Reload ES documents only |
| `make phpcsfixer` / `make phpstan` / `make qa_back` | QA (mirrors `.github/workflows/qa.yml`) |

### 1a. YAML → database (nelmio/alice + hautelook/alice-bundle)

- Fixture paths are registered in `src/DependencyInjection/GallySampleDataExtension.php::prepend()`,
  which asks `src/CatalogSelection.php` which folders take part, and adds each `*/premium`
  subfolder. Any `*.yaml` dropped in one of them is loaded — there is no explicit ordering list.
  `DataFixtures/` holds one folder per data set: `common` plus the catalog sets (`00_toolbox`,
  `01_fashion`, `02_papershop`, `default`, ...). A new folder needs no edit here.
- **`common/` always loads**, whatever the selection. It carries the `cms_page` metadata, the
  users and every source field more than one catalog needs, so each catalog folder holds only
  what is its own. That is what lets a single catalog be loaded on its own.
- **Loading a subset**: set `GALLY_SAMPLE_DATA_CATALOGS` to a comma separated list of folder
  names, or pass `make fixtures_load catalogs=default`. Empty loads everything. An unknown name
  is an error, not a silent empty load. CI sets it to `default` (monorepo
`.github/workflows/tests.yml`; `compose.yml` only passes it through) so the e2e
  assertions do not move when a demo catalog is added.
- **A new folder, or a changed selection, is invisible until the container is rebuilt.**
  `prepend()` reads the filesystem and the env var, so both are compiled into the DI container
  and Symfony cannot track them as config resources. `make fixtures_load` runs `cache:clear`
  for this reason; do the same by hand after adding a set folder, or the load silently uses the
  previous list.
- Ordering is driven by `include:` headers and `'@reference'` links, not by filename. A file in
  a catalog folder reaches `common/` with `include: - ../common/<file>.yaml`; an include is
  resolved relative to the including file's own folder, so a bare name never finds a sibling
  folder.
- `src/Locator/PremiumFilesLocator.php` decorates `hautelook_alice.locator` and **filters out
  everything under `/premium/`** when no premium bundle is installed. So `premium/*.yaml` may
  reference premium entity classes safely.

### 1b. JSON → Elasticsearch (doctrine fixtures)

Four thin `Fixture` classes in `src/Service/`, registered in `src/Resources/config/services.yaml`
with the `doctrine.fixture.orm` tag. Each creates the indices (data streams for tracking events),
then loads the documents. The tracking one also provisions the `tracking_session` transform for
every localized catalog, because the fixture load bypasses `TrackingEventHandler`.

| Service | Creates | Loads |
| --- | --- | --- |
| `ElasticsearchProductFixtures` | indices for `product` | `elasticsearch/product_documents.json` |
| `ElasticsearchCategoryFixtures` | indices for `category` | `elasticsearch/categories_documents.json` |
| `ElasticsearchCmsPageFixtures` | indices for `cms_page` | `elasticsearch/cms_page_documents.json` |
| `ElasticsearchTrackingEventsFixtures` | **data streams** for `tracking_event` | `elasticsearch/tracking_event_documents.json` |

Indices are created for **every localized catalog in DB**, so the YAML must be loaded first.

Each asks `CatalogSelection::documentFiles()` for the file under every selected catalog folder,
skipping a folder that carries no document of that entity. A new set folder is picked up with no
edit here, and it follows the same `GALLY_SAMPLE_DATA_CATALOGS` selection as the YAML side. These
four used to hold a hardcoded array apiece, which is why a new folder used to index nothing and
say nothing.

---

## 2. Conventions that fail silently

Full conventions are in `gally-sample-data/references/authoring.md` (Alice YAML) and
`gally-sample-data/references/documents.md` (Elasticsearch documents). These four are here
because nothing reports them — the load succeeds and the data is simply wrong.

- **`metadata.yaml` declares only `cms_page`.** `product` and `category` metadata and their system
  source fields (`id`, `sku`, `category`, `name`, `price`, `image`, `stock`, `description`,
  `url_key`, …) are inserted by
  `gally-standard/src/Migrations/Version20250729114500_Add_Install_Data.php`. Do not redeclare them
  here — declare only non-system, catalog-specific attributes.
- **Every `Category` needs a `Category\Configuration` row**, one per localized catalog, carrying
  the name (`gally-sample-data/references/authoring.md` §3). The category tree is built from the
  **database**, not from `categories_documents.json` — that file only feeds search. Omit the
  Configuration block and the load succeeds, search works perfectly, the skill's checks pass, and
  `/api/categoryTree?catalogId=N` returns `[]` with every category unnamed. Nothing anywhere reports it.
- **A CMS option value belongs to one catalog only.** `SourceFieldOption` is unique on
  (source_field, code), and `cms_page_topic`/`tags`/`author` live in `common/`, so every thematic
  catalog prefixes its own option codes (`tbx_`, `fio_`, `llv_`) and carries the prefix into the
  `value` of its cms_page documents. Drop the prefix on one side only and the value indexes
  happily, then renders as a raw code in the facet.
- **`index_name` must equal the index alias** built by
  `IndexSettings::getIndexAliasFromIdentifier()`:
  `gally_localized_catalog_{localized_catalog_code_lowercase}_{entity}`. A typo silently creates a
  stray index that no search will ever hit.
- **A `select` value that matches no `SourceFieldOption.code` still indexes** — and then renders as
  a raw code in the facet instead of a label.
- **Prefer `@now:±Nd` over literal timestamps** in any new tracking event. The token is replaced at
  load time with `Y-m-d H:i:s` of now ± N days (regex `/@now:([+-]?\d+)d/`). Literal dates rot and
  fall out of the analytics windows.

Valid source field `type` values (`Gally\Metadata\Entity\SourceField\Type`): `text`, `keyword`,
`select`, `int`, `boolean`, `float`, `price`, `stock`, `category`, `reference`, `image`, `object`,
`date`, `location`, `file`.

---

## 3. The dataset

Counts of catalogs, categories, products, CMS pages and tracking events are not kept in a doc:
they change with the data. Measure them from the fixture files when you need them, and do not
copy them anywhere. What each shop is for is in `guides/{en,fr}/`.

---

## 4. Rules when editing data

1. **Keep referential integrity across the four ES files and the YAML.** Every
   `tracking_event.entity_code` must resolve to a `sku`/`id` in the *same localized catalog's*
   product/category/cms index. Every `product.category[].id` must exist in that catalog's
   category index (except the root). Run the skill's checks (§5) after every change.
2. **A localized catalog is a full data silo.** Adding a product to `com_en` without adding it
   to `com_fr` breaks the locale switch. Adding a localized catalog means adding its ES block
   to *all* relevant document files **and** its labels.
3. **Never hand-edit `product_documents.json` blindly** — it is several MB. Script it
   (Python/`jq`), and re-serialize with the existing formatting (2-space indent, `/` escaped as
   `\/` in the existing file is tolerated but not required — keep diffs minimal).
4. **New attribute = 3 or 4 files**: `product_source_field.yaml` (+ `_label`, and `_option` /
   `_option_label` for `select` types) **and** the value in `product_documents.json` for every
   localized catalog. A `select` value in ES must be `{"value": "<option code>", "label": "…"}`
   matching a `SourceFieldOption.code`.
5. **Don't declare system source fields** (see §2).
6. **Prefer `@now:-Nd`** for any new tracking timestamp.
7. **Premium data goes in the set's own `premium/` subfolder** (`src/DataFixtures/<set>/premium/`)
   — never reference premium entity classes
   from a non-premium fixture file, the OSS install will fatal.
8. Fixtures are loaded with `--append`; the demo flow always drops the DB first. Do not rely on
   partial reloads to validate a change — do a full `make fixtures_load`.
9. **`make phpcsfixer` + `make phpstan` (level 5)** must pass before pushing; CI reruns them
   against the whole Gally stack (`.github/workflows/qa.yml`).
10. `.github/workflow.env` pins `last_published_version` and drives CI's
    composer resolution; bump it only when releasing.

---

## 5. Definition of done

A data change is done when the `gally-sample-data` skill's checks report no regression (the skill
says which checks and how to run them), `make fixtures_load` completes, and the demo itself shows
the change. A load with no exception is not evidence the data is right.

---

## 6. Conventions

- Commits: `feat(#<tracker-id>): <subject>` or `fix(<scope>): …`; `[Scope] #id - subject` also
  appears in history. Branches: `feat-<tracker-id>-<name>`, release branches `2.3.x`.
- PHP files carry the mandatory `DISCLAIMER.` docblock header (php-cs-fixer enforces it via
  `.php-cs-fixer.dist.php`) — copy it when adding a class.
- License: OSL-3.0.
