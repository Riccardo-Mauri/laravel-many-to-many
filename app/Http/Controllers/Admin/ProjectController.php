<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all(); // Recupera tutti i progetti
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all(); // Recupera tutte le tipologie
        $technologies = Technology::all();  //recupera tutte le tecnologie
        return view('admin.projects.create', compact('types','technologies'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Validazione dei dati in ingresso
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string', //cambito in required perché se lascaito vuot dava errore
            'image' => 'nullable|image|max:20480',
            'is_started' => 'boolean',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'array|exists:technologies,id',
            'remove_image' => 'nullable',
        ]);

        $imagePath =$request->file('image') ? Storage::put('uploads',$request->file('image')): null;
       

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'is_started' => $request->is_started ?? false,
            'type_id' => $request->type_id, 
        ]);

         // Associazione delle tecnologie selezionate
         $project->technologies()->sync($request->technologies ?? []);
    
        return redirect()->route('admin.projects.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Recupera il progetto in base all'ID
        $project = Project::findOrFail($id);

        // Passa il progetto alla vista 'projects.show'
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         // Recupera il progetto in base all'ID
         $project = Project::findOrFail($id);
         // Recupera tutte le tipologie
         $types = Type::all(); 
         // Recupera tutte le tecnologie
         $technologies = Technology::all();
        return view('admin.projects.edit', compact('project','types', 'technologies'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validazione dei dati in ingresso
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string', //cambiato in required perché se dato vuoto dava errore 
        'image' => 'nullable|image|max:20480',
        'is_started' => 'boolean',
        'type_id' => 'nullable|exists:types,id',
        'technologies' => 'array|exists:technologies,id',
        'remove_image' => 'nullable',
    ]);

    // Recupera il progetto in base all'ID
    $project = Project::findOrFail($id);
    
    // Gestione dell'immagine
    if ($request->hasFile('image')) {
        // Elimina l'immagine precedente se esiste
        if ($project->image) {
            Storage::delete($project->image);
        }
        // Salva la nuova immagine
        $imagePath = Storage::put('uploads', $request->file('image'));
        $project->image = $imagePath;
    } elseif ($request->remove_image && $project->image) {
        // Se l'utente ha richiesto di rimuovere l'immagine
        Storage::delete($project->image);
        $project->image = null;
    }

    // Aggiorna il progetto
    $project->update([
        'title' => $request->title,
        'description' => $request->description,
        'image' => $project->image,
        'is_started' => $request->is_started ?? false, // Default a false se non fornito
        'type_id' => $request->type_id,
    ]);

    // Associazione delle tecnologie selezionate
    $project->technologies()->sync($request->technologies ?? []);

    return redirect()->route('admin.projects.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Recupera il progetto in base all'ID
        $project = Project::findOrFail($id);

        if($project->image){
            Storage::delete($project->image);
        }
    
        // Cancella il progetto
        $project->delete();
    
        // Reindirizza con un messaggio di successo
        return redirect()->route('admin.projects.index');
    }
}
