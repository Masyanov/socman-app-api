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

$("#update_dates").on("click", function () {
    let user_id = $("#user_id").val();
    let dates = new Array();
    $('input[name="dates[]"]:checked').each(function () {
        dates.push($(this).val());
    });

    let _url = `/picker`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "PATCH",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            dates: dates,
            _token: _token
        },
        success: function (response) {
            $('#response').empty();
            $('#response').append('<div id="toast-success" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">\n' +
                '    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">\n' +
                '        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">\n' +
                '            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>\n' +
                '        </svg>\n' +
                '        <span class="sr-only">Check icon</span>\n' +
                '    </div>\n' +
                '    <div class="ms-3 text-sm font-normal">Даты сохранены</div>\n' +
                '</div>');
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger" role="alert">' + response.responseJSON.message + '</div>');
        }
    });
});


$('#search').on('click', function () {
    let sort_by_experience = $('#sort_by_experience').val();
    let sort_by_date = $('#date').val();

    let sort_by_w = $('#pvz1').prop('checked');
    if (sort_by_w == true) {
        sort_by_w = '1';
    } else {
        sort_by_w = '';
    }
    let sort_by_o = $('#pvz2').prop('checked');
    if (sort_by_o == true) {
        sort_by_o = '1';
    } else {
        sort_by_o = '';
    }
    let sort_by_y = $('#pvz3').prop('checked');
    if (sort_by_y == true) {
        sort_by_y = '1';
    } else {
        sort_by_y = '';
    }
    let sort_by_region = $('#region').val();
    let sort_by_city = $('#city').val();
    let url = '/users'
    $.ajax({
        url: url,
        method: "GET",
        data: {
            sort_by_experience: sort_by_experience,
            sort_by_date: sort_by_date,

            sort_by_w: sort_by_w,
            sort_by_o: sort_by_o,
            sort_by_y: sort_by_y,

            sort_by_region: sort_by_region,
            sort_by_city: sort_by_city,
        },
        success: function (response) {
            if (response.data.data != '') {
                $('#response').empty();
                response.data.data.forEach(function (entry) {

                    let countRaiting = entry.reviews.length;
                    let averegeRaiting = [];
                    var total = 0;
                    entry.reviews.forEach(function (review) {
                        averegeRaiting.push(review.review)
                    });
                    for (var i = 0; i < averegeRaiting.length; i++) {
                        total += averegeRaiting[i] << 0;
                    }
                    let raiting = total / countRaiting;
                    let raitingText = '0';
                    if (raiting) {
                        raitingText = raiting.toFixed(1)
                    }

                    let city = entry.city;
                    if (city) {
                        city = entry.city;
                    } else {
                        city = 'Город не указан';
                    }

                    let exp = entry.experience;
                    if (exp == 1) {
                        exp = '1-3 мес.';
                    } else if (exp == 2) {
                        exp = '3 мес. - 1 год';
                    } else if (exp == 3) {
                        exp = 'От 1 года';
                    } else {
                        exp = 'Нет';
                    }
                    let w = '';
                    let o = '';
                    let y = '';

                    if (entry.w != 0) {
                        w = '<img class="w-5 h-5" src="/build/assets/images/wb.png" alt="Wildberries" title="Wildberries">';
                    }
                    if (entry.o != 0) {
                        o = '<img class="w-5 h-5" src="/build/assets/images/o.png" alt="OZON" title="OZON">';
                    }
                    if (entry.y != 0) {
                        y = '<img class="w-5 h-5" src="/build/assets/images/y.png" alt="ЯндексМаркет" title="ЯндексМаркет">';
                    }
                    $('#response').append('\n' +
                        '\n' +
                        '<a href="/users/' + entry.id + '" class="relative flex flex-col justify-between max-w-sm p-3 sm:p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">\n' +
                        '    <div>\n' +
                        '        <h5 class="mb-1 text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">' + entry.name + '</h5>\n' +
                        '    </div>\n' +
                        '    <p class="mb-1 text-sm sm:font-normal text-gray-700 dark:text-gray-400">' + city + '</p>\n' +
                        '<div>' +

                        '<div class="flex items-center">\n' +
                        '<svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">\n' +
                        ' <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>\n' +
                        ' </svg>\n' +
                        ' <p class="ms-2 text-sm font-bold text-gray-900 dark:text-white">' + raitingText + '</p>\n' +
                        ' <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"></span>\n' +
                        '<div  class="text-sm font-medium text-gray-900 dark:text-white">' + countRaiting + '</div>\n' +
                        ' </div>\n' +


                        '    <p class="mb-3 text-sm sm:font-normal text-gray-700 dark:text-gray-400">Опыт: ' + exp + '</p>\n' +
                        '<div class="flex gap-2 mb-4 absolute inline-flex items-center justify-center text-xs font-bold text-white border-1 border-white rounded-full -top-2 end-2 dark:border-gray-900">' +
                        w + o + y +
                        '</div>' +

                        '    <button type="button" class="flex items-center text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">\n' +
                        '        Подробнее\n' +
                        '        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">\n' +
                        '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>\n' +
                        '        </svg>\n' +
                        '    </button>\n' +
                        '</div>\n' +
                        '</a>'
                    )

                });
            } else {
                $('#response').empty();
                $('#response').append('\n' +
                    '<div class="col-span-5 flex items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">\n' +
                    '                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">\n' +
                    '                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>\n' +
                    '                            </svg>\n' +
                    '                            <span class="sr-only">Info</span>\n' +
                    '                            <div>\n' +
                    '                                <span class="font-medium">По данному запросу ничего не найдено.</span>\n' +
                    '                            </div>\n' +
                    '                        </div>'
                )
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger" role="alert">' + response.responseJSON.message + '</div>');
        }
    });
});


$("#button_save_review").on("click", function () {
    let user_id = $("#user_id").val();
    let review = $("input[name='review']:checked").val();
    let text = $("#text").val();

    let _url = `/reviews`;
    let _token = $('input[name~="_token"]').val();

    $.ajax({
        url: _url,
        type: "POST",
        enctype: 'multipart/form-data',
        data: {
            user_id: user_id,
            review: review,
            text: text,
            _token: _token
        },
        success: function (response) {
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger text-gray-400" role="alert">Отзыв сохранен</div>');
            if (response.code == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function (response) {
            $('#response').empty();
            $('#response').append('<div class="alert alert-danger" role="alert">Заполните текст отзыва</div>');
        }
    });
});

$(document).ready(function () {
    var maxCount = 150;

    $("#counter").html(maxCount);

    $("#text").keyup(function () {
        var revText = this.value.length;

        if (this.value.length > maxCount) {
            this.value = this.value.substr(0, maxCount);
        }
        var cnt = (maxCount - revText);
        if (cnt <= 0) {
            $("#counter").html('0');
        } else {
            $("#counter").html(cnt);
        }

    });


});

$("#no").click(function () {
    document.cookie = "show=no; path=/; expires=1"
});
