@extends('layouts.app')

@section('content')
  <div class="container">
    @foreach ($users as $user)
      <p>
        {{ $user->name }}
      </p>
    @endforeach
  </div>
  {{ $users->links() }}
@endsection