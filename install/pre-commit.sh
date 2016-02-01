#!/bin/bash
echo "1. Untrack environment vars"

# cd ~/Sites/postmaster
git update-index --assume-unchanged opsworks/*
# git update-index --no-assume-unchanged opsworks/*

exit 0