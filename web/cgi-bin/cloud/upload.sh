#!/bin/bash
echo "Content-type: text/html\n\n"
echo ""

if [ "$1" = "" ]; then
  echo "please input filename\n"
  exit 0
else
#  test -e $1 && echo "this file name has exist\n" && exit 0
  FILENAME=$1
fi
USERID=markii
USERPWD=socle-markii
CLIENTID=SCJ1hwDGVDaDlnD0OaNG
CLIENTSECRET=bRtNyXKP77WvmVzvkiJMd8LoSJC6Db3y
#touch ${FILENAME}
echo "****** Start ******\n"
# access token & refresh token
RESPONSE=$(curl -s -k -X POST -d "grant_type=password&username=${USERID}&password=${USERPWD}&client_id=${CLIENTID}&client_secret=${CLIENTSECRET}&scope=profile" https://my.9ifriend.com/oauth/token)
echo "\n"${RESPONSE}"\n"
if [ "$(echo ${RESPONSE}|cut -d'"' -f2)" = "error" ]; then 
  echo "\nmust get new authorization code\n"
else
  ACCESS_TOKEN=$(echo ${RESPONSE}|cut -d'"' -f4)
  REFRESH_TOKEN=$(echo ${RESPONSE}|cut -d'"' -f14)
  echo "\nAccess Token: ${ACCESS_TOKEN}\n"
  echo "\nRefresh Token: ${REFRESH_TOKEN}\n"
  RESPONSE=$(curl -s -H "Authorization: Bearer $ACCESS_TOKEN" -F name=${FILENAME} -F parentid=d2e1f101-d34b-4ac0-bf23-5c4d57bff89a -F file=@${FILENAME} https://sas.9ifriend.com/v1.1/upload/files)
  echo "\n"${RESPONSE}"\n"
  echo "\nuploading....\n"
fi
# rm ${FILENAME}
echo "\n****** END ******\n"
#exit 0
