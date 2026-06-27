<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CvEducation;
use App\Models\CvExperience;
use App\Models\CvSkill;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $educations = CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $experiences = CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = CvSkill::where('user_id', $user->id)->get();
        $projects = \App\Models\UserPortfolio::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $title = 'Manajemen CV';

        $activeTab = $request->query('tab', 'personal');
        
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate(route('verify.cv', ['hash' => bin2hex(encrypt($user->id))])));

        return view('dashboard.user.cv.index', compact('user', 'profile', 'educations', 'experiences', 'skills', 'projects', 'title', 'activeTab', 'qrCode'));
    }

    public function updatePersonal(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = new \App\Models\Profile();
            $profile->user_id = $user->id;
        }

        if ($request->has('name')) {
            $user->name = $request->input('name');
            $user->save();
        }

        $profile->akunlinkedin = $request->input('akunlinkedin');
        $profile->tentangdiri = $request->input('tentangdiri');
        $profile->save();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.cv.index', ['tab' => 'personal'])->with('success', 'Data Diri berhasil diperbarui!');
    }

    public function storeEducation(Request $request)
    {
        CvEducation::create([
            'user_id' => Auth::id(),
            'institution' => $request->institution,
            'degree' => $request->degree,
            'field_of_study' => $request->field_of_study,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->has('is_current'),
            'description' => $request->description,
        ]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.cv.index', ['tab' => 'education'])->with('success', 'Pendidikan berhasil ditambahkan!');
    }

    public function destroyEducation($id)
    {
        CvEducation::where('id', $id)->where('user_id', Auth::id())->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('user.cv.index', ['tab' => 'education'])->with('success', 'Pendidikan berhasil dihapus!');
    }

    public function storeExperience(Request $request)
    {
        CvExperience::create([
            'user_id' => Auth::id(),
            'company' => $request->company,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->has('is_current'),
            'description' => $request->description,
        ]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.cv.index', ['tab' => 'experience'])->with('success', 'Pengalaman berhasil ditambahkan!');
    }

    public function destroyExperience($id)
    {
        CvExperience::where('id', $id)->where('user_id', Auth::id())->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.cv.index', ['tab' => 'experience'])->with('success', 'Pengalaman berhasil dihapus!');
    }

    public function storeSkill(Request $request)
    {
        CvSkill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'level' => $request->level,
        ]);
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.cv.index', ['tab' => 'skills'])->with('success', 'Keahlian berhasil ditambahkan!');
    }

    public function destroySkill($id)
    {
        CvSkill::where('id', $id)->where('user_id', Auth::id())->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('user.cv.index', ['tab' => 'skills'])->with('success', 'Keahlian berhasil dihapus!');
    }

    public function stream(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $educations = CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $experiences = CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = CvSkill::where('user_id', $user->id)->get();
        $template = $request->query('template', 'profesional');

        $verifyUrl = route('verify.cv', ['hash' => bin2hex(encrypt($user->id))]);
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->margin(0)->generate($verifyUrl));

        $viewName = $template === 'kreatif' ? 'dashboard.user.cv.pdf_kreatif' : 'dashboard.user.cv.pdf_profesional';

        $pdf = Pdf::loadView($viewName, compact('user', 'profile', 'educations', 'experiences', 'skills', 'qrCode'));
        
        return $pdf->stream('CV_' . str_replace(' ', '_', $user->name) . '_' . ucfirst($template) . '.pdf');
    }

    public function download(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $educations = CvEducation::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $experiences = CvExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $skills = CvSkill::where('user_id', $user->id)->get();
        $template = $request->query('template', 'profesional');

        $verifyUrl = route('verify.cv', ['hash' => bin2hex(encrypt($user->id))]);
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->margin(0)->generate($verifyUrl));

        $viewName = $template === 'kreatif' ? 'dashboard.user.cv.pdf_kreatif' : 'dashboard.user.cv.pdf_profesional';

        $pdf = Pdf::loadView($viewName, compact('user', 'profile', 'educations', 'experiences', 'skills', 'qrCode'));
        
        return $pdf->download('CV_' . str_replace(' ', '_', $user->name) . '_' . ucfirst($template) . '.pdf');
    }

    public function verifyCv($hash)
    {
        try {
            $userId = decrypt(hex2bin($hash));
            $user = \App\Models\User::findOrFail($userId);
            return view('landing-page.cv-verify', compact('user'));
        } catch (\Exception $e) {
            abort(404, 'Tautan verifikasi CV tidak valid atau rusak.');
        }
    }
}
