<?php

namespace App\Http\Controllers;

use App\Opinion;
use App\Comment;
use Illuminate\Http\Request;
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
        $opinion = Opinion::with('comments')->find($id);

        return response()->json(
            [
                'errors' => [],
                'data' => $opinion,
                'message' => '',
            ],
            200
        );
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
    public function update(OpinionRequest $request, $id)
    {
        $opinion = Opinion::where(
            [
                'id' => $id,
                'user_id' => \Auth::user()->id
            ]
        )->first();

        $opinion->title = $request->title;
        $opinion->text = $request->text;

        if ($opinion->save()) {
            return response()->json(
                [
                    'errors' => [],
                    'data' => [],
                    'message' => 'User opinion has been updated'
                ],
                200
            );
        }
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
