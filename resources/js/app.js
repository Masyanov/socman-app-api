import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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
        mask(code[i], "___ - ___");
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

