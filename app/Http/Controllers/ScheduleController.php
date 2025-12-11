<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil data jadwal, urutkan dari jam paling pagi
        $schedules = Schedule::orderBy('feeding_time', 'asc')->get();
        return view('schedule', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'feeding_time' => 'required|date_format:H:i',
        ]);

        Schedule::create([
            'feeding_time' => $request->feeding_time,
            'is_active' => true
        ]);

        return back()->with('success', 'Jadwal baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Schedule::destroy($id);
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}