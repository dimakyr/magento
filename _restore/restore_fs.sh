#/bin/bash
echo "Restoring filesystem..."
git reset --hard

echo "Setting file permissions..."
chown -R smile:www-data ../
chmod -R g+w ../var ../media ../app/etc
SMILE_OWNED=( "../.git" "../.idea" "../_restore" "../cron.sh" )
for _path in "${SMILE_OWNED[@]}"
do
  if [ -f "$_path" ] || [ -d "$_path" ]; then
    chown -R smile:1000 "$_path"
  fi;
done
