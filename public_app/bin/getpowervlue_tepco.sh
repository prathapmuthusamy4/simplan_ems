#! /bin/sh

TARGET=TEPCO
KEY=/home/ftuser/cert/EPP_20574_000000000000020364.pem
PASS=11456552
LISTURL=https://pu00.www6.tepco.co.jp/LNXWPWSS01OH/LNXWPWSS01I/FileListReceiver
FILEURL=https://pu00.www6.tepco.co.jp/LNXWPWSS01OH/LNXWPWSS01I/FileReceiver

echo "=== Get $TARGET Value ==="
HTML=`/usr/bin/curl $LISTURL -E $KEY:$PASS`


echo $HTML




