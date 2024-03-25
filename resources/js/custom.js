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

    let code = document.querySelectorAll('input[name="team_code"]');

    for (let i = 0, length = code.length; i < length; i++) {
        mask(code[i], "___-___");
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
