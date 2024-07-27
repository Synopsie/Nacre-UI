# SIMPLE FORM

## Introduction
Les simples form sont les formulaires les plus simples à utiliser. Ils sont utilisés pour toutes les actions qui peuvent 
être faites seulement en appuyant sur un bouton.

## Utilisation

### Création d'une simple form
```injectablephp
$form = new SimpleForm(
    $player,
    'Titre du formulaire',
    'Contenu du formulaire',
    [
        new SimpleButton('nom du bouton', 'texte du bouton', /*Fichier Icon (optionnel)*/, 'permission (optionnel)'),
    ],
    function (Player $player, $data) { #Optionnel
        // Action à effectuer lors de appui sur le bouton
    },
    function (Player $player) { #Optionnel
        // Action à effectuer lors de la fermeture du formulaire
    }
);
$player->sendForm($form);
```
*Voici donc la façons la plus simple de faire un formulaire.*

### Permission
Si vous souhaitez ajouter une permission à votre formulaire, faire :
```injectablephp
$form->setPermission('nom de la permission');
```