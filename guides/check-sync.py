#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Check that the English and French demo scripts have not drifted apart.

The two folders are translations of one document, not two documents. What has to match is the
STRUCTURE: the same files, the same headings in the same order at the same level, and the same
number of rows in every table. The prose differs, obviously, and so does its length.

It does not check the translation itself. It catches the failure that actually happens: a section
or a table row added to one language and forgotten in the other.

Usage:  ./check-sync.py          from the guides/ folder, or with its path
Exit 0 when the two sides match, 1 otherwise.
"""

import io
import os
import re
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
LANGS = ('en', 'fr')


def read(lang, name):
    return io.open(os.path.join(HERE, lang, name), encoding='utf-8').read()


def headings(text):
    """Heading levels in order. The text is translated, so only the shape is comparable."""
    return [len(m.group(1)) for m in re.finditer(r'^(#+) ', text, re.M)]


def table_rows(text):
    return sum(1 for line in text.splitlines() if line.startswith('|'))


def links(lang, name, text):
    out = []
    for m in re.finditer(r'\]\(([^)#][^)]*)\)', text):
        target = m.group(1)
        if target.startswith('http'):
            continue
        out.append((target, os.path.normpath(os.path.join(HERE, lang, target))))
    return out


def main():
    problems = []
    files = {}
    for lang in LANGS:
        d = os.path.join(HERE, lang)
        if not os.path.isdir(d):
            print('missing folder: %s/' % lang)
            return 1
        files[lang] = sorted(f for f in os.listdir(d) if f.endswith('.md'))

    only_en = set(files['en']) - set(files['fr'])
    only_fr = set(files['fr']) - set(files['en'])
    for name in sorted(only_en):
        problems.append('en/%s has no French counterpart' % name)
    for name in sorted(only_fr):
        problems.append('fr/%s has no English counterpart' % name)

    for name in sorted(set(files['en']) & set(files['fr'])):
        en, fr = read('en', name), read('fr', name)
        he, hf = headings(en), headings(fr)
        if he != hf:
            problems.append('%s: heading structure differs, en has %d and fr has %d'
                            % (name, len(he), len(hf)))
        te, tf = table_rows(en), table_rows(fr)
        if te != tf:
            problems.append('%s: table rows differ, en has %d and fr has %d' % (name, te, tf))
        for lang, text in (('en', en), ('fr', fr)):
            for target, path in links(lang, name, text):
                if not os.path.exists(path):
                    problems.append('%s/%s: broken link to %s' % (lang, name, target))

    if problems:
        print('%d problem(s):' % len(problems))
        for p in problems:
            print('  - ' + p)
        return 1

    print('en/ and fr/ are in sync: %d files, matching headings, tables and links'
          % len(files['en']))
    return 0


if __name__ == '__main__':
    sys.exit(main())
