<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class);
    }

    public function index()
    {
        return Inertia::render('Contact/Index', [
            'contacts' => ContactResource::collection(Contact::all())
        ]);
    }

    public function create()
    {
        return Inertia::render('Contact/Create');
    }

    public function store(ContactRequest $request)
    {
        Contact::create([
            'user_id' => auth()->user()->id,
            'company_name' => $request->company_name ?? null,
            'coc' => $request->coc ?? null,
            'type' => $request->type,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'invoice_email' => $request->invoice_email ?? null,
            'invoice_att' => $request->invoice_att ?? null,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        return redirect(route('contact.index'));
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return new ContactResource($contact);
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($request->validated());

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response()->json();
    }

    public function search(Request $request)
    {
        return response()->json(
            Contact
                ::where('user_id', auth()->user()->id)
                ->where(function (Builder $query) use ($request) {
                    $query
                        ->where('company_name', 'like', '%'.$request->search.'%')
                        ->orWhere('firstname', 'like', '%'.$request->search.'%')
                        ->orWhere('lastname', 'like', '%'.$request->search.'%')
                        ->orWhere('email', 'like', '%'.$request->search.'%');
                })
                ->get()
                ->toArray()
        );
    }
}
