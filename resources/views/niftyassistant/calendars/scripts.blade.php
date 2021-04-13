<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    let startDate, endDate;
    let eventAlready = false;
    let calendar = $("#calendar").fullCalendar({
        slotDuration: "00:15:00",
        minTime: "06:00:00",
        maxTime: "23:59:00",
        defaultView: "agendaWeek",
        handleWindowResize: !0,
        height: $(window).height() - 100,
        header: {
            right: "prev,next today",
        },
        events: [
            @foreach ($events as $event)
            {
                title: '{{ $event->work }}',
                start: '{{ $event->date.'T'.$event->start_time }}',
                end: '{{ $event->date.'T'.$event->end_time }}',
                className: "{{ $event->class_name }}"
            },
            @endforeach
        ],
        editable: !0,
        droppable: !0,
        eventLimit: !0,
        selectable: !0,
        drop: function(t) {
            o.onDrop($(this), t)
        },
        select: function(e, t, n) {
            startDate = e;
            endDate = t;
            eventAlready = false;
            $("#event-modal").modal({
                backdrop: "static"
            });
        },
        eventClick: function(e, t, n) {
            onEventClick(e, t, n)
        }
    });

    $(document).on('submit', '#event-form', function (e) {
        e.preventDefault();
        if (eventAlready) {
            alert('This Event is already created!');
            return;
        }
        let title = $('#work').val();
        if (!title.length) {
            alert('You have to give a title to your event');
            return;
        }
        let formData = $(this).serializeArray();
        formData.push({
            name: 'start_date',
            value: startDate.format(),
        }, {
            name: 'end_date',
            value: endDate.format(),
        });

        $.ajax({
            url: '{{ route('niftyassistant.calendars.store') }}',
            method: 'post',
            data: formData,
            success: function (data) {
                $("#calendar").fullCalendar("renderEvent", {
                    title: title,
                    start: startDate,
                    end: endDate,
                    className: "bg-danger"
                });
                $("#event-modal").modal("hide");
            },
            error: function (error) {
                swal('Error');
            }
        });

        $('#work').val('');
    })

    function onEventClick(event) {
        startDate = event.start.format();
        endDate = event.end.format();

        eventAlready = true;

        $("#event-modal").modal({
            backdrop: "static"
        });

        $('#work').val(event.title);
    }

    $(document).on('click', '#delete-event', function (e) {
        if (!confirm('Are you sure, you want to delete this event?')) {
            return;
        }
        if ($('#work').val() === 'Availability Period') {
            swal('Error', 'Please edit availability period from the availability tab under Manage Profile!', 'error');
            return;
        }
        e.preventDefault();
        let formData = [{
            name: 'start_date',
            value: startDate,
        }, {
            name: 'end_date',
            value: endDate,
        }, {
            name: '_token',
            value: '{{ csrf_token() }}',
        }, {
            name: '_method',
            value: 'delete',
        }]
        $.ajax({
            url: '{{ route('niftyassistant.calendars.destroy') }}',
            data: formData,
            method: 'post',
            success: function (data) {
                $("#calendar").fullCalendar("removeEvents", function(e) {
                    return e.start.format() === startDate && e.end.format() === endDate;
                });
                $('#work').val('');
            },
            error: function (data) {

            }
        })
    })

</script>
