<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkingHour;
use App\Http\Resources\WorkingHourCollection;
use App\Http\Resources\WorkingHourResource;

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

    return new WorkingHourCollection($workinghours);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateWorkingHours(Request $request)
  {
    try {
      $editedWorkinghours = $request->workinghours;

      foreach ($editedWorkinghours as $editedWorkinghour) {
        $workinghour = WorkingHour::findOrFail($editedWorkinghour['id']);
        $workinghour->start_time = $editedWorkinghour['start_time'];
        $workinghour->end_time = $editedWorkinghour['end_time'];
        $workinghour->status = $editedWorkinghour['status'];
        $workinghour->saveOrFail();
      }
      $workinghours = WorkingHour::get();
      
      return new WorkingHourCollection($workinghours);
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
