<?php

namespace App\Http\Controllers;

use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadsController extends Controller
{
    //

    public function index(){
        $uploads=Uploads::orderBy('id','desc')->get();
        return view('users.imports', compact('uploads'));    
    }

    public function destroy(Request $request)
    {
        try {
            $file = Uploads::findOrFail($request->id);
            $filename = public_path('store/'.$file->file); 

            if (File::exists($filename)) {
                File::delete($filename);
            } 
             // Find the role by its ID
            $file->delete(); // Delete the role

            // Redirect to the roles index page with a success message
            return redirect()->route('import.index')->with('message', 'File deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('import.index')->with('error', 'File not found or could not be deleted');
        }
    }
}
