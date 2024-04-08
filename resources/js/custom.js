/* =================    Tel Number Mask     ================= */
(function () {
    let mask = function (input, regex) {
        function setCursorPosition(pos, elem) {
            elem.focus();
            if (elem.setSelectionRange) elem.setSelectionRange(pos, pos);
            else if (elem.createTextRange) {
                let range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd("character", pos);
                range.moveStart("character", pos);
                range.select();
            }
        } // end setCursorPosition

        function change(event) {
            let matrix = regex,
                i = 0,
                def = matrix.replace(/\D/g, ""),
                val = this.value.replace(/\D/g, "");
            if (def.length >= val.length) val = def;
            this.value = matrix.replace(/./g, function (a) {
                return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? "" : a;
            });

            if (event.type == "blur") {
                if (this.value.length == 2) this.value = "";
            } else {
                setCursorPosition(this.value.length, this);
            }
        } // end Change

        input.addEventListener("input", change, false);
        input.addEventListener("focus", change, false);
        input.addEventListener("blur", change, false);
    }; // end mask

    let teamCode = document.querySelectorAll('input[name="team_code"]');
    let telMask = document.querySelectorAll('input[type="tel"]');

    for (let i = 0, length = teamCode.length; i < length; i++) {
        mask(teamCode[i], "___-___");
    }
    for (let i = 0, length = telMask.length; i < length; i++) {
        mask(telMask[i], "+7(___) ___ __ __");
    }

    document.querySelectorAll('input[type="radio"][name="role"]').forEach((button) => {
        button.addEventListener('change', function() {
            if (document.getElementById('coach').checked) {
                document.getElementById('code_field').hidden = true;
            } else {
                document.getElementById('code_field').hidden = false;
            }
        });
    });

})();

$( "#button_save_team" ).on( "click", function() {
    let user_id = $("#user_id").val();
    let name = $("#name").val();
    let team_code = $("#team_code").val();
    let desc = $("#desc").val();

    let _url = `/teams`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "POST",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            name: name,
            team_code: team_code,
            desc: desc,
            _token: _token
        },
        success: function (response) {
            if (response.code == 200) {
                location.reload();
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger" role="alert">' + response.responseJSON.message + '</div>');
        }
    });
} );

$( "#button_edit_team" ).on( "click", function() {

    let id = $("#id").val();

    let user_id = $("#user_id").val();
    let name = $("#name").val();
    let desc = $("#desc").val();
    let active = $("#active").prop('checked');
    let activeNum
    if(active === true) {
        activeNum = '1';
    } else {
        activeNum = '0';
    }

    let _url = `/teams/${id}`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "PATCH",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            name: name,
            desc: desc,
            active: activeNum,
            _token: _token
        },
        success: function (response) {
            if (response.code == 200) {
                location.reload();
            }
        },
        error: function (response) {
            console.log(response);
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger" role="alert">Такой код команды уже существует</div>');
        }
    });
} );

$( "#button_del_team" ).on( "click", function() {

    let id = $("#id").val();
    let _url = `/teams/${id}`;
    let _token = $('input[name~="_token"]').val();

    if(confirm('Удалить команду?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function(response) {
               window.location.href = '/teams';
            }
        });
    }

});

$( "#update_user_meta" ).on( "click", function() {
    let player_id = $("#player_id").val();
    console.log(player_id);
    let name = $("#name").val();
    let second_name = $("#second_name").val();
    let last_name = $("#last_name").val();
    let email = $("#email").val();

    // Дополнительные поля
    let tel = $("#tel").val();
    let position = $("#position").val();
    let number = $("#number").val();
    let tel_mother = $("#tel_mother").val();
    let tel_father = $("#tel_father").val();
    let comment = $("#comment").val();
    let active = $("#active").prop('checked');
    let activeNum
    if(active === true) {
        activeNum = '1';
    } else {
        activeNum = '0';
    }


    let _url = `/teams/${player_id}`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "PATCH",
        enctype: 'multipart/form-data',
        data: {
            player_id: player_id,
            name: name,
            second_name: second_name,
            last_name: last_name,
            email: email,

            tel: tel,
            position: position,
            number: number,
            tel_mother: tel_mother,
            tel_father: tel_father,
            comment: comment,
            active: activeNum,
            _token: _token
        },
        success: function (response) {
            if (response.code == 200) {
                location.reload();
            }
        },
        error: function (response) {
            console.log(response);
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger" role="alert">Такой код команды уже существует</div>');
        }
    });
} );

let reqInput = $('input[required]');
reqInput.each( function(i, item){
    let inputName = $(this).attr('name');
    $('label').each( function(i, item){
        let labelFor = $(this).attr('for');
        if(labelFor == inputName) {
            $(this).append('<span class="text-red-700 dark:text-red">*</span>')
        }
    });


})




