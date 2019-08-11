<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UserRequest;
use App\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeCollection;
use App\User;
use Bouncer;

class EmployeeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $employees = Employee::with('user')->get();

    return new EmployeeCollection($employees);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(UserRequest $request1, EmployeeRequest $request2)
  {
    try {
      $user = new User;

      $user->email = $request1->email;
      $user->password = bcrypt($request1->password);

      $employee = new Employee;
      $employee->fill($request2->all());

      DB::transaction(function () use ($user, $employee) {
        $user->saveOrFail();
        $employee->user_id = $user->id;
        $employee->saveOrFail();
        Bouncer::assign('employee')->to($user);
      });

      return response()->json([
        'id' => $employee->id,
        'user_id' => $employee->user_id,
        'created_at' => $employee->created_at,
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
      $employee = Employee::with('bookings')->findOrFail($id);

      return new EmployeeResource($employee);
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
  public function update(EmployeeRequest $request, $id)
  {
    try {
      $employee = Employee::findOrFail($id);
      $user = User::findOrFail($employee->user_id);

      $employee->fill($request->all());

      DB::transaction(function () use ($user, $employee) {
        $user->saveOrFail();
        $employee->saveOrFail();
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
      $employee = Employee::findOrFail($id);

      DB::transaction(function () use ($employee) {
        $employee->delete();
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
