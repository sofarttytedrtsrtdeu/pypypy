<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Http\Requests\StoreContestRequest;
use App\Http\Requests\UpdateContestRequest;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function index()
    {
        $contests = Contest::latest()->paginate(10);
        return view('contests.index', compact('contests'));
    }

    public function create()
    {
        return view('contests.create');
    }

    public function store(StoreContestRequest $request)
    {
        Contest::create($request->validated());
        return redirect()->route('admin.contests.index')->with('success', 'Конкурс создан.');
    }

    public function edit(Contest $contest)
    {
        return view('contests.edit', compact('contest'));
    }

    public function update(UpdateContestRequest $request, Contest $contest)
    {
        $contest->update($request->validated());
        return redirect()->route('admin.contests.index')->with('success', 'Конкурс обновлён.');
    }

    public function destroy(Contest $contest)
    {
        $contest->delete();
        return redirect()->route('admin.contests.index')->with('success', 'Конкурс удалён.');
    }
}