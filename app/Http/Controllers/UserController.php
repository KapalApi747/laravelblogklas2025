<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use AuthorizesRequests;
    protected $folder = 'users';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //policy bij zetten
        $this->authorize('ViewAdminPanel',User::class);
        //de homepagina van mijn users
        $users = User::withTrashed()->with(['roles','photo'])->orderBy('id', 'desc')->paginate(7);

        //return view('backend.users.index',['users' => $users, 'roles' => $roles]);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        $validatedData = $request->validated();
        //paswoord hashen
        $validatedData['password'] = Hash::make($validatedData['password']);

        //Controleer of er een foto is geüpload en sla deze op
        if ($request->hasFile('photo_id')) {
            $file = $request->file('photo_id');
            $uniqueName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $this->folder . '/' . $uniqueName;

            //opslaan in het public path onder users
            $file->storeAs('', $filePath, 'public');
            $photo = Photo::create([
                'path' => $filePath,
                'alternate_text' => $validatedData['name']
            ]);
            $validatedData['photo_id'] = $photo->id;
        }

        //gebruiker aanmaken
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_active' => $validatedData['is_active'],
            'password' => $validatedData['password'],
            'photo_id' => $validatedData['photo_id']
        ]);
        //array van rollen wegschrijven naar de role_user tussentabel
        //sync doet een detach en daarna een attach in 1 keer
        $user->roles()->sync($validatedData['role_id']);

        //redirect naar users
        return redirect()->route('users.index')->with('message', 'User created successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //weergave voor een nieuwe user
        $roles = Role::pluck('name', 'id')->all();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //weergaven van 1 enkele user
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

       // $user = User::with('roles', 'photo')->findOrFail($id);
        $user->load('roles','photo');
        $roles = Role::pluck('name', 'id')->all();
        $photoDetails = ['exists' => false, 'filesize' => 0, 'width' => 'N/A', 'height' => 'N/A', 'extension' => ''];    // Controleer of er een foto is en of deze bestaat op de 'public' disk
        if ($user->photo && Storage::disk('public')->exists($user->photo->path)) {
            $photoDetails['exists'] = true;
            $photoDetails['filesize'] = round(Storage::disk('public')->size($user->photo->path) / 1024, 2);
            $photoPath = Storage::disk('public')->path($user->photo->path);
            $dimensions = getimagesize($photoPath);
            $photoDetails['width'] = $dimensions[0] ?? 'N/A';
            $photoDetails['height'] = $dimensions[1] ?? 'N/A';
            $photoDetails['extension'] = Str::upper(pathinfo($user->photo->path, PATHINFO_EXTENSION));
        }
        return view('backend.users.edit', compact('user', 'roles', 'photoDetails'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Haal de gebruiker op of geef een 404 als deze niet bestaat
        //$user = User::findOrFail($id);

        // Validatieberichten
        $validatedData = $request->validated();

        // Verwerk het wachtwoord: als er een nieuw wachtwoord is ingevuld, hash deze; anders laat je de oude waarde intact.
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Verwerk de foto: als er een nieuwe foto is geüpload
        if ($request->hasFile('photo_id')) {
            $file = $request->file('photo_id');
            // Genereer een unieke bestandsnaam met behulp van een UUID
            $uniqueName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            // Gebruik de class-property (bijv. 'users') en bouw het bestandspad op als 'users/uniquename.ext'
            $filePath = $this->folder . '/' . $uniqueName;
            // Sla het bestand op in de 'public'-disk (die verwijst naar storage/app/public)
            $file->storeAs('', $filePath, 'public');

            // Controleer of de gebruiker al een foto-record heeft
            if ($user->photo && Storage::disk('public')->exists($user->photo->path)) {
                // Verwijder de oude fysieke foto
                Storage::disk('public')->delete($user->photo->path);
                // Update het bestaande Photo-record met de nieuwe bestandsnaam en alternate text
                $user->photo->update([
                    'path'           => $filePath,
                    'alternate_text' => $validatedData['name']
                ]);
                // Gebruik hetzelfde photo record id
                $validatedData['photo_id'] = $user->photo->id;
            } else {
                // Als er nog geen foto-record is, maak er dan een nieuw aan
                $photo = Photo::create([
                    'path'           => $filePath,
                    'alternate_text' => $validatedData['name']
                ]);
                $validatedData['photo_id'] = $photo->id;
            }
        }

        // Werk de gebruiker bij met de gevalideerde data
        $user->update($validatedData);

        // Synchroniseer de rollen voor de gebruiker
        $user->roles()->sync($validatedData['role_id']);

        return redirect()->back()->with('message', 'User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(User $user)
    {
        //delete van een user
        //$user = User::with('photo')->findOrFail($id);

        $user->load('photo');
            //controleer of het fysieke bestand bestaat
            if(Storage::disk('public')->exists($user->photo->path)){
                Storage::disk('public')->delete($user->photo->path);
            }
            //$user->photo->delete();
       $user->delete();
        //redirect naar users
        return redirect()->route('users.index')->with('message', 'User deleted successfully!');
    }

    public function restore(string $id){
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('message', 'User restored successfully!');
    }
}
