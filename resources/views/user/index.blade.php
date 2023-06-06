@extends('user.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>user</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('user.create') }}"> Create New user</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table" id="table">
        <thead>
        <tr>
            <th>No</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th width="200px">Action</th>
        </tr>
        </thead>

            <tbody>
                @foreach($users as $user)
                <tr class="user{{$user->id}}">
                    <td>{{++$i}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>


                    <td>
                        <form action="{{ route('user.destroy',$user->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('user.show',$user->id) }}"><i class="fa-solid fa-eye"></i> </a>

                            <a class="btn btn-primary" href="{{ route('user.edit',$user->id) }}"><i class="fa-solid fa-pen"></i></a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger"><i class="fa-sharp fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>


    </table>
    {!!$users->links()!!}

@endsection
