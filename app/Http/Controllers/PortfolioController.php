<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPortfolio;
use Barryvdh\DomPDF\Facade\Pdf;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $portfolios = UserPortfolio::where('user_id', $user->id)->orderBy('date_completed', 'desc')->get();
        $experiences = \App\Models\CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = \App\Models\CvSkill::where('user_id', $user->id)->get();
        $educations = \App\Models\CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $title = 'Portfolio Builder';

        return view('dashboard.user.portfolio.index', compact('user', 'profile', 'portfolios', 'experiences', 'skills', 'educations', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'project_role' => 'required|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'date_completed' => 'nullable|date',
        ]);

        $user = Auth::user();
        $portfolio = new UserPortfolio();
        $portfolio->user_id = $user->id;
        $portfolio->project_name = $request->input('project_name');
        $portfolio->project_role = $request->input('project_role');
        $portfolio->project_url = $request->input('project_url');
        $portfolio->description = $request->input('description');
        $portfolio->date_completed = $request->input('date_completed');
        $portfolio->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.portfolio.index')->with('success', 'Data Portofolio berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $portfolio = UserPortfolio::where('user_id', Auth::id())->findOrFail($id);
        $portfolio->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.portfolio.index')->with('success', 'Data Portofolio berhasil dihapus!');
    }

    public function stream(Request $request)
    {
        $user = Auth::user();
        $portfolios = UserPortfolio::where('user_id', $user->id)->orderBy('date_completed', 'desc')->get();

        $pdf = Pdf::loadView('dashboard.user.portfolio.pdf_default', compact('user', 'portfolios'));
        
        return $pdf->stream('Portfolio_' . str_replace(' ', '_', $user->name) . '.pdf');
    }

    public function download(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $portfolios = UserPortfolio::where('user_id', $user->id)->orderBy('date_completed', 'desc')->get();
        $experiences = \App\Models\CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = \App\Models\CvSkill::where('user_id', $user->id)->get();
        $educations = \App\Models\CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        
        $selectedTemplate = $profile->portfolio_template;
        if (empty($selectedTemplate) || $selectedTemplate === 'default') {
            $selectedTemplate = 'business';
        }

        $pdf = Pdf::loadView('dashboard.user.portfolio.templates.' . $selectedTemplate, compact('user', 'profile', 'portfolios', 'experiences', 'skills', 'educations'))
                  ->setPaper('a4', 'landscape');
        
        return $pdf->download('Portfolio_' . str_replace(' ', '_', $user->name) . '.pdf');
    }

    public function publicStream($hash)
    {
        try {
            $userId = decrypt(hex2bin($hash));
            $user = \App\Models\User::findOrFail($userId);
            $portfolios = UserPortfolio::where('user_id', $user->id)->orderBy('date_completed', 'desc')->get();
            $pdf = Pdf::loadView('dashboard.user.portfolio.pdf_default', compact('user', 'portfolios'));
            return $pdf->stream('Portfolio_' . str_replace(' ', '_', $user->name) . '.pdf');
        } catch (\Exception $e) {
            abort(404, 'Tautan portofolio tidak valid.');
        }
    }

    public function pdfBuilder(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $portfolios = UserPortfolio::where('user_id', $user->id)->orderBy('date_completed', 'desc')->get();
        $experiences = \App\Models\CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = \App\Models\CvSkill::where('user_id', $user->id)->get();
        $educations = \App\Models\CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $title = 'Portfolio PDF Builder';
        
        $selectedTemplate = $profile->portfolio_template;
        if (empty($selectedTemplate) || $selectedTemplate === 'default') {
            $selectedTemplate = 'business';
        }

        return view('dashboard.user.portfolio.pdf_builder', compact('user', 'profile', 'portfolios', 'experiences', 'skills', 'educations', 'title', 'selectedTemplate'));
    }

    public function updateTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|string'
        ]);

        $profile = Auth::user()->profile;
        if($profile) {
            $profile->portfolio_template = $request->template;
            $profile->save();
        }

        return response()->json(['success' => true]);
    }

    public function downloadZip(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $portfolios = UserPortfolio::where('user_id', $user->id)->orderBy('date_completed', 'desc')->get();
        $experiences = \App\Models\CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = \App\Models\CvSkill::where('user_id', $user->id)->get();
        $educations = \App\Models\CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();

        // Render standalone HTML
        $html = view('dashboard.user.portfolio.web_standalone', compact('user', 'profile', 'portfolios', 'experiences', 'skills', 'educations'))->render();

        $zip = new \ZipArchive;
        $fileName = 'WebPortfolio_' . str_replace(' ', '_', $user->name) . '.zip';
        $filePath = storage_path('app/public/' . $fileName);

        if ($zip->open($filePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFromString('index.html', $html);
            $zip->close();
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
