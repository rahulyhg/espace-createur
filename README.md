#Espace Createur

Maintenu par: Ne02ptzero <louis@ne02ptzero.me> et Fusiow

## Docs

### Norme:
La norme K&R pour tout les langages.

#### Nom des fonctions:
La norme JS est demande pour le nom des fonctions:
```php
function myAwesomeFunction();
```
> Attention, dans le cas ou une fonction view s'appelle 'showUsers', le template demande sera 'show_users.ctp' et non pas showUsers.ctp

#### Headers:
```php
/**
 * Definition of file
 * By: Author <email@email.com>
 */
```

#### PHP:
Definition de la fonction avant la declaration:
```php
/**
 * Function strlen, count number of letters
 * @param: String
 * @return: Number
 */
 function   strlen($str) {
```
Cette regle vaut aussi pour le JS.

Dans le cas ou la fonction sers pour une view, indiquer le template associe:
```php
/**
 * ..
 * Template: Controller/view.ctp
 */
```

#### CSS:
Un fichier css par controller
UsersController.php => Users.css

Declarer les differents index:
```css
/*****************/
/* action: index */
/****************/
```

### Notifications:

Voici comment doivent etre appeles les notifications:
```php
$this->Session->setFlash("Message", 'default', array(), __TYPE__);
```
ici, __TYPE__ peut etre egal a 'good' ou 'bad', en fonction du message a envoyer.

## Design:

Le template utilise est Flat Ui [1], base sur Bootstrap [2].

[1] [Presentation](http://designmodo.github.io/Flat-UI/) [Examples](http://designmodo.github.io/Flat-UI/docs/components.html)

[2] [Bootstrap](http://getbootstrap.com/css/)
