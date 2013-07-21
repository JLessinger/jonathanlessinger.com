#!/bin/bash

if [[ ( -e ".local"  &&  -e ".remote" ) || ! ( -e ".local" || -e ".remote"  ) ]]
then
  echo "ambiguous location"
  exit -1
fi

progname="host_config";
tocomment="";
touncomment="";

if [[ $1 = "-local" ]]
then
    touncomment="local"
    tocomment="remote"
elif [[ $1 = "-remote" ]]
then
    touncomment="remote"
    tocomment="local"
elif [[ $1 = "-where" ]]
then
    if [[ -e ".local" ]]
    then
	echo "local"
	exit 0
    else
        echo "remote"
	exit 0
    fi
else
    echo "usage: "$progname" [-local | -remote | -where]"
    exit -1
fi

function finish {
    touch .$touncomment
    if [ -e .$tocomment ]
    then
	yes | rm .$tocomment
    fi

    echo $1
    exit 0
}

if [ -e .$touncomment ] 
then
    finish "already done"
fi

declare -a files=("./TimeClock/css/.htaccess" "./TimeClock/js/.htaccess" "./TimeClock/php/.htaccess" "./TimeClock/.htaccess" "./.htaccess" "./TimeClock/php/connect.php");

#declare -a files=("f1.php");

function search_replace {
    comment=""
    filename=$(basename "$1")
    extension="${filename##*.}"
#    echo $extension
    case "$extension" in
	"htaccess")
	   comment="#"
	   ;;
	"php" | "js")
	   comment="//"
	   ;;
    esac
    echo $1 $comment $tocomment "->" $touncomment
  
    perl -i.bak -p00e "s@\s*$comment\s*$tocomment.*[\n\r](\s*)@$&$comment@gm" $1
    perl -i.bak -p00e "s@(\s*$comment\s*$touncomment.*[\n\r]\s*)($comment)@\$1@gm" $1

    rm $1.bak
}

for f in ${files[@]}
do
    search_replace $f;
done

finish "done"