<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingCollection;
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
    $bookings = Booking::with('client')->with('pet')->with('employee')->get();

    return new BookingCollection($bookings);
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
      $booking = new Booking;
      $booking->fill($request->all());
      $booking->client_id = $request->client_id;
      $booking->pet_id = $request->pet_id;
      $booking->employee_id = $request->employee_id;
      $booking->saveOrFail();

      return response()->json([
        'id' => $booking->id,
        'created_at' => $booking->created_at,
      ], 201);
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
      $booking = Booking::with('client')->with('pet')->with('employee')->findOrFail($id);

      return new BookingResource($booking);
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
      $booking = Booking::findOrFail($id);

      $booking->fill($request->all());
      $booking->saveOrFail();

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
    //
  }
}
