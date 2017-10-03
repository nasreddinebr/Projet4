$(function() {
    // DatePicker
    var daysToDisable = ['1-11', '25-12', '1-5']; // Les jour ferier à importer depuis la BD
    $( "#form_collection_billets_dateReservation" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: 0,
        beforeShowDay: function (date) {
            var day = date.getDay();
            var month = date.getMonth();
            var currentDate =date.getDate();
            if (day == 2) { // desactivation de tou les mardi
                return [false];
            }else if ($.inArray(currentDate + '-' + (month + 1), daysToDisable) != -1){
                // Desactivation des jour ferier
                return [false];
            } else {
                return [true];
            }
        }

    });

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#form_collection_clients');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // Nombre de visiteurs
    $('#add_client').on('click', function(e) {
        var $number = document.getElementById("num").value;
        if (index == 0) {
            // On ajoute les champs à chaque clic sur le lien de valiodation.
            addClient($container, $number);
            ajoutPaiementForm($container);
        } else {
            for (var i = 0; i < index; i++) {
                // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
                $container.children('div').each(function() {
                    addDeleteLink($(this));
                });
            }
            index = 0;
            addClient($container, $number);
        }
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    });

    // La fonction qui ajoute un formulaire CategoryType
    function addClient($container, $number) {
        for (var i = 0; i < $number; i++) {
            // Dans le contenu de l'attribut « data-prototype », on remplace :
            // - le texte "__name__label__" qu'il contient par le label du champ
            // - le texte "__name__" qu'il contient par le numéro du champ
            var template = $container.attr('data-prototype')
                .replace(/__name__label__/g, 'Client n°' + (index + 1))
                .replace(/__name__/g, index);

            // On crée un objet jquery qui contient ce template
            var $prototype = $(template);

            // On ajoute le prototype modifié à la fin de la balise <div>
            $container.append($prototype);

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            index++;
        }
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        //var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

        // Ajout du lien
        //$prototype.append($deleteLink);

        $prototype.remove();

        return false;
    }

    function ajoutPaiementForm($prototype) {
        var $paiementForm = $('<hr>\n' +
            '\t\t\t\t\t<div class="form-inline col-sm-6">\n' +
            '\t\t\t\t\t\t<label for="nom-p">Votre nom</label>\n' +
            '\t\t\t\t\t\t<input id="nom-p" class="form-control form-control-lg" type="text" name="name" placeholder="Votre nom" value="test" required>\n' +
            '\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t\n' +
            '\n' +
            '\t\t\t\t\t<div class="form-inline col-sm-6">\n' +
            '\t\t\t\t\t\t<label for="email-p">Votre Email</label>\n' +
            '\t\t\t\t\t\t<input id="email-p" class="form-control form-control-lg" type="email" name="email" placeholder="Votre e-mail" value="test@hotmail.fr" required>\n' +
            '\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t\n' +
            '\n' +
            '\t\t\t\t\t<div class="form-inline col-sm-6">\n' +
            '\t\t\t\t\t\t<label for="num-carte">Numéro de carte</label>\n' +
            '\t\t\t\t\t\t<input id="num-carte" class="form-control form-control-lg" type="text" placeholder="Votre code de carte bleu" value="4242 4242 4242 4242" data-stripe="number" required>\n' +
            '\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t\n' +
            '\n' +
            '\t\t\t\t\t<div id="test" class="d-flex flex-row">\n' +
            '\t\t\t\t\t\t<div class="p-2">\n' +
            '\t\t\t\t\t\t\t<label for="moi-exp">Moi</label>\n' +
            '\t\t\t\t\t\t\t<input id="moi-exp" class="form-control form-control-lg" type="text" placeholder="MM" value="10" data-stripe="exp-month" required>\n' +
            '\t\t\t\t\t\t</div>\n' +
            '\n' +
            '\t\t\t\t\t\t<div class="p-2">\n' +
            '\t\t\t\t\t\t\t<label for="year-exp">Année</label>\n' +
            '\t\t\t\t\t\t\t<input id="year-exp" class="form-control form-control-lg" type="text" placeholder="YY" value="18" data-stripe="exp-year" required>\n' +
            '\t\t\t\t\t\t</div>\n' +
            '\n' +
            '\t\t\t\t\t\t<div class="p-2">\n' +
            '\t\t\t\t\t\t\t<label for="cvc1">CVC</label>\n' +
            '\t\t\t\t\t\t\t<input id="cvc1" class="form-control form-control-lg p-2" type="text" placeholder="CVC" value="125" data-stripe="cvc" required>\n' +
            '\t\t\t\t\t\t</div>\n' +
            '\n' +
            '\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t<br>\n' +
            '\t\t\t\t\t<div class="col-sm-12">\n' +
            '\t\t\t\t\t\t<button type="submit" class="btn btn-primary">Valider</button>\n' +
            '\t\t\t\t\t</div>');
        //$prototype.append($paiementForm);
        $($paiementForm).insertAfter($($prototype));

    }
});
