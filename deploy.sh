#!/bin/sh



cd $1
#touch test.txt
#pwd > test.txt
#echo $1

if [ $2='master' ]; then
    git checkout master
    git pull origin master
fi

if [ $2 = 'develop' ]; then
    git checkout develop
    git pull origin develop
fi

git pull