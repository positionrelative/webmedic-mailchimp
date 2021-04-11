@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('subscriber.create') }}" class="btn btn-primary">Új hozzáadása</a>
            <table class="table">
                <thead>
                <tr>
                    <th>Hash</th>
                    <th>E-mail</th>
                    <th>Státusz</th>
                    <th>Műveletek</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row->hash }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <div class="btn btn-group">
                                <a href="{{ route('subscriber.unsubscribe', ['id' => $row->id]) }}"
                                   onclick="return confirm('Biztosan le szeretné iratkoztatni?')"
                                   class="btn btn-warning btn-sm">Leiratkozás</a>
                                <a href="{{ route('subscriber.delete', ['id' => $row->id]) }}"
                                   onclick="return confirm('Biztosan törölni szeretné?')"
                                   class="btn btn-danger btn-sm">Törlés</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $data->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
