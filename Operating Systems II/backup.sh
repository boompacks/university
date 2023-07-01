while true; do
  rsync -avzb /nextcloud /backup
  sleep 300 
done
