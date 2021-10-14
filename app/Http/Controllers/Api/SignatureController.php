<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignatureStoreRequest;
use App\Http\Resources\SignatureResource;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SignatureResource::collection(Signature::orderByDesc('created_at')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignatureStoreRequest $request)
    {
        $signature = Signature::create($request->validated());
        return new SignatureResource($signature);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SignatureStoreRequest $request, Signature $signature)
    {
        $signature->status = $request->status;
        $signature->description = $request->description;
        $signature->save();

        if ($signature->status == 'processing'){
            return response(null,Response::HTTP_NO_CONTENT);
        }
        $data = [
            'user'=>  $signature->user,
            'signature'=>  $signature,
        ];

        \Mail::send('emails.reply', $data, function ($message) use ($signature) {
            $message->subject('Заявка на буквенное имя');
            $message->from('no-reply@test.com');
            $message->to($signature->user->email);
        });

        return response(null,Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
