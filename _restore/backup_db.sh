#/bin/bash
BASE_DIR="${PWD%/*}"
MAGENTO_VER="${BASE_DIR##*/}"
DB_NAME="magento_${MAGENTO_VER}"
SQL_FILE="${DB_NAME}.sql.gz"

echo "Backing up database..."
mysqldump "$DB_NAME" | gzip -c > "$SQL_FILE"

echo "Backup complete: $SQL_FILE."
