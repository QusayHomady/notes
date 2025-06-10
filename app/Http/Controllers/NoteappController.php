<?php

namespace App\Http\Controllers;

use App\Models\Noteapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteappController extends Controller
{

    
public function addfavorte($productid)
{
    
 Auth::user()->productfavorite()->syncWithoutDetaching([$productid]);

return response()->json(['message' => 'Product added to favorites']);
}

public function removefavorte($productid)
{
 Auth::user()->productfavorite()->detach([$productid]);

return response()->json(['message' => 'Product remove to favorites']);
}


public function myFavorites()
{
    $user = Auth::user();

    $favorites = $user->productfavorite()->get();

    return response()->json($favorites);
}


    /**
     * Show the form for creating a new resource.
     */
    public function addNote(Request $request)
    {
       $noteapp =$request->validate([
        "title_note" => "required|string",
        "notes_cotent" => "required|string",
        "notes_imge" => "nullable|file|image|mimes:jpeg,png,jpg,gif,svg",
        "users_id" => "exists:users,id"
        ]
       );
       if($request->hasFile("notes_imge")){
        $path = $request->file("notes_imge")->store("note","public");
        $noteapp["notes_imge"]=$path;
       }
       $note=Noteapp::create($noteapp);
       return response()->json($note);
    }

    /**
     * Store a newly created resource in storage.
     */
 public function veiwNote(Request $request)
{
    $userNotes = Noteapp::where("users_id", $request->users_id)->get();

    if ($userNotes->isEmpty()) {
        return response()->json([
            "status" => "fail",
            "message" => "لا توجد ملاحظات للمستخدم المحدد"
        ], 404);
    }

    return response()->json([
        "status" => "success",
        "data" => $userNotes
    ]);
}



public function updateNote(Request $request)
{
    $request->validate([
        "notes_id" => "required|exists:noteapp,notes_id"
    ]);

    $note = Noteapp::where("notes_id", $request->notes_id)->firstOrFail();

    $validated = $request->validate([
        "title_note" => "sometimes|required|string",
        "notes_cotent" => "sometimes|required|string",
        "notes_imge" => "nullable|file|image|mimes:jpeg,png,jpg,gif,svg",
    ]);
    if ($request->hasFile("notes_imge")) {
        $oldPath = trim($note->notes_imge);
        if ($oldPath && \Storage::disk('public')->exists($oldPath)) {
            \Storage::disk('public')->delete($oldPath);
        }
        $newPath = $request->file("notes_imge")->store("note", "public");
        $validated["notes_imge"] = $newPath;
    }

    $note->update($validated);

    return response()->json([
        'status' => 'success',
        'data' => $note
    ]);
}




public function deleteNote(Request $request)
{
    $request->validate([
        "notes_id" => "required|exists:noteapp,notes_id"
    ]);

    $note = Noteapp::where("notes_id", $request->notes_id)->firstOrFail();

    if ($note->notes_imge && \Storage::disk('public')->exists($note->notes_imge)) {
        \Storage::disk('public')->delete($note->notes_imge);
    }

    $note->delete();

    return response()->json([
        'status' => 'success',
    ]);
}



public function deleteAllNotes()
{    $notes = Noteapp::all();
    foreach ($notes as $note) {
        if ($note->notes_imge && \Storage::disk('public')->exists($note->notes_imge)) {
            \Storage::disk('public')->delete($note->notes_imge);
        }
        $note->delete();
    }

    return response()->json([
        'status' => 'success',
    ]);
}


    /**
     * Display the specified resource.
     */
    public function show(Noteapp $noteapp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noteapp $noteapp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noteapp $noteapp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noteapp $noteapp)
    {
        //
    }
}
