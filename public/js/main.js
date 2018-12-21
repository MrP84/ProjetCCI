choixPseudo = '';
choixEmail = '';
document.addEventListener('DOMContentLoaded', () => {

    var url = '';
    var tripper = new Array();
    var stockage;

    $('#toggleMenu').removeClass('showMenu').addClass('hiddenMenu');
    $('#showUpdateForm').removeClass('showUpdateForm').addClass('hidden');
    $('#showPasswordForm').removeClass('showPasswordForm').addClass('hidden');

    $('#deleteButton').on('click', (e) => {
        e.preventDefault();
        let idTripperDelete = $('#deleteButton').data('id');
        $('#deleteModal').modal('show');
        console.log(idTripperDelete);

        $('#deleteLink').on('click', () => {
            $('#deleteLink').attr('href', 'deleteTripper.php?id=' + idTripperDelete);
        });


    });

    $('#password1').on('focus', function() {
        $('#squares').removeClass('hidden').addClass('show');
    });
    $('#password1').keyup(function() {
        var pswd = $(this).val();
        if (pswd.length == 1 || pswd.length < 2) {
            $('.color').removeClass('orange').removeClass('green').addClass('red');
        } else if (pswd.match(/[A-z]/) && pswd.length >= 4 && pswd.length < 8) {
            $('.color').removeClass('red').addClass('orange');

        } else if (pswd.match(/[0-9]/) && pswd.match(/[A-z]/) && pswd.length >= 4 && pswd.length < 8) {
            $('.color').removeClass('red').addClass('orange');

        } else if (pswd.length >= 8 && pswd.match(/[0-9]/) && pswd.match(/[A-z]/)) {
            $('.color').removeClass('orange').addClass('green');
            $('#password2').prop('disabled', false);
        }

    });
    $('#password1').on('focusout', function() {
        $('.show').removeClass('show').addClass('hidden');
    });
    $('#password2').keyup(function() {
        var pswd = $('#password1').val();
        $('small.hidden_error').removeClass('hidden_error').addClass('show_error');
        var checkPswd = $('#password2').val();
        if (pswd == checkPswd && pswd.length != 0) {
            $('small.show_error').removeClass('show_error').addClass('hidden_error');
            $('span.hidden_success').removeClass('hidden_success').addClass('show_success');
        }

    });
    $('#password2').on('focusout', function() {
        $('.show_success').removeClass('show_success').addClass('hidden_success');
        $('.show_error').removeClass('show_error').addClass('hidden_error');
    });

    $('#myAccount').on('click', () => {
        $('#toggleMenu').removeClass('hiddenMenu').addClass('showMenu');
    });

    $('#toggleMenu').mouseleave( () => {
        $('#toggleMenu').removeClass('showMenu').addClass('hiddenMenu');
    });

    // $('#updateName').on('click', () => {
    //     //console.log('hello');
    //     $('#showUpdateForm').removeClass('hidden').addClass('showUpdateForm');
    //     $('#firstNameUpdate').val($('#updateFirstName').text());
    //     $('#lastNameUpdate').val($('#updateLastName').text());
    // });

    function createAndAppendInput(type, id, className, value, location) {
        $('<input>').attr({
            type: type,
            id: id,
            class: className,
            name: id,
            value: value
        }).appendTo(location);
    };

    function validatePassword(password) {
        if (password.length >= 8 && password.match(/[0-9]/) && password.match(/[A-z]/)) {
            console.log('ok ', password);
            return password;
            console.log("mon retour ok = ",retour);
        } else {
            return false;
        }
    }

    function checkPassword(password1, password2) {
        if (password1 === password2) {
            return true;
        } else {
            return false;
        }
    }

    $('#updateName').on('click', () => {
        ($('#showUpdateForm').attr('class') === 'hidden')?$('#showUpdateForm').removeClass('hidden').addClass('showUpdateForm'):'';
        createAndAppendInput('text','firstNameUpdate','headerUpdate', $('#updateFirstName').text(), '#updateNameForm');

        createAndAppendInput('text', 'lastNameUpdate', 'headerUpdate', $('#updateLastName').text(), '#updateNameForm');

        $('#updateName').prop('disabled', true);
    });


    $('#updateLocation').on('click', () => {
        ($('#showUpdateForm').attr('class') === 'hidden')?$('#showUpdateForm').removeClass('hidden').addClass('showUpdateForm'):'';

        createAndAppendInput('text', 'cityUpdate', 'headerUpdate', $('#updateCity').text(), '#updateLocationForm');

        $('#countryUpdate').removeClass('hidden');
        $('#updateLocation').prop('disabled', true);
    });

    $('#updateAvatar').on('click', () => {
        ($('#showUpdateForm').attr('class') === 'hidden')?$('#showUpdateForm').removeClass('hidden').addClass('showUpdateForm'):'';

        createAndAppendInput('file', 'avatarUpdate', 'headerUpdate', '', '#updateAvatarForm');

        $('#updateAvatar').prop('disabled', true);
    });

    $('#updateInfo').on('click', () => {
        ($('#showUpdateForm').attr('class') === 'hidden')?$('#showUpdateForm').removeClass('hidden').addClass('showUpdateForm'):'';

        createAndAppendInput('text', 'pseudoUpdate', 'headerUpdate', $('#updatePseudo').text(), '#updatePseudoForm');

        createAndAppendInput('text', 'emailUpdate', 'headerUpdate', $('#updateEmail').text(), '#updatePseudoForm');

        createAndAppendInput('textarea', 'bioUpdate', 'headerUpdate', $('#updateBio').text(), '#updateBioForm');

        $('#updateInfo').prop('disabled', true);

    });

    $('#passwordUpdate').on('click', () => {
        ($('#showPasswordForm').attr('class') === 'hidden')?$('#showPasswordForm').removeClass('hidden').addClass('showPasswordForm'):'';
        var pwd1;
        var pwd2;
    });

    $('#initialPassword').on('change', () => {
        $.ajax({
            url: 'checkPwd.php',
            data: { pwdKey : sha256($('#initialPassword').val()) },
            async: false,
            method : 'POST'
        }).done((result) => {
            if (result === 'ok') {
                $('#newPassword').prop('disabled', false);

                $('#newPassword').on('keyup', function() {
                    if (pwd1 = validatePassword($(this).val())) {
                        $('#confirmNewPassword').prop('disabled', false);
                        console.log(sha256(pwd1));
                    } else {
                        console.log('erreur');
                    };
                });

                $('#confirmNewPassword').on('keyup', function() {
                    if ($('#initialPassword').val() !== "" && $('#newPassword').val() !== "" && $('#confirmNewPassword').val() !== "") {

                        if (pwd2 = validatePassword($(this).val())) {
                            console.log(pwd2);
                            if (checkPassword(pwd1, pwd2)) {
                                if ($('#error_show').attr('class') === 'error_show') {
                                    $('#error_show').removeClass('error_show').addClass('hidden');
                                }
                                $('#validateNewPassword').prop('disabled', false).addClass('btn-success');
                                console.log('mots de passe identiques');
                            } else {
                                let error = $('<div>').attr({
                                    class : 'error_show',
                                    id: 'error_show'
                                }).text('Les mots de passe ne sont pas identiques.');
                                error.appendTo('#showPasswordForm');
                            }
                        }
                    }
                });
            } else {
                $('#newPassword').prop('disabled', true);
            }


        })


    });


    try {
        stockage = localStorage.getItem('src');

        if (JSON.parse(stockage) !== null) {
            stockage = JSON.parse(stockage);
        } else {
            stockage = getAjax();
        }

        function getAjax() {
            var res = new Array();
            let url = 'json.php';
            $.ajax({
                url: url,
                async: false,
                datatype: 'text'
            }).done((results) => {

                results = JSON.parse(results);
                for (var i in results) {
                    if (results.hasOwnProperty(i)) {
                        tripper.push({
                            label: i,
                            value: results[i]
                        });
                    }
                }

                localStorage.setItem('src', JSON.stringify(tripper));
                res = tripper;
                return res;

            })
        };
    } catch (e) {

    } finally {
        
    }




    $('#validateUpdate').on('click', (e) => {
        e.preventDefault();
        let firstNameUpdate = ($('#firstNameUpdate').val() !== undefined)? $('#firstNameUpdate').val() : stockage[0].value;
        let lastNameUpdate = ($('#lastNameUpdate').val() !== undefined)? $('#lastNameUpdate').val() : stockage[1].value;
        let pseudoUpdate = ($('#pseudoUpdate').val() !== undefined)? $('#pseudoUpdate').val() : stockage[2].value;
        let emailUpdate = ($('#emailUpdate').val() !== undefined)? $('#emailUpdate').val() : stockage[3].value;
        let cityUpdate = ($('#cityUpdate').val() !== undefined)? $('#cityUpdate').val() : stockage[4].value;
        let countryUpdate = ($('#countryUpdate').val() !== undefined)? $('#countryUpdate').val() : stockage[7].value;
        let bioUpdate = ($('#bioUpdate').val() !== undefined)? $('#bioUpdate').val() : stockage[6].value;
        let idTripperUpdate = $('#idTripper').val();

        $.ajax({
            url : 'update.php',
            data : {firstNameUpdate, lastNameUpdate, emailUpdate, pseudoUpdate, cityUpdate, countryUpdate, bioUpdate},
            method : 'POST'
        }).done( () => {
            stockage[0].value = firstNameUpdate;
            stockage[1].value = lastNameUpdate;
            stockage[2].value = pseudoUpdate;
            stockage[3].value = emailUpdate;
            stockage[4].value = cityUpdate;
            stockage[7].value = countryUpdate;
            stockage[6].value = bioUpdate;

            localStorage.setItem('src', JSON.stringify(stockage));

        });
        $('#showUpdateForm').removeClass('showUpdateForm').addClass('hidden');

        $('#updateFirstName').text(firstNameUpdate);
        $('#updateLastName').text(lastNameUpdate);
        $('#updatePseudo').text(pseudoUpdate);
        $('#updateEmail').text(emailUpdate);
        $('#updateCity').text(cityUpdate);
        $('#updateCountry').text(countryUpdate);
        $('#updateBio').text(bioUpdate);
        $('#updateName').prop('disabled', false);
    });

    setTimeout(function() {
        $('#four1').text('4')},
        1000
    );
    setTimeout(function() {
        $('#four2').text('0');},
        2000
    );
    setTimeout(function() {
        $('#four3').text('4');},
        3000
    );
});
