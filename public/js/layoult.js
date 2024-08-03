$(document).ready(function () {
    var translations = {
        'pt-br': 'Criar Evento',
        'en-us': 'Create Event',
        'en-au': 'Create Event',
        'en-gb': 'Create Event',
        'en-nz': 'Create Event',
        'es': 'Crear Evento',
        'fr': 'Créer Événement'
    };

    $('#eventModal').on('show.bs.modal', function (event) {
        var modal = $(this);

        var id = modal.data('id');
        var title = modal.data('title');
        var description = modal.data('description');

        console.log('start', modal.data('start'));
        console.log('end', modal.data('end'));

        // Converter a string em um objeto Date
        const date = new Date(modal.data('start'));

// Formatar a data para o timezone local
        const localDate = date.toLocaleString();

        console.log(localDate);
        console.log(localDate);
        console.log(localDate);
        console.log(localDate);

        var start = moment(modal.data('start')).tz("America/Sao_Paulo").add(3, 'hours').format('DD/MM/YYYY HH:mm');
        var end = moment(modal.data('end')).tz("America/Sao_Paulo").add(3, 'hours').format('DD/MM/YYYY HH:mm');

        console.log('Formatted start:', start);
        console.log('Formatted end:', end);

        modal.find('#title').text(title);
        modal.find('#description').text(description);
        modal.find('#start').text('Inicia: ' + start);
        modal.find('#end').text('Finaliza: ' + end);

        modal.find('#edit-event-button').data('id', id);
        modal.find('#cancel-event-button').data('id', id);
    }).on('hidden.bs.modal', function (event) {
        var modal = $(this);

        modal.find('#title').text('');
        modal.find('#description').text('');
        modal.find('#start').text('Inicia: ');
        modal.find('#end').text('Finaliza: ');

        modal.find('#edit-event-button').data('id', '');
        modal.find('#cancel-event-button').data('id', '');

        modal.find('.error-message').remove();
    });

    $('#addEventModal').on('hidden.bs.modal', function () {
        var modal = $(this);

        $('#id').val('');
        $('#title').val('');
        $('#description').val('');
        $('#start_datetime').val('');
        $('#end_datetime').val('');
        $('#addEventModalLabel').text('Criar Evento');
        $('#addEventForm').attr('action', '/add-event');
        modal.find('.error-message').remove();
    });

    $.ajax({
        url: '/list-events-formatted',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            var initialLocaleCode = 'pt-br';
            var localeSelectorEl = document.getElementById('locale-selector');
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today myCustomButton',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                },
                customButtons: {
                    myCustomButton: {
                        text: translations[initialLocaleCode],
                        click: function () {
                            $('#addEventModal').modal('show');
                        }
                    }
                },
                eventClick: function (info) {
                    $('#eventModal').data({
                        'id': info.event.id,
                        'title': info.event.title,
                        'description': info.event.extendedProps.description,
                        'start': info.event.start,
                        'end': info.event.end
                    }).modal('show');
                },
                themeSystem: 'bootstrap5',
                locale: initialLocaleCode,
                buttonIcons: false,
                weekNumbers: false,
                navLinks: true,
                editable: false,
                dayMaxEvents: true,
                events: response.data,
                timeZone: 'UTC',

            });

            calendar.render();

            calendar.getAvailableLocaleCodes().forEach(function (localeCode) {
                var optionEl = document.createElement('option');
                optionEl.value = localeCode;
                optionEl.selected = localeCode == initialLocaleCode;
                optionEl.innerText = localeCode;
                localeSelectorEl.appendChild(optionEl);
            });

            localeSelectorEl.addEventListener('change', function () {
                var selectedLocale = this.value;
                if (selectedLocale) {
                    calendar.setOption('locale', selectedLocale);
                    var newButtonText = translations[selectedLocale];

                    document.querySelector('.fc-myCustomButton-button').textContent = newButtonText;
                }
            });
        },
        error: function () {
            alert('Error retrieving event data.');
        }
    });

    $('.edit-event').click(function (e) {
        e.preventDefault();
        var eventId = $(this).data('id');

        $.ajax({
            url: '/get-event',
            method: 'GET',
            data: {id: eventId},
            dataType: 'json',
            success: function (response) {
                $('#id').val(response.data.id);
                $('#title').val(response.data.title);
                $('#description').val(response.data.description);
                $('#start_datetime').val(response.data.start_datetime);
                $('#end_datetime').val(response.data.end_datetime);
                $('#addEventModalLabel').text('Editar evento');
                $('#addEventForm').attr('action', '/edit-event');
                $('#eventModal').modal('hide')
                $('#addEventModal').modal('show');
            },
            error: function () {
                alert('Error retrieving event data.');
            }
        });
    });

    $('#addEventForm').submit(function (e) {
        e.preventDefault();
        var formAction = $(this).attr('action');
        var formData = $(this).serialize();

        $.ajax({
            url: formAction,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    localStorage.setItem('success_message', response.message);
                    location.reload();
                } else {
                    for (var field in response.errors) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).next('.invalid-feedback').text(response.errors[field]);
                    }
                }
            },
            error: function () {
                alert('Error processing the request.');
            }
        });
    });

    $('.cancel-event').click(function (e) {
        e.preventDefault();
        var eventId = $(this).data('id');

        $.ajax({
            url: '/cancel-event',
            method: 'POST',
            data: {id: eventId},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    localStorage.setItem('success_message', response.message);
                    location.reload();
                } else {
                    alert('Error canceling the event.');
                }
            },
            error: function () {
                alert('Error processing the request.');
            }
        });
    });

    var successMessage = localStorage.getItem('success_message');
    if (successMessage) {
        localStorage.removeItem('success_message');
        $('.toast-body').text(successMessage);
        $('.toast').toast({delay: 3000});
        $('.toast').toast('show');
    }
});
