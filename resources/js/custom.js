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
    let date = document.querySelectorAll('input[name="date"]');
    let time = document.querySelectorAll('input.time');

    for (let i = 0, length = date.length; i < length; i++) {
        mask(date[i], "____-__-__");
    }

    for (let i = 0, length = teamCode.length; i < length; i++) {
        mask(teamCode[i], "___-___");
    }
    for (let i = 0, length = time.length; i < length; i++) {
        mask(time[i], "__:__");
    }
    for (let i = 0, length = telMask.length; i < length; i++) {
        mask(telMask[i], "+7(___) ___ __ __");
    }

    document.querySelectorAll('input[type="radio"][name="role"]').forEach((button) => {
        button.addEventListener('change', function () {
            if (document.getElementById('coach').checked) {
                document.getElementById('code_field').hidden = true;
                document.getElementById("team_code").required = false;
            } else {
                document.getElementById('code_field').hidden = false;
                document.getElementById("team_code").required = true;
            }
        });
    });


    document.querySelectorAll('input[type="radio"][name="pain"]').forEach((button) => {
        if (document.getElementById('pain-0').checked) {
            document.getElementById('local-block').hidden = true;
            document.getElementById("local").required = false;
        } else {
            document.getElementById('local-block').hidden = false;
            document.getElementById("local").required = true;
        }
        button.addEventListener('change', function () {
            if (document.getElementById('pain-0').checked) {
                document.getElementById('local-block').hidden = true;
                document.getElementById("local").required = false;
            } else {
                document.getElementById('local-block').hidden = false;
                document.getElementById("local").required = true;
            }
        });
    });

    let presence_check = document.getElementById('presence_check');
    if (presence_check) {
        document.getElementById('cause-block').hidden = true;
        document.getElementById("cause").required = false;
        presence_check.addEventListener('click', function () {
            if (document.getElementById('presence_check').checked) {
                document.getElementById('cause-block').hidden = true;
                document.getElementById("cause").required = false;
            } else {
                document.getElementById('cause-block').hidden = false;
                document.getElementById("cause").required = true;
            }
        });
    }


})();

$("#button_save_team").on("click", function () {
    let user_id = $("#user_id").val();
    let name = $("#team_name").val();
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
            team_name: name,
            team_code: team_code,
            desc: desc,
            _token: _token
        },
        success: function (response) {
            $('#teamCreate').css('opacity', '1').css('z-index', '10');
            document.querySelector('[data-modal-hide="add_team"]').click();
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$("#button_edit_team").on("click", function () {

    let id = $("#id").val();

    let user_id = $("#user_id").val();
    let name = $("#team_name").val();
    let desc = $("#desc").val();
    let active = $("#active").prop('checked');
    let activeNum
    if (active === true) {
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
            team_name: name,
            desc: desc,
            active: activeNum,
            _token: _token
        },
        success: function (response) {
            $('#btn_team_success').trigger('click');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$("#button_del_team").on("click", function () {

    let id = $("#id").val();
    let _url = `/teams/${id}`;
    let _token = $('input[name~="_token"]').val();

    if (confirm('Удалить команду?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                window.location.href = '/teams';
            }
        });
    }
});

$("#update_user_meta").on("click", function () {
    let player_id = $("#player_id").val();
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
    if (active === true) {
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
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

let reqInput = $('input[required]');
reqInput.each(function (i, item) {
    let inputName = $(this).attr('name');
    $('label').each(function (i, item) {
        let labelFor = $(this).attr('for');
        if (labelFor == inputName) {
            $(this).append('<span class="text-red-700 dark:text-red">*</span>')
        }
    });
})


$("#button_save_user").on("click", function () {
    let name = $("#name").val();
    let last_name = $("#last_name").val();
    let team_code = $("#team_code").val();
    let role = $("#role").val();
    let email = $("#email").val();
    let password = $("#password").val();
    let password_confirmation = $("#password_confirmation").val();

    let _url = `/users`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "POST",
        enctype: 'multipart/form-data',
        data: {
            name: name,
            last_name: last_name,
            team_code: team_code,
            role: role,
            email: email,
            password: password,
            password_confirmation: password_confirmation,
            _token: _token
        },
        success: function (response) {
            location.reload();
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});
$("#button_save_training").on("click", function () {
    let user_id = $("#user_id").val();
    let count_players = $("#count_players").val();
    let team_code = $("#team_code_training").val();
    let date = $("#date").val();

    let repeatUntilCheckbox = $("#repeat_until_checkbox").val();
    let repeatUntilDate = $("#repeat_until_date").val();

    let start = $("#start").val();
    let finish = $("#finish").val();
    let classTraining = $("#class").val();
    let addressesTraining = $("#addresses").val();
    let desc = $("#desc").val();
    let recovery = $("#recovery").val();
    let load = $("#load").val();
    let link_docs = $("#link_docs").val();
    let active = $("#active").prop('checked');
    let activeNum
    if (active === true) {
        activeNum = '1';
    } else {
        activeNum = '0';
    }

    let _url = `/trainings`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "POST",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            count_players: count_players,
            team_code: team_code,
            date: date,
            repeat_until_checkbox: repeatUntilCheckbox,
            repeat_until_date: repeatUntilDate,
            start: start,
            finish: finish,
            class: classTraining,
            addresses: addressesTraining,
            desc: desc,
            recovery: recovery,
            load: load,
            link_docs: link_docs,
            active: activeNum,
            _token: _token
        },
        success: function (response) {
            $('#btn_team_success').trigger('click');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$('input[name~="recovery"]').on('input', function () {
    $(this).val((i, v) => Math.max(this.min, Math.min(this.max, v)));
});
$('input[name~="load"]').on('input', function () {
    $(this).val((i, v) => Math.max(this.min, Math.min(this.max, v)));
});


$("#button_del_training").on("click", function () {
    let id = $("#id").val();
    let _url = `/trainings/${id}`;
    let _token = $('input[name~="_token"]').val();
    if (confirm('Удалить тренировку?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                window.location.href = '/trainings';
            }
        });
    }
});

$("#update_training").on("click", function () {
    let user_id = $("#user_id").val();
    let count_players = $("#count_players_udate").val();
    let trainingId = $("#training_id").val();
    let team_code = $("#team_code_training").val();
    let date = $("#date").val();
    let start = $("#start").val();
    let finish = $("#finish").val();
    let classTraining = $("#class").val();
    let addressesTraining = $("#addresses").val();
    let desc = $("#desc").val();
    let recovery = $("#recovery").val();
    let load = $("#load").val();
    let link_docs = $("#link_docs").val();
    let active = $("#active").prop('checked');
    let confirm = $("#confirmed").prop('checked');
    let ids = new Array();
    $('input[name="players[]"]:checked').each(function () {
        ids.push($(this).val());
    });
    let users = ids;
    let activeNum
    if (active === true) {
        activeNum = '1';
    } else {
        activeNum = '0';
    }
    let confirmNum
    if (confirm === true) {
        confirmNum = '1';
    } else {
        confirmNum = '0';
    }

    let _url = `/trainings/${trainingId}`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "PATCH",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            count_players: count_players,
            trainingId: trainingId,
            team_code: team_code,
            date: date,
            start: start,
            finish: finish,
            class: classTraining,
            addresses: addressesTraining,
            desc: desc,
            recovery: recovery,
            load: load,
            link_docs: link_docs,
            users: users,
            active: activeNum,
            confirmed: confirmNum,
            _token: _token
        },

        success: function (response) {
            $('#trainingCreate').css('opacity', '1').css('z-index', '10');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        },

        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$('#count_players').val($('#team_code_training option:selected').data("count-players"));
$("#team_code_training").on('change', function () {
    let dataCountPlayers = $('#team_code_training option:selected').data("count-players");
    $('#count_players').val(dataCountPlayers);
});

// Ограничение подтверждения о проведении тренировки (если отмечено менее 3)

function checkCountPresences() {
    let arr = new Array();
    $('input[name="players[]"]:checked').each(function () {
        arr.push($(this).val());
    });
    if (arr.length >= 1) {
        $('#confirmed').attr('checked', true);
        $('#confirmed').attr('disabled', false);
        $('#alert-2').addClass("transition-opacity duration-300 ease-out opacity-0 hidden");

    } else {
        $('#confirmed').attr('checked', false);
        $('#confirmed').attr('disabled', true);
        $('#alert-2').removeClass("transition-opacity duration-300 ease-out opacity-0 hidden");
    }

    if ($("#confirmed").prop('checked')) {
        $('#alert-2').addClass("transition-opacity duration-300 ease-out opacity-0 hidden");
    } else {
        $('#alert-2').removeClass("transition-opacity duration-300 ease-out opacity-0 hidden");
    }
}

checkCountPresences()
$("input[name=\"players[]\"]").on("click", function () {
    checkCountPresences();
});

$("#button_edit_settings_loadcontrol").on("click", function () {

    let user_id = $("#user_id").val();

    let on_load = $("#on_load").prop('checked');
    let on_loadNum
    if (on_load === true) {
        on_loadNum = '1';
    } else {
        on_loadNum = '0';
    }

    let on_extra_questions = $("#on_extra_questions").prop('checked');
    let on_extra_questionsNum
    if (on_extra_questions === true) {
        on_extra_questionsNum = '1';
    } else {
        on_extra_questionsNum = '0';
    }

    let question_recovery_min = $("#question_recovery_min").val();
    let question_load_min = $("#question_load_min").val();

    let _url = `/loadcontrol`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "PATCH",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            on_loadNum: on_loadNum,
            on_extra_questionsNum: on_extra_questionsNum,
            question_recovery_min: question_recovery_min,
            question_load_min: question_load_min,
            _token: _token
        },
        success: function (response) {
            $('#btn_settings_loadcontrol_success').trigger('click');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function (response) {
            $('#response_settings_loadcontrol').empty();
            $('#response_settings_loadcontrol').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$("#button_send_recovery").on("click", function () {
    let user_id = $("#user_id").val();
    let pain = $('input[name~="pain"]:checked').val();
    let local = $('#local').val();
    let sleep = $('input[name~="sleep"]:checked').val();
    let sleep_time = $('input[name~="sleep_time"]:checked').val();
    let moral = $('input[name~="moral"]:checked').val();
    let physical = $('input[name~="physical"]:checked').val();
    let presence_check = $("#presence_check").prop('checked');
    let presence_checkNum
    if (presence_check === true) {
        presence_checkNum = '1';
    } else {
        presence_checkNum = '0';
    }
    let cause = $('#cause').val();
    let recovery = $('input[name~="recovery_q"]:checked').val();

    let _url = `/questions`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "POST",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            pain: pain,
            local: local,
            sleep: sleep,
            sleep_time: sleep_time,
            moral: moral,
            physical: physical,
            presence_checkNum: presence_checkNum,
            cause: cause,
            recovery: recovery,
            _token: _token
        },
        success: function (response) {
            $('#btn_recovery_success').trigger('click');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$("#button_send_load").on("click", function () {
    let user_id = $("#user_id").val();
    let load = $('input[name~="load_q"]:checked').val();
    console.log(load);

    let _url = `/questions`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "PATCH",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            load: load,

            _token: _token
        },
        success: function (response) {
            $('#btn_load_success').trigger('click');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function (response) {
            $('#response_load').empty();
            $('#response_load').append('<div class="flex items-center p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">' +
                '<svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">' +
                '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>' +
                '</svg>' +
                '<span class="sr-only">Info</span>' +
                '<div>' +
                response.responseJSON.message +
                '</div>' +
                '</div>');
        }
    });
});

$('#check_all').change(function () {
    $('.chk').prop('checked', this.checked);
    checkCountPresences();
});

$(".chk").change(function () {
    if ($(".chk:checked").length == $(".chk").length) {
        $('#checkAll').prop('checked', 'checked');
    } else {
        $('#checkAll').prop('checked', false);
    }
});
window.updateActive = function ($id, $activeText, $disactiveText, checkbox) {
    let _url = '/users/' + $id + '/update-active-player';
    let _token = $('input[name~="_token"]').val();
    let isChecked = checkbox.checked;
    let changeAvailable = $('#changeAvailable' + $id);
    let badgeActive = '<div class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"> <div class="w-2 h-2 me-1 bg-green-500 rounded-full"></div>' + $activeText + '</div>'
    let badgeNoActive = '<div class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300"><div class="w-2 h-2 me-1 bg-red-500 rounded-full"></div>' + $disactiveText + '</div>'
    let isActive = '';

    if (isChecked === true) {
        isActive = 1;
    } else {
        isActive = 0;
    }

    $.ajax({
        url: _url,
        type: 'PATCH',
        data: {
            active: isActive,
            _token: _token
        },
        success: function (response) {
            if (response.success) {
                console.log('User  active status updated to: ' + response.active);

                if (response.active == 1) {
                    changeAvailable.html(badgeActive);
                } else if (response.active == 0) {
                    changeAvailable.html(badgeNoActive);
                }
            }
        },
        error: function (xhr) {
            console.error('Error updating user active status:', xhr);
        }
    });
};

window.deleteAnswer = function ($id) {

    let _url = '/questions/' + $id;
    console.log(_url)
    let _token = $('input[name~="_token"]').val();

    if (confirm('Удалить ответ?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                window.location.href = '/loadcontrol';
            }
        });
    }

};

// Helper function for setting cookie
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + encodeURIComponent(value || "") + expires + "; path=/";
}

// Helper function for getting cookie
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

$(document).ready(function () {

    // Global variable to store the element that triggered the modal
    // Глобальная переменная для хранения элемента, который вызвал модальное окно
    let modalTriggerElement = null;

    // Get the modal element from the DOM
    // Получаем элемент модального окна из DOM
    const modalEl = document.getElementById('modal_condition');
    let flowbiteModal = null; // Variable to hold the Flowbite Modal instance

    // Check if Flowbite library is available and the modal element exists
    // Проверяем, доступна ли библиотека Flowbite и существует ли элемент модального окна
    if (typeof Flowbite !== 'undefined' && Flowbite.Modal && modalEl) {
        // Try to get an existing Flowbite instance if it was initialized automatically (e.g., via data attributes)
        // Попытаемся получить существующий экземпляр Flowbite, если он был инициализирован автоматически (например, через data-атрибуты)
        flowbiteModal = Flowbite.Modal.getInstance(modalEl);

        if (!flowbiteModal) {
            // If no instance exists, create a new one
            // Если экземпляра нет, создаем новый
            const modalOptions = {
                placement: 'center', // Assuming you want it centered
                backdrop: 'dynamic', // Or 'static'
                // You can add other options here if needed
            };
            flowbiteModal = new Flowbite.Modal(modalEl, modalOptions);
        }

        // Attach an event listener for when the modal is hidden
        // Добавляем слушатель событий на момент скрытия модального окна
        modalEl.addEventListener('hide.flowbite', () => {
            // THE KEY FIX: Return focus to the element that opened the modal
            // КЛЮЧЕВОЕ ИСПРАВЛЕНИЕ: Возвращаем фокус на элемент, открывший модалку
            if (modalTriggerElement) {
                modalTriggerElement.focus();
                modalTriggerElement = null; // Clear the variable after use
            }
        });
    }

    let loader = '<div class="p-0 text-center modal-loader loading" >\n' +
        '                                    <svg aria-hidden="true"\n' +
        '                                         class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"\n' +
        '                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '                                        <path\n' +
        '                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"\n' +
        '                                            fill="currentColor"/>\n' +
        '                                        <path\n' +
        '                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"\n' +
        '                                            fill="currentColor"/>\n' +
        '                                    </svg>\n' +
        '                                </div>';

    function clearCondition() {
        $('#modal_condition h4').html(loader);

        $('#pain').html(loader);
        $('#local').html(loader);
        $('#sleep').html(loader);
        $('#sleep_time').html(loader);
        $('#moral').html(loader);
        $('#physical').html(loader);
        $('#general-condition').html(loader);
    }

    clearCondition();


    $(document).on('click', '.modal_condition', function () {
        var userId = $(this).data('modal-condition-userid');
        var dateAnswer = $(this).data('modal-condition-date');
        clearCondition();

        // Store the trigger element
        // Сохраняем элемент, который вызвал окно
        modalTriggerElement = this;

        // Use the Flowbite instance to show the modal
        // Используем экземпляр Flowbite для показа модального окна
        if (flowbiteModal) {
            flowbiteModal.show();
        } else {
            // Fallback for manual class/attribute manipulation if Flowbite instance is not found
            // Запасной вариант для ручной манипуляции классами/атрибутами, если экземпляр Flowbite не найден
            // This might happen if Flowbite JS is not loaded or not initialized yet
            // Это может произойти, если JS Flowbite не загружен или еще не инициализирован
            const modalEl = document.getElementById('modal_condition'); // Re-get in case of timing issues
            if (modalEl) {
                modalEl.setAttribute('aria-hidden', 'false');
                modalEl.classList.remove('hidden');
                // The problematic modalEl.focus() is removed here.
                // It was causing issues when combined with aria-hidden.
                // Correct focus management for accessibility is now primarily handled by Flowbite's hide.flowbite event.
            }
        }


        $.ajax({
            url: '/ajax/get-player-condition',
            type: 'POST',
            data: {
                user_id: userId,
                dateAnswer: dateAnswer,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#modal_condition h4').html(response.name + ' ' + response.last_name);
                let data = response.data;

                $('#pain').html(data.pain ?? '');
                $('#local').text(data.local ?? 'Нет');
                $('#sleep').html(data.sleep ?? '');
                $('#sleep_time').text(data.sleep_time ?? 'Нет');
                $('#moral').html(data.moral ?? '');
                $('#physical').html(data.physical ?? ''); // Corrected typo here
                $('#general-condition').html(data['general-condition'] ?? '');

                if (typeof initFlowbite === 'function') {
                    initFlowbite();
                    console.log('Flowbite re-initialized after AJAX update.');
                } else {
                    console.warn('initFlowbite() function not found. Ensure Flowbite is properly loaded.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Ошибка загрузки данных: ' + (errorThrown ? errorThrown : textStatus));
            }
        });
    });

// Add touch-handler for mobile devices
// Добавь touch-обработчик для мобильных устройств
    $(document).on('touchstart', '.modal_condition', function () {
        $(this).trigger('click');
    });

    $('#filter_button_week').on('click', function () {
        let team_id = $('#team_id').val(); // обязательно получить team_id
        let week = $('#weekSelect').val();

        setCookie('week', week, 7);

        $.ajax({
            url: '/teams/' + team_id + '/filter-chars', // путь со вторым роутом из решения выше
            type: 'POST',
            data: {
                week: week,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#results_filter_data_charts').html(response);
            },
            error: function (xhr) {
                console.log('error', xhr.status, xhr.responseText);
            }
        });
    });

    // Clear
    // Очистка
    $('#clear_storage_button_week').on('click', function () {
        setCookie('week', '', -1);
        $('#weekSelect').val('');
    });

    // Show/hide button on scroll
    // Показать/скрыть кнопку при прокрутке
    window.addEventListener('scroll', function () {
        const backToTop = document.getElementById('backToTop');
        if (backToTop) { // Check if element exists before manipulating
            if (window.scrollY > 300) { // Show after 300px
                backToTop.classList.remove('hidden');
                backToTop.classList.add('opacity-100');
            } else {
                backToTop.classList.add('hidden');
                backToTop.classList.remove('opacity-100');
            }
        }
    });

// Smooth scroll to top
// Плавная прокрутка наверх
    const backToTopButton = document.getElementById('backToTop');
    if (backToTopButton) { // Check if element exists before adding event listener
        backToTopButton.addEventListener('click', function () {
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    }
});

window.updateActiveLoadControl = function ($id, checkbox) {
    let _url = '/users/' + $id + '/update-load_control';
    let _token = $('input[name~="_token"]').val();
    let isChecked = checkbox.checked;
    let isActive = '';

    if (isChecked === true) {
        isActive = 1;
    } else {
        isActive = 0;
    }

    $.ajax({
        url: _url,
        type: 'PATCH',
        data: {
            load_control: isActive,
            _token: _token
        },
        success: function (response) {
            if (response.success) {
                console.log('Load control updated to: ' + response.active);
            }
        },
        error: function (xhr) {
            console.error('Error updating Load control active status:', xhr);
        }
    });
};

window.updateActiveAI = function ($id, checkbox) {
    let _url = '/users/' + $id + '/update-ai';
    let _token = $('input[name~="_token"]').val();
    let isChecked = checkbox.checked;
    let isActive = '';

    if (isChecked === true) {
        isActive = 1;
    } else {
        isActive = 0;
    }

    $.ajax({
        url: _url,
        type: 'PATCH',
        data: {
            ai: isActive,
            _token: _token
        },
        success: function (response) {
            if (response.success) {
                console.log('AI active status updated to: ' + response.active);
            }
        },
        error: function (xhr) {
            console.error('Error updating AI active status:', xhr);
        }
    });
};
window.deleteUser = function ($id) {
    let _url = '/users/' + $id + '/delete-coach';
    console.log(_url);
    let _token = $('input[name~="_token"]').val();

    if (confirm('Удалить пользователя?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                window.location.href = window.location.href;
            }
        });
    }
};

window.deletePlayer = function ($id) {
    let _url = '/users/' + $id;
    console.log(_url);
    let _token = $('input[name~="_token"]').val();

    if (confirm('Удалить пользователя?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                window.location.href = window.location.href;
            }
        });
    }
};


window.deleteClassTraining = function ($id) {


    let _url = '/trainings/class/' + $id;
    let _token = $('input[name~="_token"]').val();

    if (confirm('Удалить классификацию?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                const card = document.getElementById('trainingClass_' + $id);
                if (card) card.remove();

                const toast = document.getElementById('toast-danger');
                toast.classList.remove('hidden');

                // Optionally hide toast after few seconds
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 2000);

                // Close button handler
                const closeBtn = document.getElementById('toast-close');
                closeBtn.onclick = () => {
                    toast.classList.add('hidden');
                };
            }
        });
    }

};

const addFieldBtn = document.getElementById('addFieldBtn');
const fieldsContainer = document.getElementById('fieldsContainer');
if (addFieldBtn) {
    addFieldBtn.addEventListener('click', () => {
        const fieldWrapper = document.createElement('div');
        fieldWrapper.classList.add('flex', 'items-center', 'mb-4');

        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'classification_names[]';
        newInput.placeholder = 'Название';
        newInput.required = true;
        newInput.className = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '−';
        removeBtn.className = 'ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition';
        removeBtn.addEventListener('click', () => {
            fieldsContainer.removeChild(fieldWrapper);
        });

        fieldWrapper.appendChild(newInput);
        fieldWrapper.appendChild(removeBtn);

        fieldsContainer.appendChild(fieldWrapper);
    });
}

window.deleteAddressTraining = function ($id) {

    let _url = '/trainings/addresses/' + $id;
    let _token = $('input[name~="_token"]').val();

    if (confirm('Удалить адрес?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                const card = document.getElementById('trainingAddres_' + $id);
                if (card) card.remove();

                const toast = document.getElementById('toast-danger-addres');
                toast.classList.remove('hidden');

                // Optionally hide toast after few seconds
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 2000);

                // Close button handler
                const closeBtn = document.getElementById('toast-close-addres');
                closeBtn.onclick = () => {
                    toast.classList.add('hidden');
                };
            }
        });
    }

};


const addFieldBtnAddresses = document.getElementById('addFieldBtnAddresses');
const fieldsContainerAddresses = document.getElementById('fieldsContainerAddresses');
if (addFieldBtnAddresses) {
    addFieldBtnAddresses.addEventListener('click', () => {
        const fieldWrapper = document.createElement('div');
        fieldWrapper.classList.add('flex', 'items-center', 'mb-4');

        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'addresses_names[]';
        newInput.placeholder = 'Название';
        newInput.required = true;
        newInput.className = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '−';
        removeBtn.className = 'ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition';
        removeBtn.addEventListener('click', () => {
            fieldsContainerAddresses.removeChild(fieldWrapper);
        });

        fieldWrapper.appendChild(newInput);
        fieldWrapper.appendChild(removeBtn);

        fieldsContainerAddresses.appendChild(fieldWrapper);
    });
}

const repeat = document.getElementById('repeat_until_checkbox');
if (repeat) {
    repeat.addEventListener('change', function () {
        const repeatDateInput = document.getElementById('repeat_until_date');
        if (this.checked) {
            repeatDateInput.style.display = 'inline-block';
            repeatDateInput.required = true;
        } else {
            repeatDateInput.style.display = 'none';
            repeatDateInput.required = false;
            repeatDateInput.value = '';
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    const togglePlannedCheckbox = document.getElementById('togglePlanned');

    // Function: update planned elements visibility
    function updatePlannedVisibility(isVisible) {
        const plannedElements = document.querySelectorAll('[data-planned]');
        plannedElements.forEach(el => {
            if (isVisible) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }

    // Load state from cookie OR set first time
    let savedState = getCookie('togglePlanned');
    if (savedState === null) {
        // If no cookie → use current checkbox and save it
        savedState = togglePlannedCheckbox.checked ? "true" : "false";
        setCookie('togglePlanned', savedState, 30);
    }

    // Apply saved state
    togglePlannedCheckbox.checked = (savedState === "true");
    updatePlannedVisibility(togglePlannedCheckbox.checked);

    // Listen for checkbox changes
    togglePlannedCheckbox.addEventListener('change', function () {
        const state = this.checked ? "true" : "false";
        setCookie('togglePlanned', state, 30);
        updatePlannedVisibility(this.checked);
    });

    // Listen for AJAX complete (jQuery example)
    if (typeof jQuery !== "undefined") {
        $(document).ajaxComplete(function () {
            const stateFromCookie = getCookie('togglePlanned') === "true";
            updatePlannedVisibility(stateFromCookie);
        });
    }
});


// Main AJAX/filter logic
document.addEventListener('DOMContentLoaded', function () {
    const playerCookie = getCookie('player_id');
    if (playerCookie !== null) {
        const playerSelect = document.getElementById('playerSelect');
        if (playerSelect) playerSelect.value = playerCookie;
    }
    const weekCookie = getCookie('week_detail');
    if (weekCookie !== null) {
        const weekSelect = document.getElementById('weekSelectDetail');
        if (weekSelect) weekSelect.value = weekCookie;
    }

    let isLoading = false;

    async function performFilter() {
        if (isLoading) return;
        const teamEl = document.getElementById('team_id');
        if (!teamEl) {
            console.warn('team_id element not found, aborting AJAX filter.');
            return;
        }
        const team_id = teamEl.value;
        if (!team_id) {
            console.warn('team_id is empty, aborting AJAX filter.');
            return;
        }

        const weekSelect = document.getElementById('weekSelectDetail');
        const playerSelect = document.getElementById('playerSelect');

        const week = weekSelect ? weekSelect.value : '';
        const player_id = playerSelect ? playerSelect.value : '';

        // Save cookies for 7 days
        setCookie('week_detail', week, 7);
        setCookie('player_id', player_id, 7);

        // Prepare CSRF token from meta
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

        const formData = new FormData();
        formData.append('week_detail', week);
        formData.append('team_id', team_id);
        formData.append('player_id', player_id);
        if (csrfToken) formData.append('_token', csrfToken);

        isLoading = true;

        try {
            const response = await fetch('/teams/' + encodeURIComponent(team_id), {
                method: 'POST',
                body: formData,
                credentials: 'same-origin', // ensure cookies are sent for same-origin
                headers: {
                    // Do not set Content-Type for FormData; browser will add proper boundary
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                console.error('AJAX filter error', response.status, await response.text());
                return;
            }

            const html = await response.text();
            const container = document.getElementById('results_filter_data');
            if (container) {
                container.innerHTML = html;
                // Apply planned visibility for newly inserted elements
                applyPlannedVisibilityFromCookie();

                // Re-init modal if exists (same logic as before)
                const modalEl = document.getElementById('modal_condition');
                if (modalEl) {
                    if (modalEl._modalInstance) {
                        try {
                            modalEl._modalInstance.hide();
                        } catch (e) {
                        }
                        modalEl._modalInstance = null;
                    }
                    // Assuming `Modal` constructor is globally available (Bootstrap/vanilla lib)
                    try {
                        modalEl._modalInstance = new Modal(modalEl);
                    } catch (e) {
                        // ignore if Modal not available
                    }
                }
            }
        } catch (err) {
            console.error('Fetch error', err);
        } finally {
            isLoading = false;
        }
    }

    // Bind filter button
    const filterBtn = document.getElementById('filter_button');
    if (filterBtn) {
        filterBtn.addEventListener('click', function (e) {
            e.preventDefault();
            performFilter();
        });
    }

    // Bind clear storage button
    const clearBtn = document.getElementById('clear_storage_button');
    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            // Delete cookies by setting max-age=0
            setCookie('week_detail', '', -1);
            setCookie('player_id', '', -1);

            const weekSelect = document.getElementById('weekSelectDetail');
            const playerSelect = document.getElementById('playerSelect');
            if (weekSelect) weekSelect.value = '';
            if (playerSelect) playerSelect.value = '';
        });
    }

    // Perform initial AJAX load after DOM ready
    performFilter();
});


document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggle-form-button');
    const formContainer = document.getElementById('add-player-form-container');

    if (toggleButton && formContainer) {
        toggleButton.addEventListener('click', function () {
            formContainer.classList.toggle('hidden');
        });
    }
});
