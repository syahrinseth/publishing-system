<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ManuscriptMember;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InviteReviewerForReview;

class ManuscriptMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required',
            'status' => 'required',
            'user_id' => [Rule::requiredIf(empty($request->input('members')))],
            'members' => ['nullable', 'array']
        ]);

        $user_ids = ManuscriptMember::mapInputIntoUserID($validated);

        ManuscriptMember::createMembers(
            Manuscript::findOrFail($id),
            [
                'reviewers' => $user_ids
            ],
        );

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $member_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $member_id)
    {
        $validated = $request->validate([
            'role' => 'required',
            'status' => 'required'
        ]);

        $member =  ManuscriptMember::findOrFail($member_id);
        $member->update($validated);
        
        if ($validated['role'] == 'reviewer' && $validated['status'] == 'Accepted') {

            // Invite reviewer through email.
            Notification::send($member->user, new InviteReviewerForReview($member->manuscript, $member));

        }

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $member_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $member_id)
    {
        $member = ManuscriptMember::findOrFail($member_id)
            ->delete();

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::back();
    }

    /**
     * Accept Invitation
     * @param Request $request
     * @param int $id
     * @param int $member_id
     */
    public function acceptInvitation(Request $request, $id, $member_id)
    {
        $member = ManuscriptMember::findOrFail($member_id);
        if (auth()->id() != $member?->user_id) {
            return abort(404);
        }

        $member->update([
            'status' => 'Active'
        ]);

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::route('manuscript.edit', [
            'id' => $id
        ]);
    }

    /**
     * Decline Invitation
     */
    public function declineInvitation(Request $request, $id, $member_id)
    {
        $member = ManuscriptMember::findOrFail($member_id);
        if (auth()->id() != $member?->user_id) {
            return abort(404);
        }

        $member->update([
            'status' => 'Rejected'
        ]);

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::back();
    }
}
