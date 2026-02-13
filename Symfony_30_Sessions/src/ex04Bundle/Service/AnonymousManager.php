<?php

namespace App\ex04Bundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class AnonymousManager
{
    private const ANIMALS = ['Dog', 'Cat', 'Panda', 'Capybara', 'Sloth', 'Otter', 'Racoon'];
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
		// recuperation de la session via requeststack
        $this->requestStack = $requestStack;
    }

    public function handleAnonymousUser(): array
    {
        $session = $this->requestStack->getSession();
        $now = time();

        // recuperation des infos stockees
        $lastRequest = $session->get('ex04_last_request');
        $currentName = $session->get('ex04_anon_name');

        $secondsSince = 0;

		// si pas de nom ou requete + 1 mn
        if (!$currentName || !$lastRequest || ($now - $lastRequest > 60)) {
            // nouvelle session ou session expiree 
            $randomAnimal = self::ANIMALS[array_rand(self::ANIMALS)];
            $currentName = 'Anonymous ' . $randomAnimal;
            
            // sauvegarde du nouveau name
            $session->set('ex04_anon_name', $currentName);
            
            // remise a 0
            $secondsSince = 0;
        } else {
            // calcul de la diff pour session active
            $secondsSince = $now - $lastRequest;
        }

        // maj de l'heure de la dereire requete
		$session->set('ex04_last_request', $now);

        return [
            'name' => $currentName,
            'seconds_since' => $secondsSince
        ];
    }
}