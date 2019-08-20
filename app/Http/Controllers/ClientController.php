<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\UserRequest;
use App\Client;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;
use App\User;
use Bouncer;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $clients = Client::with('user')->get();

    return new ClientCollection($clients);
  }

  public function store(UserRequest $request1, ClientRequest $request2)
  {
    $user = new User;
    $user->email = $request1->email;
    $user->password = bcrypt($request1->password);

    $client = new Client;
    $client->fill($request2->all());

    DB::transaction(function () use ($user, $client) {
      $user->saveOrFail();
      $client->user_id = $user->id;
      $client->saveOrFail();
      Bouncer::assign('client')->to($user);
    });

    // send register email
    $email = $request1->email;
    $messageData = ['email' => $request1->email, 'name' => $request2->name];
    Mail::send('emails.register', $messageData, function ($message) use ($email) {
      $message->to($email)->subject('Registration with Pet Paradise');
    });

    $client = Client::with(['user'])->find($client->id);

    return new ClientResource($client);
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
      $client = Client::with(['pets', 'bookings', 'pendingBookings'])->findOrFail($id);

      if (auth()->user()->can('view', $client)) {
        return new ClientResource($client);
      } else {
        return response()->json([
          'message' => "Not Authorized",
        ], 401);
      }
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
      $client = Client::with('user')->findOrFail($id);
      $user = User::findOrFail($client->user_id);

      $client->fill($request->all());

      DB::transaction(function () use ($user, $client) {
        $user->saveOrFail();
        $client->saveOrFail();
      });

      return new ClientResource($client);
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
      $client = Client::with('user')->findOrFail($id);

      DB::transaction(function () use ($client) {
        $client->delete();
        $client->user->delete();
      });

      return new ClientResource($client);
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
