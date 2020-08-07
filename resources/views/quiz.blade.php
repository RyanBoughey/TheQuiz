@extends('layouts.app')

@section('title', 'The Quiz')

@section('content')
    <form method="POST" action="/confirm">
        @csrf
        <?php // this is the bit with the actual quiz in it ?>
        @foreach ($ordered_questions as $question)
            <div class="question">
                <p>{{ $question->name }}</p>
                <?php switch ($question->type) {
                    case 'radio': ?>
                        <?php $count = 1 ?>
                        @foreach ($question->scores as $answer)
                            <div style="font-weight: 200">
                                <input type="radio" name="{{ $question->key }}" id="{{ $question->key }}-{{ $count }}" value="{{ $answer[0] }}">
                                <label for="{{ $question->key }}-{{ $count }}" <?= ($errors->has($question->key) ? 'class="error"' : '') ?> > {{ $answer[0] }}</label><br>
                            </div>
                            <?php $count++; ?>
                        @endforeach
                    <?php break;
                    case 'text': ?>
                        <input type="text" name="{{ $question->key }}" value="" <?= ($errors->has($question->key) ? 'class="error"' : '') ?> >
                    <?php break;
                    default:
                        // code...
                        break;
                } ?>
            </div>
        @endforeach
        <input type="submit" class="button" value="Submit">
    </form>
@endsection
