<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\UserRequest;
use App\Client;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;
use App\User;

class ClientController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $clients = Client::get();

    return new ClientCollection($clients);
  }

  public function register(UserRequest $request1, ClientRequest $request2)
  {
    $user = new User;
    $user->name = $request1->name;
    $user->email = $request1->email;
    $user->password = bcrypt($request1->password);

    $client = new Client;
    $client->fill($request2->all());

    DB::transaction(function () use ($user, $client) {
      $user->saveOrFail();
      $client->user_id = $user->id;
      $client->saveOrFail();
    });

    return response()->json([
      'id' => $client->id,
      'user_id' => $client->user_id,
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $client = Client::with('pets')->with('bookings')->findOrFail($id);

      return new ClientResource($client);
    } catch (ModelNotFoundException $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 404);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ClientRequest $request, $id)
  {
    try {
      $client = Client::findOrFail($id);
      $user = User::findOrFail($client->user_id);

      $client->fill($request->all());
      $user->name = $request->name;

      DB::transaction(function () use ($user, $client) {
        $user->saveOrFail();
        $client->saveOrFail();
      });

      return response()->json(null, 204);
    } catch (ModelNotFoundException $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 404);
    } catch (QueryException $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 500);
    } catch (\Exception $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 500);
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
    try {
      $client = Client::findOrFail($id);

      DB::transaction(function () use ($client) {
        $client->delete();
      });

      return response()->json(null, 204);
    } catch (ModelNotFoundException $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 404);
    } catch (QueryException $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 500);
    } catch (\Exception $ex) {
      return response()->json([
        'message' => $ex->getMessage(),
      ], 500);
    }
  }
}
