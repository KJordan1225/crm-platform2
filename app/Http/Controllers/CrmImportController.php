<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use Illuminate\Http\Request;

class CrmImportController extends Controller
{
    public function index()
    {
        return view('imports.index');
    }

    public function accounts(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $rows = $this->readCsv($request->file('csv_file')->getRealPath());

        foreach ($rows as $row) {
            Account::updateOrCreate(
                ['email' => $row['email'] ?? null],
                [
                    'name' => $row['name'] ?? 'Unnamed Account',
                    'industry' => $row['industry'] ?? null,
                    'website' => $row['website'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'description' => $row['description'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Accounts imported successfully.');
    }

    public function contacts(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $rows = $this->readCsv($request->file('csv_file')->getRealPath());

        foreach ($rows as $row) {
            $account = null;

            if (!empty($row['account_email'])) {
                $account = Account::where('email', $row['account_email'])->first();
            }

            Contact::updateOrCreate(
                ['email' => $row['email'] ?? null],
                [
                    'account_id' => $account?->id,
                    'first_name' => $row['first_name'] ?? 'Unknown',
                    'last_name' => $row['last_name'] ?? 'Contact',
                    'title' => $row['title'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'mobile' => $row['mobile'] ?? null,
                    'department' => $row['department'] ?? null,
                    'notes' => $row['notes'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Contacts imported successfully.');
    }

    public function leads(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $rows = $this->readCsv($request->file('csv_file')->getRealPath());

        foreach ($rows as $row) {
            Lead::updateOrCreate(
                ['email' => $row['email'] ?? null],
                [
                    'company' => $row['company'] ?? null,
                    'first_name' => $row['first_name'] ?? 'Unknown',
                    'last_name' => $row['last_name'] ?? 'Lead',
                    'phone' => $row['phone'] ?? null,
                    'status' => $row['status'] ?? 'New',
                    'source' => $row['source'] ?? null,
                    'industry' => $row['industry'] ?? null,
                    'estimated_value' => $row['estimated_value'] ?? 0,
                    'notes' => $row['notes'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Leads imported successfully.');
    }

    private function readCsv(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'r');

        if (!$handle) {
            return $rows;
        }

        $headers = fgetcsv($handle);

        if (!$headers) {
            fclose($handle);
            return $rows;
        }

        $headers = array_map(fn ($header) => strtolower(trim($header)), $headers);

        while (($data = fgetcsv($handle)) !== false) {
            $row = [];

            foreach ($headers as $index => $header) {
                $row[$header] = $data[$index] ?? null;
            }

            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }
}
