#!/bin/bash
TIME=`date +%Y-%m-%d-%H-%M`
NAME=${PWD##*/}  
mkdir -v ../$NAME-$TIME
cp -v ./*.php ../$NAME-$TIME/
cp -v ./main.min.js ../$NAME-$TIME/
cp -v ./templates.js ../$NAME-$TIME/
cp -v ./style.css ../$NAME-$TIME/
cp -v ./img ../$NAME-$TIME/