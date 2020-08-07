@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
    <?php $my_result_shown = false; ?>
	<table class="table100 mt-12">
		<thead class="table100-head">
			<tr>
				<th class="column1">Rank</th>
				<th class="column2">Name</th>
				<th class="column3">Email</th>
				<th class="column4">Score</th>
			</tr>
		</thead>
		<tbody class="table100-body">
            @foreach ($leaderboard as $result)
                @if ($my_result->id == $result->id)
                    <?php $my_result_shown = true; ?>
                    <tr class="bold">
                @else
                    <tr>
                @endif
                    <td class="column1">{{ $result->rank }}</td>
                    <td class="column2">{{ ($result->name != null ? $result->name : 'anonymous') }}</td>
                    <td class="column3">{{ ($result->email != null ? $result->email : 'N/A') }}</td>
                    <td class="column4">{{ $result->score }}</td>
                </tr>
            @endforeach
            @if ($my_result_shown == false)
                <tr class="bold">
                    <td class="column1">{{ $my_result->rank }}</td>
                    <td class="column2">{{ ($my_result->name != null ? $my_result->name : 'anonymous') }}</td>
                    <td class="column3">{{ ($my_result->email != null ? $my_result->email : 'N/A') }}</td>
                    <td class="column4">{{ $my_result->score }}</td>
                </tr>
            @endif
		</tbody>
	</table>
@endsection
