# GUI

## Introduction
Les GUI sont des interfaces utilisateur graphiques. Elles permettent par exemple d'afficher des interfaces de coffre, 
d'inventaire ou autre.

## Création d'une GUI
Pour cet exemple on va prendre la class ``ChestMenu`` mais cela marche avec les autres classes de l'API.
````injectablephp
$menu = new ChestMenu(
                $sender,
                '§eNacre-UI', //Nom de l'interface.
                false, // viewOnly se qui signie que l'interface ne peut pas être modifié.
                null, // Contenu de l'interface.
                function(Player $sender, MenuTransaction $transaction) : MenuTransactionResult {
                    $sender->sendMessage('§8-> §eVous avez cliqué sur la case n°' . $transaction->getSlot());
                    $sender->removeCurrentWindow();
                    return $transaction->continue(); // Cela signifie que le joueur peux prendre l'item (discard pour annuler).
                }, // Fonction appelé lorsqu'un joueur clique sur une case.
                function(Player $sender, BaseMenu $inventory) : void {
                    $sender->sendMessage('§8-> §eVous avez fermé l\'inventaire');
                } // Fonction appelé lorsqu'un joueur ferme l'inventaire.
            );
            $menu->send($sender); // Envoie l'interface au joueur.
````