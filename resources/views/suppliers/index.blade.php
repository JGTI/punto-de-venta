@extends('masterpage.admin')

@section('title', 'Gestión de Menús')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" rel="stylesheet">
    <style>
        .hidden { display: none; }
    </style>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Quiero ser Proveedor</h5>
                </div>
                </div>
                <div class="table-responsive">
                <form id="reliabilityQuiz" class="needs-validation" novalidate>
                    @foreach($question as $index => $q)
                    <div class="question mb-3 {{ $index == 0 ? '' : 'hidden' }}" id="question{{$index}}" data-question-id="{{$q->id}}">
                        <p>{{$index+1}}. {{$q->question}}</p>
                        <div>
                            <input type="radio" class="form-check-input" name="question_{{$q->id}}" id="q{{$index}}o1" value="{{$q->option_a}}" required>
                            <label class="form-check-label" for="q{{$index}}o1">{{$q->option_a}}</label>
                        </div>
                        <div>
                            <input type="radio" class="form-check-input" name="question_{{$q->id}}" id="q{{$index}}o2" value="{{$q->option_b}}">
                            <label class="form-check-label" for="q{{$index}}o2">{{$q->option_b}}</label>
                        </div>
                        <div>
                            <input type="radio" class="form-check-input" name="question_{{$q->id}}" id="q{{$index}}o3" value="{{$q->option_c}}">
                            <label class="form-check-label" for="q{{$index}}o3">{{$q->option_c}}</label>
                        </div>
                        <div>
                            <input type="radio" class="form-check-input" name="question_{{$q->id}}" id="q{{$index}}o4" value="{{$q->option_d}}">
                            <label class="form-check-label" for="q{{$index}}o4">{{$q->option_d}}</label>
                        </div>
                        <br>
                        @if($index!=0)
                            <button type="button" class="btn btn-dark previous">Anterior</button>
                        @endif
                        @if($index!=count($question)-1)
                            <button type="button" class="btn btn-dark next">Siguiente</button>
                        @else
                            <button type="submit" class="btn btn-dark">Enviar</button>
                        @endif
                    </div>
                    @endforeach
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="{{url('assets/js/bootstrap-notify.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.1/js/selectize.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let totalQuestions = $('.question').length;
        let currentQuestion = 0;

        function updateQuestionVisibility() {
            $('.question').addClass('hidden');
            $('#question' + currentQuestion).removeClass('hidden');
        }

        $('.next').on('click', function() {
            if ($("input[name='question_" + $('#question' + currentQuestion).data('questionId') + "']:checked").val()) {
                currentQuestion++;
                updateQuestionVisibility();
            } else {
                alert('Por favor, seleccione una opción antes de continuar.');
            }
        });

        $('.previous').on('click', function() {
            if (currentQuestion > 0) {
                currentQuestion--;
                updateQuestionVisibility();
            }
        });

        updateQuestionVisibility(); // Inicializar visibilidad de preguntas

        $('#reliabilityQuiz').on('submit', function(e) {
            if ($("input[type='radio']:checked").length < totalQuestions) {
                e.preventDefault();
                alert('Por favor, contesta todas las preguntas antes de enviar tus respuestas.');
            }
        });
    });
</script>
@endsection
