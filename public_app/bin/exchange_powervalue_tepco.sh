#! /bin/sh

CLIPATH=/home/ftuser/enecom_app/cli
TARGATENAME=TEPCO

echo "$TARGETNAME auto file reciever"
# 受信可能ファイル取得
echo "Run file_exchange.php..."
/usr/bin/php -f $CLIPATH/file_exchange.php
echo "...done"

# 30分電力値インポート
echo "Run quick_value.php..."
/usr/bin/php -f $CLIPATH/quick_value.php
echo "...done"

# 日毎30分電力値インポート
echo "Run daily_value.php..."
/usr/bin/php -f $CLIPATH/daily_value.php
echo "...done"

# 確定値インポート
#echo "Run fix_value.php..."
#/usr/bin/php -f $CLIPATH/fix_value.php
#echo "...done"
