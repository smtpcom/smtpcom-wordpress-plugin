#!/usr/bin/env bash
#
# Builds the installable plugin zip from the committed tree (HEAD).
# vendor/ is not tracked in git; it is installed here from composer.lock.
#
# Usage: bin/build-zip.sh [output-dir]   (default: ./dist)
# Requires: git, composer, zip

set -euo pipefail

SLUG="smtp-com-mail"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT_DIR="$(mkdir -p "${1:-$ROOT/dist}" && cd "${1:-$ROOT/dist}" && pwd)"
VERSION="$(sed -n 's/^ \* Version: *//p' "$ROOT/$SLUG.php")"
STABLE_TAG="$(sed -n 's/^Stable tag: *//p' "$ROOT/readme.txt")"

if [ "$VERSION" != "$STABLE_TAG" ]; then
    echo "Version mismatch: $SLUG.php has $VERSION, readme.txt Stable tag is $STABLE_TAG" >&2
    exit 1
fi

WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

git -C "$ROOT" archive --format=tar --prefix="$SLUG/" HEAD | tar -x -C "$WORK"

# The SDK path repository (sdk/) must be present while composer runs.
composer install --working-dir="$WORK/$SLUG" --no-dev --optimize-autoloader --no-interaction --no-progress

# Files that are only needed for development or for the WordPress.org SVN assets folder.
rm -rf "$WORK/$SLUG"/{.github,bin,sdk,assets,.gitignore,README.md,composer.json,composer.lock}

ZIP="$OUT_DIR/$SLUG-$VERSION.zip"
rm -f "$ZIP"
(cd "$WORK" && zip -rqX "$ZIP" "$SLUG")

echo "$ZIP"
