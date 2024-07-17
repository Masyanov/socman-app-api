function deleteTraining(idTraining) {
    let id  = idTraining;
    let _url = `/trainings/${id}`;
    let _token = $('input[name~="_token"]').val();

    if(confirm('Удалить тренировку?')) {
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function(response) {
                window.location.href = '/trainings';
            }
        });
    }
}


