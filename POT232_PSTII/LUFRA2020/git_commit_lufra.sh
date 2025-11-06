#!/usr/bin/env bash
# Script para revisar, añadir y commitear el .gitignore de LUFRA2020
set -euo pipefail
FILE="POT232_PSTII/LUFRA2020/.gitignore"
MSG="Add .gitignore for LUFRA2020 (IDE, node, vendor, Laravel, db ignores)"

echo "Repository root: $(git rev-parse --show-toplevel 2>/dev/null || echo 'unknown')"

echo "\n== Status (porcelain) =="
git status --porcelain || true

echo "\n== Diff for $FILE =="
git --no-pager diff -- "$FILE" || true

echo "\n== Adding and committing =="
if git ls-files --error-unmatch "$FILE" >/dev/null 2>&1; then
  echo "$FILE is already tracked. Staging anyway..."
fi

git add "$FILE"

# Try to commit; if there's nothing to commit, exit gracefully
if git commit -m "$MSG"; then
  echo "Commit creado con éxito."
  echo "Para empujar los cambios: git push origin main"
else
  echo "No se creó un commit (quizá no había cambios)."
fi
