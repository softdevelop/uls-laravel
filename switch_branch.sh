#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
COMPOSER_CMD=$(which composer)
# echo $DIR
# echo "Running Composer"
cd $DIR
# $COMPOSER_CMD update
# $COMPOSER_CMD dumpautoload -o
# echo "Done.."

BRANCH=$1
pullVendorRowboat()
{
    GIT_COMMAND="git checkout -b"$1" origin/"$1
    PATH_VENDOR=$DIR'/vendor/rowboat/'$2
    cd $PATH_VENDOR
    

    GIT_FETCH_COMMAND="git fetch "
    $GIT_FETCH_COMMAND

    $GIT_COMMAND
}
if [ -z "$BRANCH" ]; then
    BRANCH="master"
fi

packages=(
    "cms-asset" 
    "cms-content" 
    "cms-block" 
    "cms-page" 
    "cms-template"
    "cms-database"
    "ticket"
    "user"
    "term-builder"
    "file"
    )
for i in "${packages[@]}"; do
    echo 'start pull package '$i'to '$BRANCH
    pullVendorRowboat $BRANCH $i
    echo 'end pull package ' $BRANCH $i
done

