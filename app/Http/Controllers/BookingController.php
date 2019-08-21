<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Booking;
use App\Client;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingCollection;
use App\Notifications\AcceptBookingEmail;
use App\Notifications\RejectBookingEmail;
use App\User;

class BookingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $bookings = Booking::with(['client', 'pet', 'employee', 'service'])->get();

    return new BookingCollection($bookings);
  }

  public function getClientBookings($id)
  {
    $bookings = Booking::with(['pet', 'employee', 'service'])->where('client_id', $id)->get();

    return new BookingCollection($bookings);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(BookingRequest $request)
  {
    try {
      $booking = new Booking;
      $booking->fill($request->all());
      $booking->client_id = $request->client_id;
      $booking->pet_id = $request->pet_id;
      if (!$booking->employee_id) {
        $booking->employee_id = $request->employee_id;
      }
      $booking->service_id = $request->service_id;
      $booking->saveOrFail();

      $client = Client::findOrFail($booking->client_id);
      $user = User::findOrFail($client->user_id);
      
      if ($request->status == 'accepted') {
        $user->notify(new AcceptBookingEmail());
      } else {
        $user->notify(new RejectBookingEmail());
      }
      $booking = Booking::with(['client', 'pet', 'service', 'employee'])->find($booking->id);
      
      return new BookingResource($booking);
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
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    try {
      $booking = Booking::with(['client', 'pet', 'service', 'employee'])->findOrFail($id);

      if (auth()->user()->can('view', $booking)) {
        return new BookingResource($booking);
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
  public function update(Request $request, $id)
  {
    try {
      $booking = Booking::with(['client', 'pet', 'service', 'employee'])->findOrFail($id);

      if (auth()->user()->can('update', $booking)) {
        $booking->fill($request->all());
        $booking->saveOrFail();
        return new BookingResource($booking);
      } else {
        return response()->json([
          'message' => "Not Authorized",
        ], 401);
      }
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
    //
  }
}
