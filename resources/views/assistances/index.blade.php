@extends('Layouts.base')

@section('title', 'Asistencias')

@section('content')

    <div class="content_assistances">
        <header>
            <h3>ASISTENCIAS</h3>
            <form>
                <div class="content_input">
                    <select name="group" id="">
                        <option value="">-- Selecciona grupo --</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} - {{ $group->career->name }}</option>
                            @if ($group->id == $groupSelected)
                                <option value="{{ $group->id }}" selected="selected">{{ $group->name }} -
                                    {{ $group->career->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="content_btn">
                    <button>Lista</button>
                </div>
            </form>
            <div>
                <h5><label class="label_color">Instrucciones</label></h5>
                <ul>
                    <li>N/A es un no registro, si se deja así se dara a entender que el profesor no pasa lista</li>
                    <li>X se utiliza para marcar asistencia</li>
                    <li>O para marcar una no asistencia</li>
                </ul>
            </div>
        </header>
        <section class="assistance_panel">
            <section class="assistance_sub_panel">
                @php($sum = 0)
                @php($c = 0)
                @for ($i = 1; $i <= $numberWeek; $i++)
                    <div class="content_table" id="week-{{ $i }}">
                        <p><strong>Semana {{ $i }}</strong></p>
                        <table class="assistance_list table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    @foreach ($days as $day)
                                        @if (in_array($day, $daysSchedule))
                                            <th>
                                                {{ $day }}
                                                @include('assistances/simpleDate', [
                                                    'value' => date_create(
                                                        date(
                                                            'd-m-Y',
                                                            strtotime($startDate . ' +' . $sum . ' days')))->format('m/d'),
                                                ])
                                            </th>
                                        @endif
                                        @php($sum = $sum + 1)
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <th>{{ $student->firstName }} {{ $student->lastName }}</th>
                                        @foreach ($days as $day)
                                            @if (in_array($day, $daysSchedule))
                                                @if (isset($assistances[$c]))
                                                    <td class="assistance_cont_{{ $c }}">
                                                        <a href="#"
                                                            id="assistance-{{ $c }}">{{ $assistances[$c]->typeAssistance }}</a>
                                                    </td>
                                                @else
                                                    <td class="assistance_cont_{{ $c }}">
                                                        <a href="#" id="assistance-{{ $c }}">N/A</a>
                                                    </td>
                                                @endif
                                                @php($c = $c + 1)
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endfor
            </section>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            @php($c = 0)
            @for ($i = 1; $i <= $numberWeek; $i++)
                @foreach ($students as $student)
                    @foreach ($days as $day)
                        @if (in_array($day, $daysSchedule))
                            $('#assistance-{{ $c }}').on('click', function(e) {
                                e.preventDefault();
                                console.log('click');
                                var $form =
                                    '<form class="form_editable" id="assistance_form_{{ $c }}" method="POST" >' +
                                    '@csrf' +
                                    '<select name="value" class="input_editable">' +
                                    '<option value="N/A">N/A</option>' +
                                    '<option value="X">X</option>' +
                                    '<option value="O">O</option>' +
                                    '</select>' +
                                    '<button id="btn_assistance_{{ $c }}" class="btn_editable btn_accept"><img src="{{ asset('assets/img/successbtn.png') }}"/></button>' +
                                    '<button id="btn_cancel_{{ $c }}" class="btn_editable">Cancel</button>' +
                                    '</form>';
                                $('#assistance-{{ $c }}').before($form);
                                $('#assistance-{{ $c }}').remove();

                            })
                            @php($c = $c + 1)
                        @endif
                    @endforeach
                @endforeach
            @endfor
            $('.btn-sm').css('display', 'none');
        });
    </script>
@stop
