<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $user = new User;

      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->saveOrFail();

      $client = new Client;
      $client->fill($request->all());
      $client->user_id = $user->id;
      $client->saveOrFail();

      return response()->json([
          'id' => $client->id,
          'user_id' => $client->user_id,
          'created_at' => $client->created_at,
      ], 201);
    }
    catch(QueryException $ex) {
        return response()->json([
            'message' => $ex->getMessage(),
        ], 500);
    }
    catch(\Exception $ex) {
        return response()->json([
            'message' => $ex->getMessage(),
        ], 500);
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
  public function update(Request $request, $id)
  {
    try {
      $client = Client::findOrFail($id);

      $client->fill($request->all());
      $client->saveOrFail();

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
