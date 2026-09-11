<?php
namespace App\Http\Controllers;
use App\Models\AuthorisedViewer;
use Illuminate\Http\Request;
class AuthorisedViewerController extends Controller {
    public function index() {
        $viewers = AuthorisedViewer::with('addedBy')->orderBy('name')->get();
        return view('admin.authorised-viewers.index', compact('viewers'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'email'             => 'required|email|unique:authorised_viewers,email',
            'name'              => 'required|string|max:100',
            'reason'            => 'required|string|max:255',
            'access_expires_at'=> 'nullable|date|after:today',
        ]);
        AuthorisedViewer::create(array_merge($validated, [
            'added_by'          => auth()->id(),
            'access_granted_at'=> now(),
            'is_active'         => true,
        ]));
        return back()->with('success', $validated['name'].' added to authorised viewers list.');
    }
    public function destroy(AuthorisedViewer $viewer) {
        $name = $viewer->name;
        $viewer->delete();
        return back()->with('success', $name.' removed from authorised viewers list.');
    }
    public function toggle(AuthorisedViewer $viewer) {
        $viewer->update(['is_active' => !$viewer->is_active]);
        $status = $viewer->is_active ? 'activated' : 'deactivated';
        return back()->with('success', $viewer->name.' access '.$status.'.');
    }
}
