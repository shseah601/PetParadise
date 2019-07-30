<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkingHour;

class WorkingHourController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $workinghours = WorkingHour::get();

    return $workinghours;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
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
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      $workinghour = WorkingHour::findOrFail($id);
      $workinghour->start_time = $request->start_time;
      $workinghour->end_time = $request->end_time;
      $workinghour->saveOrFail();

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
