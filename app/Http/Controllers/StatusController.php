<?php

namespace Chatty\Http\Controllers;

use Auth;
use Chatty\Models\User;
use Chatty\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller {

	public function postStatus(Request $request) {

		$this->validate($request, [
				'status' => 'required|max:1000',
			]);

		Auth::user()->statuses()->create( [
			'body' =>$request->input('status'),
			]);

		return redirect()->route('home')->with('info', 'Status posted.');
	}

	public function postReply(Request $request, $statusId) 
	{
		$this->validate($request, [
			"reply-{$statusId}" => 'required|max:1000',
			],[
			'required' => ' The reply body is reqired.'
			]);

			$status = Status::notReply()->find($statusId);

			if( !$status) {
				return redirect()->route('home');				
			}

			if(!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id) {
					return redirect()->route('home');
			}

			$reply = Status::create([
				'body' => $request->input("reply-{$statusId}"),
				])->user()->associate(Auth::user());

			$status->replies()->save($reply);

			return redirect()->back();

	}

	public function getLike($statusId)
	{
		$status = Status::find($statusId);
		
		if( !$status) {
				return redirect()->route('home');				
			}


		if(!Auth::user()->isFriendsWith($status->user) ) {
					return redirect()->route('home');
			}

			if (Auth::user()->hasLikedStatus($status)) {
				return redirect()->back();
				# code...
			}

			$like = $status->likes()->create([]);

			Auth::user()->likes()->save($like);

			return redirect()->back();
	}

    
}