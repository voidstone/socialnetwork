@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>

             @if (!$statuses->count())
                <p>{{ $user->getFirstNameOrUsername() }} has't posted anything  yet.</p>
                @else
                        @foreach ($statuses as $status)
                            <div class="media">
                                                   <a class="pull-left" href="{{ route('profile.index', [
                                                    'username' => $status->user->username])}}">
                                                        <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">
                                                    </a>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><a href="{{ route('profile.index', [
                                                    'username' => $status->user->username])}}">{{ $status->user->getNameOrUsername() }}</a></h4>
                                                        <p>{{ $status->body}}</p>
                                                        <ul class="list-inline">
                                                            <li>{{ $status->created_at->diffForHumans()}}</li>
                                                            <li><a href="#">Like</a></li>
                                                            <li>10 likes</li>
                                                        </ul>
                                                                
                                                                @foreach ($status->replies as $reply)
                                                                <div class="media">
                                                                    <a class="pull-left" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                                                                        <img class="media-object" alt="{{ $reply->user->getNameOrUsername()}}" src="{{ $reply->user->getAvatarUrl()}}">
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername()}}</a></h5>
                                                                        <p>{{ $reply->body}}</p>
                                                                        <ul class="list-inline">
                                                                            <li>{{ $reply->created_at->diffForHumans() }}</li>
                                                                            <li><a href="#">Like</a></li>
                                                                            <li>4 likes</li>
                                                                        </ul>
                                                                    </div>
                                                                </div> 

                                                              @endforeach

                                                        @if ($authUserIsFriend || Auth::user()->id === $status->id )
                                                            <form role="form" action="{{ route('status.reply', ['statusId'=> $status->id]) }}" method="post">
                                                                <div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error' : ''}}">
                                                                    <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                                                                    @if ($errors->has("reply-{$status->id}"))
                                                                    <span class="help-block">{{$errors->first("reply-{$status->id}")}}</span>
                                                                    @endif
                                                                </div>
                                                                <input type="submit" value="Reply" class="btn btn-default btn-sm">
                                                                    <input type="hidden" name="_token"value="{{ Session::token() }}"></input>
                                                            </form>
                                                        @endif
                                                    </div>
                                        </div>
                        @endforeach

                      
                @endif

        </div>
        <div class="col-lg-4 col-lg-offset-3">

            @if(Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friend.accept', ['username' => $user->username])}}" class="btn btn-primary">Accept friend request</a>
            @elseif(Auth::user()->isFriendsWith($user))
                <p>You and {{ $user->getNameOrUsername() }} are friends</p>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Add as friend</a>

            @endif

<h4>{{ $user->getFirstNameOrUsername() }}'s friends</h4>

@if(!$user->friends()->count())
    <p>{{ $user->getFirstNameOrUsername() }} han no friends</p>

@else
    @foreach($user->friends() as $user)
        @include('user/partials/userblock')

    @endforeach

@endif
</div>
</div>
@stop