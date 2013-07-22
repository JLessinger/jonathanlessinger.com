#!/bin/bash

host=""
config=".host"
progname="host_config";
tocomment="";
touncomment="";

if [[ -e $config ]]
then
   host=`cat $config`;
   if [[ $host != "local" && $host != "remote" ]]
   then
       echo "bad config file"
       exit -1
   fi
else
  echo "no config file"
  exit -1
fi


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
    echo $host
    exit 0
else
    echo "usage: "$progname" [-local | -remote | -where]"
    exit -1
fi

function finish {
    echo $touncomment > $config

    echo $1
    exit 0
}

if [ `cat $config` == $touncomment ] 
then
    finish "already done"
fi

declare -a files=("./TimeClock/css/.htaccess" "./TimeClock/js/.htaccess" "./TimeClock/php/.htaccess" "./TimeClock/.htaccess" "./.htaccess" "./TimeClock/php/connect.php");

#declare -a files=("./f.php");

function search_replace {
    comment=""
    filename=$(basename "$1")
    extension="${filename##*.}"

    case "$extension" in
	"htaccess")
	   comment="#"
	   ;;
	"php" | "js")
	   comment="//"
	   ;;
    esac
    echo $1 $tocomment "->" $touncomment
  
    perl -i.bak -p00e "s@(\s*)($comment)+(\s*$tocomment.*[\n\r])(\s*)@\$1\$2\$3\$4$comment@gm" $1
    perl -i.bak -p00e "s@(\s*)($comment)+(\s*$touncomment.*[\n\r]\s*)($comment)+@\$1\$2\$3@gm" $1

    rm $1.bak
}

for f in ${files[@]}
do
    search_replace $f;
done

finish "done"