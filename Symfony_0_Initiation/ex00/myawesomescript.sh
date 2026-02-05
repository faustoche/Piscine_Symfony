#!/bin/sh

# Curl get the info we looking for
# Grep filter the line we want
# Cut clean everything

# Bitly return 301 ->  Moved permanently
# In location header of answer, we can get the real url

curl -I --silent $1 | grep "location" | cut -d " " -f 2