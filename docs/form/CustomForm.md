# CUSTOM FORM

## Introduction
Les custom form, sont des formulaires qui permettent de créer des interfaces plus complexes avec par exemple la présence
d'éléments comme des input, des slider, des dropdown, etc... 

## Utilisation

### Création d'une custom form
```injectablephp
$form = new \arkania\form\class\CustomForm(
    $player,
    'Titre du formulaire',
    'Contenu du formulaire',
    [
        #Elements
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