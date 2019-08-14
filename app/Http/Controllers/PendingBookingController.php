<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PendingBookingRequest;
use App\PendingBooking;
use App\Http\Resources\PendingBookingResource;
use App\Http\Resources\PendingBookingCollection;

class PendingBookingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $pendingBookings = PendingBooking::with(['client', 'pet', 'service'])->get();

    return new PendingBookingCollection($pendingBookings);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(PendingBookingRequest $request)
  {
    try {
      $pendingBooking = new PendingBooking;
      $pendingBooking->fill($request->all());
      $pendingBooking->client_id = $request->client_id;
      $pendingBooking->pet_id = $request->pet_id;
      $pendingBooking->saveOrFail();

      return new PendingBookingResource($pendingBooking);

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
      $pendingBooking = PendingBooking::with(['client', 'pet', 'service'])->findOrFail($id);

      if (auth()->user()->can('view', $pendingBooking)) {
        return new PendingBookingResource($pendingBooking);
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
  public function update(PendingBookingRequest $request, $id)
  {
    try {
      $pendingBooking = PendingBooking::findOrFail($id);

      $pendingBooking->fill($request->all());
      $pendingBooking->saveOrFail();

      return new PendingBookingResource($pendingBooking);
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
      $pendingBooking = PendingBooking::with(['client', 'pet', 'service'])->findOrFail($id);

      $pendingBooking->delete();

      return new PendingBookingResource($pendingBooking);
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
