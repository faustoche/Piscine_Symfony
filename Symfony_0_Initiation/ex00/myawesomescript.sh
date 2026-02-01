#!/bin/sh

# Curl va permettre de recuperer l'info
# Grep filtre la ligne interessante
# Cut nettoie le tout

# Bitly renvoit 301 -> Moved permanently
# Dans le header location de la reponse, on recupere le vrai url



curl -I --silent $1 | grep "location" | cut -d " " -f 2