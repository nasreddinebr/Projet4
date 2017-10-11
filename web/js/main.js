$(function() {
    // DatePicker
    // On recupere les jours de fermeture qu'on importer depuis la DB
    /*var daysToDisable = []; // Les jours de fermeture
    $('.jourFermer').each(function (index, element) {
        daysToDisable[index] = $(element).val();
    });
    for (var i = 0; i < daysToDisable.length; i++) {
        console.log(daysToDisable[i]);
    }*/
    var txt2=[];
    //pour chaque textarea, on déclenche une fonction qui parcours l'objet textearea
    $('.jourFermer').each(function(index,element){
        //on stocke les éléments récupéré dans notre chaine de caractères

        txt2[index] = $(element).val();
    });
    //on affiche le résultat sous forme d'alerte
    for (var i = 0; i < txt2.length; i++) {
        alert(txt2);
    }

    // Integration de datepicker et desactivation des jours de fermeture
    /*$( "#form_collection_billets_dateReservation" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: 0,
        beforeShowDay: function (date) {
            var day = date.getDay();
            var month = date.getMonth();
            var currentDate =date.getDate();
            if (day == 2) { // desactivation de tou les mardi
                return [false];
            //}else if ($.inArray(currentDate + '/' + (month + 1), daysToDisable) != -1){
            }else if ($.inArray(currentDate + '/' + (month + 1), txt2) != -1){
                // Desactivation des jour ferier
                return [false];
            } else {
                return [true];
            }
        }
    });*/


/*
    //Form Collection
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#form_collection_clients');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // Nombre de visiteurs
    $('#add_client').on('click', function(e) {
        var $number = document.getElementById("num").value;
        if (index == 0) {
            // On ajoute les champs selon le nombre des visiteur
            addClient($container, $number);
            ajoutPaiementForm($container);
        } else {
            //si le client change le nombre de visiteur et s'il exist déja des champs on les supprime
            for (var i = 0; i < index; i++) {
                $container.children('div').each(function() {
                    addDeleteLink($(this));
                });
            }
            index = 0;
            // On recrée les champ des selon le nouveaux nombre des visiteurs
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

    // La fonction qui supprime les catégorie
    function addDeleteLink($prototype) {
        $prototype.remove();
        return false;
    }

    // Formulaire de paiement
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

    }*/
});
