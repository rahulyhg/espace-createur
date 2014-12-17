DB=ec_espace_createur
USER=
PASS=
git submodule init
git submodule update
mysql --user="$USER" --password="$PASS" $DB < db.sql
