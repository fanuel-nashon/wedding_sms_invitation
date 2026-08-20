<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Exports\ContributorsTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\ContributorsImport;
use App\Models\Contributor;
use App\Services\LoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ContributorsController extends Controller
{
    public function index()
    {
        return view('contributors.index', [
            'contributors' => Contributor::orderBy('name')->paginate(15),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone_no' => 'required|string|unique:contributors,phone_no',
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
        $request->validate([
            'name' => 'required|string',
            'phone_no' => ['required', 'string', Rule::unique('contributors', 'phone_no')->ignore($contributor->id)],
            'assigned_seats' => 'required|integer|min:0',
            'status' => ['required', Rule::in(['not_invited', 'invited'])],
        ]);

        try {
            $contributor->update($request->only([
                'name', 'phone_no', 'assigned_seats', 'status',
            ]));

            LoggerService::log('Contributors', auth()->user()->email, auth()->user()->name, 'Edited contributor: ' . $contributor->name);

            return redirect()->route('contributors.index')->with('success', 'Contributor updated successfully');
        } catch (\Exception $e) {
            Log::alert('Failed to update contributor: ' . $e->getMessage());
            return back()->with('failure', 'Something went wrong, please try again later');
        }
    }

}
