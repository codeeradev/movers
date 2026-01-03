<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return view('admin.users.index');
    }
public function getData(Request $request)
{
    $columns = ['id', 'name', 'email', 'phone', 'role', 'status'];

      // Only Employees (role = 2)
    $query = User::where('role', 2);

    // Searching
    if (!empty($request->search['value'])) {
        $search = $request->search['value'];
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('role', 'like', "%{$search}%");
        });
    }

    $totalRecords = User::count();
    $filteredRecords = $query->count();

    // Sorting
    if ($request->has('order')) {
        $columnIndex = $request->order[0]['column'] ?? 0;
        $columnName = $columns[$columnIndex] ?? 'id';
        $columnSortOrder = $request->order[0]['dir'] ?? 'desc';
        $query->orderBy($columnName, $columnSortOrder);
    } else {
        $query->orderBy('id', 'desc');
    }

    // Pagination
    $start = $request->start ?? 0;
    $length = $request->length ?? 10;

    $users = $query->skip($start)->take($length)->get();

    // Format Data for DataTables
    $data = $users->map(function ($user) {

        // Convert role from constants
        $roleName = config('constants.roles')[$user->role] ?? 'Unknown';

        // Optional Badge UI
        $roleBadge = $user->role == 1 
            ? '<span class="badge bg-primary">Admin</span>' 
            : '<span class="badge bg-info text-dark">Employee</span>';

        return [
            'id' => $user->id,
            'name' => e($user->name),
            'email' => e($user->email ?? '-'),
            'phone' => e($user->phone ?? '-'),

            // Either use badge or plain text
            'role' => $roleBadge,     // badge
            // 'role' => e($roleName), // OR plain text

            'status' => $user->status == 1 
                ? '<span class="badge bg-success">Active</span>' 
                : '<span class="badge bg-danger">Inactive</span>',

            'actions' => '
                <div class="d-flex justify-content-center gap-2">
                    <a href="' . route('employees.edit', $user->id) . '" 
                        class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" 
                        onclick="deleteUser(' . $user->id . ')" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>'
        ];
    });

    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data,
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // Validation
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'phone'    => 'required',
        'role'     => 'required|in:1,2',   // ADMIN / EMPLOYEE from constants
        'status'   => 'required|in:0,1',   // ACTIVE / INACTIVE
        'password' => 'required|min:6',
    ]);

    // Create Employee / User
    $employee = new User();
    $employee->name     = $request->name;
    $employee->email    = $request->email;
    $employee->phone    = $request->phone;
    $employee->role     = $request->role;
    $employee->status   = $request->status;
    $employee->password = Hash::make($request->password);

    $employee->save();

    return redirect()->route('employees.index')
                     ->with('success', 'Employee added successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
{
    $employee = User::findOrFail($id);
    return view('admin.users.edit', compact('employee'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $employee = User::findOrFail($id);

    // Validation
    $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|unique:users,email,' . $employee->id,
        'phone'  => 'required',
        'role'   => 'required|in:1,2',   // ADMIN / EMPLOYEE
        'status' => 'required|in:0,1',   // ACTIVE / INACTIVE
        'password' => 'nullable|min:6'
    ]);

    // Update Fields
    $employee->name   = $request->name;
    $employee->email  = $request->email;
    $employee->phone  = $request->phone;
    $employee->role   = $request->role;
    $employee->status = $request->status;

    // Update password only if user entered it
    if ($request->password) {
        $employee->password = Hash::make($request->password);
    }

    $employee->save();

    return redirect()->route('employees.index')
                     ->with('success', 'Employee updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $employee = User::findOrFail($id);
    $employee->delete();

    return response()->json([
        'success' => true,
        'message' => 'Employee deleted successfully'
    ]);
}

}
