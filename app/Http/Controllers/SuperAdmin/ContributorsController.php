<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Exports\ContributorsTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\ContributorsImport;
use App\Models\Contributor;
use App\Rules\E164Phone;
use App\Services\LoggerService;
use App\Support\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ContributorsController extends Controller
{
    public function index()
    {
        return view('contributors.index');
    }

    public function list(Request $request)
    {
        $contributors = Contributor::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('text_code', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('contributors.list', [
            'contributors' => $contributors,
        ]);
    }

    public function markAttended(Contributor $contributor)
    {
        if ($contributor->status !== 'attended') {
            $contributor->status = 'attended';
            $contributor->save();

            LoggerService::log('Verification', auth()->user()->email, auth()->user()->name, 'Confirmed attendance: ' . $contributor->name);
        }

        return back()->with('success', 'Attendance confirmed for ' . $contributor->name);
    }

    public function updateSeats(Request $request, Contributor $contributor)
    {
        $request->validate([
            'assigned_seats' => 'required|integer|min:0',
        ]);

        $contributor->assigned_seats = $request->assigned_seats;
        $contributor->save();

        LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Updated seats for ' . $contributor->name . ' to ' . $contributor->assigned_seats);

        return back()->with('success', 'Seats updated for ' . $contributor->name);
    }

    public function store(Request $request)
    {
        $request->merge([
            'phone_no' => PhoneNumber::normalize($request->input('phone_no')),
        ]);

        $request->validate([
            'name' => 'required|string',
            'phone_no' => ['required', 'string', new E164Phone(), Rule::unique('contributors', 'phone_no')],
            'assigned_seats' => 'required|integer|min:0',
            'status' => ['required', Rule::in(['not_invited', 'invited'])],
        ]);

        try {
            $contributor = Contributor::create($request->only([
                'name', 'phone_no', 'assigned_seats', 'status',
            ]));

            if (!$contributor) {
                return back()->with('failure', 'Contributor creation failed');
            }

            LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Added contributor: ' . $contributor->name);

            return back()->with('success', 'Contributor added successfully');
        } catch (\Exception $e) {
            Log::alert('Failed to create contributor: ' . $e->getMessage());
            return back()->with('failure', 'Something went wrong, please try again later');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $import = new ContributorsImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->failures();

        if ($failures->isNotEmpty()) {
            $messages = $failures->map(
                fn ($failure) => "Row {$failure->row()}: " . implode(', ', $failure->errors())
            )->implode(' | ');

            return back()->with('failure', "Import finished with some rows skipped - {$messages}");
        }

        LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Imported contributors from spread sheet');

        return back()->with('success', 'Contributors imported successfully');
    }

    public function template()
    {
        return Excel::download(new ContributorsTemplateExport(), 'contribuotrs_template.xlsx');
    }

    public function edit(Contributor $contributor)
    {
        return view('contributors.edit', [
            'contributor' => $contributor,
        ]);
    }

    public function update(Request $request, Contributor $contributor)
    {
        $request->merge([
            'phone_no' => PhoneNumber::normalize($request->input('phone_no')),
        ]);

        $request->validate([
            'name' => 'required|string',
            'phone_no' => ['required', 'string', new E164Phone(), Rule::unique('contributors', 'phone_no')->ignore($contributor->id)],
            'assigned_seats' => 'required|integer|min:0',
            'status' => ['required', Rule::in(['not_invited', 'invited'])],
        ]);

        try {
            $contributor->update($request->only([
                'name', 'phone_no', 'assigned_seats', 'status',
            ]));

            LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Edited contributor: ' . $contributor->name);

            return redirect()->route('contributors.list')->with('success', 'Contributor updated successfully');
        } catch (\Exception $e) {
            Log::alert('Failed to update contributor: ' . $e->getMessage());
            return back()->with('failure', 'Something went wrong, please try again later');
        }
    }

    public function destroy(Contributor $contributor)
    {
        $name = $contributor->name;

        $contributor->delete();

        LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Deleted contributor: ' . $name);

        return redirect()->route('contributors.list')->with('success', 'Contributor deleted: ' . $name);
    }

    public function trashed(Request $request)
    {
        $contributors = Contributor::onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('text_code', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('deleted_at')
            ->paginate(15)
            ->withQueryString();

        return view('contributors.trashed', [
            'contributors' => $contributors,
        ]);
    }

    public function restore($id)
    {
        $contributor = Contributor::onlyTrashed()->findOrFail($id);
        $contributor->restore();

        LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Restored contributor: ' . $contributor->name);

        return back()->with('success', 'Contributor restored: ' . $contributor->name);
    }

}
