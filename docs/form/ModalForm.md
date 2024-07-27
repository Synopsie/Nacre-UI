# MODAL FORM
## Introduction
Les modal form sont des interfaces de dialogue. Ils sont utilisés pour afficher des messages, des avertissements, des quêtes, etc...

## Utilisation

### Création d'une modal form
```injectablephp
$form = new \arkania\form\class\ModalForm(
    $player,
    'Titre du formulaire',
    'Contenu du formulaire',
    'Bouton 1',
    'Bouton 2',
    function (Player $player, $data) { #Optionnel
        // Action à effectuer lors de appui sur le bouton
    },
    function (Player $player) { #Optionnel
        // Action à effectuer lors de la fermeture du formulaire
    }
);
$player->sendForm($form);
```
*Voici donc la façons la plus simple de faire un formulaire*

### Permission
Si vous souhaitez ajouter une permission à votre formulaire, faire :
```injectablephp
$form->setPermission('nom de la permission');
```