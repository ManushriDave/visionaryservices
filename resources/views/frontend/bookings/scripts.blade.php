<script>
    $(document).ready(function () {
        $('#assistant_type_id').val({{ isset($_GET['assistant_type_id']) ? $_GET['assistant_type_id'] : '' }});
        $.get('{{ config('app.url') }}/api/assistant-types/{{ isset($_GET['assistant_type_id']) ? $_GET['assistant_type_id'] : $assistant_types->first()->id }}/tasks').then(
            res => {
                let options = '';
                if (res.length) {
                    let data;

                    if (typeof res === 'object') {
                        data = res;
                    } else {
                        data = JSON.parse(res);
                    }

                    $.each(data, function (i, opt) {
                        options += '<option value="' + opt.id + '">' + opt.name + '</option>';
                    });
                }
                $('#task_ids').html(options);
            }
        );

        $(document).on('change', '#assistant_type_id', function () {
            $.get('{{ config('app.url') }}/api/assistant-types/' + $(this).val() + '/tasks').then(
                res => {
                    let options = '';
                    if (res.length) {
                        let data;

                        if (typeof res === 'object') {
                            data = res;
                        } else {
                            data = JSON.parse(res);
                        }

                        $.each(data, function (i, opt) {
                            options += '<option value="' + opt.id + '">' + opt.name + '</option>';
                        });

                        if ($(this).val() === '4') {
                            $('#approx_duration').attr('disabled', true).val('Not required!');
                        }
                    }
                    $('#task_ids').html(options);
                }
            )
        });
    })
</script>
