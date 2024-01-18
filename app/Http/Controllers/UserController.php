<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Uploads;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use League\Csv\Reader;
use Illuminate\Support\Facades\Artisan;
use League\Csv\Writer;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    //

    public function index(){
        $roles=Role::where('name','<>','Super Admin')->get();
        return view('users.index', compact('roles'));    }

    public function getUsersData(Request $request)
    {
        $users = User::select(['roles', 'name', 'email', 'contact_number', 'hobbies', 'gender', 'address', 'city','id'])->orderBy('id','desc');

        return Datatables::of($users)->make(true);
    }

    public function store(Request $request)
    {
        $user=User::where('email',$request->email)->get();
        if(count($user)>0){
            return redirect()->back()->with('message','User Already Exists');
        }
        
        // Create a new User instance with the validated data
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->roles = $request->roles;
        $user->hobbies = implode(',' ,$request->hobbies);
        $user->address = $request->address;
        $user->city = $request->city;
        $user->gender = $request->gender;
        $user->contact_number = $request->phone;
        $user->password = 'password';
        // Save the user to the database
        $user->save();
    
        // Return a response (you can customize this based on your needs)
        return redirect()->back()->with('message','Added Successfully');
    }

    public function edit(Request $request,$id){
        try {
            $user = User::findOrFail($id); // Find the role by its ID
            return response()->json(['name' => $user->name,'email'=>$user->email,'roles'=>$user->roles,
            'contact_number'=> $user->contact_number,'hobbies' => $user->hobbies, 'address' => $user->address,
            'city' =>$user->city, 'gender' => $user->gender,'id'=> $user->id
        ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Role not found.'], 404);
        }
    }

    public function update(Request $request){
        try {
            $userId = $request->id;

    // Find the user by ID
    $user = User::find($userId);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found');
    }

    // Update the user's information
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'contact_number' => $request->phone,
        'gender' => $request->gender,
        'hobbies' => $request->hobbies,
        'address' => $request->address,
        'city' => $request->city,
        'roles' => $request->role,
    ]);

    return redirect()->back()->with('message', 'User updated successfully');
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $role = User::findOrFail($request->id); // Find the role by its ID
            $role->delete(); // Delete the role

            // Redirect to the roles index page with a success message
            return redirect()->route('users.index')->with('message', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'User not found or could not be deleted');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|file|mimes:csv,txt',
        ]);
    
        $csvFile = $request->file('csvFile');
    
        // Generate a unique filename to avoid overwriting existing files
        $filename = uniqid('import_') . '.' . $csvFile->getClientOriginalExtension();
    
        // Move the file to the public directory
        $csvFile->move(public_path('store'), $filename);
    
        // Full path to the stored file
        $filePath = public_path('store/' . $filename);

        // Artisan::call('app:import-users', [
        //     'file' => $filePath,
        // ]);

        $uploads=new Uploads();
        $uploads->file=$filename;
        $uploads->progress=0;
        $uploads->executed=0;
        $uploads->save();


        // After importing, you can redirect back to the users' page with a success message
        return redirect()->route('users.index')->with('message', 'Users Imported started');
    }

    public function export(){
        $users = User::all();

        // Create a new CSV writer instance
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        // Add a header row
        $csv->insertOne(['Name', 'Email', 'Contact Number', 'Hobbies', 'Address', 'City', 'Roles']);

        // Add data rows
        foreach ($users as $user) {
            $csv->insertOne([
                $user->name,
                $user->email,
                $user->contact_number,
                $user->hobbies,
                $user->address,
                $user->city,
                $user->roles,
            ]);
        }

        // Set the response headers for file download
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_data.csv"',
        ];

        return Response::stream(function () use ($csv) {
            $csv->output();
        }, 200, $headers);
    }


    public function downloadSample()
    {
        // Define the path to the sample file
        $filePath = public_path("store/sample.csv");

        // Check if the file exists
        if (file_exists($filePath)) {
            // Provide the file for download
            return Response::download($filePath, 'sample.csv');
        } else {
            // Handle the case where the file does not exist
            abort(404);
        }
    }


}
