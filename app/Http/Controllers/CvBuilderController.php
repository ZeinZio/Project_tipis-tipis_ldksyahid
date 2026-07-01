<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvBuilderController extends Controller
{
    /**
     * Show the creative CV editor.
     *
     * @param string $template_id
     * @return \Illuminate\View\View
     */
    public function editor($template_id)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $title = 'CV Builder Editor';
        
        // Pass user data to the React app via blade
        return view('dashboard.user.cv-builder.editor', compact('user', 'profile', 'template_id', 'title'));
    }
}
