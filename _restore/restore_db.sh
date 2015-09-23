#/bin/bash
BASE_DIR="${PWD%/*}"
MAGENTO_VER="${BASE_DIR##*/}"
DB_NAME="magento_${MAGENTO_VER}"
SQL_FILE="${DB_NAME}.sql.gz"

echo "Restoring database..."
gunzip -c "$SQL_FILE" | mysql "$DB_NAME"
