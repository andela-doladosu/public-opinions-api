<?php

namespace App\Http\Controllers;

use App\Opinion;
use App\Comment;
use App\Http\Requests\OpinionRequest;
use App\Http\Requests\CommentRequest;

class OpinionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opinions = Opinion::with('comments')->get();

        return response()->json(
            [
                'errors' => [],
                'data' => $opinions,
                'message' => '',
            ]
        );
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
     * @return \Illuminate\Http\Response
     */
    public function store(OpinionRequest $request)
    {
        $opinion = array_merge(
            [
                'user_id' => \Auth::user()->id
            ],
            $request->all()
        );

        if (Opinion::create($opinion)) {
            return response()->json(
                [
                    'errors' => [],
                    'data' => [],
                    'message' => 'User opinion has been added',
                ],
                200
            );
        }
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(CommentRequest $request)
    {
        $comment = $request->all();

        if (Comment::create($comment)) {
            return response()->json(
                [
                    'errors' => [],
                    'data' => [],
                    'message' => 'User comment has been added',
                ],
                200
            );
        }
    }
}
