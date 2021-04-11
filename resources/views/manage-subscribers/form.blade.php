@extends('layout')

@section('content')
    <h1>Új feliratkozás</h1>
    <form action="{{ route('subscriber.store') }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback @if ($errors->has('email')) has-error @endif">
                    <label for="email">E-mail cím</label>
                    <input type="email" class="form-control" id="email" value="{{$model->email}}" name="email">
                    @if ($errors->has('email'))
                        <span class="help-block" role="alert">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Mentés</button>
            </div>
        </div>
    </form>

@endsection
