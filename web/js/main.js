$(function() {
    // Variables
    var dateNaissance = [];
    var daysToDisable = []; // Les jours de fermeture
    var $url, $result;

    // DatePicker
    // On recupere les jours de fermeture qu'on importer depuis la DB

    $('.jourFermer').each(function (index, element) {
        daysToDisable[index] = $(element).val();
    });

    // Integration de datepicker et desactivation des jours de fermeture à la date de reservation
    $( "#form_collection_billets_dateReservation" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: 0,
        beforeShowDay: function (date) {
            var day = date.getDay();
            var month = date.getMonth();
            var currentDate =date.getDate();
            if (day == 2) { // desactivation de tou les mardi
                return [false];
            //}else if ($.inArray(currentDate + '/' + (month + 1), daysToDisable) != -1){
            }else if ($.inArray(currentDate + '/' + (month + 1), daysToDisable) != -1){
                // Desactivation des jour ferier
                return [false];
            } else {
                return [true];
            }
        }
    });

    /*
     * On desactive le billet Journer si le client veul acheter son billet pour le jour méme,
     * et que l'heur a dépasser 14h.
     *
     * On verifie si le nombre des visiteur ne dépasse pas 1000 pessone le jour de visite choisie
     */
    $('.datePicker').change(function(){
        // Désactivation du billet journee aprés 14h du jour méme
        var datch = $('.datePicker').val().split('-');
        var dateChoisie = new Date(datch[2], datch[1], datch[0]);
        var now = new Date();
        var heur = now.getHours();


        if ((dateChoisie.getDate() == now.getDate()) && (dateChoisie.getMonth() == (now.getMonth()+1)) && (dateChoisie.getFullYear() == now.getFullYear()) && (heur >= 14)) {
            $("#form_collection_billets_produit option[value=2]").attr('selected','selected');
            $("#form_collection_billets_produit option[value=1]").removeAttr('selected');
            $('#form_collection_billets_produit option[value=1]').hide();
        }else {
            $('#form_collection_billets_produit option[value=1]').show();
            $("#form_collection_billets_produit option[value=1]").attr('selected','selected');
            $("#form_collection_billets_produit option[value=2]").removeAttr('selected');
        }

        // Rquête ajax pour verifier si le nombre de visiteur
        // du jour choisie ne depasse 1000 visiteurs.
        var $dateChoisie = $('.datePicker').val();
        $url = 'count-visitors/'+ $dateChoisie;

        ajax_call($url, function(data) {
            $result = $('<span id="alert" class="alert alert-danger"></span>').text('La date choisie et invalide');
            if (data >= 3) {
                $('#alert').remove();
                $('#message').show();
                $('.datePicker').val('');
                $('#message')
                    .append($result)
            }
        });
        setTimeout(function (){
            message.style.display = "none";
        }, 2000);
    });

    //Form Collection
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#form_collection_clients');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // Nombre de visiteurs
    $('#add_client').on('click', function(e) {
        var $number = document.getElementById("num").value;
        if ($number) {
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
        }else {
            alert('Vous devais choisire le nombre de visiteur')
        }

        // Integration et parametrage de datepicker a la date de naissance
        $( ".dateNaissance" ).datepicker({
            yearRange: "1900:+nn",
            maxDate: "-4y",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy'
        });
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    });

    var total = 0;

    //Importer les prix selon la date de naissance
    $('body').delegate('.dateNaissance', 'change', function() {
        var id =$(this).attr("id");
        var dateVisite = $("#form_collection_billets_dateReservation").val();
        var typeBillet = $("#form_collection_billets_produit").val();
        var dateN = $("#"+id).val();
        $url ='prix/' + dateN + '/' + dateVisite + '/' + typeBillet ;
        var key = id.substr(24,1);

        // Si le visiteur et un enfant on décoche le tarif reduit et on le cache
        var $age = age(dateN);
        var checkB = 'form_collection_clients_'+(key)+'_tarifReduit';
        if ($age <= 12){
            document.getElementById(checkB).checked = false;
            $('#'+checkB).parents('label').hide();
        }else {
            $('#'+checkB).parents('label').show();
        }

        ajax_call($url, function(data) {
            var prix = parseFloat(data);
            if($('#'+checkB).is(':checked') != true) {
                // Si le prix et existe déja, on le modifie sinon on le crée puis on calcule le total
                calculPrix(prix, key);
            }
        });
    });

    // Tarif Reduit
    $('body').delegate('.tarifReduit', 'change', function() {
        var id =$(this).attr("id");
        var key = id.substr(24,1);
        var typeBillet = $("#form_collection_billets_produit").val();
        var checkBo=$('#'+id).val();
            $url ='reduit/' + checkBo + '/' + typeBillet;
            ajax_call($url, function(data) {
                var prix = parseFloat(data);
                calculPrix(prix, key);
            });
    });

    // Si le prix et existe déja, on le modifie sinon on le crée puis on calcule le total
    function calculPrix(prix, key) {
        if (document.getElementById(key)) {
            var soustraire = $('#'+key).text();
            $('#'+key).text(prix.toFixed(2));
            total -= parseFloat(soustraire);
        }else {
            $result = $('<tr><td>Visiteur ' + (parseInt(key)+1) + '     </td>\n' +
                '<td class="leftText"><span id="' + key + '">' + prix.toFixed(2) + '</span> €</td></tr>');
            $('#detaillePrix').append($result);
        }
        total += prix;
        $('#total').text(total.toFixed(2));
    }

    function ajax_call($url, callback){
        $.ajax({
            url: 'http://projet4.fr/app_dev.php/' + $url,
            data: {
                format: 'json'
            },

            success: function(data) {
                callback.call(this, data);
            },
            type: 'GET'
        });
    }

    function age($dateNassance) {
        $dateNassance = $dateNassance.split('-').reverse().join('-');
        $dateNassance = new Date($dateNassance);
        var jour = $dateNassance.getDate();
        var moi = $dateNassance.getMonth();
        var annee = $dateNassance.getFullYear();
        var aujourdhuit = new Date('2017-11-05');
        if ((moi < aujourdhuit.getMonth()) || (moi == aujourdhuit.getMonth() && jour < aujourdhuit.getDate())) {
           var $age = aujourdhuit.getFullYear() - annee - 1;
        }else {
            var $age = aujourdhuit.getFullYear() - annee;
        }
        return $age;
    }



    // La fonction qui ajoute un formulaire CategoryType
    function addClient($container, $number) {
        for (var i = 0; i < $number; i++) {
            // Dans le contenu de l'attribut « data-prototype », on remplace :
            // - le texte "__name__label__" qu'il contient par le label du champ
            // - le texte "__name__" qu'il contient par le numéro du champ
            var template = $container.attr('data-prototype')
                .replace(/__name__label__/g, 'Client n°' + (index + 1))
                .replace(/__name__/g, index)
                .replace('col-sm-2', 'col-sm-4');

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

    }

});

