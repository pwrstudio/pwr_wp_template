#!/bin/bash
TIME=`date +%Y-%m-%d-%H-%M`
NAME=${PWD##*/}
NICK=`gshuf -n 1 /usr/share/dict/words`
mkdir -v ../$NAME-$TIME-$NICK
cp -v ./*.php ../$NAME-$TIME-$NICK/
cp -v ./app.min.js ../$NAME-$TIME-$NICK/
cp -v ./style.css ../$NAME-$TIME-$NICK/
rsync -av ./img/ ../$NAME-$TIME-$NICK/img
rsync -av ./fonts/ ../$NAME-$TIME-$NICK/fonts