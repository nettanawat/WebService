@extends('master')

@section('title', 'Place order')

@section('content')


@if (isset($response_order_message))
<div id="responseBack">
    @if($response_order_message == 'success')
    <div class="alert alert-success text-center">
        <h3>{{ $response_order_message }}</h3>
        <li><h4>{{ $response_order_message_detail }}</h4></li>
    </div>
    @else
    <div class="alert alert-danger  text-center">
        <ul>
            <li>{{ $response_order_message }}</li>
            <li><h4>{{ $response_order_message_detail }}</h4></li>
        </ul>
    </div>
    @endif
</div>

@endif

<div class="container-fluid">
    <div class="col-md-12 text-center">
        <h1>Notification</h1>
    </div>
    <table class="table">
        <tr>
            <th>id</th>
            <th>title</th>
            <th>message</th>
            <th>status</th>
            <th>action</th>
        </tr>
        @foreach($notifications as $notification)
            @if($notification->is_read == 0)
                <tr class="alert-danger">
                    <td>{{$notification->id}}</td>
                    <td>{{$notification->title}}</td>
                    <td>{{$notification->detail}}</td>
                    <td>unread</td>
                    <td>
                        <form action="/notification/read/{{$notification->id}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="submit" value="Mark as read" class="btn btn-xs btn-default">
                        </form>
                    </td>
                </tr>
            @else
                <tr class="alert-success">
                    <td>{{$notification->id}}</td>
                    <td>{{$notification->title}}</td>
                    <td>{{$notification->detail}}</td>
                    <td>read</td>
                    <td>
                        <form>
                            <input type="hidden" name="id" value="{{$notification->id}}">
                            <input type="submit" value="Mark as read" class="btn btn-sm btn-default" disabled>
                        </form>
                    </td>
                </tr>
            @endif

        @endforeach
    </table>

</div>

@endsection